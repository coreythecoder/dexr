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
<style>
            .state-list {
                margin-top:25px; 
                margin-bottom:80px;
            }
            .nearby-cities {
                margin-top:25px; 
                margin-bottom:80px;
            }
            .city-list {
                margin-top:25px; 
                margin-bottom:80px;
            }
            .letter-list {
                margin-top:25px; 
                margin-bottom:80px;
            }
            .word-break {
                word-break: break-all;
            }
            .other-text {
                padding:10px;
            }
            .others-number {
                font-size:2.6em;
                font-weight:bold;                    
                margin-right:5px;
                margin-left:15px;
                color: #09afdf;
                text-align:right;
            }
            .others-label {
                position:relative;
                top:8px;
            }
            .others-list {
                position:relative;
                top:8px;
            }

            @media (max-width:600px){
                .mobile-center {
                    text-align:center;
                }
                .others-number {
                    margin-right:15px;
                    margin-left:15px;
                }
                .other-names .col-md-3 {
                    margin-bottom:10px;
                }
                .state-list .col-md-3 {
                    margin-bottom:10px;
                }
                .main-navigation {
                    position: absolute;
                    top: -65px;
                    right: 0px;
                    z-index:999;
                }
                .state-list .col-md-4 {
                    margin-bottom: 10px;
                }
                .nearby-cities .col-md-4 {
                    margin-bottom:10px;
                }
                .city-list .col-md-4 {
                    margin-bottom:10px;
                }
                .letter-list .col-md-4 {
                    margin-bottom: 10px;
                }
                body > div.page-wrapper > div.breadcrumb-container > div > ol > li > a {
                    line-height: 2em;
                }
                .breadcrumb {
                    text-align:center;
                }
                .copyright {
                    text-align:right;
                    margin-right:40px;
                }

            }
        </style>
    </head>

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
                                        <?php if(!isset($hideMenu)){ ?><li><i class="fa fa-envelope-o pr-5 pl-10"></i> Support@Dexr.io</li><?php } ?>
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
                                            <a href="/user_settings" class="btn btn-default btn-sm"><i class="fa fa-user pr-10"></i> My Account</a>
                                        </div>
                                        <div class="btn-group">
                                            <a href="/login/logout" class="btn dropdown-toggle btn-default btn-sm"><i class="fa fa-sign-out pr-10"></i> Sign Out</a>

                                        </div>
                                    </div>
                                    <!--  header top dropdowns end -->
                                </div>
                                <!-- header-top-second end -->
                            </div>
                        </div>
                    </div>
                </div>

                <header class="header <?php if (uri_string() !== "") { echo "fixed"; } ?> clearfix">                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-2">
                                <!-- header-left start -->
                                <!-- ================ -->
                                <div class="header-left clearfix">

                                    <!-- header dropdown buttons -->
                                    <div class="header-dropdown-buttons visible-xs">

                                        <div class="btn-group dropdown">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><i class="icon-basket-1"></i><span class="cart-count default-bg">8</span></button>
                                            <ul class="dropdown-menu dropdown-menu-right dropdown-animation cart">
                                                <li>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th class="quantity">QTY</th>
                                                                <th class="product">Product</th>
                                                                <th class="amount">Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="quantity">2 x</td>
                                                                <td class="product"><a href="shop-product.html">Android 4.4 Smartphone</a><span class="small">4.7" Dual Core 1GB</span></td>
                                                                <td class="amount">$199.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="quantity">3 x</td>
                                                                <td class="product"><a href="shop-product.html">Android 4.2 Tablet</a><span class="small">7.3" Quad Core 2GB</span></td>
                                                                <td class="amount">$299.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="quantity">3 x</td>
                                                                <td class="product"><a href="shop-product.html">Desktop PC</a><span class="small">Quad Core 3.2MHz, 8GB RAM, 1TB Hard Disk</span></td>
                                                                <td class="amount">$1499.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="total-quantity" colspan="2">Total 8 Items</td>
                                                                <td class="total-amount">$1997.00</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="panel-body text-right">
                                                        <a href="shop-cart.html" class="btn btn-group btn-gray btn-sm">View Cart</a>
                                                        <a href="shop-checkout.html" class="btn btn-group btn-gray btn-sm">Checkout</a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- header dropdown buttons end-->

                                    <!-- logo -->
                                    <div id="logo" class="logo">
                                        <a href="/"><img id="logo_img" src="/assets/images/blue-logo-45.png" alt=""></a>
                                    </div>

                                </div>
                                <!-- header-left end -->

                            </div>
                            <div class="col-md-10 text-center">

                                <!-- header-right start -->
                                <!-- ================ -->
                                <div class="header-right clearfix pull-right" style="">

                                    <!-- main-navigation start -->
                                    <!-- classes: -->
                                    <!-- "onclick": Makes the dropdowns open on click, this the default bootstrap behavior e.g. class="main-navigation onclick" -->
                                    <!-- "animated": Enables animations on dropdowns opening e.g. class="main-navigation animated" -->
                                    <!-- "with-dropdown-buttons": Mandatory class that adds extra space, to the main navigation, for the search and cart dropdowns -->
                                    <!-- ================ -->
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
                                                <div class="collapse navbar-collapse" id="navbar-collapse-1" style='min-height:70px;'>
                                                    <!-- main-menu -->
                                                    <?php if(!isset($hideMenu)){ ?>
                                                    <ul class="nav navbar-nav ">

                                                        <!-- mega-menu start -->
                                                        <li class=" mega-menu">
                                                            <a href="/"><i class="fa fa-search"></i> Search Corpus</a>														
                                                        </li>
                                                        <li class=" mega-menu">
                                                            <a href="/datasets"><i class="fa fa-database"></i> My Datasets</a>														
                                                        </li>
                                                        <li class=" mega-menu">
                                                            <a href="/reports"><i class="fa fa-users"></i> My Name Reports</a>														
                                                        </li>
                                                        <!-- mega-menu end -->

                                                    </ul>
                                                    <?php } ?>
                                                    <!-- main-menu end -->

                                                    <!-- header dropdown buttons -->
                                                    <div class="header-dropdown-buttons hidden-xs ">

                                                    </div>

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

            <?php if (uri_string() == "") { echo "<div style='height:123px;'></div>"; }?>