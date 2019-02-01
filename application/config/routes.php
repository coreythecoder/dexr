<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$states = array(
    'AL' => 'Alabama',
    'AK' => 'Alaska',
    'AZ' => 'Arizona',
    'AR' => 'Arkansas',
    'CA' => 'California',
    'CO' => 'Colorado',
    'CT' => 'Connecticut',
    'DE' => 'Delaware',
    'DC' => 'District of Columbia',
    'FL' => 'Florida',
    'GA' => 'Georgia',
    'HI' => 'Hawaii',
    'ID' => 'Idaho',
    'IL' => 'Illinois',
    'IN' => 'Indiana',
    'IA' => 'Iowa',
    'KS' => 'Kansas',
    'KY' => 'Kentucky',
    'LA' => 'Louisiana',
    'ME' => 'Maine',
    'MD' => 'Maryland',
    'MA' => 'Massachusetts',
    'MI' => 'Michigan',
    'MN' => 'Minnesota',
    'MS' => 'Mississippi',
    'MO' => 'Missouri',
    'MT' => 'Montana',
    'NE' => 'Nebraska',
    'NV' => 'Nevada',
    'NH' => 'New Hampshire',
    'NJ' => 'New Jersey',
    'NM' => 'New Mexico',
    'NY' => 'New York',
    'NC' => 'North Carolina',
    'ND' => 'North Dakota',
    'OH' => 'Ohio',
    'OK' => 'Oklahoma',
    'OR' => 'Oregon',
    'PA' => 'Pennsylvania',
    'RI' => 'Rhode Island',
    'SC' => 'South Carolina',
    'SD' => 'South Dakota',
    'TN' => 'Tennessee',
    'TX' => 'Texas',
    'UT' => 'Utah',
    'VT' => 'Vermont',
    'VA' => 'Virginia',
    'WA' => 'Washington',
    'WV' => 'West Virginia',
    'WI' => 'Wisconsin',
    'WY' => 'Wyoming');

$states = array_flip($states);

$currHost = $_SERVER['HTTP_HOST'];
$currHost = explode('.', $currHost);

$currPath = explode('/', $_SERVER['REQUEST_URI']);

if ($currHost[0] == 'app') {
    //BACKEND
    $route['default_controller'] = "home/index";
} else {
    // FRONTEND
    //state/{/page-number} 
    //(lists cities)

    if (isset($currPath[1]) && !isset($currPath[2]) && in_array(strtoupper($currPath[1]), $states)) {
        echo 'state';
        exit();
        $route['(:any)'] = "frontend/state/$1";
    } elseif (isset($currPath[2]) && !isset($currPath[3])) {
        echo 'city';
        exit();
        //state/city/initial 
        //(first page is A with alpha at top)
        $route['(:any)/(:any)'] = "frontend/city/$1/$2";
    } elseif (isset($currPath[3]) && preg_match("/^[a-z]$/", $currPath[3])) {
        echo 'initial';
        exit();
        //state/city/name
        //(lists domains/whois info)
        $route['(:any)/(:any)/(:any)'] = "frontend/city/$1/$2/$3";
    } else {
        echo 'name-city';
        exit();
        $route['(:any)/(:any)/(:any)'] = "frontend/name/$1/$2/$3";
    }
}

// Custom Routes
$route['profile/(:any)'] = "profile/index/$1";
$route['data/import'] = "data/import";

$route['login'] = "login/index";
$route['login/logout'] = "login/logout";
$route['login/pro'] = "login/pro";
$route['login/forgotpw'] = "login/forgotpw";
$route['login/forgotpw_pro'] = "login/forgotpw_pro";
$route['login/twitter_login'] = "login/twitter_login";
$route['login/facebook_login'] = "login/facebook_login";
$route['login/google_login'] = "login/google_login";
$route['login/google_login_pro'] = "login/google_login_pro";
$route['login/resetpw/(:any)/(:any)'] = "login/resetpw/$1/$2";
$route['login/resetpw_pro/(:any)/(:any)'] = "login/resetpw_pro/$1/$2";

$route['stats'] = "welcome/stats";
$route['email/targeting'] = "welcome/email_targeting";
$route['email/targeting/create'] = "welcome/targeting_create";
$route['email/inboxes/create'] = "welcome/inboxes_create";
$route['email/templates/create'] = "welcome/templates_create";
$route['email/campaigns/create'] = "welcome/campaigns_create";
$route['cron/files'] = "welcome/cron_files";
$route['cron/emails'] = "welcome/cron_emails";
$route['email/templates'] = "welcome/email_templates";
$route['email/inboxes'] = "welcome/email_inboxes";
$route['email/campaigns'] = "welcome/email_campaigns";
$route['user_settings'] = "User_settings";
$route['pricing'] = "home/pricing";

$route['datasets'] = "home/datasets";
$route['dataset/(:any)/(:any)/(:any)'] = "home/dataset/$1/$2/$3";

$route['scrub'] = "home/scrub";

$route['zap/(:any)/(:any)/(:any)/(:any)'] = "home/zap/$1/$2/$3/$4";

$route['imap'] = "Imap_controller/index";

$route['create'] = "create/index";
$route['translate_uri_dashes'] = FALSE;

$route['404_override'] = 'Error_404';
$route['translate_uri_dashes'] = FALSE;
