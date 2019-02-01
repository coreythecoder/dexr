<div class="report">
    <div class='list-title'>
        <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
            <div class='row'>
                <div class='col-md-6 center-xs'>
                    <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-user white'></i> Report for <?php echo ucwords($report->first . ' ' . $report->last); ?> <?php if (!empty($report->street) || !empty($report->city) || !empty($report->state) || !empty($report->zip)) { ?>

                        <span><?php echo ucwords($report->street); ?></span> <?php
                            if (!empty($report->city) || !empty($report->state)) {
                                echo " in ";
                            }
                            ?><?php
                            if (!empty($report->city)) {
                                echo ucwords($report->city);
                            } if (!empty($report->state)) {
                                echo ', ' . strtoupper($report->state);
                            }
                            ?> <?php echo ucwords($report->zip); ?>

                        <?php } ?></h1>  
                </div>
                
                <div class='col-md-3 col-xs-12 center-xs' style='margin-top:23px;'>
                    <div class='text-right center-xs'><i class="fa fa-birthday-cake"></i> <?php
                        if (!empty($report->dob) && $report->dob !== 0) {
                            echo date("M d, Y", $report->dob);
                        } else {
                            echo "None";
                        }
                        ?> &nbsp; &nbsp; <i class="fa fa-phone"></i> <?php
                        if (!empty($report->phone) && $report->phone !== 0) {
                            echo formatPhoneNumber($report->phone);
                        } else {
                            echo "None";
                        }
                        ?></div>
                </div>
                <?php if ($isActive) { ?>
                    <div class='col-md-3' style='margin-top:23px;'>
                        <div class='text-center'>Support: Hi@Yoliya.com</div>
                    </div>
                <?php } ?>
            </div>
        </div>   
    </div>
    <div id="map_outer" class="animated slideInLeft hidden-xs" style="">
        <div id="map_canvas" style=""></div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 hidden-xs" style="">

            </div>
            <div class="col-md-10">
                <div class="stagerred-box" style="padding-bottom:0px;">

                    <div class="" style="height:30px;"></div>
                    <ul class="nav nav-tabs top-tabs" style="padding-left:20px;">
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-publicRecords', eventLabel: ''});" aria-controls="public-records" role="tab" data-toggle="tab" class="active col-md-2 text-center" href="#public-records"><a href="#public-records" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-book" id="number1"><span class="badge badge-success badge-menu"><?php echo $publicRecordsTotal; ?></span></i>Public Records</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-onlineProfiles', eventLabel: ''});" aria-controls="online-profiles" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#online-profiles"><a href="#online-profiles" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-share-alt" id="number2"><span class="badge badge-success badge-menu"><?php echo $onlineProfilesTotal; ?></span></i> Online Profiles</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-relationships', eventLabel: ''});" aria-controls="relationships" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#relationships"><a data-toggle="modal" data-target="#upgradeModal" href="#relationships" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-users" id="number3"><span class="badge badge-success badge-menu"><?php echo $relationshipTotal; ?></span></i> Relationships</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-criminalRecords', eventLabel: ''});" aria-controls="criminal-records" role="tab" data-toggle="tab" href="#criminal-records" class="col-md-2 text-center"><a data-toggle="modal" data-target="#upgradeModal" href="#criminal-records" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-lock" id="number4"><span class="badge badge-success badge-menu"><?php
                                        if ($report->pid == 6 || $report->pid == 7 || $report->pid == 9 || $report->pid == 10) {
                                            echo $criminalTotal;
                                        } else {
                                            ?><span class="fa fa-plus"></span><?php } ?></span></i> Criminal Records</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-contactInfo', eventLabel: ''});" aria-controls="contact-info" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#contact-info"><a data-toggle="modal" data-target="#upgradeModal" href="#contact-info" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-comments" id="number5"><span class="badge badge-success badge-menu"><?php echo $contactInfoTotal; ?></span></i> Contact Info</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-careerEducation', eventLabel: ''});" aria-controls="employer-history" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#employer-history"><a data-toggle="modal" data-target="#upgradeModal" href="#employer-history" class='noThinker'><i style="display:block; font-size:50px;" class="fa fa-building" id="number6"><span class="badge badge-success badge-menu"><?php echo $carreerTotal; ?></span></i> Career & Education</a></li>

                    </ul>  
                </div>
                <div class="col-md-12 stagerred-box">
                    <div class="inner">


                        <!-- Tab panes -->
                        <div class="tab-content">  
                            <div role="tabpanel" class="tab-pane <?php
                            if (!isset($_GET['tab'])) {
                                echo ' in';
                            }
                            ?>" id="public-records">
                                <div class="row">
                                    <div class='col-md-1 big-number-side text-center'>
                                        <?php echo $voterRecordCountByNameAddress; ?>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Voter Records Matching <?php echo $first; ?> <?php echo $last; ?> & <?php echo $fullAddress; ?></h3>
                                        </div>

                                    </div>                                
                                </div>
                                <?php echo $voterRecordListByNameAddress; ?>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <?php echo $sameAddressCount; ?>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Other People At <?php echo ucwords($fullAddress); ?>. <?php ?></h3>
                                        </div>
                                        <div class="row">
                                            <?php echo $atList; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-1 big-number-side text-center'>
                                        <?php echo $neighborCount; ?>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Neighbors On <?php echo ucwords($streetName); ?>.</h3>
                                        </div>
                                        <div class="row">
                                            <?php echo $neighborList; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade <?php
                            if (isset($_GET['tab']) && $_GET['tab'] == 'criminal') {
                                echo 'active';
                            }
                            ?> in" id="criminal-records">
                                 <?php if ($report->pid !== '6' && $report->pid !== '7' && $report->pid !== '9' && $report->pid !== '10') { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row" style="padding-left: 20px;">
                                                <div class="page-header"><h3>Nationwide Background Check (Local Level)</h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>Was <strong class="strike"><span style="color:black;">$14.99</span></strong></div>
                                                    <div class="big-number">$10</div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> All 50 States<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'criminalCheckSelect'});" href="/register?nid=<?php //echo $name['id']['S'];                     ?>&pid=3" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>                                                
                                                </div>
                                                <div class="col-md-5">
                                                    The Nationwide Background Check is a powerful, high-speed multi-state and federal search of our proprietary databases compiled from multiple sources consisting of court records, incarceration records, prison/inmate records, probation/parole/release information, arrest data, wants and warrants and/or other proprietary sources. Each search includes a 50-state sex offender screening, terrorist watch list report and our proprietary database derived from millions of historical searches.
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12">
                                            <div class="row" style="padding-left: 20px;">
                                                <div class="page-header"><h3>Federal Background Check (Local & Federal Level) </h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>Was <strong class="strike"><span style="color:black;">$19.99</span></strong></div>
                                                    <div class="big-number">$15</div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'federalCheckSelect'});" href="/register?nid=<?php //echo $name['id']['S'];                    ?>&pid=4" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                                </div>
                                                <div class="col-md-5">
                                                    The Federal Background Check is an instant federal criminal court records search of our database compiled from Federal U.S District Court Criminal Records which covers more than 89 districts in the 50 states, with a total of 94 districts including territories.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="row">
                                        <p style="padding:20px;">Since we search nationwide records by name it's likely that your search will return many matched records. We recommend cross referencing any results with possible addresses you have for the person.  We do our best to provide a match score but we cannot guarantee it's accuracy.</p>

                                        <div class='col-md-1 big-number-side text-center'>
                                            <i class="fa fa-lock"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="page-header" style="margin-top:50px;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <h3 style="display: inline;">Nationwide Criminal, Sex Offender & Terrorist Records + Wants/Warrants</h3>     
                                                    </div>
                                                    <div class="col-md-4 text-right">  
                                                        Match Score <span class="badge badge-info">Low</span> <span class="badge badge-warning">Possible</span> <span class="badge badge-danger">Likely</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                    
                                                <div class="col-md-12">       

                                                    <?php echo $criminalList; ?>

                                                </div>
                                            </div>
                                            <div class="row">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-md-1 big-number-side text-center'>
                                            <i class="fa fa-bank"></i>
                                        </div>
                                        <div class="col-md-11">
                                            <div class="page-header" style="margin-top:50px;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3 style="display: inline;">Federal Records</h3>     
                                                    </div>
                                                    <div class="col-md-6 text-right">  
                                                        Match Score <span class="badge badge-info">Low</span> <span class="badge badge-warning">Possible</span> <span class="badge badge-danger">Likely</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                    
                                                <div class="col-md-12">       

                                                    <?php echo $federalList; ?>

                                                </div>
                                            </div>
                                            <div class="row">
                                            </div>
                                        </div>
                                        </div>
                                    <?php } ?>
                                

                            </div>

                            <div role="tabpanel" class="tab-pane fade in" id="online-profiles">
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3 style="display: inline;">Profile Images</h3>                                             
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo $imageList; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Usernames</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo $usernameList; ?> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>User IDs</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <?php echo $userIdList; ?> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-share-alt-square"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Online Profiles</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>Domain</th><th>Profile Link</th><tr>
                                                        <?php echo $profileList; ?>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="relationships">
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Relationships</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <?php echo $relationshipList; ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="contact-info">
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Names / Aliases</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>First</th><th>Middle</th><th>Last</th></tr>
                                                    <?php echo $namesList; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-at"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Email Addresses</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <?php echo $emailList; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Phone History</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <?php echo $phoneList; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Address History</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>Street Address</th><th>Apt #</th><th>City</th><th>State</th><th>Zip</th><th>Country</th></tr>
                                                    <?php echo $addressList; ?>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="employer-history">
                                <div class=""></div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Employer History</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <?php echo $employerList; ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-graduation-cap"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Education</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <?php echo $educationList; ?>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="height:75px;"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>

