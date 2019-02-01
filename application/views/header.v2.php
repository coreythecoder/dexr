<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link href="/assets/stylesheets/jednotka_green.css" media="all" id="colors" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--[if lt IE 9]>
      <script src="/assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="/assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->

        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/animate.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet"> 

        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.1/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.0.1/dist/leaflet.js"></script>
        <script src="/assets/javascripts/tether.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="/plupload/js/plupload.min.js"></script>
        <script type="text/javascript" src="/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>

        <script src="/assets/javascripts/custom.js"></script>
        <meta charset="utf-8">
        <title><?php echo $metaTitle; ?></title>
        <meta name="description" content="<?php echo $metaDescription; ?>">
        <meta name="robots" content="noindex, nofollow">

    </head>

    <body>    
        <div class="bs-component">
            <nav class="navbar navbar-default transparent navbar-fixed-top blue-background shadow">
                <div class="container-fluid">
                    <div class='row'>
                        <div class='col-md-2' style="max-width: 175px;">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="/"><span class="strokeme"><span class="logo">dexr.</span></span> <span style="color:white; position:relative; bottom:3px;"></span></a>
                            </div>

                        </div>
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <div class='col-md-9'>
                                <ul class="nav navbar-nav">                            
                                    <li class=""><a href="/"><i class="fa fa-search"></i> Discover</a></li>
                                    <li class=""><a href="/crm"><i class="fa fa-comments"></i> Communicate<i class="badge badge-notify">3</i></a></li>                                    
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle noThinker" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-magic"></i> Automate <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li class=""><a class="dropdown-item" style="margin:8px;" href="/email/campaigns"><i class="fa fa-envelope"></i> Email</a></li>
                                            <li class=""><a class="dropdown-item" style="margin:8px;" href="/email/campaigns"><i class="fa fa-phone"></i> Ringless VM</a></li>
                                            <li class=""><a class="dropdown-item" style="margin:8px;" href="/email/campaigns"><i class="fa fa-gears"></i> RoboCaller</a></li>
                                            <li class=""><a class="dropdown-item" style="margin:8px;" href="/email/campaigns"><i class="fa fa-mobile-phone"></i> SMS</a></li>
                                            <li class="divider"></li>
                                            <li class=""><a class="dropdown-item" style="margin:8px;" href="/email/campaigns"><i class="fa fa-clock-o"></i> Alarms</a></li>
                                        </ul>
                                    </li> 
                                </ul>   
                            </div>
                            <div class='col-md-1 text-right'>
                                <ul class="nav navbar-nav navbar-right">
                                    <?php if ($this->user->loggedin) { ?>
                                        <div class="dropdown">
                                            <button class="btn btn-default btn-xs dropdown-toggle menu-button" style="margin:0px;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Menu <i class='fa fa-caret-down'></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <div><a rel="nofollow" class="dropdown-item" style="margin:8px;" href="/dash"><i class='fa fa-plus'></i> New Report</a></div>
                                                <div><a rel="nofollow" class="dropdown-item" style="margin:8px;" href="/archive"><i class='fa fa-archive'></i> Archives</a></div>
                                                <div><a rel="nofollow" class="dropdown-item" style="margin:8px;" href="/user_settings"><i class='fa fa-wrench'></i> My Account</a></div>
                                                <div class='separator'></div>
                                                <div><a rel="nofollow" class="dropdown-item" style="margin:8px;" href="/help"><i class='fa fa-question-circle'></i> Help Center</a></div>
                                                <div class='separator'></div>
                                                <div><a rel="nofollow" class="dropdown-item" style="margin:8px;" href="/login/logout"><i class='fa fa-sign-out'></i> Sign Out</a></div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <li class=""><a rel="nofollow"  href="/login" class="btn btn-default btn-xs" style="margin:8px;">Sign In</a></li>
                                        <?php } ?> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>