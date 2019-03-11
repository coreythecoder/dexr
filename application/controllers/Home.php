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
        $this->load->helper("stripe");
        if (!$this->user->loggedin) {
            redirect("/login");
        }
    }

    public function index() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $userType = $this->Db_model->userPlanType($this->user->info->ID);
        if ($userType !== 'admin' && $userType !== 'free_pro' && $userType !== 'free_premium' && !hasSubscription($this->config->item('pro')) && !hasSubscription($this->config->item('premium'))) {
            redirect("https://app.dexr.io/pricing");
            $data['hideMenu'] = true;
        }

        $this->load->model('db_model');

        //$data['userType'] = $userType = $this->db_model->userPlanType($this->user->info->ID);

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

        if (isset($_POST['search']) && (!empty($_POST['keyword'][0]) || !empty($_POST['keyword'][1]) || !empty($_POST['keyword'][2]) || !empty($_POST['keyword'][3]) || !empty($_POST['keyword'][4]) || !empty($_POST['keyword'][5]) || !empty($_POST['keyword'][6]) || !empty($_POST['keyword'][7]) || !empty($_POST['keyword'][8]))) {
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
                $data['list'] .= '<tr><td><a href="http://' . $domain->domain_name . '" target="_blank">' . $domain->domain_name . '</a><br><strong>' . $domain->registrant_company . '</strong></td><td>' . ucwords(strtolower($domain->registrant_name)) . '<br>' . formatPhoneNumber($domain->registrant_phone) . '<br>' . strtolower($domain->registrant_email) . '</td><td>' . ucwords(strtolower($domain->registrant_address)) . '<br>' . ucwords(strtolower($domain->registrant_city)) . ', ' . $domain->registrant_state . '</td><td>' . $domain->created_date_normalized . '</td></tr>';
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

                    if (($data['userType'] == 'admin' || $data['userType'] == 'free_pro') || hasSubscription($this->config->item('pro'))) {
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

    public function reports() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');
        $this->load->helper("stripe");
        $data['userType'] = $this->db_model->userPlanType($this->user->info->ID);
        $data['reportList'] = "";

        $reports = $this->db_model->getUserReports($this->user->info->ID);
        if ($reports) {
            $data['reportList'] .= "<tr><th>Name, City, State</th><th style='text-align:right;'>Created</th></tr>";
            foreach ($reports as $report) {
                $data['reportList'] .= "<tr><td><a href='/report/" . $report->state . "/" . $report->city_slug . "/" . $report->name_slug . "' target='_blank'><i class='fa fa-user'></i>&nbsp; " . ucwords(unslugify($report->name_slug)) . ", " . ucwords(unslugify($report->city_slug)) . ", " . strtoupper($report->state) . "</a></td><td style='text-align:right;'>" . $report->created . "</td></tr>";
            }
        }

        $data['metaTitle'] = "My Name Reports";
        $data['metaDescription'] = "";

        $this->load->view('header', $data);
        $this->load->view('home/reports');
        $this->load->view('footer');
    }

    public function report($state, $city, $name) {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }

        $this->load->model('db_model');
        $this->load->model('frontend_model');
        $this->load->helper("stripe");
        $data['userType'] = $this->db_model->userPlanType($this->user->info->ID);
        $data['reportList'] = "";


        $currPath = $_SERVER['REQUEST_URI'];

        if (isset($currPath) && substr($currPath, -1) == '-') {
            redirect("https://dexr.io" . substr_replace($currPath, "", -1), 'location', 301);
            exit();
        }

        $statesArray = statesArray();
        $data['state'] = $statesArray[strtoupper($state)];
        $data['state_abr'] = $state;
        $data['city'] = ucwords(str_replace('-', ' ', $city));
        $data['city_slug'] = $city;
        $data['name_slug'] = $name;
        $data['domains'] = "";
        $siteList = array();
        $i = 0;

        $domains = $this->frontend_model->getDomainsByCityStateName($city, $state, $name, 50);
        $nId = $this->frontend_model->getNameIdFromNameSlugCityState($city, $state, $name);
        $data['total'] = $domains['total'];

        $domainBucket = array();

        if ($domains['results']) {
            foreach ($domains['results'] as $d) {
                $data['domains'] .= "<div class='row domain'>";
                $data['domains'] .= "<div class='col-md-12'><h2 class='word-break'><i class='fa fa-asterisk' style='color:#09afdf;'></i> " . $d->domain_name . "</h2><div class='separator'></div></div>";

                $created = "";
                if (!empty($d->created_date_normalized)) {
                    $ex = explode(" ", $name);
                    $created = " " . ucwords(strtolower($ex[0])) . " registered this web site on " . date('M d, Y', strtotime($d->created_date_normalized)) . ". ";
                }
                $expires = "";
                if (!empty($d->expiry_date)) {
                    $expires = " The expiration for " . ucwords($d->domain_name) . " is listed as " . date('M d, Y', strtotime($d->expiry_date)) . ". ";
                }

                $updated = "";
                if (!empty($d->update_date)) {
                    $updated = " The site's info was last updated on " . date('M d, Y', strtotime($d->update_date));
                }

                if (!empty($d->registrant_company)) {
                    $updated .= " by " . ucwords(strtolower($d->registrant_company)) . " who is the registered company for this domain.";
                } else {
                    $updated .= ".";
                }

                $contact = "";
                if (!empty($d->registrant_phone)) {
                    $contact = " You may be able to contact them at " . formatPhoneNumber($d->registrant_phone);
                }

                if (!empty($d->registrant_email)) {
                    $contact .= " or using their email address at " . obfuscate_email($d->registrant_email) . ".";
                } else {
                    $contact .= ".";
                }

                if ($data['total'] > 5) {
                    $totalListed = '5';
                } else {
                    $totalListed = $data['total'];
                }

                if ($i == 0) {
                    //$data['domains'] .= "<div class='col-md-12'><p>" . ucwords(str_replace('-', ' ', strtolower($name))) . " was located at " . ucwords(strtolower($d->registrant_address)) . " in " . $data['city'] . ", " . strtoupper($state) . " when they registered " . ucwords($d->domain_name) . " at " . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "." . $created . $expires . $updated . $contact . " We have " . $data['total'] . " domain registration(s) total in our database, " . $totalListed . " of which are listed below. For the complete list please create an account, <a href='/pricing?src=name&link=description' rel='nofollow'>click here for pricing</a>.</p><div class='separator'></div></div>";
                }

                $data['domains'] .= "<div class='col-md-9'>";
                $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Keyword Split</div><div class='col-info'>" . $d->num . "</div></div>";
                if (!empty($d->created_date_normalized)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>" . date('M d, Y', strtotime($d->created_date_normalized)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->update_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>" . date('M d, Y', strtotime($d->update_date)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->expiry_date)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>" . date('M d, Y', strtotime($d->expiry_date)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_name)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>" . $d->registrant_name . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_company)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>" . ucwords(strtolower($d->registrant_company)) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_address)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>" . $d->registrant_address . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_city)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>" . ucwords(strtolower($d->registrant_city)) . ", " . $d->registrant_state . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_state)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>" . $d->registrant_state . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_zip)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>" . $d->registrant_zip . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_email)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>" . $d->registrant_email . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_phone)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>" . formatPhoneNumber($d->registrant_phone) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>-</div></div>";
                }

                if (!empty($d->registrant_fax)) {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>" . formatPhoneNumber($d->registrant_fax) . "</div></div>";
                } else {
                    $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>-</div></div>";
                }

                $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrar</div><div class='col-info'>" . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "</div></div>";

                $data['domains'] .= "</div>";

                $data['domains'] .= "<div class='col-md-3 text-center'>"
                        . "<img style='width:250px; height:250px; border-radius:50%; margin-top:40px; margin-bottom:40px; margin-left:auto; margin-right:auto;' src='https://maps.googleapis.com/maps/api/staticmap?center=" . explode("|", explode("#", ucwords(strtolower($d->registrant_address)))[0])[0] . " " . $data['city'] . ", " . strtoupper($state) . "&zoom=13&size=250x250&maptype=roadmap
                                        &markers=color:blue%7Clabel:%7C" . explode("|", explode("#", ucwords(strtolower($d->registrant_address)))[0])[0] . " " . $data['city'] . ", " . strtoupper($state) . "
                                        &key=AIzaSyBSK9ERERVRBcrcRMVZkwhIt9Hjjb42dMg'></img>"
                        . "</div>";


                if ($i < 3) {
                    $siteList[] = $d->domain_name;
                    $i++;
                }
                $data['domains'] .= "</div>";

                $domainBucket['theseDomains'][$d->domain_name] = $d->domain_name;
                $domainBucket['emails'][$d->registrant_email] = trim($d->registrant_email);
                $domainBucket['cities'][$d->city_slug . ", " . $d->registrant_state] = $d->city_slug . ", " . $d->registrant_state;
                $domainBucket['phones'][trim($d->registrant_phone)] = trim($d->registrant_phone);
                $domainBucket['addresses'][slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state] = slugify($d->registrant_address) . "|" . $d->city_slug . "|" . $d->registrant_state;
            }

            //echo var_dump($domainBucket); // exit();

            $newBucket = array();

            if ($domainBucket['emails']) {
                foreach ($domainBucket['emails'] as $bucketEmails) {
                    $bucketFromEmail = $this->frontend_model->getAllFromEmail($bucketEmails, 20);
                    if ($bucketFromEmail) {
                        foreach ($bucketFromEmail as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains']['registrant_email'][$bfe->domain_name] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['phones']) {
                foreach ($domainBucket['phones'] as $bucketPhones) {
                    $bucketFromPhone = $this->frontend_model->getAllFromPhone($bucketPhones, 20);
                    if ($bucketFromPhone) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains']['registrant_phone'][$bfe->domain_name] = $bfe->registrant_phone;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array(slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state, $domainBucket['addresses'])) {
                                $newBucket['addresses'][slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state] = slugify($bfe->registrant_address) . "|" . $bfe->city_slug . "|" . $bfe->registrant_state;
                            }
                        }
                    }
                }
            }

            if ($domainBucket['addresses']) {
                foreach ($domainBucket['addresses'] as $bucketAddress) {
                    $bucketFromAddress = $this->frontend_model->getAllFromAddress($bucketAddress, 20);
                    if ($bucketFromAddress) {
                        foreach ($bucketFromPhone as $bfe) {
                            if (!in_array($bfe->domain_name, $domainBucket['theseDomains'])) {
                                $newBucket['domains']['registrant_address'][$bfe->domain_name] = $bfe->registrant_address;
                            }
                            if (!in_array($bfe->registrant_email, $domainBucket['emails'])) {
                                $newBucket['emails'][$bfe->registrant_email] = $bfe->registrant_email;
                            }
                            if (!in_array($bfe->city_slug . ", " . $bfe->registrant_state, $domainBucket['cities'])) {
                                $newBucket['cities'][$bfe->city_slug . ", " . $bfe->registrant_state] = $bfe->city_slug . ", " . $bfe->registrant_state;
                            }
                            if (!in_array($bfe->registrant_phone, $domainBucket['phones'])) {
                                $newBucket['phones'][$bfe->registrant_phone] = $bfe->registrant_phone;
                            }
                        }
                    }
                }
            }

            // echo var_dump($newBucket['domains']); exit();

            $data['contains_cities'] = "";

            if (!isset($newBucket['addresses'])) {
                $newBucket['addresses'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['addresses'], $domainBucket['addresses']);
            foreach ($merged as $address) {
                $ex = explode("|", $address);
                $obfuscated[] = ucwords(unslugify($ex[0]) . ' ' . $ex[1]) . ", " . strtoupper($ex[2]);
            }
            $data['contains_addresses'] = '
                    <div class="col-md-5 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['addresses'], $domainBucket['addresses'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Address(es)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';

            if (!isset($newBucket['phones'])) {
                $newBucket['phones'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['phones'], $domainBucket['phones']);
            foreach ($merged as $phone) {
                $obfuscated[] = formatPhoneNumber($phone);
            }
            $data['contains_phones'] = '
                    <div class="col-md-3 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['phones'], $domainBucket['phones'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Phone(s)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';

            if (!isset($newBucket['emails'])) {
                $newBucket['emails'] = array();
            }
            $obfuscated = array();
            $merged = array_merge($newBucket['emails'], $domainBucket['emails']);
            foreach ($merged as $email) {
                $obfuscated[] = $email;
            }
            $data['contains_emails'] = '
                    <div class="col-md-4 other-text">
                        <div class="col-md-4 text-center">
                            <div class="others-number mobile-center">' . count(array_merge($newBucket['emails'], $domainBucket['emails'])) . '</div>
                        </div>
                        <div class="col-md-8">
                            <div class="others-label small mobile-center">Email(s)</div>
                            <div class="others-list small mobile-center"><strong>' . implode(",<br>", $obfuscated) . '</strong></div>
                        </div>
                    </div>';

// BEGIN LINKED DOMAINS

            if (isset($newBucket['domains']) && !empty($newBucket['domains'])) {

                $data['domains'] .= "<hr></hr><div class='row' style='margin-bottom:40px;'><div class='col-md-12'><h2>Linked Registrations</h2></div><p>Below are registrations we've discovered linked by phone, street address or phone number.</p></div>";

                foreach ($newBucket['domains'] as $match_field => $array) {
                    foreach ($array as $k => $match_value) {

                        $d = $this->frontend_model->getDomainInfoByDomain($k, $match_field, $match_value);

                        $data['domains'] .= "<div class='row domain'>";
                        $data['domains'] .= "<div class='col-md-12'><h2 class='word-break'><i class='fa fa-asterisk' style='color:#09afdf;'></i> " . $d->domain_name . " &nbsp; <span style='font-size:.6em;' class='pull-right'>(Matched by " . ucwords(unslugify($match_field)) . ": " . $match_value . ")</span></h2><div class='separator'></div></div>";

                        $created = "";
                        if (!empty($d->created_date_normalized)) {
                            $ex = explode(" ", $name);
                            $created = " " . ucwords(strtolower($ex[0])) . " registered this web site on " . date('M d, Y', strtotime($d->created_date_normalized)) . ". ";
                        }
                        $expires = "";
                        if (!empty($d->expiry_date)) {
                            $expires = " The expiration for " . ucwords($d->domain_name) . " is listed as " . date('M d, Y', strtotime($d->expiry_date)) . ". ";
                        }

                        $updated = "";
                        if (!empty($d->update_date)) {
                            $updated = " The site's info was last updated on " . date('M d, Y', strtotime($d->update_date));
                        }

                        if (!empty($d->registrant_company)) {
                            $updated .= " by " . ucwords(strtolower($d->registrant_company)) . " who is the registered company for this domain.";
                        } else {
                            $updated .= ".";
                        }

                        $contact = "";
                        if (!empty($d->registrant_phone)) {
                            $contact = " You may be able to contact them at " . formatPhoneNumber($d->registrant_phone);
                        }

                        if (!empty($d->registrant_email)) {
                            $contact .= " or using their email address at " . obfuscate_email($d->registrant_email) . ".";
                        } else {
                            $contact .= ".";
                        }

                        if ($data['total'] > 5) {
                            $totalListed = '5';
                        } else {
                            $totalListed = $data['total'];
                        }

                        if ($i == 0) {
                            $data['domains'] .= "<div class='col-md-12'><p>" . ucwords(str_replace('-', ' ', strtolower($name))) . " was located at " . ucwords(strtolower($d->registrant_address)) . " in " . $data['city'] . ", " . strtoupper($state) . " when they registered " . ucwords($d->domain_name) . " at " . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "." . $created . $expires . $updated . $contact . " We have " . $data['total'] . " domain registration(s) total in our database, " . $totalListed . " of which are listed below. For the complete list please create an account, <a href='/pricing?src=name&link=description' rel='nofollow'>click here for pricing</a>.</p><div class='separator'></div></div>";
                        }

                        $data['domains'] .= "<div class='col-md-9'>";
                        $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Keyword Split</div><div class='col-info'>" . $d->num . "</div></div>";
                        if (!empty($d->created_date_normalized)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>" . date('M d, Y', strtotime($d->created_date_normalized)) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Created</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->update_date)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>" . date('M d, Y', strtotime($d->update_date)) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Updated</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->expiry_date)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>" . date('M d, Y', strtotime($d->expiry_date)) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Expiration</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_name)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>" . $d->registrant_name . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrant Name</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_company)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>" . ucwords(strtolower($d->registrant_company)) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Company</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_address)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>" . $d->registrant_address . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Address</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_city)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>" . ucwords(strtolower($d->registrant_city)) . ", " . $d->registrant_state . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>City</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_state)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>" . $d->registrant_state . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>State</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_zip)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>" . $d->registrant_zip . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Zip</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_email)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>" . $d->registrant_email . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Email</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_phone)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>" . formatPhoneNumber($d->registrant_phone) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Phone</div><div class='col-info'>-</div></div>";
                        }

                        if (!empty($d->registrant_fax)) {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>" . formatPhoneNumber($d->registrant_fax) . "</div></div>";
                        } else {
                            $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Fax</div><div class='col-info'>-</div></div>";
                        }

                        $data['domains'] .= "<div class='col-md-4'><div class='col-title'>Registrar</div><div class='col-info'>" . str_replace('Llc', 'LLC', ucwords(strtolower($d->domain_registrar_name))) . "</div></div>";

                        $data['domains'] .= "</div>";

                        $data['domains'] .= "<div class='col-md-3 text-center'>"
                                . "<img style='width:250px; height:250px; border-radius:50%; margin-top:40px; margin-bottom:40px; margin-left:auto; margin-right:auto;' src='https://maps.googleapis.com/maps/api/staticmap?center=" . explode("|", explode("#", ucwords(strtolower($d->registrant_address)))[0])[0] . " " . $data['city'] . ", " . strtoupper($state) . "&zoom=13&size=250x250&maptype=roadmap
                                        &markers=color:blue%7Clabel:%7C" . explode("|", explode("#", ucwords(strtolower($d->registrant_address)))[0])[0] . " " . $data['city'] . ", " . strtoupper($state) . "
                                        &key=AIzaSyBSK9ERERVRBcrcRMVZkwhIt9Hjjb42dMg'></img>"
                                . "</div>";


                        if ($i < 3) {
                            $siteList[] = $d->domain_name;
                            $i++;
                        }
                        $data['domains'] .= "</div>";
                    }
                }
            }
            // END LINKED DOMAINS 


            $idRollList = "";
            $data['names'] = "";


            //$data['domains'] .= "</div>";
        } else {
            show_404();
        }

        if (count($siteList) > 0) {
            $siteList = implode(', ', $siteList);
        } else {
            $siteList = $siteList[0];
        }

        $data['name'] = ucwords($domains['results'][0]->registrant_name);

        if (empty($data['names'])) {
            //header('Location: /' . $state);
        }

        //$data['showAds'] = true;

        $data['metaTitle'] = "Webmaster: " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state);
        $data['metaDescription'] = "Contact webmaster " . ucwords(str_replace('-', ' ', strtolower($name))) . " in " . $data['city'] . ", " . strtoupper($state) . " by owner name, email, phone or address. They've registered " . $siteList . ".";


        $this->load->view('header', $data);
        $this->load->view('home/report');
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
        
        $userType = $this->Db_model->userPlanType($this->user->info->ID);
        if ($userType !== 'admin' && $userType !== 'free_pro' && $userType !== 'free_premium' && (!hasSubscription($this->config->item('pro')) || !hasSubscription($this->config->item('premium')))) {
            $data['hideMenu'] = true;
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
            $pid = $this->config->item('premium');
            //$pid = "plan_EOPfv7iEDXLQFy"; // TEST
            $trial = strtotime("+7 Days");
            if ($this->input->post("type") == "pro") {
                $pid = $this->config->item('pro');
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