<footer id="footer" class="clearfix ">
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
<script>
    $(document).ready(function () {
        $("#submit_opt").click(function (event) {
                if (grecaptcha.getResponse() == "") {
                    alert("reCaptcha Failed! Are you a robot? Please try again...");
                    event.preventDefault();
                } else {
                    $( "#opt-out" ).submit();
                }
            });
    });

</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
