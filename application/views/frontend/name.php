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
                Make Your Choice
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

        </div>
    </div>
</div>