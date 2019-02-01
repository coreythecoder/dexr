<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $this->template->loadData("activeLink", array("home" => array("general" => 1)));
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->model("funds_model");
        $this->load->model("Db_model");
        $this->load->helper("aws");
        $this->load->helper("url");
        if (!$this->user->loggedin) {
            redirect("/login");
        }
      
    }

    public function index() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');
        $this->load->helper("stripe");
        
        $data['userType'] = $this->db_model->userPlanType($this->user->info->ID);

        $data['error'] = "";
        $data['list'] = "";
        $data['total'] = "";
        $e = 0;

        if (isset($_POST['load']) && !empty($_POST['load'])) {
            $loadedData = $this->Db_model->filters($_POST['load']);
            if ($loadedData) {
                $data['loadedFilter'] = true;
                unset($_POST['col'], $_POST['type'], $_POST['keyword']);
                foreach ($loadedData as $ld) {
                    $_POST['col'][$e] = $ld->filter_key;
                    $_POST['type'][$e] = $ld->match_type;
                    $_POST['keyword'][$e] = $ld->filter_value;
                    $e++;
                }
            }
        }

        if (isset($_POST['search']) && !empty($_POST['keyword'])) { 
            $data['list'] .= '<tr><th><strong>Organization</strong></th><th>Contact</th><th>Address</th><th>Created</th></tr>';
            if ($this->input->post('daterangeTrue')) {
                $query = $this->db_model->applyFilters($_POST, 25, $this->input->post('daterange'));
            } else {
                $query = $this->db_model->applyFilters($_POST, 25, false);
            }
            //$data['count'] = $this->db_model->applyFilters_Count($_POST, $this->input->post('daterange'));
            //echo var_dump($_POST); exit();
            $data['total'] = count($query);
            foreach ($query as $domain) {
                $data['list'] .= '<tr><td><a href="http://' . $domain->domain_name . '" target="_blank">' . $domain->domain_name . '</a><br><strong>' . $domain->registrant_company . '</strong></td><td>' . ucwords(strtolower($domain->registrant_name)) . '<br>' . substr(formatPhoneNumber($domain->registrant_phone), 0, -4) . "xxxx" . '<br>' . obfuscate_email(strtolower($domain->registrant_email)) . '</td><td>' . ucwords(strtolower($domain->registrant_address)) . '<br>' . ucwords(strtolower($domain->registrant_city)) . ', ' . $domain->registrant_state . '</td><td>' . $domain->created_date_normalized . '</td></tr>';
                //domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone
            }
        }

        if (isset($_POST['save']) || !empty($_POST['hidden_campaign_type']) && !empty($_POST['keyword'][0]) && !empty($_POST['filter_label'])) {
            $nameExists = $this->db_model->audienceNameExists(trim(strtolower($_POST['filter_label'])));

            if ($nameExists == false) {
                $this->db_model->insertFilters($_POST['col'], $_POST['type'], $_POST['keyword'], trim(strtolower($_POST['filter_label'])), $this->user->info->ID);
                $data['error'] .= "<div class='alert alert-success'>Filter saved successfully!</div>";
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'email_redirect') {
                    redirect("/email/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'robo_redirect') {
                    redirect("/robo/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'sms_redirect') {
                    redirect("/sms/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'alarm_redirect') {
                    redirect("/alarm/campaigns", 301);
                }
            } elseif (empty($_POST['filter_label'])) {
                $data['error'] .= "<div class='alert alert-danger'>Filter label cannot be left blank.</div>";
            } else {
                $data['error'] .= "<div class='alert alert-danger'>Filter label already exists. Please click \"Update View\" and save with a different label.</div>";
            }
        } elseif (isset($_POST['save'])) {
            $data['error'] .= "<div class='alert alert-danger'>Didn't save. Please make sure the filter label as well as at least one filter is set.</div>";
        }

        $data['userFilters'] = "";
        if (isset($this->user->info->ID)) {
            $userFilters = $this->Db_model->getFilters($this->user->info->ID);

            if ($userFilters) {
                foreach ($userFilters as $filter) {
                    $data['userFilters'] .= "<option value='" . $filter->filter_id . "'>" . $filter->filter_id . "</option>";
                }
            }
        }

        if (isset($this->user->info->ID) && isset($_POST['datasetName']) && !empty($_POST['datasetName'])) {
            if (isset($_POST["daterangeTrue"]) && !empty($this->input->post("daterange"))) {
                $processed = $this->db_model->processDataset($this->user->info->ID, trim(strtolower($this->input->post("datasetName"))), $_POST['col'], $_POST['type'], $_POST['keyword'], $_POST, $this->input->post("daterange"));
            } else {
                $processed = $this->db_model->processDataset($this->user->info->ID, trim(strtolower($this->input->post("datasetName"))), $_POST['col'], $_POST['type'], $_POST['keyword'], $_POST, false);
            }

            if ($processed) {
                redirect("/dataset/" . $processed . "/25/1");
            }
        }


        $data['metaTitle'] = "Search Corpus";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/index');
        $this->load->view('footer');
    }

    public function dataset($dataset_id, $count, $page) {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        if (!$this->user->info->ID) {
            redirect("/login");
        }

        $this->load->model('db_model');
        $this->load->helper("stripe");
        $data['userType'] = $this->db_model->userPlanType($this->user->info->ID);

        $datasetInfo = $this->db_model->getDatasetInfo($dataset_id);
        $data['dataset_id'] = $dataset_id;
        $data['userID'] = $this->user->info->ID;
        $data['datasetInfo'] = $datasetInfo;

        if (isset($_POST['webhook'])) {
            $this->db_model->insertZap($this->input->post("webhook"), $this->input->post("name"), $this->user->info->ID);
        }
        if (isset($_POST['delete_zap'])) {
            $this->db_model->deleteZap($this->input->post("zap_list"));
        }

        $zaps = $this->db_model->getUserZaps($this->user->info->ID);
        $data['existingZaps'] = "";
        $data['zapButtons'] = "";
        if ($zaps) {
            foreach ($zaps as $z) {
                $data['existingZaps'] .= "<option value='" . $z->ID . "'>" . $z->zap_name . "</option>";
            }
        }


        $data['error'] = "";
        $data['list'] = "";
        $data['total'] = "";
        $e = 0;

        if (isset($_POST['load']) && !empty($_POST['load'])) {
            $loadedData = $this->Db_model->filters($_POST['load']);
            if ($loadedData) {
                $data['loadedFilter'] = true;
                unset($_POST['col'], $_POST['type'], $_POST['keyword']);
                foreach ($loadedData as $ld) {
                    $_POST['col'][$e] = $ld->filter_key;
                    $_POST['type'][$e] = $ld->match_type;
                    $_POST['keyword'][$e] = $ld->filter_value;
                    $e++;
                }
            }
        }

        if (isset($_POST['download'])) {
            $count = 10000;
        }

        $data['list'] .= '<tr><th><strong>Organization</strong></th><th>Zaps</th><th>Contact</th><th>Address</th><th>Created</th></tr>';
        if ($this->input->post('daterangeTrue')) {
            $query = $this->db_model->applyFiltersDataset($datasetInfo->table_name, $_POST, $count, $this->input->post('daterange'), $page);
            $data['count'] = $this->db_model->applyFiltersDataset_count($datasetInfo->table_name, $_POST, $count, $this->input->post('daterange'), $page);
        } else {
            $query = $this->db_model->applyFiltersDataset($datasetInfo->table_name, $_POST, $count, false, $page);
            $data['count'] = $this->db_model->applyFiltersDataset_count($datasetInfo->table_name, $_POST, $count, false, $page);
        }
        //$data['count'] = $this->db_model->applyFilters_CountDataset($datasetInfo->table_name, $_POST, $this->input->post('daterange'));
        //echo var_dump($_POST); exit();

        if (isset($_POST['download'])) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header("Content-Disposition: attachment; filename=" . str_replace(' ', '_', strtolower($datasetInfo->table_name)) . "_" . date('y-m-d_h_i_s') . ".csv");
            header('Last-Modified: ' . date('D M j G:i:s T Y'));
            $outss = fopen("php://output", "w");

            function objectToArray($object) {
                if (!is_object($object) && !is_array($object))
                    return $object;

                return array_map('objectToArray', (array) $object);
            }

            $query = objectToArray($query);

            foreach ($query as $rows) {
                fputcsv($outss, $rows);
            }
            fclose($outss);

            exit();
        }

        $data['total'] = count($query);
        $zapButtons = "";
        foreach ($query as $domain) {
            if ($zaps) {
                foreach ($zaps as $z) {
                    $zapButtons .= "<div><button style='padding:2px 15px; background-color:#333; border:0px; ' class=\"btn btn-default btn-sm zap-button\" onclick=\"zap('" . $this->user->info->ID . "', '" . $domain->ID . "', '" . $z->ID . "', '" . $datasetInfo->table_name . "');\">" . ucwords($z->zap_name) . "</button></div>";
                }
            }

            $data['list'] .= '<tr><td><a href="http://' . $domain->domain_name . '" target="_blank">' . $domain->domain_name . '</a><br><strong>' . $domain->registrant_company . '</strong></td><td>' . $zapButtons . '</td><td>' . ucwords(strtolower($domain->registrant_name)) . '<br>' . formatPhoneNumber($domain->registrant_phone) . '<br>' . strtolower($domain->registrant_email) . '</td><td>' . ucwords(strtolower($domain->registrant_address)) . '<br>' . ucwords(strtolower($domain->registrant_city)) . ', ' . $domain->registrant_state . '</td><td>' . $domain->create_date . '</td></tr>';
            //domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone
            $zapButtons = "";
        }


        if (isset($_POST['save']) || !empty($_POST['hidden_campaign_type']) && !empty($_POST['keyword'][0]) && !empty($_POST['filter_label'])) {
            $nameExists = $this->db_model->audienceNameExists(trim(strtolower($_POST['filter_label'])));

            if ($nameExists == false) {
                $this->db_model->insertFilters($_POST['col'], $_POST['type'], $_POST['keyword'], trim(strtolower($_POST['filter_label'])), $this->user->info->ID);
                $data['error'] .= "<div class='alert alert-success'>Filter saved successfully!</div>";
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'email_redirect') {
                    redirect("/email/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'robo_redirect') {
                    redirect("/robo/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'sms_redirect') {
                    redirect("/sms/campaigns", 301);
                }
                if (!empty($_POST['hidden_campaign_type']) && $_POST['hidden_campaign_type'] == 'alarm_redirect') {
                    redirect("/alarm/campaigns", 301);
                }
            } elseif (empty($_POST['filter_label'])) {
                $data['error'] .= "<div class='alert alert-danger'>Filter label cannot be left blank.</div>";
            } else {
                $data['error'] .= "<div class='alert alert-danger'>Filter label already exists. Please click \"Update View\" and save with a different label.</div>";
            }
        } elseif (isset($_POST['save'])) {
            $data['error'] .= "<div class='alert alert-danger'>Didn't save. Please make sure the filter label as well as at least one filter is set.</div>";
        }

        $data['userFilters'] = "";
        if (isset($this->user->info->ID)) {
            $userFilters = $this->Db_model->getFilters($this->user->info->ID);

            if ($userFilters) {
                foreach ($userFilters as $filter) {
                    $data['userFilters'] .= "<option value='" . $filter->filter_id . "'>" . $filter->filter_id . "</option>";
                }
            }
        }

        $data['maxPerPage'] = $count;
        $data['lastPage'] = $data['count'] / $count;
        $data['thisPage'] = $page;

        $data['metaTitle'] = ucwords(strtolower($datasetInfo->name));
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/dataset');
        $this->load->view('footer');
    }

    public function downloadCSV($tableID, $name) {

        $datasetData = $this->db_model->getDataset($tableID);

        header('Content-Type: text/csv; charset=utf-8');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header("Content-Disposition: attachment; filename=" . str_replace(' ', '_', strtolower($name)) . "_" . date('y-m-d_h_i_s') . ".csv");
        header('Last-Modified: ' . date('D M j G:i:s T Y'));
        $outss = fopen("php://output", "w");
        foreach ($datasetData->result_array() as $rows) {
            fputcsv($outss, $rows);
        }
        fclose($outss);
    }

    public function datasets() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');
        $this->load->helper("stripe");
        $data['userType'] = $this->db_model->userPlanType($this->user->info->ID);

        if (isset($_GET['delete']) && !empty($_GET['delete'])) {
            $this->db_model->deleteUserTable($this->input->get("delete"), $this->user->info->ID);
            redirect("/datasets");
        }

        if (isset($_GET['action']) && $_GET['action'] == 'download') {
            $datasetInfo = $this->db_model->getDatasetInfo($this->input->get("dataset_id"));
            if ($datasetInfo->user_id == $this->user->info->ID) {
                $this->downloadCSV($datasetInfo->table_name, $datasetInfo->name);
                exit();
            }
        }

        $data['datasetList'] = "";
        if (isset($this->user->info->ID)) {

            $datasets = $this->db_model->getDatasets($this->user->info->ID);

            if ($datasets) {
                foreach ($datasets as $d) {

                    $filters = $this->db_model->getFilter($this->user->info->ID, $d->name);
                    $filterList = "";
                    if ($filters) {
                        foreach ($filters as $f) {
                            $filterList .= $f->filter_key . " <strong>" . $f->match_type . "</strong> " . $f->filter_value . "; ";
                        }
                    }

                    if (($data['userType'] == 'admin' || $data['userType'] == 'free_pro') || (hasSubscription("plan_EOP7ViqCXFPfte") || hasSubscription("plan_EOP6GRC06U4CFz"))) {
                        $dlButton = '<a href="/datasets?dataset_id=' . $d->ID . '&uid=' . $this->user->info->ID . '&action=download" class="btn btn-default btn-xs btn-block download-button" style="position:relative; top:8px;"><i class="fa fa-download"></i> Download</a>';
                    } else {
                        $dlButton = '<a class="btn btn-default btn-xs btn-block download-button noThinker" style="position:relative; top:8px;" disabled><i class="fa fa-download"></i> Download</a>';
                    }

                    $data['datasetList'] .= '<div class="col-lg-4 col-md-6 stagerred-box animated fadeInUp">
            <div class="dataset" style="border:1px solid #ddd; border-radius:0px;">
                <h4><i class="fa fa-database"></i> Dataset: ' . ucwords(strtolower($d->name)) . '</h4>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">                        
                        Created: ' . date('M d, Y', strtotime($d->created)) . '<br>
                        
                    </div>
                    <div class="col-md-6 text-center">
                        <i class="fa fa-check-circle fa-5x blue" style="position:relative; bottom:15px;left:15px;"></i>                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 text-center">
                        <a href="/dataset/' . $d->ID . '/25/1" class="btn btn-default btn-xs btn-block" style="position:relative; top:8px;"><i class="fa fa-eye"></i> View Data</a>
                    </div>
                    <div class="col-md-5 text-center">
                        ' . $dlButton . '
                    </div>
                    <div class="col-md-1 pull-right">
                        <a href="/datasets?delete=' . $d->ID . '" class="noThinker" onclick="return confirm(\'Are you sure? This will permanantly delete dataset: ' . ucwords(strtolower($d->name)) . '\');"><i class="fa fa-trash red" style="font-size:1.4em; position:relative; right:10px; top:25px; color:red;"></i></a>
                    </div>
                </div>
            </div>
        </div>';
                }
            }
        }

        $data['metaTitle'] = "My Datasets";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/datasets');
        $this->load->view('footer');
    }

    public function zap($UID, $recordID, $zapID, $tableName) {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');
        $zapInfo = $this->db_model->getZapInfo($zapID);
        $recordInfo = $this->db_model->getRecord($recordID, $tableName);

        $jsonEncodedData = json_encode($recordInfo);
        $curl = curl_init();
        $opts = array(
            CURLOPT_URL => $zapInfo[0]->zap_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $jsonEncodedData,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'Content-Length: ' . strlen($jsonEncodedData))
        );

        // Set curl options
        curl_setopt_array($curl, $opts);

        // Get the results
        $result = curl_exec($curl);

        // Close resource
        curl_close($curl);

        //$this->db_model->insertZap($UID, $result);

        echo $result;
        exit();
    }

    public function scrub() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');

        if (isset($_GET['action']) && $_GET['action'] == 'download') {
            $datasetInfo = $this->db_model->getDatasetInfo($this->input->get("dataset_id"));
            if ($datasetInfo->user_id == $this->user->info->ID) {
                $this->downloadCSV($datasetInfo->table_name, $datasetInfo->name);
                exit();
            }
        }

        $data['datasetList'] = "";
        if (isset($this->user->info->ID)) {

            $datasets = $this->db_model->getDatasets($this->user->info->ID);

            if ($datasets) {
                foreach ($datasets as $d) {

                    $filters = $this->db_model->getFilter($this->user->info->ID, $d->name);
                    $filterList = "";
                    if ($filters) {
                        foreach ($filters as $f) {
                            $filterList .= $f->filter_key . " <strong>" . $f->match_type . "</strong> " . $f->filter_value . "; ";
                        }
                    }

                    $data['datasetList'] .= '<div class="col-lg-4 col-md-6 stagerred-box animated fadeInUp">
            <div class="dataset">
                <h4><i class="fa fa-database"></i> Dataset: ' . ucwords(strtolower($d->name)) . '</h4>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        Records: ' . number_format($d->records) . '<br>
                        Created: ' . date('M d, Y', strtotime($d->created)) . '<br>
                        Filters: ' . $filterList . '
                    </div>
                    <div class="col-md-6 text-center">
                        <i class="fa fa-check-circle fa-5x blue"></i>                    
                    </div>
                </div>
                <div class="row"><br><br>
                    <div class="col-md-5 text-center">
                        <a href="/dataset/' . $d->ID . '/25/1" class="btn btn-default btn-xs btn-block" style="position:relative; top:8px;"><i class="fa fa-eye"></i> View Data</a>
                    </div>
                    <div class="col-md-5 text-center">
                        <a href="/datasets?dataset_id=' . $d->ID . '&uid=' . $this->user->info->ID . '&action=download" class="btn btn-default btn-xs btn-block noThinker" style="position:relative; top:8px;"><i class="fa fa-download"></i> Download</a>
                    </div>
                    <div class="col-md-1 pull-right">
                        <a href="" class="noThinker" onclick="return confirm(\'Are you sure? This will permanantly delete dataset: ' . ucwords(strtolower($d->name)) . '\');"><i class="fa fa-trash red" style="font-size:1.4em; position:relative; right:10px; top:10px;"></i></a>
                    </div>
                </div>
            </div>
        </div>';
                }
            }
        }

        $data['metaTitle'] = "Scrubbing";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/datasets');
        $this->load->view('footer');
    }

    private function get_fresh_results($stats) {
        $data = new STDclass;

        $data->google_members = $this->user_model->get_oauth_count("google");
        $data->facebook_members = $this->user_model->get_oauth_count("facebook");
        $data->twitter_members = $this->user_model->get_oauth_count("twitter");
        $data->total_members = $this->user_model->get_total_members_count();
        $data->new_members = $this->user_model->get_new_today_count();
        $data->active_today = $this->user_model->get_active_today_count();

        return $data;
    }

    public function change_language() {
        $languages = $this->config->item("available_languages");
        if (!isset($_COOKIE['language'])) {
            $lang = "";
        } else {
            $lang = $_COOKIE["language"];
        }
        $this->template->loadContent("home/change_language.php", array(
            "languages" => $languages,
            "user_lang" => $lang
                )
        );
    }

    public function change_language_pro() {
        $lang = $this->common->nohtml($this->input->post("language"));
        $languages = $this->config->item("available_languages");
        if (!in_array($lang, $languages, TRUE)) {
            $this->template->error(lang("error_25"));
        }

        setcookie("language", $lang, time() + 3600 * 7, "/");
        $this->session->set_flashdata("globalmsg", lang("success_14"));
        redirect(site_url());
    }

    public function pricing() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');

        $CI = get_instance();

        require_once(APPPATH . 'third_party/stripe/init.php');

        $stripe = array(
            "secret_key" => $CI->settings->info->stripe_secret_key,
            "publishable_key" => $CI->settings->info->stripe_publish_key
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        // ON POST SAVE CUSTOMER ID FROM STRIPE RESPONSE
        if (isset($_POST['stripeToken'])) {
            // CREATE CUSTOMER AT STRIPE
            \Stripe\Stripe::setApiKey($CI->settings->info->stripe_secret_key);

            $customer = \Stripe\Customer::create([
                        "description" => $this->user->info->email,
                        "source" => trim($this->input->post("stripeToken")) // obtained with Stripe.js
            ]);

            // SAVE CUST ID FOR LATER USE
            $this->db_model->saveStripeCustomerID($this->user->info->ID, $customer->id);

            // GET PLAN TYPE
            $pid = "plan_EOP7ViqCXFPfte";
            //$pid = "plan_EOPfv7iEDXLQFy"; // TEST
            $trial = strtotime("+7 Days");
            if ($this->input->post("type") == "pro") {
                $pid = "plan_EOP6GRC06U4CFz";
                //$pid = "plan_EOPPjrZGnFyQlM"; // TEST
                $trial = "now";
            }

            // SUBSCRIBE CUSTOMER TO PLAN 
            $subscribe = \Stripe\Stripe::setApiKey($CI->settings->info->stripe_secret_key);

            \Stripe\Subscription::create([
                "customer" => trim($customer->id),
                "items" => [
                    [
                        "plan" => $pid,
                    ],
                ],
                "trial_end" => $trial
            ]);

            redirect("/");
        }

        $data['metaTitle'] = "Pricing";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/pricing');
        $this->load->view('footer');
    }

}

?>