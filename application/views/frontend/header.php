<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="theme-color" content="#09afdf" />
        <title><?php echo $metaTitle; ?></title>
        <meta name="description" content="<?php echo $metaDescription; ?>">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic|Raleway:700,400,300|Pacifico|PT+Serif' rel='stylesheet' type='text/css'>
        <link href="https://static.dexr.io/css/combined-minified.css" rel="stylesheet">
    </head>
    <body class="no-trans    ">
        <div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>
        <div class="page-wrapper">
            <div class="header-container" <?php if (uri_string() == "") { ?>style="position:fixed; left:0px; right:0px; top:0xp; z-index:999;"<?php } ?>>
                <div class="header-top dark" style="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-9">
                                <div class="header-top-first clearfix">
                                    <ul class="social-links circle small clearfix hidden-xs">
                                        <li class="skype"><a target="_blank" href="http://www.skype.com"><i class="fa fa-skype"></i></a></li>
                                        <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
                                        <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                                        <li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
                                        <li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                                    </ul>
                                    <div class="social-links hidden-lg hidden-md hidden-sm circle small">
                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></button>
                                            <ul class="dropdown-menu dropdown-animation">
                                                <li class="skype"><a target="_blank" href="http://www.skype.com"><i class="fa fa-skype"></i></a></li>
                                                <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
                                                <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                                                <li class="youtube"><a target="_blank" href="http://www.youtube.com"><i class="fa fa-youtube-play"></i></a></li>
                                                <li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <ul class="list-inline hidden-sm hidden-xs">
                                        <li><i class="fa fa-envelope-o pr-5 pl-10"></i> Support@Dexr.io</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-6 col-md-3">
                                <div id="header-top-second"  class="clearfix">
                                    <div class="header-top-dropdown text-right">
                                        <div class="btn-group">
                                            <a href="https://app.dexr.io/login" class="btn dropdown-toggle btn-default btn-sm"><i class="fa fa-sign-out pr-10"></i> Sign In</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <header class="header <?php if (uri_string() !== "") {
    echo "fixed";
} ?> clearfix">                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="header-left clearfix">
                                    <div id="logo" class="logo">
                                        <a href="/"><img id="logo_img" src="/assets/images/blue-logo-45.png" alt="The Project"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10 text-center">
                                <div class="header-right clearfix pull-right" style="">
                                    <div class="main-navigation  animated with-dropdown-buttons">
                                        <nav class="navbar navbar-default" role="navigation">
                                            <div class="container-fluid">
                                                <div class="navbar-header">
                                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                                        <span class="sr-only">Toggle navigation</span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                    </button>
                                                </div>
                                                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                                    <ul class="nav navbar-nav ">
                                                        <li class=" mega-menu">
                                                            <a href="/pricing"><i class="fa fa-search"></i> Pricing</a>														
                                                        </li>
                                                        <li class=" mega-menu">
                                                            <a href="https://app.dexr.io/register"><i class="fa fa-user"></i> Create a Free Account</a>														
                                                        </li>
                                                    </ul>
                                                </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
<?php
if (uri_string() == "") {
    echo "<div style='height:123px;'></div>";
}?>