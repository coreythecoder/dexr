<?php

$CI = get_instance();

require_once(APPPATH . 'third_party/stripe/init.php');

$stripe = array(
    "secret_key" => $CI->settings->info->stripe_secret_key,
    "publishable_key" => $CI->settings->info->stripe_publish_key
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

function isActive() {
    $CI = get_instance();
    $CI->load->model('Db_model');

    if (isset($CI->user->info->ID)) {
        $cust = $CI->Db_model->getCustomerID($CI->user->info->ID);
    }
    if (!empty($cust)) {
        return true;
    } else {
        return false;
    }
}

function hasSubscription($subName = "") {

    $CI = get_instance();
    $CI->load->model('Db_model');

    if (!empty($cid = $CI->Db_model->getCustomerID($CI->user->info->ID))) {
        $subscriptions = \Stripe\Customer::retrieve($cid);
        if (isset($subscriptions->subscriptions->data[0])) {
            foreach ($subscriptions->subscriptions->data as $sub) {
                if (strtolower($sub->plan->name) == strtolower($subName)) {
                    return true;
                } elseif ($subName) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}
