<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class IPN extends CI_Controller {

    public $project = null;

    public function __construct() {
        parent::__construct();
        $this->load->model("ipn_model");
        $this->load->model("user_model");
        $this->config->set_item('csrf_protection', FALSE);
    }

    public function index() {
        exit();
    }

    public function stripe($id) {
        $this->ipn_model->log_ipn("[STRIPE] Tried to buy credits with STRIPE: " . $id);

        // Processing stripe payments
        // Stripe
        if (!empty($this->settings->info->stripe_secret_key) && !empty($this->settings->info->stripe_publish_key)) {
            // Stripe
            require_once(APPPATH . 'third_party/stripe/init.php');

            $stripe = array(
                "secret_key" => $this->settings->info->stripe_secret_key,
                "publishable_key" => $this->settings->info->stripe_publish_key
            );

            \Stripe\Stripe::setApiKey($stripe['secret_key']);
        } else {
            $stripe = null;
        }

        if ($stripe === null) {
            //$this->template->error("No Stripe Keys found!");
        }

        if (isset($_POST['stripeToken'])) {
            $_SESSION['token'] = $_POST['stripeToken'];
            $_SESSION['nid'] = $_POST['nid'];
            $_SESSION['pid'] = $id;
            $stripeInfo = \Stripe\Token::retrieve($_POST['stripeToken']);
            $_SESSION['email'] = $stripeInfo->email;
        } else {
            redirect($_POST['nid'] . '?error=no_token_received', 301);
            exit();
        }

        $this->ipn_model->log_ipn("[STRIPE] Connected successfully to API.");

        if ($this->user->loggedin) {
            redirect("/", 301);
        } else {
            redirect("/register", 301);
        }
    }

    public function process2() {
        require_once('paypal/config.php');
        $this->ipn_model->log_ipn("Attempted to pay Funds");
        // Read the post from PayPal system and add 'cmd'   
        $req = 'cmd=_notify-validate';

        // Store each $_POST value in a NVP string: 1 string encoded 
        // and 1 string decoded   
        $ipn_email = '';
        $ipn_data_array = array();
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&" . $key . "=" . $value;
            $ipn_email .= $key . " = " . urldecode($value) . '<br />';
            $ipn_data_array[$key] = urldecode($value);
        }

        // Store IPN data serialized for RAW data storage later
        $ipn_serialized = serialize($ipn_data_array);

        // Validate IPN with PayPal
        require_once('paypal/validate.php');

        // Load IPN data into PHP variables
        require_once('paypal/parse-ipn-data.php');

        $ipn_log_data['ipn_data_serialized'] = $ipn_serialized;

        if (strtoupper($txn_type) == 'WEB_ACCEPT') {
            $this->ipn_model->log_ipn($ipn_log_data['ipn_data_serialized']);
            // Invoice Payment
            $userid = intval($this->common->nohtml($custom));
            $id = intval($item_number);
            $this->ipn_model->log_ipn("Tried to pay Funds ($mc_gross): " .
                    $id . " Userid:" . $userid);

            // Get amount
            $amount = abs($mc_gross);
            $this->user_model->add_points($userid, $amount);
            $this->ipn_model->log_ipn("Payment Added to user: $userid, $amount");
            $this->ipn_model->add_payment(array(
                "userid" => $userid,
                "amount" => $amount,
                "timestamp" => time(),
                "email" => $this->common->nohtml($payer_email),
                "processor" => "PayPal"
                    )
            );
        }
    }

}

?>