</section>
<?php if (!isset($checkoutModal)) { ?>
    <footer id="footer" class="clearfix ">
        <div class="footer">
            <div class="container">
                <div class="footer-inner">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-content">
                                <div class="logo-footer"><img id="logo-footer" src="https://static.dexr.io/assets/images/blue-logo-45.png" alt=""></div>
                                <p>Dexr connects you with more than 68 million targeted businesses & web site owners with full contact information.</p>
                                <div class="separator-2"></div>
                                <nav>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a target="_blank" href="/pricing">Pricing</a></li>
                                        <li><a href="https://app.dexr.io/login">Sign In</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="footer-content state-list">
                                <h2 class="title">Browse Our Directory</h2>
                                <div class="separator-2"></div>
                                <?php
                                $states = statesArray();
                                foreach ($states as $k => $v) {
                                    echo "<div class='col-md-3 col-xs-6'><a href='/" . strtolower($k) . "'>" . $v . "</a></div>";
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
                            <p class="text-center">Copyright © <?php echo date('Y'); ?> <a href="/">dexr.</a> All Rights Reserved | <a href="/opt-out" rel="nofollow">Opt-Out</a></p>                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php } ?>
</div>
<?php if (isset($checkoutModal)) { ?>
    <div class="modal fade animated fadeInDown" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="">
        <div class="modal-dialog" role="document" style="width:90%; max-width:800px;">
            <div class="modal-content">
                <div class="modal-header" style="background-color:white;">
                    <div class="row">
                        <div class="col-md-1 text-center">
                            <i class="fa fa-check-circle fa-4x" style="color:#09afdf;"></i>
                        </div>
                        <div class="col-md-11">
                            <h3 class="modal-title" id="exampleModalLabel" style="color:#09afdf;">Get Instant Information on <strong><?php echo ucwords(strtolower($name)); ?></strong></h3>
                            <h6 style="position:relative; bottom:8px;">Your Purchase is confidential. <?php echo ucwords(strtolower($name)); ?> will NOT be notified of your purchase.</h6>
                        </div>

                    </div>                
                </div>
                <div class="modal-body">
                    <div id="step_1">
                        <h5>Make Your Choice</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <img style="width:250px; height:250px; border-radius:50%; margin-top:20px; margin-bottom:40px; margin-left:auto; margin-right:auto;" src='https://api.mapbox.com/styles/v1/mapbox/satellite-streets-v11/static/pin-s-building+285A98(<?php echo $oneMap; ?>)/<?php echo $oneMap; ?>,16.42,0.00,0.00/300x300@2x?access_token=pk.eyJ1IjoiZGV4ciIsImEiOiJjanZzcndybDYwdWVmM3pvZWFpcnBsYmRhIn0.bl_iQq9nNrlVGVMU6TZOyA'>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>Full Name Report</h5>
                                        <h4 style="font-size:28px;color:#09afdf;font-weight:bold;">$0.99</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-default" id="99_checkout_btn">Continue &nbsp;<i class="fa fa-caret-right"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <p>Special offer with FREE trial membership</p>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full Access to Name Search</div>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full Phone Numbers</div>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full Email Address(es)</div>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full Street Address(es)</div>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full List of Domain Registrations & Data</div>
                                <div><i class="fa fa-check-circle" style="color:#09afdf;"></i> Full Access to 68,000,000 registrations</div>
                                <div style="margin-top:25px;">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div><strong>Name Report Only</strong></div>
                                            $9.99                     
                                        </div>
                                        <div class="col-md-6">
                                            <a  id="9_99_checkout_btn">Continue &nbsp;<i class="fa fa-caret-right"></i></a>
                                        </div>
                                    </div>


                                </div>
                            </div>                    
                        </div>
                    </div>
                    <div id="step_2" style="display:none;">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Create an Account &nbsp; &nbsp; <small>Already have an account? <a style="color:#09afdf;" href="https://app.dexr.io/login" rel="nofollow">Sign In</a></small> <button type='button' id="continue_btn" class="btn btn-default pull-right" style="position:relative; bottom:22px;">Continue &nbsp;<i class="fa fa-caret-right"></i></button></h5>
                                <hr>
                                <?php if (!empty($fail)) : ?>
                                    <div class="alert alert-danger"><?php echo $fail ?></div>
                                <?php endif; ?>

                                <form action="https://app.dexr.io/register" class="form-horizontal" method="post" accept-charset="utf-8" id="payment-form">


                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="text" class="form-control" placeholder="First & Last Name" id="name-in" name="first_name" value="<?php if (isset($first_name)) echo $first_name ?>" autofocus="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <?php if (!isset($_SESSION['email'])) { ?>
                                                        <input type="email" class="form-control" placeholder="Email Address" id="email-in" name="email" value="<?php if (isset($email)) echo $email; ?>">
                                                    <?php } else { ?>
                                                        <?php echo strip_tags($_SESSION['email']); ?>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12" style=''>

                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="password" placeholder="Password" class="form-control" id="password-in" name="password" value="">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <input type="password" placeholder="Confirm Password" class="form-control" id="cpassword-in" name="password2" value="">
                                                </div>
                                            </div>
                                        </div>                                
                                        <div class="col-md-12">

                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    <div id="step_3" style="display:none;">
                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fa fa-shopping-cart"></i>&nbsp; Secure Checkout<span class="pull-right"><i class="fa fa-lock" style="color:green;"></i>&nbsp; 256-bit SSL</span></h5>
                                <hr> 
                                <div class="row" style="margin-top:20px; margin-bottom:20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">
                                        <h3><i class="fa fa-user"></i>&nbsp; Dexr.io Report for<br><b style="position:relative; left:30px;"><?php echo ucwords(strtolower($name)); ?></b> <span style="font-weight: bold; font-size:28px;" class="pull-right blue">$0.99</span></h3>
                                        <strong>+ 7 Day Dexr Membership Trial *FREE</strong>
                                        <hr>

                                        <small>*Cancel anytime. After your 7 day free trial, you will be billed 49.00 per month.</small><br>
                                        <hr>                                    
                                        <h3>Total: $0.99</h3>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <script src="https://js.stripe.com/v3/"></script>
                                <div class="row" style="margin-top:20px; margin-bottom:20px;">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8">

                                        <div class="form-row">
                                            <label for="card-element">
                                                Credit or debit card
                                            </label>
                                            <div id="card-element">
                                                <!-- A Stripe Element will be inserted here. -->
                                            </div>

                                            <!-- Used to display form errors. -->
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <input type="hidden" name="s" value="">
                                        <input type="hidden" name="type" value="" id="type">
                                        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>">

                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-12 text-center'>
                                        <button name="s" form="payment-form" id="savePaymentSource" type="submit" class="btn btn-default btn-xs"><i class="fa fa-credit-card"></i>&nbsp; Pay $0.99</button>   

                                    </div>
                                </div>
                                <div class="row" style='margin-bottom:30px; '>
                                    <div class='col-md-2'></div>
                                    <div class='col-md-8'>
                                        <div>By clicking this button I agree that I will not use dexr.io to determine an individual's eligibility for credit, insurance, employment, housing, or any other purpose covered under the Fair Credit Reporting Act (FCRA). I understand that dexr.io is not a consumer reporting agency. I have read and agree to the dexr.io terms and conditions as well as the dexr.io privacy policy. I understand that if I do not cancel my free trial within 7 days that my debit or credit card will be charged $49 at that time and each month thereafter until I cancel.  I understand dexr.io does not provide refunds. I understand that in order to cancel my subscription, I need to login to dexr.io, navigate to "my account" and click "cancel" next to my subscription. 
                                        </div>

                                    </div>
                                    <div class='col-md-2'></div>
                                </div>

                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="thinker" tabindex="-1" role="dialog" aria-labelledby="thinker" data-backdrop="static">
        <div class="modal-dialog" style=" "  role="document">
            <div class="modal-content" style="background-color:transparent; border: 0px solid grey; box-shadow: unset; webkit-box-shadow: unset; position:relative; top:100px;">
                <div class="modal-body">
                    <div class='col-sm-12 text-center'>
                        <img style="display:unset;" src="/assets/images/waiting.gif" class='animated fadeInDown'><br>
                        <div class='animated fadeInUp'>
                            <h1 style="color:white;">Just a moment,</h1>
                            <h3 style='color:white;'>We're building a report for<br><br><strong><?php echo ucwords(strtolower($name)); ?></strong>.</h3>
                        </div>
                    </div>                                
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="success" data-backdrop="static">
        <div class="modal-dialog" style=" "  role="document">
            <div class="modal-content" style="background-color:transparent; border: 0px solid grey; box-shadow: unset; webkit-box-shadow: unset; position:relative; top:200px;">
                <div class="modal-body">
                    <div class='col-sm-12 text-center'>
                        <div style="font-size: 100px; color:#00ff00" class="fa fa-check-circle fa-3x animated fadeInDown"></div><br>
                        <h1 class="animated fadeInUp" style="color:white;">Report Complete!</h1>
                    </div>                                
                </div>
            </div>
        </div>
    </div>

<?php } ?>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/plugins/jquery.min.js"></script>
<script type="text/javascript" src="https://static.dexr.io/assets/themes/v4/bootstrap/js/bootstrap.min.js"></script>

<script>
    jQuery(document).ready(function () {
        jQuery("#checkout_modal").click(function () {
            window.GoogleAnalyticsObject = 'analytics';
            jQuery.getScript('//www.google-analytics.com/analytics.js', function () {
                analytics('create', 'UA-133857018-1', 'auto');
                analytics('send', 'event', 'download_btn', 'click');
            });

        });
        jQuery("#99_checkout_btn").click(function () {
            window.GoogleAnalyticsObject = 'analytics';
            jQuery.getScript('//www.google-analytics.com/analytics.js', function () {
                analytics('create', 'UA-133857018-1', 'auto');
                analytics('send', 'event', '99_checkout_btn', 'click');
            });

        });
        jQuery("#9_99_checkout_btn").click(function () {
            window.GoogleAnalyticsObject = 'analytics';
            jQuery.getScript('//www.google-analytics.com/analytics.js', function () {
                analytics('create', 'UA-133857018-1', 'auto');
                analytics('send', 'event', '9_99_checkout_btn', 'click');
            });

        });
        jQuery(".uncover_btn").click(function () {
            window.GoogleAnalyticsObject = 'analytics';
            jQuery.getScript('//www.google-analytics.com/analytics.js', function () {
                analytics('create', 'UA-133857018-1', 'auto');
                analytics('send', 'event', 'uncover_btn', 'click');
            });

        });
<?php if (isset($checkoutModal)) { ?>

            $('#thinker').modal('show');
            setTimeout(
                    function ()
                    {
                        $('#thinker').fadeOut();
                        $('#success').modal({backdrop: 'static', keyboard: false});

                    }, 10000);
            setTimeout(
                    function ()
                    {
                        $('#success').fadeOut();
                        $('#exampleModal').modal({backdrop: 'static', keyboard: false});

                    }, 14000);


            jQuery("#99_checkout_btn").click(function () {
                jQuery("#step_1").slideUp();
                jQuery("#step_2").slideDown();
            });
            jQuery("#continue_btn").click(function () {


                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/


                var pass = true;

                var name = jQuery("#name-in").val();
                if (!name) {
                    jQuery("#name-in").css("border-color", "red");
                    pass = false;
                }
                var email = jQuery("#email-in").val();
                if (!email || !email.match(re)) {
                    jQuery("#email-in").css("border-color", "red");
                    pass = false;
                }
                var passw = jQuery("#password-in").val();
                if (!passw) {
                    jQuery("#password-in").css("border-color", "red");
                    pass = false;
                }
                var cpass = jQuery("#cpassword-in").val();
                if (!cpass) {
                    jQuery("#cpassword-in").css("border-color", "red");
                    pass = false;
                }

                if (!pass) {
                    //jQuery(".form-control").css("border-color", "red");
                } else {
                    jQuery("#step_2").slideUp();
                    jQuery("#step_3").slideDown();
                }

                jQuery(".form-control").on("keyup", function () {
                    jQuery(this).css("border-color", "green");
                });


            });


            jQuery("#continue_btn").click(function () {



                // Create a Stripe client.
                var stripe = Stripe('pk_live_eBC8PoJVsc1ID70rOlsKkllM');

                // Create an instance of Elements.
                var elements = stripe.elements();

                // Custom styling can be passed to options when creating an Element.
                // (Note that this demo uses a wider set of styles than the guide below.)
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                // Create an instance of the card Element.
                var card = elements.create('card', {style: style});

                // Add an instance of the card Element into the `card-element` <div>.
                card.mount('#card-element');

                // Handle real-time validation errors from the card Element.
                card.addEventListener('change', function (event) {
                    var displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                // Handle form submission.
                var form = document.getElementById('payment-form');
                form.addEventListener('submit', function (event) {
                    event.preventDefault();

                    stripe.createToken(card).then(function (result) {
                        if (result.error) {
                            // Inform the user if there was an error.
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            // Send the token to your server.
                            stripeTokenHandler(result.token);
                        }
                    });
                });

            });


            // Submit the form with the token ID.
            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);

                // Submit the form
                form.submit();
            }
<?php } ?>
    });
</script>
</body>
</html>
