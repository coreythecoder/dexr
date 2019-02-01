<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {

        parent::__construct();
        $this->load->helper(array('url', 'general', 'aws'));
        $this->load->model("user_model");
        //$this->load->library('Awslib');
        //$this->load->model('db_model');
    }

    public function index() {

        $data['metaTitle'] = "";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('footer', $data);
    }

    public function stats() {

        $data['metaTitle'] = "Stats";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('footer', $data);
    }

    public function email_targeting() {

        $this->load->model('db_model');
        $this->load->model("user_model");

        if (!$this->user->loggedin) {
            redirect('/login', 301);
        }

        $data['metaTitle'] = "Stats";
        $data['metaDescription'] = "";
        $data['list'] = "";

        $uid = $this->user->info->ID;

        if (isset($_GET['delete'])) {
            $this->db_model->deleteAudience($_GET['delete'], $uid);
        }

        $audienceList = $this->db_model->getAudiences($uid);
        $data['list'] = "";

        if ($audienceList) {

            foreach ($audienceList as $audience) {
                $data['list'] .= '<div class="col-sm-6">
                    <div class="panel panel-bordered mg-b">
                    <div class="panel-body">
                    ';
                $data['list'] .= "<div class='row'><div class='col-md-6' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>" . ucwords(strtolower($audience->filter_id)) . "</h3></div><div class='col-md-4' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>Created: " . date('M d, Y', strtotime($audience->created)) . "</h3></div><div class='col-md-1'><a class='btn btn-danger btn-xs' script=\"confirm('Are you sure?');\" href='/targeting?delete=" . $audience->filter_id . "'>Delete</a></div></div>";

                $filters = $this->db_model->filters($audience->filter_id);
                $data['list'] .= "<div class='row'>";
                foreach ($filters as $filter) {
                    $data['list'] .= "<div class='col-md-6'>" . $filter->filter_key . " &nbsp; <strong>" . $filter->match_type . "</strong> &nbsp; " . $filter->filter_value . "</div>";
                }

                $data['list'] .= "</div></div></div></div>";
            }
        }

        $this->load->view('header', $data);
        $this->load->view('email_targeting', $data);
        $this->load->view('footer', $data);
    }

    public function templates_create() {

        $this->load->model('db_model');
        $data['error'] = "";

        if (isset($_POST['save']) && empty($_POST['name'])) {
            $data['error'] .= "<div class='alert alert-danger'>Please name this template.</div>";
        }
        if (isset($_POST['save']) && empty($_POST['subject'])) {
            $data['error'] .= "<div class='alert alert-danger'>Please provide an email subject line.</div>";
        }
        if (isset($_POST['save']) && empty($_POST['body'])) {
            $data['error'] .= "<div class='alert alert-danger'>Email body cannot be empty.</div>";
        }
        if (isset($_POST['save']) && empty($_POST['address'])) {
            $data['error'] .= "<div class='alert alert-danger'>Please provide your business name & mailing address.</div>";
        }

        if (isset($_POST['save']) && empty($data['error'])) {
            $this->db_model->insertTemplate($_POST, $this->user->info->ID);
            $data['error'] .= "<div class='alert alert-success'>Template saved!</div>";
            $this->output->set_header('refresh:3;url=/email/templates');
        }

        $data['metaTitle'] = "Create Email Template";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('templates_create', $data);
        $this->load->view('footer', $data);
    }

    public function targeting_create() {

        $this->load->model('db_model');
        $data['error'] = "";

        $data['list'] = "";
        $data['total'] = "";

        if (isset($_POST['search']) && !empty($_POST['keyword'][0]) && !empty($_POST['name'])) {
            $query = $this->db_model->applyFilters($_POST);
            $data['total'] = count($query);
            foreach ($query as $domain) {
                $data['list'] .= '<tr><td>' . $domain->domainName . '</td><td>' . $domain->registrarName . '</td><td>' . $domain->createdDate . '</td><td>' . $domain->registrant_name . '</td><td>' . $domain->contactEmail . '</td><td>' . $domain->registrant_city . '</td><td>' . $domain->registrant_state . '</td><td>' . $domain->registrant_country . '</td><td>' . $domain->registrant_telephone . '</td></tr>';
                //domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone
            }
        }

        if (isset($_POST['save']) && !empty($_POST['keyword'][0]) && !empty($_POST['name'])) {

            $nameExists = $this->db_model->audienceNameExists(trim(strtolower($_POST['name'])));

            if ($nameExists == false) {
                $this->db_model->insertFilters($_POST['col'], $_POST['type'], $_POST['keyword'], trim(strtolower($_POST['name'])));
                $data['error'] .= "<div class='alert alert-success'>Audience created successfully! Added to <a href=''>Targeting Lists</a></div>";
            } else {
                $data['error'] .= "<div class='alert alert-danger'>Audience name already exists. Please try a different name.</div>";
            }
        } elseif (isset($_POST['save'])) {
            $data['error'] .= "<div class='alert alert-danger'>Didn't save. Please make sure the Audience Label as well as at least one filter is set.</div>";
        }



        /*
          if (isset($_POST['term'])) {
          $domains = $this->db_model->findByKeyword($_POST['term']);
          $data['total'] = count($domains);

          foreach ($domains as $domain) {
          $data['list'] .= '<tr><td>'.$domain->domainName . '</td><td>'.$domain->registrarName . '</td><td>'.$domain->createdDate . '</td><td>'.$domain->registrant_name . '</td><td>'.$domain->registrant_city . '</td><td>'.$domain->registrant_state . '</td><td>'.$domain->registrant_country . '</td><td>'.$domain->registrant_telephone . '</td></tr>';
          //domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone
          }
          }
         * 
         */

        $data['metaTitle'] = "Create Audience";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('targeting_create', $data);
        $this->load->view('footer', $data);
    }

    public function inboxes_create() {

        $this->load->model('Db_model');
        $data['error'] = "";

        $data['list'] = "";
        $data['total'] = "";

        if (isset($_POST['test_save']) && empty($_POST['address'])) {
            $data['error'] .= "<div class='alert alert-danger'>Email address cannot be empty.</div>";
        }
        if (isset($_POST['test_save']) && empty($_POST['imap_server'])) {
            $data['error'] .= "<div class='alert alert-danger'>Imap server cannot be empty.</div>";
        }

        if (isset($_POST['test_save']) && empty($_POST['imap_password'])) {
            $data['error'] .= "<div class='alert alert-danger'>Imap password cannot be empty.</div>";
        }

        if (isset($_POST['test_save']) && empty($_POST['smtp_server'])) {
            $data['error'] .= "<div class='alert alert-danger'>SMTP server cannot be empty.</div>";
        }

        if (isset($_POST['test_save']) && empty($_POST['smtp_password'])) {
            $data['error'] .= "<div class='alert alert-danger'>SMTP password cannot be empty.</div>";
        }

        if (isset($_POST['test_save']) && empty($data['error'])) {

            $alreadyExists = $this->Db_model->inboxExists($_POST['address']);

            if ($alreadyExists) {
                $data['error'] .= "<div class='alert alert-danger'>This email address already exists in our system.</div>";
            } else {
                // IMAP TEST 

                $hostname = '{' . $_POST['imap_server'] . '/imap/ssl}INBOX';
                $username = $_POST['address'];
                $password = $_POST['imap_password'];

                /* try to connect */
                imap_timeout(IMAP_READTIMEOUT, 10);
                imap_timeout(IMAP_OPENTIMEOUT, 10);
                $mbox = @imap_open($hostname, $username, $password); // or die('Cannot connect to Gmail: ' . imap_last_error());

                if (!$mbox) {
                    $data['error'] .= "<div class='alert alert-danger'>Couldn't connect to IMAP server.</div>";
                    imap_errors();
                    imap_alerts();
                } else {
                    imap_errors();
                    imap_alerts();
                    imap_close($mbox);
                }

                // SMTP TEST

                date_default_timezone_set('America/New_York');

                require $_SERVER['DOCUMENT_ROOT'] . '/PHPMailer/PHPMailerAutoload.php';

                $mail = new PHPMailer;
                $mail->isSMTP();

                //Enable SMTP debugging
                // 0 = off (for production use)
                // 1 = client messages
                // 2 = client and server messages
                $mail->SMTPDebug = 0;
                $mail->Debugoutput = 'html';

                if (strpos($_POST['smtp_server'], ":") !== false) {
                    $parts = explode(":", $_POST['smtp_server']);
                } else {
                    $data['error'] .= "<div class='alert alert-danger'>Please provide an SMTP server port number.</div>";
                }

                $mail->Host = $parts[0];
                $mail->Port = $parts[1];
                $mail->SMTPSecure = 'ssl';
                $mail->SMTPAuth = true;
                $mail->Username = $_POST['address'];
                $mail->Password = $_POST['smtp_password'];
                $mail->setFrom($_POST['address']);

                //Set an alternative reply-to address
                //$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
                $mail->addAddress($_POST['address']);

//Set the subject line
                $mail->Subject = 'New Inbox Added to Yoliya Account';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
                //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
                $mail->Body = 'This is an automatically generated email sent when you added a new inbox to your yoliya account.';

//Attach an image file
                $mail->addAttachment('/PHPMailer/images/phpmailer_mini.png');

//send the message, check for errors
                if (!$mail->send()) {
                    //echo "Mailer Error: " . $mail->ErrorInfo;
                    $data['error'] .= "<div class='alert alert-danger'>Couldn't connect to SMTP server.</div>";
                } else {
                    //echo "Message sent!";
                }
            }
        }

        if (isset($_POST['test_save']) && empty($data['error'])) {
            $this->Db_model->saveInbox($_POST, $this->user->info->ID);
            $data['error'] .= "<div class='alert alert-success'>Inbox successfully added!</div>";
            $this->output->set_header('refresh:3;url=/email/inboxes');
        }

        $data['metaTitle'] = "Create Inbox";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('inboxes_create', $data);
        $this->load->view('footer', $data);
    }

    public function campaigns_create() {

        $this->load->model('Db_model');
        $data['error'] = "";

        $data['targets'] = "";
        $targets = $this->Db_model->getAudiences($this->user->info->ID);
        if ($targets) {
            foreach ($targets as $target) {
                $data['targets'] .= "<option value'" . $target->filter_id . "'>" . ucwords(strtolower($target->filter_id)) . "</option>";
            }
        }

        $data['boxes'] = "";
        $boxes = $this->Db_model->getInboxes($this->user->info->ID);
        if ($boxes) {
            foreach ($boxes as $box) {
                $data['boxes'] .= "<option value'" . $box->ID . "'>" . ucwords(strtolower($box->address)) . "</option>";
            }
        }

        $data['templates'] = "";
        $templates = $this->Db_model->getEmails($this->user->info->ID);
        if ($templates) {
            foreach ($templates as $template) {
                $data['templates'] .= "<option value'" . $template->ID . "'>" . ucwords(strtolower($template->name)) . "</option>";
            }
        }

        if (isset($_POST['save']) && empty($data['error'])) {
            $this->Db_model->insertCampaign($_POST, $this->user->info->ID);
            $data['error'] .= "<div class='alert alert-success'>Campaign saved!</div>";
            $this->output->set_header('refresh:3;url=/email/campaigns');
        }

        $data['metaTitle'] = "Create Inbox";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('campaigns_create', $data);
        $this->load->view('footer', $data);
    }

    public function email_templates() {


        $this->load->model('db_model');
        $this->load->model("user_model");

        if (!$this->user->loggedin) {
            redirect('/login', 301);
        }

        $data['metaTitle'] = "Emails";
        $data['metaDescription'] = "";
        $data['list'] = "";

        $uid = $this->user->info->ID;

        if (isset($_GET['delete'])) {
            $this->db_model->deleteAudience($_GET['delete'], $uid);
        }

        $emailList = $this->db_model->getEmails($uid);
        $data['list'] = "";

        if ($emailList) {

            foreach ($emailList as $email) {
                $data['list'] .= '<div class="col-sm-6">
            <div href="/create" class="panel panel-bordered mg-b">
                <div class="panel-body">';
                $data['list'] .= "<div class='row'><div class='col-md-6' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>" . ucwords(strtolower($email->subject)) . "</h3></div><div class='col-md-4' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>Created: " . date('M d, Y', strtotime($email->created)) . "</h3></div><div class='col-md-2'><a class='btn btn-danger btn-xs' script=\"confirm('Are you sure?');\" href='/emails?delete=" . $email->ID . "'>Delete</a></div></div>";

                $data['list'] .= "</div>";
                $data['list'] .= "</div></div>";
            }
        }

        $this->load->view('header', $data);
        $this->load->view('email_templates', $data);
        $this->load->view('footer', $data);
    }

    public function email_inboxes() {

        $data['metaTitle'] = "Inboxes";
        $data['metaDescription'] = "";

        $data['list'] = "";


        $this->load->model('db_model');
        $this->load->model("user_model");

        if (!$this->user->loggedin) {
            redirect('/login', 301);
        }

        $uid = $this->user->info->ID;

        if (isset($_GET['delete'])) {
            $this->db_model->deleteInbox($_GET['delete'], $uid);
        }

        $inboxList = $this->db_model->getInboxes($uid);
        $data['list'] = "";

        if ($inboxList) {

            foreach ($inboxList as $inbox) {
                $data['list'] .= '<div class="col-sm-6">
            <div href="/create" class="panel panel-bordered mg-b">
                <div class="panel-body">';
                $data['list'] .= "<div class='row'><div class='col-md-6' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>" . ucwords(strtolower($inbox->address)) . "</h3></div><div class='col-md-4' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>Created: " . date('M d, Y', strtotime($inbox->created)) . "</h3></div><div class='col-md-2'><a class='btn btn-danger btn-xs' script=\"confirm('Are you sure?');\" href='/email/inboxes?delete=" . $inbox->ID . "'>Delete</a></div></div>";

                $data['list'] .= "</div>";
                $data['list'] .= "</div></div>";
            }
        }


        $this->load->view('header', $data);
        $this->load->view('email_inboxes', $data);
        $this->load->view('footer', $data);
    }

    public function email_campaigns() {

        $data['metaTitle'] = "Email Campaigns";
        $data['metaDescription'] = "";

        $data['list'] = "";

        $this->load->model('db_model');

        $campaigns = $this->db_model->getCampaigns($this->user->info->ID);
        if ($campaigns) {
            foreach ($campaigns as $campaign) {
                $data['list'] .= '<div class="col-sm-6">
                <div href="/create" class="panel panel-bordered mg-b">
                <div class="panel-body">';
                $data['list'] .= "<div class='row'><div class='col-md-6' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>" . ucwords(strtolower($campaign->name)) . "</h3></div><div class='col-md-4' style='border-bottom:1px solid #d0d0d0;'><h3 style='display:inline;'>Created: " . date('M d, Y', strtotime($campaign->created)) . "</h3></div><div class='col-md-2'><a class='btn btn-danger btn-xs' script=\"confirm('Are you sure?');\" href='/email/inboxes?delete=" . $campaign->ID . "'>Delete</a></div></div>";

                $data['list'] .= "</div>";
                $data['list'] .= "</div></div>";
            }
        }

        $this->load->view('header', $data);
        $this->load->view('email_campaigns', $data);
        $this->load->view('footer', $data);
    }

    public function cron_files() {

        $this->load->model('db_model');
        $this->load->helper('general_helper');

        if (isset($_GET['days']) && !empty($_GET['days'])) {
            $days = strip_tags(trim("-" . $_GET['days']));
        } else {
            $days = "-1";
        }

        // SETUP HOURLY CRON IN HOSTING
        // GET YESTERDAY
        date_default_timezone_set("America/New_York");
        $this_year = date('Y', strtotime($days . " day"));
        $this_month = date('m', strtotime($days . " day"));
        $yesterday = date('d', strtotime($days . " day"));

        // turn into file names
        $com_filename = $this_year . '-' . $this_month . '-' . $yesterday . '.zip';

        // check database for file name
        $fileExists = $this->db_model->checkFileExists($com_filename, 'success');

        //$res = curl($com_filename);
        // if exists do nothing, else check if file exists in folder then ftp
        if (!$fileExists) {
            if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/downloads/' . $com_filename)) {
                $file = file_get_contents('http://2018-07-10-S:2rG68J4vPRlgXm@members.whoisdatacenter.com/' . $com_filename);
                if ($file) {
                    $put = file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/downloads/' . $com_filename . '', $file);
                    if ($put) {
                        $this->db_model->insertFileLog($com_filename, 'success');
                        echo "<br>Log inserted into db";
                    }
                }
            }

            $unzippedFolder = $_SERVER['DOCUMENT_ROOT'] . '/downloads/' . strtolower(date('dMy', strtotime(str_replace('.zip', '', $com_filename))));
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/downloads/' . $com_filename) && !file_exists($unzippedFolder)) {

                $zipFile = $_SERVER['DOCUMENT_ROOT'] . '/downloads/' . $com_filename;
                $path = pathinfo(realpath($unzippedFolder), PATHINFO_DIRNAME);
                $zip = new ZipArchive;
                $res = $zip->open($zipFile);

                if ($res === TRUE) {
                    // extract it to the path we determined above
                    $zip->extractTo($unzippedFolder);
                    $zip->close();
                    echo "<br>Extracted to " . $unzippedFolder;
                    unlink($zipFile);
                    echo "<br>" . $zipFile . " Deleted";
                } else {
                    echo "Couldn't open " . $zipFile;
                    exit();
                }

                // LOAD INFILE CSV TO DB
                $ref = explode("/", $unzippedFolder);
                if (file_exists($unzippedFolder . "/Country Wise/united_states.csv")) {
                    $this->db_model->insertFile($unzippedFolder . "/Country Wise/united_states.csv");
                } elseif (file_exists($unzippedFolder . "/" . end($ref) . "/Country Wise/united_states.csv")) {
                    $this->db_model->insertFile($unzippedFolder . "/" . end($ref) . "/Country Wise/united_states.csv");
                }
                deleteDir($unzippedFolder);
                echo "<br>All uncompressed files and folders deleted.";
                echo "<br>Operation completed.";
                exit();
            }
        } else {
            echo "Daily operation already completed.";
        }
    }

    public function cron_emails() {

        $this->load->model('db_model');

        // SETUP HOURLY CRON IN HOSTING
        // get todays date
        // check db sent log for todays date
        // if sent do nothing, else get match criteria from user_filters
        // look for matches in db
        // if no matches do nothing, else insert matches to user_matches table
        // loop this batch in user_matches table
        // scrub each match against master opt_out table
        // scrub each match against user_recent_sends table
        // scrub each match against user_opt_out table
        // sennd email
        // log sent email
    }

    public function state() {
        //$this->output->cache(43200); // 30 Days
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');
        $state = str_replace('/', '', uri_string());
        $data['state'] = strtoupper($state);
        $cities = getAllCities($state);
        $data['cities'] = "";
        $data['addresses'] = "";

        if ($cities) {
            foreach ($cities as $city) {
                $data['cities'] .= '<div class="col-md-3"><a href="/' . uri_string() . '/' . formatForSearch($city['city']['S']) . '">' . ucwords(strtolower($city['city']['S'])) . ', ' . strtoupper($city['state']['S']) . '</a></div>';
            }
        } else {
            show_404();
        }

        $data['metaTitle'] = "Find People, Friends & Family in " . $data['state'];
        $data['metaDescription'] = "Find people, friends & family in " . strtoupper($data['state']) . " by searching millions of public records at yoliya.com.";

        $this->load->view('header', $data);
        $this->load->view('state', $data);
        $this->load->view('footer');
    }

    public function city() {
        //$this->output->cache(43200); // 30 Days
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');
        $peices = explode('/', uri_string());
        $city = unslugify($peices[1]);
        $state = unslugify($peices[0]);
        $data['city'] = ucwords(strtolower($city));
        $data['state'] = $state;
        $data['alpha'] = "";
        $i = 0;

        $data['crumbs'] = "";
        $data['crumbs'] .= "<i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "'>" . strtoupper($data['state']) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "'>" . ucwords(str_replace('_', ' ', $data['city'])) . ', ' . strtoupper($data['state']) . "</a>";

        foreach (range('A', 'Z') as $letter) {
            $someNames = getNamesByAlpha($letter, $data['city'], $data['state']);
            if (count($someNames) > 0) {
                $data['alpha'] .= '<div class="col-md-6">';
                $data['alpha'] .= '<div class="row"><div class="col-md-12">';
                $data['alpha'] .= '<div class="page-header"><h2 style="color:white;">' . $letter . '</h2></div>';
                $data['alpha'] .= '</div></div>';
                $data['alpha'] .= '<div class="row">';
                foreach ($someNames as $name) {
                    $data['alpha'] .= '<div class="col-md-6"><a class="white" href="' . current_url() . '/' . $name['first.last']['S'] . '">' . ucwords($name['first']['S']) . ' ' . ucwords($name['last']['S']) . ' in ' . ucwords($name['city']['S']) . ', ' . strtoupper($name['state']['S']) . '</a></div>';
                    $i++;
                }
                $data['alpha'] .= '</div></div>';
            }
        }

        if ($i < 1) {
            redirect('/' . $data['state'], 301);
            exit();
        }

        $data['metaTitle'] = "Find People, Friends & Family In " . ucwords(unformatForSearch($data['city'])) . ", " . strtoupper($data['state']);
        $data['metaDescription'] = "Find people, friends and family in " . ucwords(unformatForSearch($data['city'])) . ", " . strtoupper($data['state']) . " by searching public records at yoliya.com.";

        $this->load->view('header', $data);
        $this->load->view('city', $data);
        $this->load->view('footer');
    }

    public function nameList() {
        //$this->output->cache(43200); // 30 Days
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');
        //$this->load->model('user_model');

        $data['optOutLink'] = " | <a rel='nofollow' href='/opt-out'>Opt-out</a>";

        $peices = explode('/', uri_string());
        $data['state'] = $state = $peices[0];
        $data['city'] = $city = $peices[1];
        $name = $peices[2];

        $parts = explode('.', $name);
        $data['first'] = $first = $parts[0];
        $data['last'] = $last = $parts[1];

        $data['crumbs'] = "";
        $data['crumbs'] .= "<i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "'>" . strtoupper($data['state']) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "'>" . ucwords(unformatForSearch($data['city'])) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "/" . strtolower($name) . "'>" . ucwords(unformatForSearch($data['first'])) . " " . ucwords(unformatForSearch($data['last'])) . "</a>";

        $names = getNameByCity($first, $last, $city, $state);
        $data['count'] = $count = count($names);

        if ($count < 1) {
            redirect('/' . $state . '/' . $city, 301);
            exit();
        }
        $data['nameList'] = "";
        $data['mapAddresses'] = array();
        $a = 1;
        $b = 1;
        $addressList = array();

        if ($names) {
            foreach ($names as $name) {
                $weHave = "";
                $data['mapAddresses'][] = $name['fullAddress']['S'] . ' ' . $name['city']['S'] . ', ' . $name['state']['S'];
                $weHave .= '<a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '"><div class="badge badge-success" data-toggle="tooltip" title="Home Address"><i class="fa fa-home fa-2x"></i></div>';

                $age = CurrentAge($name['dob']['S']);
                if (isset($name['gender']['S']) && $name['gender']['S'] == 'f') {
                    $gender = "Female";
                } elseif (isset($name['gender']['S']) && $name['gender']['S'] == 'm') {
                    $gender = "Male";
                } else {
                    $gender = "";
                }
                if (isset($name['apt']['S'])) {
                    $apartment = $name['apt']['S'];
                } else {
                    $apartment = "";
                }
                if (isset($name['phone']['S'])) {
                    $phone = '<div class="hidden-md hidden-lg"><h4><i class="fa fa-phone"></i> <span class=""><a href="tel:' . $name['phone']['S'] . '">' . formatPhoneNumber($name['phone']['S']) . '</a></span></h4></div>';
                    $phone .= '<div class="hidden-xs hidden-sm"><i class="fa fa-phone"></i> <span class="">' . formatPhoneNumber($name['phone']['S']) . '</span></div>';

                    $weHave .= '<a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '"  data-toggle="tooltip" title="Phone Number"><div class="badge badge-success"><i class="fa fa-phone fa-2x"></i></div>';
                } else {
                    $phone = '';
                    $weHave .= '<a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '"  data-toggle="tooltip" title="Phone Number"><div class="badge badge-success"><i class="fa fa-phone fa-2x"></i></div>';
                }
                if (1 == 1) {
                    $weHave .= '<a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '"  data-toggle="tooltip" title="Email Address"><div class="badge badge-success"><i class="fa fa-at fa-2x"></i></div>';
                } else {
                    $weHave .= "";
                }
                if (isset($name['middle']['S'])) {
                    $middle = $name['middle']['S'];
                } else {
                    $middle = "";
                }

                $weHave .= '<a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '?tab=criminal"  data-toggle="tooltip" title="Criminal Records"><div class="badge badge-success"><i class="fa fa-lock fa-2x"></i></div></a>';

                $sameAddress = getAllFromAddress($name['fullAddress']['S'], $name['city']['S'], $name['state']['S']);
                $neighbors = getNeighbors($name['streetName']['S'], $name['city']['S'], $name['state']['S']);
                $atAddress = "";
                $atAddressArray = array();
                $i = 1;
                foreach ($sameAddress as $address) {
                    if ($name['id']['S'] !== $address['id']['S']) {
                        $atAddressArray[] = $address['id']['S'];
                        if (isset($address['middle']['S'])) {
                            $atAddress .= '<div class="col-md-12"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['middle']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                        } else {
                            $atAddress .= '<div class="col-md-12"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                        }
                        $i++;
                    }
                    if ($i > 5) {
                        if (count($sameAddress) > 5) {
                            $atAddress .= "<div class='col-md-12'><small><i>+" . (count($sameAddress) - 5) . " more...</i></small></div>";
                        }
                        break;
                    }
                }


                $neighbors = getNeighbors($name['streetName']['S'], $name['city']['S'], $name['state']['S']);
                $neighborList = "";
                $i = 1;
                foreach ($neighbors as $neighbor) {
                    if ($name['id']['S'] !== $neighbor['id']['S'] && !in_array($neighbor['id']['S'], $atAddressArray)) {
                        if (isset($neighbor['middle']['S'])) {
                            $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['middle']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                        } else {
                            $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                        }
                        $i++;
                    }
                    if ($i > 3) {
                        if (count($sameAddress) > 3) {
                            $neighborList .= "<div class='col-md-6'><small><i>+" . (count($neighborList) - 3) . " more...</i></small></div>";
                        }
                        break;
                    }
                }

                if ($a == 1) {
                    $ads = '<div class="ad">
                                <div class="inne">
                                    <div class="row vertical-alig">
                                        <div class="col-md-12 text-left">
                                            <div class="" style="font-size:10px;"><i>Advertisements</i></div>
                                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                            <!-- Name List - Main Line -->
                                            <ins class="adsbygoogle"
                                                 style="display:block"
                                                 data-ad-client="ca-pub-2063867378055756"
                                                 data-ad-slot="9994786905"
                                                 data-ad-format="auto"></ins>
                                            <script>
                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                            </script><br>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                } else {
                    $ads = "";
                }

                if ($age > 17 && strtolower(date('F d', $name['dob']['S'])) !== 'december 26') {
                    $ageGender = '
                                <div class="col-md-4">                                    
                                    <div style="">' . $age . ' yrs old, ' . $gender . '</div>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-calendar"></i> Born ' . date('F d, Y', $name['dob']['S']) . '
                                </div>
                                ';
                } elseif ($age > 17 && !empty($gender)) {
                    $ageGender = '
                                <div class="col-md-4">                                    
                                    <div style="">' . $gender . ' Born ' . date('F d, Y', $name['dob']['S']) . '</div>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-calendar"></i> ' . $age . ' yrs.
                                </div>
                                ';
                } elseif ($age > 17 && empty($gender)) {
                    $ageGender = '
                                <div class="col-md-4">                                    
                                    <div style="">Born ' . date('Y', $name['dob']['S']) . '</div>
                                </div>
                                <div class="col-md-2">
                                    <i class="fa fa-calendar"></i> ' . $age . ' yrs.
                                </div>
                                ';
                } else {
                    $ageGender = '
                                <div class="col-md-4">                                    
                                    <div style=""></div>
                                </div>
                                <div class="col-md-2">                                    
                                </div>
                                ';
                }

                $addressList[] = strtolower(str_replace('-', '', str_replace('.', '', $name['fullAddress']['S'])));

                //$data['mapAddresses'][] = $name['fullAddress']['S'] . ' ' . $name['city']['S'] . ' ' . $name['state']['S'];
                $data['nameList'] .= '
                <div class="result">
                    <div class="inner">
                        <div class="row">
                            <div class="col-md-9 hidden-xs">
                                <a href="/' . uri_string() . '/' . $name['id']['S'] . '">
                                            <h2 class="result-name">' . ucwords($name['first']['S']) . ' ' . ucwords($middle) . ' ' . ucwords($name['last']['S']) . '</h2>
                                </a>
                                <span style="display:inline; position:relative; bottom:5px; margin-left:5%;">' . $weHave . '</span>
                                    <div>See ' . ucwords($name['first']['S']) . '\'s: <a href="/' . uri_string() . '/' . $name['id']['S'] . '?tab=criminal&src=nameList-link">Criminal Records</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-contact-info">Contact Info</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-work-history">Work History</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-online-profiles">Online Profiles</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-relationships">Relationships</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-all-records">All Records</a></div>
                            ' . $ads . '</div>
                            <div class="col-md-9 hidden-md hidden-lg hidden-sm text-center">
                                <div class="row">
                                    <div class="col-xs-12" style="margin-bottom:8px;">
                                        <a href="/' . uri_string() . '/' . $name['id']['S'] . '">
                                            <h2 class="result-name">' . ucwords($name['first']['S']) . ' ' . ucwords($middle) . ' ' . ucwords($name['last']['S']) . '</h2>
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div style="display:inline; position:relative; bottom:5px; margin-left:5%;">' . $weHave . '</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 text-right">
                                <a rel="nofollow" href="/' . uri_string() . '/' . $name['id']['S'] . '" class="btn btn-success btn-block btn-xs animated fadeInRight"><i class="fa fa-user"></i> &nbsp; Public Records</a>
                                    <a rel="nofollow" href="/reports" class="btn btn-info btn-block btn-xs animated fadeInRight"><i class="fa fa-lock"></i> &nbsp; Background Check</a>
                            </div>
                        </div>
                        <div class="row vertical-align hidden-sm hidden-xs">
                            <div class="col-md-12">  
                            ' . $ageGender . '
                                <div class="col-md-6">
                                <!-- ' . $phone . ' -->
                                    <div><a href="/' . uri_string() . '/' . $name['id']['S'] . '" rel="nofollow" class="btn btn-info btn-xs"><i class="fa fa-phone"></i>&nbsp; Show Phone #</a></div>
                                <i class="fa fa-map-marker"></i> ' . ucwords($name['fullAddress']['S']) . '. ' . ucwords($apartment) . '<br>
                                    ' . ucwords(unformatForSearch($city)) . '. ' . strtoupper($state) . ' ' . substr($name['zip']['S'], 0, 5) . '
                                </div>                                                            
                            </div>                            
                        </div>   
                        <div class="row hidden-lg hidden-md">
                            <div class="col-md-12 text-center" style="margin-top:8px;"> 
                            
                                <div class="text-center">See ' . ucwords($name['first']['S']) . '\'s: <a href="/' . uri_string() . '/' . $name['id']['S'] . '?tab=criminal&src=nameList-link">Criminal Records</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-contact-info">Contact Info</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-work-history">Work History</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-online-profiles">Online Profiles</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-relationships">Relationships</a> | <a href="/' . uri_string() . '/' . $name['id']['S'] . '?src=nameList-link-all-records">All Records</a></div><br>
                            ' . $ads . '
                                <div><i class="fa fa-map-marker"></i> ' . ucwords($name['fullAddress']['S']) . '. ' . ucwords($apartment) . '</div>
                                <div>' . ucwords(unformatForSearch($city)) . '. ' . strtoupper($state) . ' ' . substr($name['zip']['S'], 0, 5) . '</div>
                                        <div style="margin-top:8px;"><i class="fa fa-calendar"></i> ' . $gender . ' Born ' . date('F d, Y', $name['dob']['S']) . '</div>
                                        <div>(' . $age . ' yrs)</div><br>
                                        <!-- <div style="margin-top:8px;" name="format-detection" content="telephone=no">' . $phone . '</div> -->
                                            <div style="margin-top:0px;" name="format-detection" content="telephone=no"><a href="/' . uri_string() . '/' . $name['id']['S'] . '" rel="nofollow" class="btn btn-info btn-xs"><i class="fa fa-phone"></i>&nbsp; Show Phone #</a><br><br></div>
                            </div>
                        </div>   
                           ';
                $data['nameList'] .= '<div class="row">';
                if (!empty($atAddress)) {
                    $data['nameList'] .= '<div class="col-md-3">
                                <div class="other-title"><i class="fa fa-user"></i> At This Address</div>
                                    <div class="col-md-12">
                                        ' . $atAddress . '
                                    </div>
                            </div>';
                }
                if (!empty($neighborList)) {
                    $data['nameList'] .= '<div class="col-md-8">
                                <div class="other-title"><i class="fa fa-home"></i> ' . ucwords($name['first']['S']) . '\'s Neighbors On ' . ucwords($name['streetName']['S']) . '</div>
                                    <div class="col-md-12">
                                        ' . $neighborList . '
                                    </div>
                            </div>
            ';
                }
                $data['nameList'] .= '</div>
                    </div>
                    </div>
                ';

                // ADSENSE //
                if ($a == 3 || $a % 5 == 0) {
                    if ($b < 3) {
                        $data['nameList'] .= '
                            <div class="ad">
                                <div class="inne">
                                    <div class="row vertical-alig">
                                        <div class="col-md-12 text-left">
                                        <div style="font-size:10px;"><i>Advertisements</i></div>
                                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                            <!-- Name List - Main Line -->
                                            <ins class="adsbygoogle"
                                                 style="display:block"
                                                 data-ad-client="ca-pub-2063867378055756"
                                                 data-ad-slot="9994786905"
                                                 data-ad-format="auto"></ins>
                                            <script>
                                            (adsbygoogle = window.adsbygoogle || []).push({});
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                        $b++;
                    }
                }
                $a++;
            }
            if (!strstr(strtolower($_SERVER['HTTP_USER_AGENT']), "googlebot")) {
                $url = "https://teasers.infopay.com/teaser/affWhitePagesXml?user=cdshowers23@gmail.com&key=d96e82ff967584f119641f22e28655f7852e139d&fname=" . $data['first'] . "&lname=" . $data['last'] . "&city=" . $data['city'] . "&state=" . $data['state'];
                if (($response_xml_data = file_get_contents($url)) === false) {
                    //echo "Error fetching XML\n";
                } else {
                    libxml_use_internal_errors(true);
                    $d = simplexml_load_string($response_xml_data);
                    if (!$d) {
                        //echo "Error loading XML\n";
                        foreach (libxml_get_errors() as $error) {
                            //echo "\t", $error->message;
                        }
                    } else {
                        $xml = new SimpleXMLElement($response_xml_data);
                        //echo var_dump($xml);
                        if (isset($xml->recordset->record)) {
                            $data['nameList'] .= '<h3 class="grey">Possible Matches <small class="pull-right" style="position:relative; bottom:10px;">Data provided by Infopay</small></h3>';

                            foreach ($xml->recordset->record as $r) {
                                if (!in_array(strtolower($r->fullAddress), $addressList)) {
                                    if (!empty($r->age)) {
                                        $age = $r->age . ' yrs';
                                    } else {
                                        $age = "";
                                    }
                                    $data['nameList'] .= '
              <div class="result">
              <div class="inner">
              <div class="row">
              <div class="col-md-9 hidden-xs">
              <a target="_blank" rel="nofollow" href="http://www.everify.com/?s=rw&source=yoliya&redir_page=results/person/&fname=' . $r->firstname . '&lname=' . $r->lastname . '&city=' . urlencode($r->addresses[0]->address->city) . '&state=' . urlencode($r->addresses[0]->address->state) . '&tid=&addPixel=yes">
              <h2 class="result-name">' . ucwords(strtolower($r->firstname)) . ' ' . ucwords(strtolower($r->middlename)) . ' ' . ucwords(strtolower($r->lastname)) . '</h2>
              </a>
              <span style="display:inline; position:relative; bottom:5px; margin-left:5%;"></span>

              </div>
              <div class="col-md-9 hidden-md hidden-lg hidden-sm text-center">
              <div class="row">
              <div class="col-xs-12" style="margin-bottom:8px;">
              <a target="_blank" rel="nofollow" href="http://www.everify.com/?s=rw&source=yoliya&redir_page=results/person/&fname=' . $r->firstname . '&lname=' . $r->lastname . '&city=' . urlencode($r->addresses[0]->address->city) . '&state=' . urlencode($r->addresses[0]->address->state) . '&tid=&addPixel=yes">
              <h2 class="result-name">' . ucwords(strtolower($r->firstname)) . ' ' . ucwords(strtolower($r->middlename)) . ' ' . ucwords(strtolower($r->lastname)) . '</h2>
              </a>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12">
              <div style="display:inline; position:relative; bottom:5px; margin-left:5%;"></div>
              </div>
              </div>
              </div>
              <div class="col-md-3 text-right">
              <a rel="nofollow" target="_blank" href="http://www.everify.com/?s=rw&source=yoliya&redir_page=results/person/&fname=' . $r->firstname . '&lname=' . $r->lastname . '&city=' . urlencode($r->addresses[0]->address->city) . '&state=' . urlencode($r->addresses[0]->address->state) . '&tid=&addPixel=yes" class="btn btn-success btn-block animated fadeInRight"><i class="fa fa-user"></i> &nbsp; View Full Report<div class="buttonText">Contact, Job, Criminal, Family, Etc.</div></a>

              </div>
              </div>
              <div class="row vertical-align hidden-sm hidden-xs">
              <div class="col-md-12">
              <div class="col-md-6"> ' . $age . '</div>
              <div class="col-md-6">
              <i class="fa fa-map-marker"></i> ' . ucwords(strtolower($r->fullAddress)) . '<br>
              ' . ucwords(strtolower($r->addresses[0]->address->city)) . '. ' . ucwords(strtolower($r->addresses[0]->address->state)) . ' ' . ucwords(strtolower($r->addresses[0]->address->zip)) . '
              </div>
              </div>
              </div>
              <div class="row hidden-lg hidden-md">
              <div class="col-md-12 text-center" style="margin-top:8px;">
              <div>(' . $age . ')</div>

              <div><i class="fa fa-map-marker"></i> ' . ucwords(strtolower($r->fullAddress)) . '<br>' . ucwords(strtolower($r->addresses[0]->address->city)) . '. ' . ucwords(strtolower($r->addresses[0]->address->state)) . ' ' . ucwords(strtolower($r->addresses[0]->address->zip)) . '</div>


              </div>
              </div>
              ';
                                    $data['nameList'] .= '</div>
              </div>

              ';
                                    $addressList[] = strtolower(str_replace('-', '', str_replace('.', '', $r->fullAddress)));
                                }
                            }
                        }
                    }
                }
            }
            /*
              $data['nameList'] .= '<h3 class="grey">Possible Matches</h3>';
              $data['nameList'] .= '
              <div class="result">
              <div class="inner">
              <div class="row">
              <div class="col-md-9 hidden-xs">
              <a rel="nofollow" href="/search?fname=' . $data['first'] . '&lname=' . $data['last'] . '&city=' . $data['city'] . '&state=' . $data['state'] . '">
              <h2 class="result-name">' . ucwords(unformatForSearch($data['first'])) . ' ' . ucwords(unformatForSearch($data['last'])) . '</h2>
              </a>
              <span style="display:inline; position:relative; bottom:5px; margin-left:5%;"><div class="badge badge-success"><i class="fa fa-home fa-2x"></i></div> <div class="badge badge-success"><i class="fa fa-phone fa-2x"></i></div> <div class="badge badge-success"><i class="fa fa-lock fa-2x"></i></div></span>
              </div>
              <div class="col-md-9 hidden-md hidden-lg hidden-sm text-center">
              <div class="row">
              <div class="col-xs-12" style="margin-bottom:8px;">
              <a rel="nofollow" href="/search?fname=' . $data['first'] . '&lname=' . $data['last'] . '&city=' . $data['city'] . '&state=' . $data['state'] . '">
              <h2 class="result-name">' . ucwords(unformatForSearch($data['first'])) . ' ' . ucwords(unformatForSearch($data['last'])) . '</h2>
              </a>
              </div>
              </div>
              <div class="row">
              <div class="col-xs-12">
              <div style="display:inline; position:relative; bottom:5px; margin-left:5%;"><div class="badge badge-success"><i class="fa fa-home fa-2x"></i></div> <div class="badge badge-success"><i class="fa fa-phone fa-2x"></i></div> <div class="badge badge-success"><i class="fa fa-lock fa-2x"></i></div></div>
              </div>
              </div>
              </div>
              <div class="col-md-3 text-right">
              <a rel="nofollow" href="/search?fname=' . $data['first'] . '&lname=' . $data['last'] . '&city=' . $data['city'] . '&state=' . $data['state'] . '" class="btn btn-success btn-block animated fadeInRight"><i class="fa fa-user"></i> &nbsp; View All Records<div class="buttonText">Contact, Job, Criminal, Relationships, Etc.</div></a>
              </div>
              </div>

              <div class="row info-row">
              <div class="col-md-1">

              </div></div></div></div>';
             * 
             */
        } else {
            deleteSitmemapItem($first, $last, $city, $state);
            redirect('/' . $state . '/' . $city, 301);
        }
        $data['otherCities'] = "";
        $cities = getNearByCities($city, $state);
        if ($cities) {
            $inCities = getNameByCities($first, $last, $cities, $state);
            foreach ($inCities as $inCity) {
                foreach ($inCity as $c) {
                    $exp = explode('.', $c['first.last.city']['S']);
                    if ($exp[2] !== $city) {
                        $data['otherCities'] .= "<div class='col-md-4'><a href='/" . $state . "/" . $exp[2] . "/" . $c['first.last']['S'] . "'>" . ucwords(unformatForSearch($exp[2])) . ', ' . strtoupper($state) . '</a></div>';
                    }
                }
            }
        }


        $data['metaTitle'] = '(' . $count . ') ' . str_replace("'", "", ucwords(strtolower(unformatForSearch($first)))) . ' ' . str_replace("'", "", ucwords(strtolower(unformatForSearch($last)))) . ' In ' . ucwords(strtolower(unformatForSearch($city))) . ', ' . strtoupper($state);
        $data['metaDescription'] = 'We\'ve found public records for ' . $count . ' ' . str_replace("'", "", ucwords(strtolower(unformatForSearch($first)))) . ' ' . str_replace("'", "", ucwords(strtolower(unformatForSearch($last)))) . ' In ' . ucwords(strtolower(unformatForSearch($city))) . ', ' . strtoupper($state) . ' at yoliya.com. We may have their phone number, pics/images, email address, criminal records if any & other information.';

        $this->load->view('header', $data);
        $this->load->view('nameList');
        $this->load->view('footer');
    }

    public function name() {
        //$this->output->cache(43200); // 30 Days
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');
        $this->load->model("ipn_model");
        $this->load->model("user_model");

        require_once(APPPATH . 'third_party/stripe/init.php');

        $data['stripe'] = $stripe = array(
            "secret_key" => $this->settings->info->stripe_secret_key,
            "publishable_key" => $this->settings->info->stripe_publish_key
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        $peices = explode('/', uri_string());
        $data['state'] = $state = $peices[0];
        $data['city'] = $city = $peices[1];
        $name = $peices[2];
        $id = $peices[3];
        $data['addresses'] = "";
        $data['neighborList'] = "";
        $data['atList'] = "";
        $data['mapAddresses'] = array();
        $data['optOutLink'] = " | <a rel='nofollow' href='/opt-out?url=" . current_url() . "'>Opt-out</a>";
        $data['totalPublic'] = 0;

        $parts = explode('.', $name);
        $first = $parts[0];
        $last = $parts[1];

        $data['name'] = getNameById($id);
        $count = count($data['name']);

        $data['mapAddresses'][] = $data['name']['fullAddress']['S'] . ' ' . $data['name']['city']['S'] . ', ' . $data['name']['state']['S'];

        if ($count < 1) {
            redirect('/' . $data['state'] . '/' . $data['city'] . '/' . $name, 301);
        }

        if (isset($data['name']['gender']['S']) && $data['name']['gender']['S'] == "m") {
            $data['imageGender'] = "men";
        } elseif (isset($data['name']['gender']['S']) && $data['name']['gender']['S'] == "f") {
            $data['imageGender'] = "women";
        } else {
            $data['imageGender'] = "men";
        }

        $data['age'] = CurrentAge($data['name']['dob']['S']);

        if (isset($data['name']['apt']['S'])) {
            $apt = ucwords($data['name']['apt']['S']);
        } else {
            $apt = "";
        }

        $data['crumbs'] = "";
        $data['crumbs'] .= "<i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "'>" . strtoupper($data['state']) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "'>" . ucwords(unformatForSearch($data['city'])) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "/" . strtolower($name) . "'>" . ucwords(unformatForSearch($first)) . " " . ucwords(unformatForSearch($last)) . "</a>";
        $data['crumbs'] .= " <i class='fa fa-angle-right'></i> <a href='/" . strtolower($data['state']) . "/" . strtolower($data['city']) . "/" . strtolower($name) . "/" . $id . "'>" . ucwords($data['name']['fullAddress']['S']) . " " . $apt . "</a>";

        $data['first'] = ucwords($data['name']['first']['S']);
        $data['last'] = ucwords($data['name']['last']['S']);
        if (isset($data['name']['middle']['S'])) {
            $data['middle'] = $data['name']['middle']['S'];
        } else {
            $data['middle'] = "";
        }
        $data['city'] = $data['name']['city']['S'];
        $data['state'] = $data['name']['state']['S'];

        $data['voterRecordListByNameAddress'] = "";
        $voterSearch = searchVoterRecords($data['name']['first']['S'], $data['name']['last']['S'], $data['name']['fullAddress']['S'], $data['name']['city']['S'], $data['name']['state']['S']);
        $data['voterRecordCountByNameAddress'] = count($voterSearch);
        foreach ($voterSearch as $record) {
            if (isset($record['registrationDate']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-1 text-center'>" . date('F d, Y', $record['registrationDate']['S']) . "</div>";
            } else {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-1 text-center'></div>";
            }
            $data['voterRecordListByNameAddress'] .= "<div class='col-md-11'><div class='row'>";
            if (isset($record['first']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>First Name<br><b>" . ucwords($record['first']['S']) . "</b></div>";
            }
            if (isset($record['middle']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Middle<br><b>" . ucwords($record['middle']['S']) . "</b></div>";
            }
            if (isset($record['last']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Last Name<br><b>" . ucwords($record['last']['S']) . "</b></div>";
            }
            if (isset($record['address']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Street Address<br><b>" . ucwords($record['address']['S']) . "</b></div>";
            }
            if (isset($record['city']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>City<br><b>" . ucwords($record['city']['S']) . "</b></div>";
            }
            if (isset($record['state']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>State<br><b>" . ucwords($record['state']['S']) . "</b></div>";
            }
            if (isset($record['zip']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Zip<br><b>" . ucwords($record['zip']['S']) . "</b></div>";
            }
            if (isset($record['county']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>County<br><b>" . ucwords($record['county']['S']) . "</b></div>";
            }
            if (isset($record['gender']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Gender<br><b>" . ucwords($record['gender']['S']) . "</b></div>";
            }
            if (isset($record['race']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Race<br><b>" . ucwords($record['race']['S']) . "</b></div>";
            }
            if (isset($record['voterID']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Voter ID<br><b>" . ucwords($record['voterID']['S']) . "</b></div>";
            }
            if (isset($record['mailingAddress']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Mailing Address<br><b>" . ucwords($record['mailingAddress']['S']) . "</b></div>";
            }
            if (isset($record['mailingCity']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Mailing City<br><b>" . ucwords($record['mailingCity']['S']) . "</b></div>";
            }
            if (isset($record['mailingState']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Mailing State<br><b>" . ucwords($record['mailingState']['S']) . "</b></div>";
            }
            if (isset($record['mailingZip']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Mailing Zip<br><b>" . ucwords($record['mailingZip']['S']) . "</b></div>";
            }
            if (isset($record['dob']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Birth Date<br><b>" . date('F d, Y', $record['dob']['S']) . "</b></div>";
            }
            if (isset($record['partyAffiliation']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Party Affiliation<br><b>" . ucwords($record['partyAffiliation']['S']) . "</b></div>";
            }
            if (isset($record['precinct']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Precinct<br><b>" . ucwords($record['precinct']['S']) . "</b></div>";
            }
            if (isset($record['precinctGroup']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Precinct Group<br><b>" . ucwords($record['precinctGroup']['S']) . "</b></div>";
            }
            if (isset($record['precinctSplit']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Precinct Split<br><b>" . ucwords($record['precinctSplit']['S']) . "</b></div>";
            }
            if (isset($record['precinctSuffix']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Precinct Suffix<br><b>" . ucwords($record['precinctSuffix']['S']) . "</b></div>";
            }
            if (isset($record['voterStatus']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Voter Status (as of " . date('m/d/y', $record['created']['S']) . ")<br><b>" . ucwords($record['voterStatus']['S']) . "</b></div>";
            }
            if (isset($record['congressionalDistrict']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Congressional District<br><b>" . ucwords($record['congressionalDistrict']['S']) . "</b></div>";
            }
            if (isset($record['houseDistrict']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>House District<br><b>" . ucwords($record['houseDistrict']['S']) . "</b></div>";
            }
            if (isset($record['senateDistrict']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Senate District<br><b>" . ucwords($record['senateDistrict']['S']) . "</b></div>";
            }
            if (isset($record['countyCommissionDistrict']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>County Commission District<br><b>" . ucwords($record['countyCommissionDistrict']['S']) . "</b></div>";
            }
            if (isset($record['schoolBoardDistrict']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>School Board District<br><b>" . ucwords($record['schoolBoardDistrict']['S']) . "</b></div>";
            }
            if (isset($record['areaCode']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Area Code<br><b class=''>" . ucwords($record['areaCode']['S']) . "</b></div>";
            }
            if (isset($record['phone']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Phone<br><b class=''>" . ucwords($record['phone']['S']) . "</b></div>";
            }
            if (isset($record['email']['S'])) {
                $data['voterRecordListByNameAddress'] .= "<div class='col-md-2 col-xs-6 info'>Email Address<br><b>" . ucwords($record['email']['S']) . "</b></div>";
            }
            $data['voterRecordListByNameAddress'] .= "</div></div>";
            $data['totalPublic'] ++;
        }


        $sameAddress = getAllFromAddress($data['name']['fullAddress']['S'], $data['name']['city']['S'], $data['name']['state']['S']);
        $neighbors = getNeighbors($data['name']['streetName']['S'], $data['name']['city']['S'], $data['name']['state']['S']);
        $atAddress = "";
        $sameAddressArray = array();
        $i = 1;
        $data['sameAddressCount'] = (count($sameAddress) - 1);
        foreach ($sameAddress as $address) {
            if ($data['name']['id']['S'] !== $address['id']['S']) {
                $sameAddressArray[] = $address['id']['S'];
                if (isset($address['middle']['S'])) {
                    $atAddress .= '<div class="col-md-6"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['middle']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                } else {
                    $atAddress .= '<div class="col-md-6"><a href="/' . slugify($address['state']['S']) . '/' . slugify($address['city']['S']) . '/' . $address['first.last']['S'] . '/' . $address['id']['S'] . '">' . ucwords($address['first']['S'] . ' ' . $address['last']['S']) . '</a> (' . CurrentAge($address['dob']['S']) . ' yrs)</div>';
                }
                $i++;
                $data['totalPublic'] ++;
            }
            if ($i > 10) {
                if (count($sameAddress) > 10) {
                    $atAddress .= "<div class='col-md-12'><small><i>+" . (count($sameAddress) - 10) . " more...</i></small></div>";
                }
                break;
            }
        }

        $neighbors = getNeighbors($data['name']['streetName']['S'], $data['name']['city']['S'], $data['name']['state']['S']);
        $neighborList = "";
        $data['neighborCount'] = (count($neighbors));
        $data['neighborCount'] = ($data['neighborCount'] - count($sameAddressArray));
        $i = 1;
        foreach ($neighbors as $neighbor) {
            if ($data['name']['id']['S'] !== $neighbor['id']['S'] && !in_array($neighbor['id']['S'], $sameAddressArray)) {
                if (isset($neighbor['middle']['S'])) {
                    $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['middle']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                } else {
                    $neighborList .= '<div class="col-md-6"><a href="/' . slugify($neighbor['state']['S']) . '/' . slugify($neighbor['city']['S']) . '/' . $neighbor['first.last']['S'] . '/' . $neighbor['id']['S'] . '">' . ucwords($neighbor['first']['S'] . ' ' . $neighbor['last']['S']) . '</a> (' . CurrentAge($neighbor['dob']['S']) . ' yrs)<br>@ ' . ucwords($neighbor['fullAddress']['S']) . '.</div>';
                }
                $i++;
                $data['totalPublic'] ++;
            }
            if ($i > 20) {
                if (count($sameAddress) > 20) {
                    $neighborList .= "<div class='col-md-6'><small><i>+" . (count($neighborList) - 20) . " more...</i></small></div>";
                }
                break;
            }
        }

        $name = $data['name'];

        if (!empty($atAddress)) {
            $data['atList'] .= '<div class="col-md-12">
                                <div class="other-title"><i class="fa fa-user"></i> At This Address</div>
                                    <div class="col-md-12">
                                        ' . $atAddress . '
                                    </div>
                            </div>';
        }
        if (!empty($neighborList)) {
            $data['neighborList'] .= '<div class="col-md-12">
                                <div class="other-title"><i class="fa fa-home"></i> ' . ucwords($name['first']['S']) . '\'s Neighbors On ' . ucwords($name['streetName']['S']) . '</div>
                                    <div class="col-md-12">
                                        ' . $neighborList . '
                                    </div>
                            </div>
            ';
        }

        if ($data['sameAddressCount'] < 1) {
            $data['sameAddressCount'] = 0;
        }
        if ($data['neighborCount'] < 1) {
            $data['neighborCount'] = 0;
        }

        $data['addresses'] = "'" . $name['fullAddress']['S'] . " " . $name['city']['S'] . " " . $name['state']['S'] . " " . $name['zip']['S'] . "'";

        $data['metaTitle'] = ucwords($data['first'] . ' ' . $data['middle'] . ' ' . $data['last'] . ' in ' . $data['city']) . ', ' . strtoupper($data['state']);
        $data['metaDescription'] = 'All public records for ' . ucwords($data['first'] . ' ' . $data['middle'] . ' ' . $data['last'] . ' in ' . $data['city']) . ', ' . strtoupper($data['state']) . ' @ ' . ucwords($name['fullAddress']['S']) . '.';
        $data['noIndex'] = true;

        $this->load->view('header', $data);
        $this->load->view('name', $data);
        $this->load->view('footer', $data);
    }

    public function privacy_policy() {

        $data['metaTitle'] = "Privacy Policy @ yoliya, Inc.";
        $data['metaDescription'] = "";
        $data['noIndex'] = true;

        $this->load->view('header', $data);
        $this->load->view('privacy_policy', $data);
        $this->load->view('footer');
    }

    public function sitemap_zip() {
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');

        $parts = explode('/', uri_string());
        $state = $parts[1];
        $zip = $parts[2];

        $listPages = getListPages($zip, $state);

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        foreach ($listPages as $list) {
            $state = $list['state']['S'];
            $city = str_replace($list['first.last']['S'] . '.', '', $list['first.last.city']['S']);
            $firstLast = $list['first.last']['S'];

            $url = $urlset->addChild('url');
            $url->addChild('loc', 'https://yoliya.com/' . $state . '/' . $city . '/' . $firstLast);
            $url->addChild('priority', '1.0');
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
    }

    public function sitemapIndex_1($state) {
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');

        //$parts = explode('/', uri_string());

        $zips = getZips($state);
        $count = count($zips);
        $split = ($count / 2);
        $i = 1;

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        foreach ($zips as $zip) {

            $state = $zip['state']['S'];
            $zip = $zip['zip']['S'];

            $url = $urlset->addChild('sitemap');
            $url->addChild('loc', 'https://yoliya.com/sitemaps/' . $state . '/' . $zip);
            //$url->addChild('changefreq', 'monthly');
            //$url->addChild('priority', '1.0');
            $i++;
            if ($i > $split) {
                break;
            }
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
    }

    public function sitemapIndex_2($state) {
        $this->load->helper('url');
        $this->load->helper('general');
        $this->load->helper('aws');

        //$parts = explode('/', uri_string());

        $zips = getZips($state);
        $count = count($zips);
        $split = ($count / 2);
        $i = 1;

        $urlset = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" /><!--?xml version="1.0" encoding="UTF-8"?-->');

        foreach ($zips as $zip) {
            if ($i > $split) {
                $state = $zip['state']['S'];
                $zip = $zip['zip']['S'];

                $url = $urlset->addChild('sitemap');
                $url->addChild('loc', 'https://yoliya.com/sitemaps/' . $state . '/' . $zip);
                //$url->addChild('changefreq', 'monthly');
                //$url->addChild('priority', '1.0');
            }
            $i++;
        }

        $dom = new DomDocument();
        $dom->loadXML($urlset->asXML());

        $dom->formatOutput = true;
        $data['map'] = $dom->saveXML();

        $this->load->view('sitemapxml', $data);
    }

    public function opt_out() {
        //$this->load->helper('aws');
        $this->load->model('Db_model');
        $data['noIndex'] = true;
        $data['messages'] = "";

        $data['metaTitle'] = "Opt Out of yoliya.";
        $data['metaDescription'] = "Hide your personal information & opt out of yoliya.";

        if (isset($_POST['form'])) {
            if (empty($_POST['url'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please copy & paste your profile URL below.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['fName'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your first name.</div>";
            }
        }
        if (isset($_POST['form'])) {
            if (empty($_POST['lName'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your last name.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['birthMonth'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your birth month.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['birthDay'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your birth day.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['birthYear'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your birth year.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['email'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your email address.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['address'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your address.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['phone'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please provide your 10-digit phone number.</div>";
            }
        }

        if (isset($_POST['form'])) {
            if (empty($_POST['agree'])) {
                $data['messages'] .= "<div class='alert alert-danger'>Please state that you agree to our Privacy Policy and that this is your information/profile by checking the box below.</div>";
            }
        }

        if (empty($data['messages']) && isset($_POST['form'])) {
            $parts = explode('/', $_POST['url']);
            $name = getNameById($parts[6]);

            if (isset($name['id']['S'])) {
                $_POST['city.state'] = $name['city.state']['S'];
                $_POST['fullAddress.last.first.middle'] = $name['fullAddress.last.first.middle']['S'];
                $insert = $this->Db_model->insertOptOut($_POST);
                removeName($name['city.state']['S'], $name['fullAddress.last.first.middle']['S']);
                $data['messages'] = "<div class='alert alert-success'>Your request has been submitted. We'll process it shortly.</div>";
            } else {
                $data['messages'] = "<div class='alert alert-danger'>Profile not found. It has already been removed or the profile URL you submitted below is not correct.</div>";
            }
        }

        $this->load->view('header', $data);
        $this->load->view('opt-out');
        $this->load->view('footer');
    }

    public function tac() {
        $data['noIndex'] = true;

        $data['metaTitle'] = "Yoliya, Inc Terms & Conditions";
        $data['metaDescription'] = "Yoliya's terms, conditions and other legal stuff.";

        $this->load->view('header', $data);
        $this->load->view('terms_and_conditions');
        $this->load->view('footer');
    }

    public function search() {
        $this->load->helper('aws');
        $this->load->model('Db_model');
        $this->load->helper('general');
        $data['noIndex'] = true;
        $data['messages'] = "";

        $data['metaTitle'] = "New Report";
        $data['metaDescription'] = "";

        $data['mapAddresses'][] = $_GET['city'] . ', ' . $_GET['state'];

        $this->load->view('header', $data);
        $this->load->view('search');
        $this->load->view('footer');
    }

}
