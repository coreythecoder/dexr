
<div class="container">
    <div class='row' style='margin: 10px;'>

        <div class="main col-md-12">

            <!-- page-title start -->
            <!-- ================ -->
            <h1 class="page-title">Pricing.</h1>
            <div class="separator-2"></div>
            <!-- page-title end -->

            <!-- pricing tables start -->
            <!-- ================ -->
            <div class="pricing-tables stripped object-non-visible" data-animation-effect="fadeInUpSmall"  data-effect-delay="0">
                <div class="row grid-space-0">
            

                    <!-- pricing table start -->
                   

                    <!-- pricing table start -->
                    <!-- ================ -->
                    <div class="col-sm-4 plan stripped">
                        <div class="header dark-bg">
                            <h3>Pro</h3>
                            <div class="price"><span>$100</span>/m.</div>
                        </div>
                        <ul>
                            <li>All Basic Options +</li>
                            <li>All Premium Options +</li>
                            <li>
                                <a href="#" class="pt-popover" data-toggle="popover" data-placement="right" data-content="Download CSV files & bulk import into any CRM, program or app you want." title="" data-original-title="Unlimited CSV Downloads">Unlimited CSV Downloads</a>
                            </li>
                            <li>Bulk Data Scrubbing<br>(coming soon)</li>

                            <li><button data-toggle="modal" data-target="#payment" id="pro_payment_button" class="btn btn-default btn-animated">Sign Up <i class="fa fa-user"></i></a></li>
                        </ul>
                    </div>
                    <!-- pricing table end -->
                    
                     <!-- ================ -->
                    <div class="col-sm-4 plan stripped best-value">
                        <div class="header default-bg">
                            <h3>Premium</h3>
                            <div class="price"><span>$49</span>/m.</div>
                        </div>
                        <ul>
                            <li><b><i class="fa fa-star blue"></i> 7 Day Free Trial</b></li>
                            <li>Access to Email Addresses<br>& Phone Numbers</li>
                            <li>Unlimited Results</li>
                            <li>Data Pulls in 10k Chunks</li>
                            <li>Unlimited Datasets</li>
                            <li>Domain Keyword Lookups</li>                            
                            <li>Owner Lookups</li>
                            <li>Reverse Phone # Lookups</li>
                            <li>Address Lookups</li>
                            <li>City & State Lookups</li>
                            <li>Company Name Lookups</li>
                            <li>Zip Code Lookups</li>
                            <li>Reverse Email Lookups</li>
                            <li>
                                <a href="https://zapier.com/" target="_blank" class="pt-popover noThinker" data-toggle="popover" data-placement="right" data-content="Zapier connects Dexr. to more than 1000 other popular web apps which enables you to create automated tasks. Visit Zapier.com to learn more." title="" data-original-title="Zapier Integration">Zapier Integration</a> <i class="fa fa-bolt blue"></i>
                            </li>
                            <li><button data-toggle="modal" data-target="#payment" id="premium_payment_button" class="btn btn-dark btn-animated">Start 7-Day Trial <i class="fa fa-user"></i></button></li>
                        </ul>
                    </div>
                    <!-- pricing table end -->

                    <!-- pricing table start -->
                    <!-- ================ -->
                    <div class="col-sm-4 plan">
                        <div class="header dark-bg">
                            <h3>Ultimate</h3>
                            <div class="price"><span>Contact Us</span></div>
                        </div>
                        <ul>
                            <li>All Basic Options +</li>
                            <li>All Premium Options +</li>
                            <li>All Pro Options +</li>
                            <li>
                                <a href="#" class="pt-popover" data-toggle="popover" data-placement="right" data-content="Full access to query our API on-demand using SQL-like commands." title="" data-original-title="API Access">API Access</a>
                            </li>

                            <li><a href="mailto:support@dexr.io" class="btn btn-dark btn-animated noThinker">Contact Us <i class="fa fa-envelope"></i></a></li>
                        </ul>
                    </div>
                    <!-- pricing table end -->

                </div>
            </div>
            <!-- pricing tables end -->

        </div>

    </div>                        
</div>

<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Setup Your Payment Source...</h4>                    
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="">                            
                        <p><div id="text"></div></p>

                        <script src="https://js.stripe.com/v3/"></script>
                        <div class="row" style="margin-top:50px; margin-bottom:50px;">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <form class="noThinker" method="post" id="payment-form" name="payment-form">
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
                                    <input type="hidden" name="type" value="" id="type">
                                </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">             
                <div class="btn-group">
                    <button name="save_premium" id="savePaymentSource" form="payment-form" type="submit" class="btn btn-default btn-xs"><i class="fa fa-credit-card"></i> Save & Start Trial Period</button>   
                    <button data-dismiss="modal" data-target="#createDataset" id="closeDataset" class="btn btn-default btn-xs"><i class="fa fa-close"></i> Cancel</button>   

                </div>
            </div>
        </div>
    </div>
</div>