<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModal">
    <div class="modal-dialog" style=" max-width:900px; width:95%;"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="pull-right btn btn-success" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">I Agree</span></button>
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-exclamation-circle"></i> Important!</h4>
            </div>
            <div class="modal-body">
                <div class="page-header" style="margin-top:0px; margin-bottom:0px; border-bottom: 0px solid transparent; padding-left:20px;">
                    <div class="alert alert-danger">                        
                        <p>We do our best to gather, organize & present the most valid, accurate data to our users but we can't guarantee a positive match. That being said, it's best to perform your own due diligence before coming to any conclusions about an individual. </p>       
                        <p>By viewing this report you're stating that you will not use any of this data to do anything against the law and that you will not use the data to harass or stalk an individual.  You also state that you will not use the data for hiring purposes, use the data in determining tenant eligibility or any purpose against the FCRA federal guidelines.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .label {
        font-size:18px;
    }
    p {
        margin-bottom:20px;
    }
</style>
<script>
    $('#warningModal').modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#1').hide();
    $('#2').hide();
    $('#searchAll').hide();
    $('.top-tabs i').removeClass('fa');
    $('.top-tabs i').addClass('loading');
    setTimeout(
            function ()
            {
                $('#1').show();
                $('#1').addClass('animated fadeInUp');
            }, 2000);
    setTimeout(
            function ()
            {
                $('#2').show();
                $('#2').addClass('animated fadeInUp');
            }, 3000);
    setTimeout(
            function ()
            {
                $('#public-records').addClass('active animated fadeInUp');
            }, 4000);
    setTimeout(
            function ()
            {
                $('#searchAll').show();
                $('#searchAll').addClass('animated fadeInUp');
                $('#searchAll').removeClass('animated fadeInUp');
            }, 1000);

    setTimeout(
            function ()
            {
                $('#number1').removeClass('loading');
                $('#number1').addClass('fa animated pulse');

            }, 4000);
    setTimeout(
            function ()
            {
                $('#number6').removeClass('loading');
                $('#number6').addClass('fa animated swing');

            }, 1000);
    setTimeout(
            function ()
            {
                $('#number5').removeClass('loading');
                $('#number5').addClass('fa animated wobble');

            }, 2000);
    setTimeout(
            function ()
            {
                $('#number3').removeClass('loading');
                $('#number3').addClass('fa animated tada');

            }, 5000);
    setTimeout(
            function ()
            {
                $('#number2').removeClass('loading');
                $('#number2').addClass('fa animated shake');

            }, 3000);
    setTimeout(
            function ()
            {
                $('#number4').removeClass('loading');
                $('#number4').addClass('fa animated bounce');

            }, 8000);


