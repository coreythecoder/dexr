<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link href="/assets/stylesheets/jednotka_green.cs" media="all" id="colors" rel="stylesheet" type="text/css" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
      <script src="/assets/javascripts/ie/html5shiv.js" type="text/javascript"></script>
      <script src="/assets/javascripts/ie/respond.min.js" type="text/javascript"></script>
    <![endif]-->


        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet"> 
        <meta charset="utf-8">
        <title><?php echo $metaTitle; ?></title>
        <meta name="description" content="<?php echo $metaDescription; ?>">
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-86345414-1', 'auto');
            ga('send', 'pageview');

        </script>
        <style>
            .inputs .input-group[class*="col-"] {
                float: left;
            }
        </style>
    </head>

    <body class="text-center">
        <div id="fb-root"></div>
        <script>(function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=199318973842559";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>        
        <div class="background-image"></div>
        <div class="container">
            <div id="home-search" class="animated fadeInUp hidden-xs">
                <div class="page-header" id="banner">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a style="font-size:23px;" href="/"><span class="strokeme"><span class="logo">yoliya.</span></span></a>
                        </div>          
                    </div>
                    <div class="row">
                    </div>
                </div>
                <form action="/results" method="POST" class="form-inline" style=''>   
                    <div class="row">

                        <div class="inputs">
                            <div class="input-group col-md-4">
                                <input type="text" required="required" name="fName" value="<?php if (isset($fname)) echo ucwords($fname); ?>" style='border-radius: 8px 0px 0px 8px;' class="form-control input-md" placeholder="First Name..." autofocus="">                    
                            </div><!-- /input-group -->
                            <div class="input-group col-md-4">
                                <input type="text" required="required" name="lName" value="<?php if (isset($lname)) echo ucwords($lname); ?>" class="form-control input-md" placeholder="Last Name...">                    
                            </div><!-- /input-group -->                
                            <div class="input-group col-md-4">
                                <select required="required" name="state" class="form-control input-md" style='border-radius: 0px 8px 8px 0px;'>
                                    <option value="">State...</option>
                                    <?php
                                    $statesArrayFlip = statesArray(true);
                                    foreach (statesArray() as $stateList) {
                                        if (isset($state) && strtolower($state) == strtolower($statesArrayFlip[$stateList])) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='" . $statesArrayFlip[$stateList] . "' " . $selected . ">" . $stateList . "</option>";
                                    }
                                    ?>
                                </select>                                
                            </div><!-- /input-group -->
                        </div>

                    </div>
                    <div class="row">             
                        <div class="input-group col-xs-12 text-center">
                            <span class="input-group-btn text-center">
                                <button type="submit" style="border-radius: 8px; margin-top:8px;" class="btn btn-success btn-block btn-md" type="button">Find Em'</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>

            <div id="home-search-mobile" class="animated fadeInUp hidden-sm hidden-md hidden-lg">
                <br><br>
                <div class="page-header" id="banner">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <a style="font-size:20px;" href="/"><span class="strokeme"><span class="logo">yoliya.</span></span></a>
                        </div>          
                    </div>
                </div>
                <form action="/results" method="POST" class="form-inline" style=''>   
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <div class="inputs-mobile">
                                <div class="input-group col-xs-12 text-center">
                                    <input type="text" required="required" name="fName" value="<?php if (isset($fname)) echo ucwords($fname); ?>" style='border-radius:8px;' class="form-control input-md text-center" placeholder="First Name..." autofocus="">                    
                                </div><!-- /input-group -->
                                <div class="input-group col-xs-12 text-center">
                                    <input type="text" required="required" name="lName" value="<?php if (isset($lname)) echo ucwords($lname); ?>" style="border-radius:8px;" class="form-control input-md text-center" placeholder="Last Name...">                    
                                </div><!-- /input-group -->                
                                <div class="input-group col-xs-12 text-center">
                                    <select required="required" name="state" class="form-control input-md text-center" style='border-radius:8px;'>
                                        <option value="">State...</option>
                                        <?php
                                        $statesArrayFlip = statesArray(true);
                                        foreach (statesArray() as $stateList) {
                                            if (isset($state) && strtolower($state) == strtolower($statesArrayFlip[$stateList])) {
                                                $selected = "selected";
                                            } else {
                                                $selected = "";
                                            }
                                            echo "<option value='" . $statesArrayFlip[$stateList] . "' " . $selected . ">" . $stateList . "</option>";
                                        }
                                        ?>
                                    </select>                                
                                </div><!-- /input-group -->
                            </div>
                        </div>
                    </div>
                    <div class="row">             
                        <div class="input-group col-xs-12 text-center inputs-mobile">
                            <span class="input-group-btn text-center">
                                <button type="submit" class="btn btn-success btn-md text-center" style="border-radius:8px;" type="button">Find Em'</button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>


        </div>

        <div style="height:450px;" class="hidden-xs"></div>
        <div style="height:40px;" class="hidden-sm hidden-md hidden-lg"></div>
        <footer>
            <div class="bs-component">
                <nav class="navbar navbar-bottom animated fadeInUp">
                    <div class="container-fluid">
                        <div class="">                 
                            <div style="margin:8px; font-size:10px;"><?php if ($this->user->loggedin) { ?>
                                    <a rel="nofollow" class="" style="margin:8px;" href="/archive">My Archives</a> | <a rel="nofollow" class="" style="margin:8px;" href="/user_settings">My Account</a> | <a rel="nofollow" class="" style="margin:8px;" href="/login/logout">Sign Out</a>
                                <?php } else { ?>
                                    <a rel="nofollow"  href="/login" class="" style="margin:8px;">Sign In</a>
                                <?php } ?></div>
                            <div style='margin:8px; font-size:10px; color:white;'>Copyright <?php echo date('Y'); ?> <a href="/">yoliya.</a> All rights reserved.<br><a href='/privacy' rel='nofollow'>Privacy Policy</a> | <a href='/tac' rel='nofollow'>Terms & Conditions</a> | <a href="/help" rel="nofollow">Help Center</a></div>
                            <div style='margin:8px; font-size:10px;'><a href="/co">CO</a> | <a href="/ct">CT</a> | <a href="/fl">FL</a> | <a href="/de">DE</a> | <a href="/ok">OK</a> | <a href="/ut">UT</a></div>
                        </div>
                    </div>
                </nav>
            </div>
        </footer>

        <div class="modal fade" id="wait" tabindex="-1" role="dialog" aria-labelledby="wait" data-backdrop="static">
            <div class="modal-dialog" style=" "  role="document">
                <div class="modal-content" style="background-color:transparent; border: 0px solid grey; box-shadow: unset; webkit-box-shadow: unset; position:relative; top:-20px;">

                    <div class="modal-body">
                        <div class='col-sm-12 text-center'>
                            <img src="/assets/images/loading.gif">
                        </div>                                
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
        <script src="/assets/javascripts/custom.js"></script>
    </body>
</html>
