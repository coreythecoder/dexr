<?php

function piplSearch($POST) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/piplapis/search.php';
    PiplApi_SearchAPIRequest::get_default_configuration()->api_key = "BUSINESS-PREMIUM-s2tbyn56m4ehutxftpnrfanu";
    PiplApi_SearchAPIRequest::get_default_configuration()->minimum_probability = 0.9;
    PiplApi_SearchAPIRequest::get_default_configuration()->minimum_match = 0.8;
    PiplApi_SearchAPIRequest::get_default_configuration()->hide_sponsored = true;
    PiplApi_SearchAPIRequest::get_default_configuration()->live_feeds = false;
    PiplApi_SearchAPIRequest::get_default_configuration()->use_https = true;
    PiplApi_SearchAPIRequest::get_default_configuration()->show_sources = "all";

    $fields = array();
    $fields['first_name'] = trim($POST['first']);
    $fields['last_name'] = trim($POST['last']);

    if (!empty($POST['middle'])) {
        $fields['middle_name'] = trim($POST['middle']);
    }
    if (!empty($POST['email'])) {
        $fields['email'] = trim($POST['email']);
    }
    if (!empty($POST['street']) || !empty($POST['city']) || !empty($POST['state'])) {
        $fields['raw_address'] = trim($POST['street'] . ', ' . $POST['city'] . ', ' . $POST['state']);
    }
    if (!empty($POST['zip'])) {
        $fields['zipcode'] = trim($POST['zip']);
    }

    if (!empty($POST['birthMonth']) && !empty($POST['birthDay']) && !empty($POST['birthYear'])) {
        $from = new DateTime();
        $from->setTimestamp(strtotime($POST['birthMonth'].'-'.$POST['birthDay'].'-'.$POST['birthYear']));
        $to = new DateTime('today');
        $age = $from->diff($to)->y;
        $fields['age'] = trim($age);
    }
    $request = new PiplApi_SearchAPIRequest($fields);

    try {
        return $response = $request->send();
    } catch (PiplApi_SearchAPIError $e) {
        $CI = & get_instance();
        $CI->Db_model->logError("pipl lookup failed. MESSAGE: " . $e->getMessage());
        return false;
    }
}

function postJSON($data) {
    $url = 'https://api.imsasllc.com/v3/ ';
    $data_string = json_encode($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    curl_close($ch);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

function imsasCriminalSearch($POST) {
    $data = array();
    $data['credentials'] = array(
        'account_id' => '128073',
        'api_key' => 'ZsAUc32CVBC3pDtXibSElvxs7I'
    );
    $data['product'] = 'criminal_database';
    $data['data']['FirstName'] = $POST['first'];
    $data['data']['LastName'] = $POST['last'];

    if (isset($POST['middle']) && !empty($POST['middle'])) {
        $data['data']['MiddleName'] = $POST['middle'];
    }
    if (isset($POST['birthMonth']) && !empty($POST['birthMonth']) && isset($POST['birthDay']) && !empty($POST['birthDay']) && isset($POST['birthYear']) && !empty($POST['birthYear'])) {
        $data['data']['DOB'] = $POST['birthYear'] . '-' . $POST['birthMonth'] . '-' . $POST['birthDay'];
    }
    if (isset($POST['street']) && !empty($POST['street'])) {
        $data['data']['Address'] = $POST['street'];
    }
    if (isset($POST['city']) && !empty($POST['city'])) {
        $data['data']['City'] = $POST['city'];
    }
    if (isset($POST['state']) && !empty($POST['state'])) {
        $data['data']['State'] = $POST['state'];
    }
    if (isset($POST['zip']) && !empty($POST['zip'])) {
        $data['data']['Zip'] = $POST['zip'];
    }
    $data['data']['Limit'] = 10;
    $data['data']['ExactMatch'] = 'yes';

    $json_response = postJSON($data);
    if ($json_response) {
        return $json_response;
    } else {
        return false;
    }
}

function imsasFederalSearch($POST) {
    $data = array();
    $data['credentials'] = array(
        'account_id' => '128073',
        'api_key' => 'ZsAUc32CVBC3pDtXibSElvxs7I'
    );
    $data['product'] = 'federal_criminal';
    $data['data']['FirstName'] = $POST['first'];
    $data['data']['LastName'] = $POST['last'];

    if (isset($POST['middle']) && !empty($POST['middle'])) {
        $data['data']['MiddleName'] = $POST['middle'];
    }

    $data['data']['Limit'] = 20;

    $json_response = postJSON($data);
    if ($json_response) {
        return $json_response;
    } else {
        return false;
    }
}
