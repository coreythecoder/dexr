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
                            ?><?php echo $total; ?> Registration(s) &nbsp; &nbsp; <a href="/<?php echo uri_string(); ?>/report" rel="nofollow" class="btn btn-default btn-sm">See Full List</a></h4>
                        <?php } else { ?>
                        <h4 class="mobile-center">Showing <?php echo $total; ?> of <?php
                            if ($total >= 25) {
                                echo ">";
                            }
                            ?><?php echo $total; ?> Registration(s)</h4>
                    <?php } ?>         
                </div>       
                <div class="col-md-3">
                    <a href="/<?php echo uri_string(); ?>/report" rel="nofollow" class="btn btn-default btn-block"><i class="fa fa-arrow-down"></i>&nbsp; Download Full Report</a>
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
            <img src='https://static.dexr.io/images/zapier.jpg' style='display:inline;'>
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
