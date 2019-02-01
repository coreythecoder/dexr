<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$curr = $_SERVER['HTTP_HOST'];
$curr = explode('.', $curr);
if ($curr[0] == 'app') {
    $route['default_controller'] = "home/index";
} else {
   // $route['default_controller'] = "live/index";
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
$route['create/(:any)'] = "create/index/$1";

$route['404_override'] = 'Error_404';
$route['translate_uri_dashes'] = FALSE;
