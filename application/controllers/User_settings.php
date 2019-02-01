<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Settings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("user_model");
        $this->load->model("Db_model");

        if (!$this->user->loggedin)
            $this->template->error(lang("error_1"));

        $this->template->loadData("activeLink", array("settings" => array("general" => 1)));
    }

    public function index() {
        $totalReports = $this->Db_model->countReports($this->user->info->ID);
        //$charges = $this->Db_model->getCharges($this->user->info->ID);

        require_once(APPPATH . 'third_party/stripe/init.php');

        $stripe = array(
            "secret_key" => $this->settings->info->stripe_secret_key,
            "publishable_key" => $this->settings->info->stripe_publish_key
        );

        \Stripe\Stripe::setApiKey($stripe['secret_key']);

        if (isset($_GET['cancel']) && !empty($_GET['cancel'])) {
            $sub = \Stripe\Subscription::retrieve(trim($_GET['cancel']));
            $sub->cancel();

            $message = "Hi," . PHP_EOL . PHP_EOL;
            $message .= "We're just sending you confirmation that we have canceled your public records search subscription at dexr.io.  We hope you've enjoyed using our services and hope to see you back soon!" . PHP_EOL . PHP_EOL;
            $message .= "The yoliya.com Team";
            $html = "Hi " . ucwords($this->user->info->first_name) . ",<br><br>";
            $html .= "We're just sending you confirmation that we have cancelled your public records search subscription at dexr.io.  We hope you've enjoyed using our services and hope to see you back soon!<br><br>";
            $html .= "The yoliya.com Team";

            $this->load->helper('aws');

            //sendEmail($this->user->info->email, "subscriptions@yoliya.com", "Dexr.io Subscription Canceled", $message, $html);
        }

        $chargeList = "";

        if (!empty($this->Db_model->getCustomerID($this->user->info->ID))) {
            $charges = \Stripe\Charge::all(array("limit" => 5, "customer" => $this->Db_model->getCustomerID($this->user->info->ID)));
        }

        if (isset($charges->data[0])) {
            $chargeList .= "<table class='table table-striped'>";
            $chargeList .= "<tr><th>Amount</th><th class='text-left'>Date</th><th class='text-right'>Status</th></tr>";
            foreach ($charges->data as $charge) {
                $chargeList .= "<tr><td>$" . number_format(($charge->amount / 100), 2, '.', ' ') . "</td><td class='text-left'>" . date("M d, Y", $charge->created) . "</td><td class='text-right'>" . ucwords($charge->status) . "</td></tr>";
            }
            $chargeList .= "</table>";
        } else {
            $chargeList .= "<div class='no-charges text-center'>No Charges Yet.</div>";
            $chargeList .= "";
        }

        if (!empty($this->Db_model->getCustomerID($this->user->info->ID))) {
            $subscriptions = \Stripe\Subscription::all(array('customer' => $this->Db_model->getCustomerID($this->user->info->ID)));
        }
        $subList = "";
        if (isset($subscriptions->data[0])) {
            $subList .= "<table class='table table-striped'>";
            $subList .= "<tr><th>Plan</th><th>Amount</th><th class='text-left'>Interval</th><th>Action</th></tr>";
            foreach ($subscriptions->data as $sub) {
                $subList .= "<tr><td>" . ucwords($sub->plan->name) . "</td><td>$" . number_format(($sub->plan->amount / 100), 2, '.', ' ') . "</td><td class='text-left'>" . ucwords($sub->plan->interval) . "ly</td><td><a href='/user_settings?cancel=" . $sub->id . "' onclick=\"return confirm('Are you sure?')\">Cancel</a></td></tr>";
            }
            $subList .= "</table>";
        } else {
            $subList .= "<div class='no-charges text-center'>No Subscriptions.</div>";
        }
        
        $data['metaTitle'] = "My Account";
        $data['metaDescription'] = "";
        
        $this->load->view("header", $data);

        $fields = $this->user_model->get_custom_fields_answers(array(
            "edit" => 1
                ), $this->user->info->ID);
        $this->template->loadContent("user_settings/index.php", array(
            "fields" => $fields,
            "totalReports" => $totalReports,
            "chargeList" => $chargeList,
            "subList" => $subList
                )
        );
    }

    public function pro() {
        $this->load->model("register_model");
        $fields = $this->user_model->get_custom_fields_answers(array(
            "edit" => 1
                ), $this->user->info->ID);

        $this->load->helper('email');
        $this->load->library("upload");
        $email = $this->common->nohtml($this->input->post("email"));
        $first_name = $this->common->nohtml($this->input->post("first_name"));
        $last_name = $this->common->nohtml($this->input->post("last_name"));
        $aboutme = $this->common->nohtml($this->input->post("aboutme"));

        $this->load->helper('email');

        if (empty($email))
            $this->template->error(lang("error_18"));

        if (!valid_email($email)) {
            $this->template->error(lang("error_47"));
        }

        if ($email != $this->user->info->email) {
            if (!$this->register_model->checkEmailIsFree($email)) {
                $this->template->error(lang("error_20"));
            }
        }

        $enable_email_notification = intval($this->input->post("enable_email_notification"));
        if ($enable_email_notification > 1 || $enable_email_notification < 0)
            $enable_email_notification = 0;

        if ($this->settings->info->avatar_upload) {
            if ($_FILES['userfile']['size'] > 0) {
                $this->upload->initialize(array(
                    "upload_path" => $this->settings->info->upload_path,
                    "overwrite" => FALSE,
                    "max_filename" => 300,
                    "encrypt_name" => TRUE,
                    "remove_spaces" => TRUE,
                    "allowed_types" => "gif|png|jpg|jpeg",
                    "max_size" => $this->settings->info->file_size
                ));

                if (!$this->upload->do_upload()) {
                    $this->template->error(lang("error_21")
                            . $this->upload->display_errors());
                }

                $data = $this->upload->data();

                $image = $data['file_name'];
            } else {
                $image = $this->user->info->avatar;
            }
        } else {
            $image = $this->user->info->avatar;
        }

        // Custom Fields
        // Process fields
        $answers = array();
        foreach ($fields->result() as $r) {
            $answer = "";
            if ($r->type == 0) {
                // Look for simple text entry
                $answer = $this->common->nohtml($this->input->post("cf_" . $r->ID));

                if ($r->required && empty($answer)) {
                    $this->template->error(lang("error_78") . $r->name);
                }
                // Add
                $answers[] = array(
                    "fieldid" => $r->ID,
                    "answer" => $answer
                );
            } elseif ($r->type == 1) {
                // HTML
                $answer = $this->common->nohtml($this->input->post("cf_" . $r->ID));

                if ($r->required && empty($answer)) {
                    $this->template->error(lang("error_78") . $r->name);
                }
                // Add
                $answers[] = array(
                    "fieldid" => $r->ID,
                    "answer" => $answer
                );
            } elseif ($r->type == 2) {
                // Checkbox
                $options = explode(",", $r->options);
                foreach ($options as $k => $v) {
                    // Look for checked checkbox and add it to the answer if it's value is 1
                    $ans = $this->common->nohtml($this->input->post("cf_cb_" . $r->ID . "_" . $k));
                    if ($ans) {
                        if (empty($answer)) {
                            $answer .= $v;
                        } else {
                            $answer .= ", " . $v;
                        }
                    }
                }

                if ($r->required && empty($answer)) {
                    $this->template->error(lang("error_78") . $r->name);
                }
                $answers[] = array(
                    "fieldid" => $r->ID,
                    "answer" => $answer
                );
            } elseif ($r->type == 3) {
                // radio
                $options = explode(",", $r->options);
                if (isset($_POST['cf_radio_' . $r->ID])) {
                    $answer = intval($this->common->nohtml($this->input->post("cf_radio_" . $r->ID)));

                    $flag = false;
                    foreach ($options as $k => $v) {
                        if ($k == $answer) {
                            $flag = true;
                            $answer = $v;
                        }
                    }
                    if ($r->required && !$flag) {
                        $this->template->error(lang("error_78") . $r->name);
                    }
                    if ($flag) {
                        $answers[] = array(
                            "fieldid" => $r->ID,
                            "answer" => $answer
                        );
                    }
                }
            } elseif ($r->type == 4) {
                // Dropdown menu
                $options = explode(",", $r->options);
                $answer = intval($this->common->nohtml($this->input->post("cf_" . $r->ID)));
                $flag = false;
                foreach ($options as $k => $v) {
                    if ($k == $answer) {
                        $flag = true;
                        $answer = $v;
                    }
                }
                if ($r->required && !$flag) {
                    $this->template->error(lang("error_78") . $r->name);
                }
                if ($flag) {
                    $answers[] = array(
                        "fieldid" => $r->ID,
                        "answer" => $answer
                    );
                }
            }
        }


        $this->user_model->update_user($this->user->info->ID, array(
            "email" => $email,
            "first_name" => $first_name,
            "last_name" => $last_name,
            "email_notification" => $enable_email_notification,
            "avatar" => $image,
            "aboutme" => $aboutme)
        );

        // Update CF
        // Add Custom Fields data
        foreach ($answers as $answer) {
            // Check if field exists
            $field = $this->user_model->get_user_cf($answer['fieldid'], $this->user->info->ID);
            if ($field->num_rows() == 0) {
                $this->user_model->add_custom_field(array(
                    "userid" => $this->user->info->ID,
                    "fieldid" => $answer['fieldid'],
                    "value" => $answer['answer']
                        )
                );
            } else {
                $this->user_model->update_custom_field($answer['fieldid'], $this->user->info->ID, $answer['answer']);
            }
        }



        $this->session->set_flashdata("globalmsg", lang("success_22"));
        redirect(site_url("user_settings"));
    }

    public function change_password() {
        $this->template->loadContent("user_settings/change_password.php", array(
                )
        );
    }

    public function change_password_pro() {
        $current_password = $this->common->nohtml($this->input->post("current_password"));
        $new_pass1 = $this->common->nohtml($this->input->post("new_pass1"));
        $new_pass2 = $this->common->nohtml($this->input->post("new_pass2"));

        if (empty($new_pass1))
            $this->template->error(lang("error_45"));
        if ($new_pass1 != $new_pass2)
            $this->template->error(lang("error_22"));

        $phpass = new PasswordHash(12, false);
        if (!$phpass->CheckPassword($current_password, $this->user->getPassword())) {
            $this->template->error(lang("error_59"));
        }

        $pass = $this->common->encrypt($new_pass1);
        $this->user_model->update_user($this->user->info->ID, array("password" => $pass));

        $this->session->set_flashdata("globalmsg", lang("success_23"));
        redirect(site_url("user_settings/change_password"));
    }

}

?>