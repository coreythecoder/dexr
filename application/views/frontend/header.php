<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->

    <head>
        <meta charset="utf-8">
        <title><?php echo $metaTitle; ?></title>
        <meta name="description" content="<?php echo $metaDescription; ?>">
        <meta name="author" content="htmlcoder.me">

        <!-- Mobile Meta -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Favicon -->
        <link rel="shortcut icon" href="images/favicon.ico">

        <!-- Web Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic|Raleway:700,400,300|Pacifico|PT+Serif' rel='stylesheet' type='text/css'>


        <!-- Bootstrap core CSS -->
        <link href="/assets/themes/v4/bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Font Awesome CSS -->
        <link href="/assets/themes/v4/fonts/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Fontello CSS -->
        <link href="/assets/themes/v4/fonts/fontello/css/fontello.css" rel="stylesheet">

        <!-- Plugins -->
        <link href="/assets/themes/v4/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">
        <link href="/assets/themes/v4/css/animations.css" rel="stylesheet">
        <link href="/assets/themes/v4/plugins/owl-carousel/owl.carousel.css" rel="stylesheet">
        <link href="/assets/themes/v4/plugins/owl-carousel/owl.transitions.css" rel="stylesheet">
        <link href="/assets/themes/v4/plugins/hover/hover-min.css" rel="stylesheet">		

        <!-- The Project core CSS file -->
        <link href="/assets/themes/v4/css/style.css" rel="stylesheet" >
        <!-- Color Scheme (In order to change the color scheme, replace the blue.css with the color scheme that you prefer)-->
        <link href="/assets/themes/v4/css/skins/light_blue.css" rel="stylesheet">

        <!-- Custom css --> 
        <link href="/assets/themes/v4/css/custom.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    </head>

    <!-- body classes:  -->
    <!-- "boxed": boxed layout mode e.g. <body class="boxed"> -->
    <!-- "pattern-1 ... pattern-9": background patterns for boxed layout mode e.g. <body class="boxed pattern-1"> -->
    <!-- "transparent-header": makes the header transparent and pulls the banner to top -->
    <!-- "gradient-background-header": applies gradient background to header -->
    <!-- "page-loader-1 ... page-loader-6": add a page loader to the page (more info @components-page-loaders.html) -->
    <body class="no-trans    ">

        <!-- scrollToTop -->
        <!-- ================ -->
        <div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>

        <!-- page wrapper start -->
        <!-- ================ -->
        <div class="page-wrapper">

            <!-- header-container start -->
            <div class="header-container" <?php if (uri_string() == "") { ?>style="position:fixed; left:0px; right:0px; top:0xp; z-index:999;"<?php } ?>>

                <div class="header-top dark" style="">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-3 col-sm-6 col-md-9">
                                <!-- header-top-first start -->
                                <!-- ================ -->
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
                                <!-- header-top-first end -->
                            </div>
                            <div class="col-xs-9 col-sm-6 col-md-3">

                                <!-- header-top-second start -->
                                <!-- ================ -->
                                <div id="header-top-second"  class="clearfix">

                                    <!-- header top dropdowns start -->
                                    <!-- ================ -->
                                    <div class="header-top-dropdown text-right">
                                       
                                        <div class="btn-group">
                                            <a href="https://app.dexr.io/login" class="btn dropdown-toggle btn-default btn-sm"><i class="fa fa-sign-out pr-10"></i> Sign In</a>

                                        </div>
                                    </div>
                                    <!--  header top dropdowns end -->
                                </div>
                                <!-- header-top-second end -->
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
                                <!-- header-left start -->
                                <!-- ================ -->
                                <div class="header-left clearfix">
                                    <!-- logo -->
                                    <div id="logo" class="logo">
                                        <a href="/"><img id="logo_img" src="/assets/images/blue-logo-45.png" alt="The Project"></a>
                                    </div>

                                </div>
                                <!-- header-left end -->

                            </div>
                            <div class="col-md-10 text-center">

                                <div class="header-right clearfix pull-right" style="">
                                    <div class="main-navigation  animated with-dropdown-buttons">

                                        <!-- navbar start -->
                                        <!-- ================ -->
                                        <nav class="navbar navbar-default" role="navigation">
                                            <div class="container-fluid">

                                                <!-- Toggle get grouped for better mobile display -->
                                                <div class="navbar-header">
                                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                                        <span class="sr-only">Toggle navigation</span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                    </button>

                                                </div>

                                                <!-- Collect the nav links, forms, and other content for toggling -->
                                                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                                                    <!-- main-menu -->
                                                    <ul class="nav navbar-nav ">

                                                        <!-- mega-menu start -->
                                                        <li class=" mega-menu">
                                                            <a href="/"><i class="fa fa-search"></i> Pricing</a>														
                                                        </li>
                                                        <li class=" mega-menu">
                                                            <a href="/register"><i class="fa fa-user"></i> Create a Free Account</a>														
                                                        </li>
                                                        <!-- mega-menu end -->

                                                    </ul>
                                                    <!-- main-menu end -->

                                                    <!-- header dropdown buttons -->
                                                    
                                                </div>
                                        </nav>
                                        <!-- navbar end -->

                                    </div>
                                    <!-- main-navigation end -->
                                </div>
                                <!-- header-right end -->

                            </div>
                        </div>
                    </div>
                </header>
                <!-- header end -->
            </div>
            <!-- header-container end -->

<?php
if (uri_string() == "") {
    echo "<div style='height:123px;'></div>";
}?>