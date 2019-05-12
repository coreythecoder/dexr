# dexr.io

ACTIVE ROUTES

    DAILY WHOIS IMPORT (yesterday's files)
        $route['cron/files'] = "welcome/cron_files";

    LOGIN/LOGOUT
        $route['login'] = "login/index";
        $route['login/logout'] = "login/logout";
        $route['login/pro'] = "login/pro";
        $route['login/forgotpw'] = "login/forgotpw";
        $route['login/forgotpw_pro'] = "login/forgotpw_pro";
        $route['login/resetpw/(:any)/(:any)'] = "login/resetpw/$1/$2";
        $route['login/resetpw_pro/(:any)/(:any)'] = "login/resetpw_pro/$1/$2";

    ACCOUNT SETTINGS
        $route['user_settings'] = "User_settings";

    DIRECTORY OPT OUT
        $route['opt-out'] = "frontend/opt_out";

    PRICING
        if ($currHost[0] == 'app') {
            //BACKEND
            $route['pricing'] = "home/pricing";
        } else {
            $route['pricing'] = "frontend/pricing";
        }

    BACKEND
        $route['datasets'] = "home/datasets";
        $route['reports'] = "home/reports";
        $route['report/(:any)/(:any)/(:any)'] = "home/report/$1/$2/$3";
        $route['dataset/(:any)/(:any)/(:any)'] = "home/dataset/$1/$2/$3";
        $route['scrub'] = "home/scrub";
        $route['zap/(:any)/(:any)/(:any)/(:any)'] = "home/zap/$1/$2/$3/$4";

    SITEMAPS
        $route['sitemap'] = "frontend/sitemap_index";
        $route['sitemap/(:any)'] = "frontend/sitemap/$1";