</script>

<?php
$locs = "";
$markers = "";
$markerNames = "";

$i = 1;
if (isset($mapAddresses) && count($mapAddresses) > 1 && !empty($mapAddresses[0])) {
    foreach ($mapAddresses as $address) {
        $coor = geocode($address, $_SERVER['HTTP_USER_AGENT']);

        $locs .= "loc" . $i . " = new L.LatLng(" . $coor['lat'] . ", " . $coor['long'] . ")," . PHP_EOL;
        if ($i > 1) {
            $markerNames .= ", loc" . $i;
        }
        $markers .= "L.marker([" . $coor['lat'] . ", " . $coor['long'] . "]).addTo(map);" . PHP_EOL;
        $i++;
    }
    ?>

    <script>
        var map = L.map('map_canvas');

        // add an OpenStreetMap tile layer
        L.tileLayer('https://{s}.tiles.mapbox.com/v3/cdshowers23.i628d3l8/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

    <?php echo "var " . $locs; ?>
        bounds = new L.LatLngBounds(loc1<?php echo $markerNames; ?>);

    <?php echo $markers; ?>

        map.fitBounds(bounds, {padding: [30, 30]});
    </script>
    <?php
} elseif (isset($mapAddresses) && !empty($mapAddresses)) {
    $coor = geocode($mapAddresses[0], $_SERVER['HTTP_USER_AGENT']);
    ?>
    <script>
        var map = L.map('map_canvas').setView([<?php echo $coor['lat']; ?>, <?php echo $coor['long']; ?>], 13);

        L.tileLayer('https://{s}.tiles.mapbox.com/v3/cdshowers23.i628d3l8/{z}/{x}/{y}.png', {
            attribution: ''
        }).addTo(map);

        L.marker([<?php echo $coor['lat']; ?>, <?php echo $coor['long']; ?>]).addTo(map);
    </script>
<?php } ?>