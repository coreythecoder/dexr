<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>"><?php echo $state; ?></a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>/<?php echo $city_slug; ?>"><?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>/<?php echo $city_slug; ?>/<?php echo $name_slug; ?>"><?php echo ucwords(strtolower($name)); ?> in <?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></a></li>
        </ol>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <div class="row">
                <div class="col-md-9">
                    <h1 class="mobile-center">
                        <?php echo ucwords(strtolower($name)); ?> in <?php echo $city; ?>, <?php echo $state_abr; ?>
                    </h1>
                    <?php if ($total >= 5) { ?>
                        <h4 class="mobile-center">Showing 5 of <?php
                            if ($total >= 25) {
                                echo ">";
                            }
                            ?><?php echo $total; ?> Registration(s) &nbsp; &nbsp; <a href="/pricing?src=name&btn=show_full_list" rel="nofollow" class="btn btn-default btn-sm">See Full List</a></h4>
                        <?php } else { ?>
                        <h4 class="mobile-center">Showing <?php echo $total; ?> of <?php
                            if ($total >= 25) {
                                echo ">";
                            }
                            ?><?php echo $total; ?> Registration(s)</h4>
                    <?php } ?>         
                </div>       
                <div class="col-md-3">
                    <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-default btn-block" id="checkout_modal"><i class="fa fa-arrow-down"></i>&nbsp; Download Full Report</button>
                </div>
            </div>

            <div class="separator"></div>

            <div class="row">
                <div class="col-md-12 other-text">
                    <h4 class="mobile-center">Our Database Contains</h4>
                    <div class="row">
                        <?php echo $contains_emails . $contains_cities . $contains_phones . $contains_addresses; ?>                        
                    </div>
                </div>                
            </div>
            <div class="separator"></div>

            <?php echo $domains; ?>
        </div>    
    </div>
</div>
<div class="container">
    <div class="row other-names">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <?php echo $names; ?>  
        </div>
    </div>
</div>
<section class="section default-bg clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="call-to-action text-center">
                    <div class="row">                            
                        <div class="col-sm-3 text-center">
                            <h3><i class="fa fa-building-o fa-2x" style="margin-bottom:10px;"></i><br>B2B Marketing</h3>
                        </div>
                        <div class="col-sm-3 text-center">
                            <h3><i class="fa fa-link fa-2x" style="margin-bottom:10px;"></i><br>Link Building Outreach</h3>
                        </div>
                        <div class="col-sm-3 text-center">
                            <h3><i class="fa fa-line-chart fa-2x" style="margin-bottom:10px;"></i><br>Competitive Analysis</h3>
                        </div>
                        <div class="col-sm-3 text-center">
                            <h3><i class="fa fa-users fa-2x" style="margin-bottom:10px;"></i><br>Contact Management</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="row" style='margin-top:30px; margin-bottom:80px;'>
        <div class="col-md-12 text-center">
            <h2 style="padding:15px;">We're Integrated with Zapier!</h2>
            <p class='text-center large' style="padding:15px;">Send our data to any of over 1000 other apps connected by Zapier!<br><small>**requires a Zapier account</small></p>
            <img src='https://static.dexr.io/images/zapier.png' style='display:inline;'>
        </div>
    </div>
</section>



<section class="section default-bg clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="call-to-action text-center">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="title">Ready To Take A Test Drive?</h1>
                            <p>Get started today.</p>
                        </div>
                        <div class="col-sm-4">
                            <br>
                            <p><a href="/pricing?src=name&btn=test_drive" rel="nofollow" class="btn btn-lg btn-gray-transparent btn-animated">Check Out Our Pricing<i class="fa fa-arrow-right pl-20"></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width:90%; max-width:800px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color:white;">
                <div class="row">
                    <div class="col-md-1 text-center">
                        <i class="fa fa-check-circle fa-4x" style="color:#09afdf;"></i>
                    </div>
                    <div class="col-md-10">
                        <h3 class="modal-title" id="exampleModalLabel" style="color:#09afdf;">Get Instant Information on <strong><?php echo ucwords(strtolower($name)); ?></strong></h3>
                        <h6 style="position:relative; bottom:8px;">Your Purchase is confidential. <?php echo ucwords(strtolower($name)); ?> will NOT be notified of your purchase.</h6>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>                
            </div>
            <div class="modal-body">
                <div id="step_1">
                    <h5>Make Your Choice</h5>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <img style="width:250px; height:250px; border-radius:50%; margin-top:20px; margin-bottom:40px; margin-left:auto; margin-right:auto;" src="https://maps.googleapis.com/maps/api/staticmap?center=41 East 11th Street 2nd Floor New York, NY&amp;zoom=13&amp;size=250x250&amp;maptype=roadmap&#10;                                        &amp;markers=color:blue%7Clabel:%7C41 East 11th Street 2nd Floor New York, NY&#10;                                        &amp;key=AIzaSyBSK9ERERVRBcrcRMVZkwhIt9Hjjb42dMg">
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
                                    <div class="col-md-6 col-xs-12 col-sm-12" style='padding-left:0px'>

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
                                    <h3><i class="fa fa-user"></i>&nbsp; Dexr.io Report for John Doe <span style="font-weight: bold; font-size:28px;" class="pull-right blue">$0.99</span></h3>
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
                                    <div>I agree that I will not use dexr.io to determine an individual's eligibility for credit, insurance, employment, housing, or any other purpose covered under the Fair Credit Reporting Act (FCRA). I understand that dexr.io is not a consumer reporting agency. I have read and agree to the dexr.io terms and conditions as well as the dexr.io privacy policy. I understand that if I do not cancel my free trial within 7 days that my debit or credit card will be charged $49 at that time and each month thereafter until I cancel.  I understand dexr.io does not provide refunds. I understand that in order to cancel my subscription, I need to login to dexr.io, navigate to "my account" and click "cancel" next to my subscription. 
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
<script>

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

</script>