<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link href="/assets/stylesheets/jednotka_green.css" media="all" id="colors" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
      <script src="/assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="/assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->


        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet"> 
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBww1v8bCOqbtsz5AWbUsJoT9Q-lpeMUQc&callback=initMap" async defer></script>
        <script src="/assets/javascripts/custom.js"></script>
        <meta charset="utf-8">
        <title><?php echo $metaTitle; ?></title>
        <meta name="description" content="<?php echo $metaDescription; ?>">

        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" href="/plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>

        <!-- production -->
        <script type="text/javascript" src="/plupload/js/plupload.min.js"></script>
        <script type="text/javascript" src="/plupload/js/jquery.ui.plupload/jquery.ui.plupload.js"></script>

        <!-- debug 
        <script type="text/javascript" src="../js/plupload.dev.js"></script>
        <script type="text/javascript" src="../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
        -->

    </head>

    <body>
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=210411152326136";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
        <div class="bs-component">
            <nav class="navbar navbar-default transparent navbar-fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="/"><span class="strokeme"><span class="logo">yoliya.</span></span></a>
                    </div>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">                            
                            <li class=""><a href="/"><i class="fa fa-search"></i> Search</a></li>
                            <li class=""><a href="/"><i class="fa fa-tree"></i> Directory Tree</a></li>

                        </ul>   
                        <form class="navbar-form navbar-right pull-left" method="GET" action="/results" role="search" style='margin:6px;'>
                            <div class="form-group">
                                <input type="text" class="form-control input-sm" name="fName" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control input-sm" name="lName" placeholder="Last Name">
                            </div>
                            <button type="submit" class="btn btn-info btn-xs">Find Em'</button>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <?php if (isset($_SESSION['username'])) { ?>
                                <li class=""><a href="/logout">Sign Out</a></li>
                            <?php } else { ?>
                                <li class=""><a href="/login" class="btn btn-default btn-xs" style="margin:8px;">Sign In</a></li>
                                <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>