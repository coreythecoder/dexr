<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Archive extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $this->template->loadData("activeLink", array("archive" => array("general" => 1)));
        $this->load->model("user_model");
        $this->load->model("home_model");
        $this->load->model("Db_model");
        if (!$this->user->loggedin) {
            redirect(site_url("login"));
        }
    }

    public function index() {
        if (defined('REQUEST') && REQUEST == "external") {
            return;
        }
        $totalReports = $this->Db_model->countReports($this->user->info->ID);

        $reports = $this->Db_model->getReports($this->user->info->ID);
        $reportList = "";
        if ($totalReports > 0) {
            foreach ($reports as $report) {
                $date = date('M d, Y', strtotime($report->timestamp));
                $reportList .= "<div class='col-sm-4 panel-item'>
                            <a href='/reports/".$report->ID."' style='color:inherit;' class='panel panel-circle-contrast panel-light pricing-table'>
                                <div class='panel-icon'>
                                    <i class='fa fa-list-alt icon'></i>
                                </div>
                                <div class='panel-body'>
                                    <h3 class='panel-title'>" . ucwords(strtolower($report->first)) . " " . ucwords(strtolower($report->middle)) . " " . ucwords(strtolower($report->last)) . "</h3>
                                    Created<br>" . $date . "
                                    
                                </div>
                            </a>
                        </div> ";
            }
        }

        $this->template->loadContent("archive/index.php", array(
            "reportList" => $reportList,
            "totalReports" => $totalReports
                )
        );
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