<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Live extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $this->template->loadData("activeLink", array("home" => array("general" => 1)));
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->model("funds_model");
        $this->load->model("db_model");
        $this->load->helper("aws");       
    }

    public function index() { 
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        
        $this->load->model('db_model');

        $data['error'] = "";
        $data['list'] = "";
        $data['total'] = "";
        $e = 0;

        if (isset($_POST['search']) && !empty($_POST['keyword'][0])) {
            $data['list'] .= '<tr><th><strong>Organization</strong></th><th class="text-center">Default Actions</th><th>Contact</th><th>Address</th><th>Properties</th></tr>';
            $query = $this->db_model->applyFilters($_POST, 50, $this->input->post('daterange'));
            //echo var_dump($_POST); exit();
            $data['total'] = count($query);
            foreach ($query as $domain) {
                $data['list'] .= '<tr><td><strong>' . $domain->registrant_company . '</strong></td><td class="text-center"><i class="fa fa-at" data-toggle="tooltip" data-placement="left" title="Email"></i><br><i class="fa fa-users" data-toggle="tooltip" data-placement="left" title="RoboCall"></i><br><i class="fa fa-mobile" data-toggle="tooltip" data-placement="left" title="SMS"></i></td><td>' . ucwords(strtolower($domain->registrant_name)) . '<br>' . formatPhoneNumber($domain->registrant_phone) . '<br>' . strtolower($domain->registrant_email) . '</td><td>' . ucwords(strtolower($domain->registrant_address)) . '<br>' . ucwords(strtolower($domain->registrant_city)) . ', ' . $domain->registrant_state . '</td><td>' . $domain->domain_name . '</td></tr>';
                //domainName, registrarName, createdDate, registrant_email, registrant_name, registrant_city, registrant_state, registrant_country, registrant_telephone
            }
        }



        $data['userFilters'] = "";
        

        $data['metaTitle'] = "dexr";
        $data['metaDescription'] = "";

        $this->load->view('live/header', $data);
        $this->load->view('live/index');
        $this->load->view('live/footer');
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

}

?>