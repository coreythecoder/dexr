</section>
<footer id="footer" class="clearfix ">
    <div class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-content">
                            <div class="logo-footer"><img id="logo-footer" src="https://static.dexr.io/assets/images/blue-logo-45.png" alt=""></div>
                            <p>Dexr connects you with more than 68 million targeted businesses & web site owners with full contact information. Create a free forever account today.</p>
                            <div class="separator-2"></div>
                            <nav>
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a target="_blank" href="/pricing">Pricing</a></li>
                                    <li><a href="#">About Our Data</a></li>
                                    <li><a href="#">Opt-Outs & Removals</a></li>
                                    <li><a href="page-about.html">Create Account</a></li>
                                    <li><a href="page-about.html">Sign In</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="footer-content">
                            <h2 class="title">Browse Our Directory</h2>
                            <div class="separator-2"></div>
                            <?php
                            $states = statesArray();
                            foreach ($states as $k => $v) {
                                echo "<div class='col-md-3'><a href='/" . strtolower($k) . "'>" . $v . "</a></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="subfooter">
        <div class="container">
            <div class="subfooter-inner">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center">Copyright © <?php echo date('Y'); ?> <a href="/">dexr.</a> All Rights Reserved</p>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/jquery.min.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/modernizr.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/waypoints/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/jquery.countTo.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="https://static.dexr.io/assets/themes/v4/plugins/jquery.parallax-1.1.3.js"></script>
<script src="https://static.dexr.io/assets/themes/v4/plugins/jquery.validate.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/owl-carousel/owl.carousel.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/jquery.browser.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/SmoothScroll.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/js/template.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/js/custom.js"></script>
<script src="https://static.dexr.io/assets/javascripts/custom.js"></script>
</body>
</html>
