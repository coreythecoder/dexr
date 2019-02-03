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
                                if (!isset($url[2])) {
                                    $url[2] = 1;
                                    $thisPage = 1;
                                }
                                $next = $url[2] + 1;
                                $previous = $url[2] - 1;


                                if ($thisPage != '1') {
                                    ?>
                                    <a rel="prev" href="<?php echo "/" . $url[1] . "/" . $previous; ?>" class="btn btn-default btn-xs"><i class="fa fa-caret-left"></i></a> 
                                <?php } ?> &nbsp; Page <?php echo $url[2]; ?> of <?php echo ceil($lastPage); ?> &nbsp; 
                                <?php if ($thisPage != ceil($lastPage)) { ?>
                                    <a rel="next" href="<?php echo "/" . $url[1] . "/" . $next; ?>" class="btn btn-default btn-xs"><i class="fa fa-caret-right"></i></a> 
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
<script type="text/javascript" src="/assets/themes/v4/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
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
</body>
</html>