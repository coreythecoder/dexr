<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>         
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex">
        <!-- Bootstrap -->
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen">

        <!-- Styles -->
        <link href="<?php echo base_url(); ?>styles/login_layout.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>styles/responsive.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
        <link href="/assets/stylesheets/jednotka_green.css" media="all" id="colors" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
        <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet">


        <!-- SCRIPTS -->
        <script type="text/javascript">
            var global_base_url = "<?php echo site_url('/') ?>";
        </script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function () {
                $(document).tooltip();
            });
        </script>

        <!-- CODE INCLUDES -->
        <?php echo $cssincludes ?> 
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

    </head>
    <body>
        <div class="background-image"></div>
        <div class="container-fluid">
            <div class="bs-component">
                <nav class="navbar transparent navbar-fixed-top animated fadeInDown">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="/"><span class="strokeme"><span class="logo"></span></span></a>
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                            <ul class="nav navbar-nav navbar-right">
                                <?php if ($this->user->loggedin) { ?>
                                    <li><a rel="nofollow" class="btn btn-default btn-xs" style="margin:8px;" href="/dash">My Dashboard</a></li>
                                    <li><a rel="nofollow" class="btn btn-default btn-xs" style="margin:8px;" href="/login/logout">Sign Out</a></li>
                                <?php } ?>                            
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <div class="col-md-12 top-margin">
                    <?php $gl = $this->session->flashdata('globalmsg'); ?>
                    <?php if (!empty($gl)) : ?>
                        <div class="container projects-wrap">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success"><b><span class="glyphicon glyphicon-ok"></span></b> <?php echo $this->session->flashdata('globalmsg') ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php echo $content ?>

                </div>
            </div>
        </div>



    </body>
</html>