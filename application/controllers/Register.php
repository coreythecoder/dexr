<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("register_model");
        $this->load->model("db_model");
        $this->load->model("user_model");
        $this->load->model("funds_model");
        $this->load->model("login_model");
        $this->load->library("Awslib");
        $this->load->helper("aws");
        $this->load->helper("general");
        $this->load->library('session');
    }

    public function index() {

        if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
            $_SESSION['redirect'] = $this->input->post("redirect");
        }

        if (isset($_POST['stripeToken']) && !empty($_POST['stripeToken'])) {
            $_SESSION['stripeToken'] = $this->input->post("stripeToken");
        }

        if (isset($_POST['fullPrice']) && !empty($_POST['fullPrice'])) {
            $_SESSION['fullPrice'] = $this->input->post("fullPrice");
        }

        if ($this->user_model->check_block_ip()) {
            $this->template->error(lang("error_26"));
        }

        $this->template->set_error_view("error/login_error.php");
        $this->template->set_layout("layout/login_layout.php");
        if ($this->settings->info->register) {
            $this->template->error(lang("error_54"));
        }

        if (isset($_SESSION['email'])) {
            $login = $this->login_model->getUserByUsername($_SESSION['email']);
            if ($login->num_rows() > 0) {
                redirect('/login', 301);
            }
        }

        $this->load->helper('email');

        $email = "";
        $name = "";
        $username = "";
        $fail = "";
        $first_name = "";
        $last_name = "";

        if (isset($_POST['s'])) {
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
            } else {
                $email = $this->input->post("email", true);
            }
            $first_name = $this->common->nohtml(
                    $this->input->post("first_name", true));

            $pass = $this->common->nohtml(
                    $this->input->post("password", true));
            $pass2 = $this->common->nohtml(
                    $this->input->post("password2", true));
            $captcha = $this->input->post("captcha", true);

            if (!$this->settings->info->disable_captcha) {
                if ($captcha != $_SESSION['sc']) {
                    $fail = lang("error_55");
                }
            }
            if ($pass != $pass2)
                $fail = lang("error_22");

            if (strlen($pass) <= 5) {
                $fail = lang("error_17");
            }

            if (strlen($first_name) > 25) {
                $fail = lang("error_56");
            }

            if (empty($first_name)) {
                $fail = lang("error_58");
            }

            if (empty($email)) {
                $fail = lang("error_18");
            }

            if (!valid_email($email)) {
                $fail = lang("error_19");
            }

            if (!$this->register_model->checkEmailIsFree($email)) {
                $fail = lang("error_20");
            }

            if (empty($fail)) {

                $pass = $this->common->encrypt($pass);
                $active = 1;
                $activate_code = "";
                $success = lang("success_20");

                if ($this->settings->info->activate_account) {
                    $active = 0;
                    $activate_code = md5(rand(1, 10000000000) . "fhsf" . rand(1, 100000));
                    $success = lang("success_33");

                    // Send email
                    $this->load->model("home_model");

                    /*
                      $email_template = $this->home_model->get_email_template(2);
                      if ($email_template->num_rows() == 0) {
                      $this->template->error(lang("error_48"));
                      }
                      $email_template = $email_template->row();

                      $email_template->message = $this->common->replace_keywords(array(
                      "[NAME]" => $username,
                      "[SITE_URL]" => site_url(),
                      "[EMAIL_LINK]" =>
                      site_url("register/activate_account/" . $activate_code .
                      "/" . $username),
                      "[SITE_NAME]" => $this->settings->info->site_name
                      ), $email_template->message);

                      $this->common->send_email($email_template->title, $email_template->message, $email);
                     * 
                     */
                }

                $userid = $this->register_model->add_user(array(
                    "username" => $username,
                    "email" => $email,
                    "first_name" => $first_name,
                    "password" => $pass,
                    "user_role" => $this->settings->info->default_user_role,
                    "IP" => $_SERVER['REMOTE_ADDR'],
                    "joined" => time(),
                    "joined_date" => date("n-Y"),
                    "active" => $active,
                    "activate_code" => $activate_code,
                        )
                );

                // Check for any default user groups
                $default_groups = $this->user_model->get_default_groups();
                foreach ($default_groups->result() as $r) {
                    $this->user_model->add_user_to_group($userid, $r->ID);
                }

                $login = $this->login_model->getUserByEmail($email);
                if ($login->num_rows() == 0) {
                    $login = $this->login_model->getUserByUsername($email);
                    if ($login->num_rows() == 0) {
                        //$this->login_protect($email);
                        $this->template->error(lang("error_29"));
                    }
                }
                $r = $login->row();
                $userid = $r->ID;

                $token = rand(1, 100000) . $email;
                $token = md5(sha1($token));

                // Store it
                $this->login_model->updateUserToken($userid, $token);

                $ttl = 3600 * 24 * 31;
                $config = $this->config->item("cookieprefix");
                setcookie($config . "un", $email, time() + $ttl, "/");
                setcookie($config . "tkn", $token, time() + $ttl, "/");

                // GET TOKEN
                if (isset($_SESSION['stripeToken'])) {

                    // CREATE STRIPE INSTANCE
                    require_once(APPPATH . 'third_party/stripe/init.php');
                    $stripe = array(
                        "secret_key" => $this->settings->info->stripe_secret_key,
                        "publishable_key" => $this->settings->info->stripe_publish_key
                    );
                    \Stripe\Stripe::setApiKey($stripe['secret_key']);

                    //CREATE CUSTOMER
                    \Stripe\Stripe::setApiKey($this->settings->info->stripe_secret_key);

                    $customer = \Stripe\Customer::create([
                                "description" => $email,
                                "source" => trim($_SESSION['stripeToken']) // obtained with Stripe.js
                    ]);

                    // SAVE CUST ID FOR LATER USE
                    $this->db_model->saveStripeCustomerID($userid, $customer->id);

                    // GET PLAN TYPE (49/month + 7 day trial)
                    $pid = $this->config->item('premium');
                    $trial = strtotime("+7 Days");

                    $amount = 99;
                    if (isset($_SESSION['fullPrice'])) {
                        $amount = 999;
                    } else {
                        // ADD SUBSCRIPTION
                        $subscribe = \Stripe\Stripe::setApiKey($this->settings->info->stripe_secret_key);

                        \Stripe\Subscription::create([
                            "customer" => trim($customer->id),
                            "items" => [
                                [
                                    "plan" => $pid,
                                ],
                            ],
                            "trial_end" => $trial
                        ]);
                    }

                    // CHARGE CARD
                    $charge = \Stripe\Charge::create([
                                'amount' => $amount,
                                'currency' => 'usd',
                                'description' => 'Name_Report_' . $_SESSION['redirect'],
                                'customer' => $customer->id,
                    ]);

                    // SAVE NAME TO USER_REPORTS
                    $ex = explode("/", $_SESSION['redirect']);
                    $saveNameReport = $this->db_model->saveNameReport($userid, $ex[2], $ex[3], $ex[4]);
                }


                if (isset($_SESSION['redirect']) && !empty($_SESSION['redirect'])) {
                    redirect($_SESSION['redirect']);
                    $this->session->unset_userdata('stripeToken');
                    $this->session->unset_userdata('fullPrice');
                    $this->session->unset_userdata('redirect');
                    exit();
                } elseif ($this->user->loggedin) {
                    redirect("/", 301);
                }

                /*
                  $message = "Hi ".ucwords($this->user->info->first_name)."," . PHP_EOL . PHP_EOL;
                  $message .= "Welcome to Yoliya! We " . PHP_EOL . PHP_EOL;
                  $message .= "The Yoliya Team";
                  $html = "Hi " . ucwords($this->user->info->first_name) . ",<br><br>";
                  $html .= "We're just sending you confirmation that we have cancelled your public records search subscription at yoliya.com.  We hope you've enjoyed using our services and hope to see you back soon!<br><br>";
                  $html .= "The yoliya.com Team";

                  sendEmail($this->user->info->email, "subscriptions@yoliya.com", "Yoliya Subscription Cancelled", $message, $html);
                 * 
                 */

                $this->session->set_flashdata("globalmsg", $success);


                //CHECK FOR COOKIE, IF NO COOKIE REDIRECT, IF COOKIE GO TO CREDIT CARD VIEW
                //redirect(site_url("/pricing"));


                if (isset($_POST['redirect']) && !empty($_POST['redirect'])) {
                    echo $_POST['redirect'];
                    //redirect("https://app.dexr.io" . $_POST['redirect']);
                    exit();
                } else {
                    //CHECK FOR COOKIE, IF NO COOKIE REDIRECT, IF COOKIE GO TO CREDIT CARD VIEW
                    redirect(site_url("/pricing"));
                }

            }
        }

        $this->template->loadContent("register/index.php", array(
            "email" => $email,
            "first_name" => $first_name,
            'fail' => $fail,
            "username" => $username,
                )
        );
    }

    public function add_username_pro() {
        $this->load->helper('email');
        $email = $this->input->post("email", true);
        $username = $this->common->nohtml(
                $this->input->post("username", true));
        if (strlen($username) < 3)
            $fail = lang("error_14");

        if (!preg_match("/^[a-z0-9_]+$/i", $username)) {
            $fail = lang("error_15");
        }

        if (!$this->register_model->check_username_is_free($username)) {
            $fail = lang("error_16");
        }
        if (empty($email)) {
            $fail = lang("error_18");
        }

        if (!valid_email($email)) {
            $fail = lang("error_19");
        }

        if (!$this->register_model->checkEmailIsFree($email)) {
            $fail = lang("error_20");
        }

        if (!empty($fail))
            $this->template->error($fail);

        $this->register_model
                ->update_username($this->user->info->ID, $username, $email);
        $this->session->set_flashdata("globalmsg", lang("success_21"));
        redirect(site_url());
    }

    public function check_username() {
        $username = $this->common->nohtml(
                $this->input->get("username", true));
        if (strlen($username) < 3)
            $fail = lang("error_14");

        if (!preg_match("/^[a-z0-9_]+$/i", $username))
            $fail = lang("error_15");

        if (!$this->register_model->check_username_is_free($username)) {
            $fail = "$username " . lang("ctn_243");
        }
        if (empty($fail)) {
            echo"<span style='color:#4ea117'>" . lang("ctn_244") . "</span>";
        } else {
            echo $fail;
        }
        exit();
    }

    public function activate_account($code, $username) {
        $code = $this->common->nohtml($code);
        $username = $this->common->nohtml($username);

        $code = $this->user_model->get_verify_user($code, $username);
        if ($code->num_rows() == 0) {
            $this->template->error(lang("error_69"));
        }
        $code = $code->row();
        if ($code->active) {
            $this->template->error(lang("error_69"));
        }

        $this->user_model->update_user($code->ID, array(
            "active" => 1,
            "activate_code" => ""
                )
        );

        $this->session->set_flashdata("globalmsg", lang("success_34"));
        redirect(site_url("login"));
    }

    public function send_activation_code($userid, $email) {
        $userid = intval($userid);
        $email = $this->common->nohtml(urldecode($email));

        // Check request
        $request = $this->user_model->get_user_event("email_activation_request");
        if ($request->num_rows() > 0) {
            $request = $request->row();
            if ($request->timestamp + (15 * 60) > time()) {
                $this->template->error(lang("error_70"));
            }
        }

        $this->user_model->add_user_event(array(
            "event" => "email_activation_request",
            "IP" => $_SERVER['REMOTE_ADDR'],
            "timestamp" => time()
                )
        );

        // Resend
        $user = $this->user_model->get_user_by_id($userid);
        if ($user->num_rows() == 0) {
            $this->template->error(lang("error_71"));
        }
        $user = $user->row();
        if ($user->email != $email) {
            $this->template->error(lang("error_71"));
        }
        if ($user->active) {
            $this->template->error(lang("error_71"));
        }
        // Send email
        $this->load->model("home_model");
        $email_template = $this->home_model->get_email_template(2);
        if ($email_template->num_rows() == 0) {
            $this->template->error(lang("error_48"));
        }
        $email_template = $email_template->row();

        $email_template->message = $this->common->replace_keywords(array(
            "[NAME]" => $user->username,
            "[SITE_URL]" => site_url(),
            "[EMAIL_LINK]" =>
            site_url("register/activate_account/" . $user->activate_code .
                    "/" . $user->username),
            "[SITE_NAME]" => $this->settings->info->site_name
                ), $email_template->message);

        $this->common->send_email($email_template->title, $email_template->message, $user->email);
        $this->session->set_flashdata("globalmsg", lang("success_35"));
        redirect(site_url("login"));
    }

}

?>