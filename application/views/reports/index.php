<style>
    .form div.row {
        margin-bottom:25px;
    }
</style>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class="container">
            <div class='row'>
                <div class='col-md-7'>
                    <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Plans & Pricing</h1>  
                </div>
                <div class='col-md-5' style='margin-top:23px;'>
                    <div class='text-right'>
                        <!-- <a class="white top-white-link" href="/help" rel="nofollow"><strong>Questions?</strong> Visit Our Help Center</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>   
</div>
<div class="container" style='margin-top:15px;'>
    <?php
    if (isset($_GET['message']) && !empty($_GET['message'])) {
        echo "<div class='alert alert-danger'><i class='fa fa-exclamation-triangle'></i> " . ucwords(strip_tags($_GET['message'])) . "</div>";
    }
    ?>
    <div class="white-area-conten animated fadeInUp">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class='row panels'>
                            <div class='col-sm-4 panel-item'>
                                <div class='panel panel-circle-contrast panel-light pricing-table'>
                                    <div class='panel-icon' style="background-color:transparent;">
                                        <i class='fa fa-user icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>Basic</h3>
                                        <div class="numberBox">
                                            <h4 class='price' id="price1">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                1
                                            </h4>
                                            <h4 class='price' id="price1-2">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                5
                                            </h4>
                                        </div>
                                        <div>Reports Include When Available:</div><br>
                                        <i class="fa fa-check green"></i> Online Profiles<br>
                                        <i class="fa fa-check green"></i> Profile Images<br>
                                        <i class="fa fa-check green"></i> Usernames<br>
                                        <i class="fa fa-check green"></i> Relationships<br>
                                        <i class="fa fa-check green"></i> Names & Aliases<br>
                                        <i class="fa fa-check green"></i> Email Addresses<br>
                                        <i class="fa fa-check green"></i> Phone History<br>
                                        <i class="fa fa-check green"></i> Address History<br>
                                        <i class="fa fa-check green"></i> Career & Education<br>
                                        <i class="fa fa-check green"></i> Instant Results<br><br>
                                        <input type="checkbox" id="checkbox1" checked> + 5-Day Unlimited Public Record Search Free Trial                                        
                                        <a href="#" data-toggle="modal" data-target="#details" class="noThinker">Learn More</a><br><br>


                                        <div class="button-wra">
                                            <form id="form1" action="<?php echo site_url("ipn/stripe/8") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button disabled"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="100"
                                                    data-label="SELECT"
                                                    data-name="Basic Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>

                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox1" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency. I understand if I do not cancel my 5 day free trial that my monthly subscription of $9.99 will automatically begin on the 6th day and that I can cancel the subscription anytime by logging into my account and clicking "Cancel" next to the subscription.
                                                </div>
                                            </form>    
                                            <form id="form1-2" action="<?php echo site_url("ipn/stripe/5") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="500"
                                                    data-label="SELECT"
                                                    data-name="Basic Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>
                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox2" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency.
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-4 panel-item'>
                                <div class='panel panel-circle-contrast panel-contrast pricing-table'>
                                    <div class='panel-icon' style="background-color:transparent;">
                                        <i class='fa fa-star icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>Thorough</h3>
                                        <div class="numberBox">
                                            <h4 class='price' id="price2">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                10
                                            </h4>
                                            <h4 class='price' id="price2-2">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                15
                                            </h4>
                                        </div>
                                        <p class='period'><i class="fa fa-star"></i> Most Popular <i class="fa fa-star"></i></p>
                                        <b>Everything From Basic Report +</b><br><br>
                                        <i class="fa fa-check green"></i> 50 State Criminal Check<br>
                                        <i class="fa fa-check green"></i> Court Records<br>
                                        <i class="fa fa-check green"></i> Incarceration Records<br>
                                        <i class="fa fa-check green"></i> Prison/Inmate Records<br>
                                        <i class="fa fa-check green"></i> Probation Info<br>
                                        <i class="fa fa-check green"></i> Parole & Release Info<br>
                                        <i class="fa fa-check green"></i> Wants & Warrants<br>
                                        <i class="fa fa-check green"></i> 50 State Sex Offender Check<br>
                                        <i class="fa fa-check green"></i> Terrorist Watch List Check<br>
                                        <i class="fa fa-check green"></i> Instant Results<br><br>
                                        <input type="checkbox" id="checkbox2" checked> + 5-Day Unlimited Public Record Search Free Trial                                        
                                        <a href="#" data-toggle="modal" data-target="#details" class="noThinker">Learn More</a><br><br>

                                        <div class="button-wra">
                                            <form id="form2" action="<?php echo site_url("ipn/stripe/9") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="1000"
                                                    data-label="SELECT"
                                                    data-name="Thorough Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>
                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox3" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency. I understand if I do not cancel my 5 day free trial that my monthly subscription of $9.99 will automatically begin on the 6th day and that I can cancel the subscription anytime by logging into my account and clicking "Cancel" next to the subscription.
                                                </div>
                                            </form>    
                                            <form id="form2-2" action="<?php echo site_url("ipn/stripe/6") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="1500"
                                                    data-label="SELECT"
                                                    data-name="Thorough Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>
                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox4" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency.
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class='col-sm-4 panel-item'>
                                <div class='panel panel-circle-contrast panel-light pricing-table'>
                                    <div class='panel-icon' style="background-color:transparent;">
                                        <i class='fa fa-rocket icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>Complete</h3>
                                        <div class="numberBox">
                                            <h4 class='price' id="price3">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                15
                                            </h4>
                                            <h4 class='price' id="price3-2">
                                                <span class='currency'>
                                                    &#36;
                                                </span>
                                                20
                                            </h4>
                                        </div>
                                        <b>Everything From Basic Report + Thorough Report +</b><br><br>
                                        <i class="fa fa-check green"></i> Federal Crimes & Records<br>
                                        <i class="fa fa-check green"></i> Instant Results<br><br>
                                        <input type="checkbox" id="checkbox3" checked> + 5-Day Unlimited Public Record Search Free Trial                                        
                                        <a href="#" data-toggle="modal" data-target="#details" class="noThinker">Learn More</a><br><br>
                                        <style>
                                            .stripe-button-el span {
                                                background: #5BC506; 
                                                width:200px;
                                                height:40px;
                                                padding:5px;
                                                font-size:1.2em;
                                                letter-spacing: 1px;
                                            }
                                        </style>
                                        <div class="button-wra">
                                            <form id="form3" action="<?php echo site_url("ipn/stripe/10") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="1500"
                                                    data-label="SELECT"
                                                    data-name="Complete Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>
                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox5" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency. I understand if I do not cancel my 5 day free trial that my monthly subscription of $9.99 will automatically begin on the 6th day and that I can cancel the subscription anytime by logging into my account and clicking "Cancel" next to the subscription.
                                                </div>
                                            </form>    
                                            <form id="form3-2" action="<?php echo site_url("ipn/stripe/7") ?>" method="POST">
                                                <input type="hidden" name="nid" value="<?php echo current_url(); ?>">
                                                <script
                                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="<?php echo $stripe['publishable_key']; ?>"
                                                    data-amount="2000"
                                                    data-label="SELECT"
                                                    data-name="Complete Report"
                                                    data-description="Instant Results"
                                                    data-zip-code="true"
                                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                    data-locale="auto"
                                                    data-zip-code="true"
                                                    data-currency="<?php echo $this->settings->info->paypal_currency ?>">
                                                </script>
                                                <div class="terms">
                                                    <input style="color:red;" id="agreecheckbox6" type="checkbox" name="agree" class="agree"> I confirm that I have read & agree to the <a href="/tac" rel="nofollow" target="_blank">terms & conditions</a> as well as the <a href="/privacy" target="_blank" rel="nofollow">privacy policy</a> at yoliya.com. I understand yoliya.com is not a consumer reporting agency.
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="height:40px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-labelledby="upgradeModal">
    <div class="modal-dialog" style=" max-width:900px; width:95%;"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bars"></i> 5 Day Unlimited Public Records Search Free Trial</h4>Reports may include when available:
            </div>
            <div class="modal-body">
                <div class='col-sm-6'>
                    <h2>Special Trial Offer</h2>
                    <p>As a special offer, you'll receive free & unlimited access to our public records datasets for 5 days.  You'll also receive unlimited $1 Basic Reports & other premium reports as much as 33% off (unlimited).</p>
                    <p>If you haven't canceled the free trial within 5 days your subscription of $9.99 per month will automatically start.  You can cancel anytime by simply logging in, clicking "My Account" and canceling the subscription.</p>
                    <p class='text-center'><br><button type="button" class="btn btn-info btn-sm" data-dismiss="modal" aria-label="Close">Got It</button></p>
                </div>
                <div class='col-sm-6'>
                    <div class='row panels'>
                        <div class='col-md-12 panel-item'>
                            <div class='panel panel-circle-contrast panel-light pricing-table'>
                                <div class='panel-icon'>
                                    <i class='fa fa-user icon'></i>
                                </div>
                                <div class='panel-body'>
                                    <h3 class='panel-title'>Public Records Search</h3>
                                    <h3 class='price'><span class="">5 Days FREE</span>
                                        <div style="font-size:.5em;"><span class='currency'>
                                                &#36;
                                            </span><span class="strike">9.99</span></div>                                        

                                    </h3>
                                    <div style="position: relative; bottom:10px;">/month</div>
                                    <i class="fa fa-check green"></i> Full Addresses<br>
                                    <i class="fa fa-check green"></i> Phone Numbers<br>
                                    <i class="fa fa-check green"></i> Email Addresses<br>
                                    <i class="fa fa-check green"></i> Voter Records<br>
                                    <i class="fa fa-check green"></i> Domain Purchases<br>
                                    <i class="fa fa-check green"></i> Business Licenses<br>
                                    <i class="fa fa-check green"></i> Business Registrations<br>
                                    <i class="fa fa-check green"></i> & Other Misc Data<br>
                                    <i class="fa fa-check green"></i> Instant Access<br><br>                                                         
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-sm-12'>
                        <hr class='hr-half hr-invisible'>
                        <p class='lead lead-xs text-center'>* Not all reports contain all data listed above. Data will be displayed when available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>