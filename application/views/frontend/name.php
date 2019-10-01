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
                        <span class="col-title" style="font-size:.5em;display:block;">Webmaster</span>
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
                    <?php if (isset($allDomains) && !empty($allDomains)) { ?>
                        <div>
                            <div class="col-title">Linked Registrations</div><?php echo ucwords($allDomains); ?>
                        </div>
                    <?php } ?>
                </div>       
                <div class="col-md-3 text-center"><br><br>
                    <a href="/<?php echo uri_string(); ?>/report" rel="nofollow" class="btn btn-default btn-block animated shake"><i class="fa fa-arrow-down"></i>&nbsp; Download Full WHOIS Report</a><small>Complete reports contain full contact details & all linked registrations.</small>
                </div>
            </div>

            <div class="separator"></div>

            <div class="row">
                <div class="col-md-12 other-text">
                    <h4 class="mobile-center">About <?php echo ucwords(strtolower($name)); ?> in <?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></h4>
                    <div class="row" style="margin:20px 0px 20px 20px;">

                        <?php echo $paragraph; ?>  

                    </div>
                </div>                
            </div>
            

            <?php if (!empty($nearbyCities)) { ?>
                <div class="row">
                    <div class="col-md-12 other-text">
                        <h4 class="mobile-center"><?php echo ucwords(strtolower($name)); ?> Also Found In</h4>
                        <div class="row" style="margin:20px 0px 20px 20px;">

                            <?php echo $nearbyCities; ?>  

                        </div>
                    </div>                
                </div>
                <div class="separator"></div>
            <?php } ?>

            <div class="row" style="margin-bottom:90px;">
                <div class="col-md-12 other-text">
                    <h4 class="mobile-center">Our Database Contains</h4>
                    <div class="row">
                        <?php echo $contains_emails . $contains_cities . $contains_phones . $contains_addresses; ?>                        
                    </div>
                </div>                
            </div>
            


            <?php echo $domains; ?>

            <?php if (!empty($sameCityNames)) { ?>
                <div class="row">
                    <div class="col-md-12 other-text">
                        <h4 class="mobile-center">Other Records in <?php echo $city; ?>, <?php echo $state; ?></h4>
                        <div class="row" style="margin:20px 0px 20px 20px;">

                            <?php echo $sameCityNames; ?>  

                        </div>
                    </div>                
                </div>
                <div class="separator"></div>
            <?php } ?>

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




