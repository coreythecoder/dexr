<div style="height:80px;"></div>
<footer id="footer" class="clearfix ">
    <!-- .footer end -->

    <!-- .subfooter start -->
    <!-- ================ -->
    <div class="subfooter" style="position:fixed; bottom:0px; width:100%;">
        <div class="container-fluid">
            <div class="subfooter-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center" style="position:absolute; left:20px; bottom:-20px;">
                            <?php if (isset($count) && $count > $maxPerPage) { ?>
                                <?php
                                $url = explode("/", $_SERVER['REQUEST_URI']);
                                $next = $url[4] + 1;
                                $previous = $url[4] - 1;

                                if ($thisPage != '1') {
                                    ?>
                                    <a href="<?php echo "" . $url[0] . "/" . $url[1] . "/" . $url[2] . "/" . $url[3] . "/" . $previous; ?>" class="btn btn-default btn-xs"><i class="fa fa-caret-left"></i></a> 
                                <?php } ?> &nbsp; Page <?php echo $url[4]; ?> of <?php echo ceil($lastPage); ?> &nbsp; 
                                <?php if ($thisPage != ceil($lastPage)) { ?>
                                    <a href="<?php echo "" . $url[0] . "/" . $url[1] . "/" . $url[2] . "/" . $url[3] . "/" . $next; ?>" class="btn btn-default btn-xs"><i class="fa fa-caret-right"></i></a> 
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <p class="text-center">Copyright © <?php echo date('Y'); ?> <a href="/">dexr.</a> All Rights Reserved</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .subfooter end -->

</footer>
<!-- footer end -->

</div>
<!-- page-wrapper end -->

<div class="modal fade" id="thinker" tabindex="-1" role="dialog" aria-labelledby="thinker" data-backdrop="static">
    <div class="modal-dialog" style=" "  role="document">
        <div class="modal-content" style="background-color:transparent; border: 0px solid grey; box-shadow: unset; webkit-box-shadow: unset; position:relative; top:100px;">
            <div class="modal-body">
                <div class='col-sm-12 text-center'>
                    <img style="display:unset;" src="/assets/images/waiting.gif"><br>
                    <h1 style="color:white;">Doing stuff...</h1>
                </div>                                
            </div>
        </div>
    </div>
</div>

<!-- JavaScript files placed at the end of the document so the pages load faster -->
<!-- ================================================== -->
<!-- Jquery and Bootstap core js files -->
<script type="text/javascript" src="/assets/themes/v4/plugins/jquery.min.js"></script>
<script type="text/javascript" src="/assets/themes/v4/bootstrap/js/bootstrap.min.js"></script>
<!-- Modernizr javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/modernizr.js"></script>
<!-- Magnific Popup javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- Appear javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/waypoints/jquery.waypoints.min.js"></script>
<!-- Count To javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/jquery.countTo.js"></script>
<!-- Parallax javascript -->
<script src="/assets/themes/v4/plugins/jquery.parallax-1.1.3.js"></script>
<!-- Contact form -->
<script src="/assets/themes/v4/plugins/jquery.validate.js"></script>
<!-- Owl carousel javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/owl-carousel/owl.carousel.js"></script>
<!-- SmoothScroll javascript -->
<script type="text/javascript" src="/assets/themes/v4/plugins/jquery.browser.js"></script>
<script type="text/javascript" src="/assets/themes/v4/plugins/SmoothScroll.js"></script>
<!-- Initialization of Plugins -->
<script type="text/javascript" src="/assets/themes/v4/js/template.js"></script>

<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<!-- Custom Scripts -->
<script type="text/javascript" src="/assets/themes/v4/js/custom.js"></script>

<script src="/assets/javascripts/custom.js"></script>
<script>
</script>
<?php if (empty($list)) { ?>
    <script>
        $('#editFilters').modal('show');
    </script>
<?php } ?>

</body>
</html>