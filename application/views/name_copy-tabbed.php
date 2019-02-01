<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-lock white'></i> <?php echo ucwords($first . ' ' . $middle . ' ' . $last); ?> in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></h1>  
            </div>
            <div class='col-md-5 col-xs-12 hidden-xs' style='margin-top:23px;'>
                <div class='text-right center-xs'><?php echo $crumbs; ?></div>
            </div>
            <div class='col-md-5 col-xs-12 center-xs hidden-lg hidden-md hidden-sm' style=''>
                <div class='text-right center-xs'><?php echo $crumbs; ?></div>
            </div>
        </div>
    </div>   
</div>

<div class="hidden-lg hidden-md hidden-sm">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group accordion accordion-bordered" id="accordion5867">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-1">
                                Public Records <span class='badge badge-success pull-right'><?php echo $totalPublic; ?></span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse" id="accordion5867-item-1">
                        <div class="panel-body">
                            <div class="row">
                                <div class='col-md-1 big-number-side text-center'>
                                    <?php echo $voterRecordCountByNameAddress; ?>
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3>Voter Records Matching <?php echo $first; ?> <?php echo $last; ?> & <?php echo ucwords($name['fullAddress']['S']); ?></h3>
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
                                        <h3>Other People At <?php echo ucwords($name['fullAddress']['S']); ?>. <?php
                                            if (isset($name['apartment']['S'])) {
                                                echo ucwords($name['apartment']['S']);
                                            }
                                            ?></h3>
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
                                        <h3>Neighbors On <?php echo ucwords($name['streetName']['S']); ?>.</h3>
                                    </div>
                                    <div class="row">
                                        <?php echo $neighborList; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-2">
                                Criminal Records <span class='badge badge-info pull-right' style="font-weight: normal;">+ Add On</span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse " id="accordion5867-item-2">
                        <div class="panel-body">
                            <div class="col-md-12">

                                <!-- <div class="col-md-12">
                                    <div class="row">
                                        <div class="page-header"><h3>Statewide Background Check (<?php echo strtoupper($name['state']['S']); ?>)</h3></div>
                                        <div class="col-md-4 text-center">
                                            <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;"><?php echo getStateFromJson(strtoupper($name['state']['S'])); ?></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div>Was <strong class="strike"><span style="color:black;">$9.99</span></strong></div>
                                            <div class="big-number">$4.99</div>
                                            <i class="fa fa-check green"></i> Instant Results<br>
                                            <i class="fa fa-check green"></i> All 67 Counties In Florida<br>
                                            <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                            <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'stateCheckSelect'});" href="/register?state=fl&nid=<?php echo $name['id']['S']; ?>&pid=2" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                        </div>
                                        <div class="col-md-5">
                                            <p>The Local Background Check is an affordable & quick way to check a persona criminal history at the state level.  This check is currently only available in Florida.  We'll query our large database of Florida offenders & return any matching records from the Florida Department of Corrections.</p>
                                            <p>This database includes currently incarcerated, released & parolees. 
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="page-header"><h3>Nationwide Background Check (Local Level) </h3></div>
                                        <div class="col-md-4 text-center">
                                            <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="numberBox">
                                                <div class='big-number' id="price2-name">                                               
                                                    $10
                                                </div>
                                                <div class='big-number' id="price2-2-name">                                                
                                                    $15
                                                </div>
                                            </div>
                                            <i class="fa fa-check green"></i> Instant Results<br>
                                            <i class="fa fa-check green"></i> All 50 States<br>
                                            <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>                                                   

                                            <a href="/reports" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade This Report</a>
                                        </div>
                                        <div class="col-md-5">
                                            The Nationwide Background Check is a powerful, high-speed multi-state and federal search of our proprietary databases compiled from multiple sources consisting of court records, incarceration records, prison/inmate records, probation/parole/release information, arrest data, wants and warrants and/or other proprietary sources. Each search includes a 50-state sex offender screening, terrorist watch list report and our proprietary database derived from millions of historical searches.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="page-header"><h3>Federal Background Check (Local & Federal Level) </h3></div>
                                        <div class="col-md-4 text-center">
                                            <span class="stateface stateface-replace" style="font-size:140px; color:#5dc3de;"><i class="fa fa-bank"></i></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="numberBox">
                                                <div class='big-number' id="price3-name">                                               
                                                    $15
                                                </div>
                                                <div class='big-number' id="price3-2-name">                                                
                                                    $20
                                                </div>
                                            </div>
                                            <i class="fa fa-check green"></i> Instant Results<br>
                                            <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                            <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                            <a href="/reports" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade This Report</a>
                                        </div>
                                        <div class="col-md-5">
                                            The Federal Background Check is an instant federal criminal court records search of our database compiled from Federal U.S District Court Criminal Records which covers more than 89 districts in the 50 states, with a total of 94 districts including territories.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-3">
                                Contact Information <span class='badge badge-info pull-right' style="font-weight: normal;">+ Add On</span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse " id="accordion5867-item-3">
                        <div class="panel-body">

                            <div class="row">
                                <div class='col-md-1 big-number-side text-center'>
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3>Names / Aliases</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's a data sample.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <tr><th>First</th><th>Middle</th><th>Last</th><th>Valid Since</th></tr>
                                                <tr class="blur"><td>Corey</td><td>Don</td><td>Showers</td><td>12/1/1998</td></tr>
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
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's some sample data.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class=""><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class=""><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class=""><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
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
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's some sample data.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <li class="list-group-item bold blur">972-555-5555 <div class="pull-right"></div></li>
                                                <li class="list-group-item bold blur">386-555-5666 <div class="pull-right"></div></li>
                                                <li class="list-group-item bold blur">386-555-5666 <div class="pull-right"></div></li>
                                                <li class="list-group-item bold blur">386-555-5666 <div class="pull-right"></div></li>
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
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's some sample data.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-responsive">
                                                <tr><th>Street Address</th><th>Apt #</th><th>City</th><th>State</th><th>Zip</th><th>Last Valid</th></tr>
                                                <tr class="blur"><td>2103 SW 75th Terrace</td><td></td><td>Gainesville</td><td>FL</td><td>32607</td><td>11/22/2016</td></tr>
                                                <tr class="blur"><td>9819 Glengreen St.</td><td></td><td>Dallas</td><td>TX</td><td>75081</td><td>8/22/2010</td></tr>
                                                <tr class="blur"><td>98 Rowlett Rd.</td><td></td><td>Rowlett</td><td>TX</td><td>75086</td><td>11/2/2001</td></tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-4">
                                Family & Relationships <span class='badge badge-info pull-right' style="font-weight: normal;">+ Add On</span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse " id="accordion5867-item-4">
                        <div class="panel-body">

                            <div class="row">
                                <div class='col-md-1 big-number-side text-center'>
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3>Relationships</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Here's some sample data.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Vicki Showers (Mother)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Deanna Showers (Sister)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Shawna Pollard (Other)</span> &nbsp; <i class="fa fa-exclamation-triangle" style="color:red;"></i><div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Bill Reynolds (Grandfather)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-5">
                                Online Profiles <span class='badge badge-info pull-right' style="font-weight: normal;">+ Add On</span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse " id="accordion5867-item-5">
                        <div class="panel-body">

                            <div class="row">

                                <div class='col-md-1 big-number-side text-center'>
                                    <i class="fa fa-image"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3 style="display: inline;">Profile Images</h3>                                             
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Here's some sample data.</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/11.jpg" class="img-circle blur big-circle-img">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/12.jpg" class="img-circle blur big-circle-img">
                                        </div>
                                        <div class="col-md-4 text-center">
                                            <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/13.jpg" class="img-circle blur big-circle-img">
                                        </div>
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
                                            <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-center">
                                            <div class="label label-info big-username blur">SampleUsername</div>
                                        </div>   
                                        <div class="col-md-4 text-center">
                                            <div class="label label-info blur">SampleUsername2</div>
                                        </div>   
                                        <div class="col-md-4 text-center">
                                            <div class="label label-info blur">AnotherSampleUsername</div>
                                        </div>   
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
                                            <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                        </div>
                                        <div class="col-md-12">
                                            <p>Here's some sample data.</p>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">
                                            <table class="table table-striped">
                                                <tr><th>Image</th><th>Provider</th><th>Profile Link</th><tr>
                                                <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/13.jpg" class="img-circle table-img blur"></td><td class="vert-align">Facebook.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.facebook.com/people/100001489843289</a></td></tr>
                                                <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/14.jpg" class="img-circle table-img blur"></td><td class="vert-align">Twitter.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.twitter.com/people/100001489843289</a></td></tr>
                                                <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/15.jpg" class="img-circle table-img blur"></td><td class="vert-align">Instagram.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.instagram.com/people/100001489843289</a></td></tr>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a class="accordion-toggle collapsed" data-parent="#accordion5867" data-toggle="collapse" href="#accordion5867-item-6">
                                Career & Education <span class='badge badge-info pull-right' style="font-weight: normal;">+ Add On</span>
                            </a>
                        </h4>
                    </div>
                    <div class="panel-collapse collapse " id="accordion5867-item-6">
                        <div class="panel-body">

                            <div class=""></div>
                            <div class="row">                                    
                                <div class='col-md-1 big-number-side text-center'>
                                    <i class="fa fa-building-o"></i>
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3>Employer History</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's some sample data.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Vicki Showers (Mother)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Deanna Showers (Sister)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Shawna Pollard (Other) &nbsp; <i class="fa fa-exclamation-triangle" style="color:red;"></i></span><div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Bill Reynolds (Grandfather)</span> <div class=""><button class="btn btn-success btn-xs">View Records</button></div></li></a>

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
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members.<br><br> <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" href="/register" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            Here's some sample data.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="list-group">
                                                <li class="list-group-item bold blur">Farmersville High School<br> <div class="">Class of 2002</div></li>
                                                <li class="list-group-item bold blur">Computer Learning Center<br> <div class="">2003-2005</div></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div style='height:100px;'></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="">                
                    <div class="col-xs-12">
                        <div class="page-heade" style="margin-bottom:5px;">
                            <div class='text-center' style='font-size:10px;'>Advertisement</div>
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- yoliya - site wide -->
                            <ins class="adsbygoogle"
                                 style="display:block"
                                 data-ad-client="ca-pub-2063867378055756"
                                 data-ad-slot="4370605300"
                                 data-ad-format="auto"></ins>
                            <script>
                                            (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                        </div>                    
                    </div>                                
                </div>
            </div>
        </div>
    </div>
</div>

<div id="map_outer" class="animated slideInLeft hidden-xs">
    <div id="map_canvas"></div>
</div>

<div class="container-fluid hidden-xs">
    <div class="row">
        <div class="col-md-2 hidden-xs" style="">

        </div>
        <div class="col-md-10">
            <div class="page-header" id="1" style="margin-top:0px; border-bottom: 0px solid transparent;">
                <div class='row'>
                    <div class='col-md-12 stagerred-box' style="padding-left:20px;">
                        <div class='inner blue-background'>
                            <div class='row '>
                                <div class='col-md-8 col-xs-12 center-xs'>
                                    <h4>
                                        <i class="fa fa-map-marker"></i> <span><?php echo ucwords($name['fullAddress']['S']); ?>. <?php
                                            if (isset($name['apt']['S'])) {
                                                echo ucwords($name['apt']['S']);
                                            }
                                            ?></span>
                                        <?php echo ucwords($name['city']['S']); ?>, <?php echo strtoupper($name['state']['S']); ?> <?php echo $name['zip']['S']; ?></h4>
                                </div>                        
                                <div class='col-md-4 col-xs-12 text-right center-xs'>
                                    <h4><i class="fa fa-birthday-cake" style=''></i>
                                        <?php
                                        if ($age > 17) {
                                            echo 'Born ' . date('Y', $name['dob']['S']);
                                        }
                                        ?></h4>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-heade" id="1" style="margin-top:10px; margin-bottom:0px; padding-bottom:0px; border-bottom: 0px solid transparent;"> 

                    <ul class="nav nav-tabs top-tabs" style="padding-left:20px; border-bottom:0px;">
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-publicRecords', eventLabel: ''});" aria-controls="public-records" role="tab" data-toggle="tab" class="active col-md-2 text-center tab" href="#public-records"><a href="#public-records"><i style="display:block; font-size:50px;" class="" id="number1"><span class='badge badge-success badge-absolute'><?php echo $totalPublic; ?></span></i>Public Records</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-onlineProfiles', eventLabel: ''});" aria-controls="online-profiles" role="tab" data-toggle="tab" class="col-md-2 text-center tab" href="#online-profiles"><a href="#online-profiles"><i style="display:block; font-size:50px;" class="" id="number2"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i> Online Profiles</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-relationships', eventLabel: ''});" aria-controls="relationships" role="tab" data-toggle="tab" class="col-md-2 text-center tab" href="#relationships"><a href="#relationships"><i style="display:block; font-size:50px;" class="" id="number3"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i> Relationships</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-criminalRecords', eventLabel: ''});" aria-controls="criminal-records" role="tab" data-toggle="tab" href="#criminal-records" class="col-md-2 text-center"><a href="#criminal-records"><i style="display:block; font-size:50px;" class="" id="number4"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i> Criminal Records</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-contactInfo', eventLabel: ''});" aria-controls="contact-info" role="tab" data-toggle="tab" class="col-md-2 text-center tab" href="#contact-info"><a href="#contact-info"><i style="display:block; font-size:50px;" class="" id="number5"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i> Contact Info</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-careerEducation', eventLabel: ''});" aria-controls="employer-history" role="tab" data-toggle="tab" class="col-md-2 text-center tab" href="#employer-history"><a href="#employer-history"><i style="display:block; font-size:50px;" class="" id="number6"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i> Career & Education</a></li>
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
                                            <h3>Voter Records Matching <?php echo $first; ?> <?php echo $last; ?> & <?php echo ucwords($name['fullAddress']['S']); ?></h3>
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
                                            <h3>Other People At <?php echo ucwords($name['fullAddress']['S']); ?>. <?php
                                                if (isset($name['apartment']['S'])) {
                                                    echo ucwords($name['apartment']['S']);
                                                }
                                                ?></h3>
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
                                            <h3>Neighbors On <?php echo ucwords($name['streetName']['S']); ?>.</h3>
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
                                <div class="row">
                                    <div class="col-md-12">

                                        <!-- <div class="col-md-12">
                                            <div class="row">
                                                <div class="page-header"><h3>Statewide Background Check (<?php echo strtoupper($name['state']['S']); ?>)</h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;"><?php echo getStateFromJson(strtoupper($name['state']['S'])); ?></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>Was <strong class="strike"><span style="color:black;">$9.99</span></strong></div>
                                                    <div class="big-number">$4.99</div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> All 67 Counties In Florida<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a rel="nofollow" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'stateCheckSelect'});" href="/register?state=fl&nid=<?php echo $name['id']['S']; ?>&pid=2" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                                </div>
                                                <div class="col-md-5">
                                                    <p>The Local Background Check is an affordable & quick way to check a persona criminal history at the state level.  This check is currently only available in Florida.  We'll query our large database of Florida offenders & return any matching records from the Florida Department of Corrections.</p>
                                                    <p>This database includes currently incarcerated, released & parolees. 
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="page-header"><h3>Nationwide Background Check (Local Level) </h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="numberBox">
                                                        <div class='big-number' id="price2-name">                                               
                                                            $10
                                                        </div>
                                                        <div class='big-number' id="price2-2-name">                                                
                                                            $15
                                                        </div>
                                                    </div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> All 50 States<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>                                                   

                                                    <a href="/reports" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade This Report</a>
                                                </div>
                                                <div class="col-md-5">
                                                    The Nationwide Background Check is a powerful, high-speed multi-state and federal search of our proprietary databases compiled from multiple sources consisting of court records, incarceration records, prison/inmate records, probation/parole/release information, arrest data, wants and warrants and/or other proprietary sources. Each search includes a 50-state sex offender screening, terrorist watch list report and our proprietary database derived from millions of historical searches.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="page-header"><h3>Federal Background Check (Local & Federal Level) </h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:140px; color:#5dc3de;"><i class="fa fa-bank"></i></span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="numberBox">
                                                        <div class='big-number' id="price3-name">                                               
                                                            $15
                                                        </div>
                                                        <div class='big-number' id="price3-2-name">                                                
                                                            $20
                                                        </div>
                                                    </div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a href="/reports" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade This Report</a>
                                                </div>
                                                <div class="col-md-5">
                                                    The Federal Background Check is an instant federal criminal court records search of our database compiled from Federal U.S District Court Criminal Records which covers more than 89 districts in the 50 states, with a total of 94 districts including territories.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div role="tabpanel" class="tab-pane fade in" id="online-profiles">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members. &nbsp; <a href="/register" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-image"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3 style="display: inline;">Profile Images</h3>                                             
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>This report is only available to upgraded members. Here's some sample data.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/11.jpg" class="img-circle blur big-circle-img">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/12.jpg" class="img-circle blur big-circle-img">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/13.jpg" class="img-circle blur big-circle-img">
                                            </div>
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
                                                <p>This report is only available to upgraded members. Here's some sample data.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <div class="label label-info big-username blur">SampleUsername</div>
                                            </div>   
                                            <div class="col-md-4 text-center">
                                                <div class="label label-info blur">SampleUsername2</div>
                                            </div>   
                                            <div class="col-md-4 text-center">
                                                <div class="label label-info blur">AnotherSampleUsername</div>
                                            </div>   
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
                                                <p>This report is only available to upgraded members. Here's some sample data.</p>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>Image</th><th>Provider</th><th>Profile Link</th><tr>
                                                    <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/13.jpg" class="img-circle table-img blur"></td><td class="vert-align">Facebook.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.facebook.com/people/100001489843289</a></td></tr>
                                                    <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/14.jpg" class="img-circle table-img blur"></td><td class="vert-align">Twitter.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.twitter.com/people/100001489843289</a></td></tr>
                                                    <tr><td><img src="https://randomuser.me/api/portraits/<?php echo $imageGender; ?>/15.jpg" class="img-circle table-img blur"></td><td class="vert-align">Instagram.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.instagram.com/people/100001489843289</a></td></tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="relationships">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members. &nbsp; <a href="/register" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Relationships</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p>This report is only available to upgraded members. Here's a data sample.</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Vicki Showers (Mother)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Deanna Showers (Sister)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Shawna Pollard (Other)</span> &nbsp; <i class="fa fa-exclamation-triangle" style="color:red;"></i><div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Bill Reynolds (Grandfather)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="contact-info">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members. &nbsp; <a href="/register" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Names / Aliases</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>First</th><th>Middle</th><th>Last</th><th>Valid Since</th></tr>
                                                    <tr class="blur"><td>Corey</td><td>Don</td><td>Showers</td><td>12/1/1998</td></tr>
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
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class="pull-right"><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class="pull-right"><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">cdshowers23@aol.com</span> <div class="pull-right"><button class="btn btn-success btn-xs">Send Message</button></div></li></a>
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
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <li class="list-group-item bold blur">972-555-5555 <div class="pull-right"></div></li>
                                                    <li class="list-group-item bold blur">386-555-5666 <div class="pull-right"></div></li>

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
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <tr><th>Street Address</th><th>Apt #</th><th>City</th><th>State</th><th>Zip</th><th>Last Valid</th></tr>
                                                    <tr class="blur"><td>2103 SW 75th Terrace</td><td></td><td>Gainesville</td><td>FL</td><td>32607</td><td>11/22/2016</td></tr>
                                                    <tr class="blur"><td>9819 Glengreen St.</td><td></td><td>Dallas</td><td>TX</td><td>75081</td><td>8/22/2010</td></tr>
                                                    <tr class="blur"><td>98 Rowlett Rd.</td><td></td><td>Rowlett</td><td>TX</td><td>75086</td><td>11/2/2001</td></tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="employer-history">
                                <div class=""></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included for upgraded members. &nbsp; <a href="/register" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" class="btn btn-success btn-xs"><i class="fa fa-arrow-right"></i> Upgrade for Just $1</a></div>
                                    </div>
                                    <div class='col-md-1 big-number-side text-center'>
                                        <i class="fa fa-building-o"></i>
                                    </div>
                                    <div class="col-md-11">
                                        <div class="page-header" style="margin-top:50px;">
                                            <h3>Employer History</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Vicki Showers (Mother)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Deanna Showers (Sister)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Shawna Pollard (Other) &nbsp; <i class="fa fa-exclamation-triangle" style="color:red;"></i></span><div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>
                                                    <a href="#" class="disabled-cursor"><li class="list-group-item bold"><span class="blur">Bill Reynolds (Grandfather)</span> <div class="pull-right"><button class="btn btn-success btn-xs">View Records</button></div></li></a>

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
                                                This report is only available to upgraded members. Here's a data sample.
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <ul class="list-group">
                                                    <li class="list-group-item bold blur">Farmersville High School <div class="pull-right">Class of 2002</div></li>
                                                    <li class="list-group-item bold blur">Computer Learning Center <div class="pull-right">2003-2005</div></li>

                                                </ul>
                                            </div>
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

<style>
    ul.mobile li {
        font-size: 10px;
        margin-top:4px;
        list-style: none;
        height:16.6%;
    }
</style>



<style>
    .label {
        font-size:18px;
    }
    p {
        margin-bottom:20px;
    }
</style>
<script>
    $('a').click(function () {
        $('html, body').animate({
            scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
        }, 800);
        return false;
    });
    //$('#map_outer').animate({width: "100%"}, 0);
    //$('.searching').modal('show');

    //$('#1').hide();
    //$('#2').hide();
    $('#searchAll').hide();
    $('.top-tabs i').addClass('loading');
    setTimeout(
            function ()
            {
                //$('#1').show();
                //$('#1').addClass('animated fadeInUp');
            }, 9000);
    setTimeout(
            function ()
            {
                //$('#2').show();
                //$('#2').addClass('animated fadeInUp');
            }, 10500);
    setTimeout(
            function ()
            {
                $('#public-records').addClass('active animated fadeInUp');
            }, 3000);
    setTimeout(
            function ()
            {
                $('#searchAll').show();
                $('#searchAll').addClass('animated fadeInUp');
                $('#searchAll').removeClass('animated fadeInUp');
            }, 14500);

    setTimeout(
            function ()
            {
                $('#number1').removeClass('loading');
                $('#number1').addClass('fa fa-book animated swing');

            }, 2500);
    setTimeout(
            function ()
            {
                $('#number6').removeClass('loading');
                $('#number6').addClass('fa fa-building animated swing');

            }, 4000);
    setTimeout(
            function ()
            {
                $('#number5').removeClass('loading');
                $('#number5').addClass('fa fa-comments animated wobble');

            }, 4300);
    setTimeout(
            function ()
            {
                $('#number3').removeClass('loading');
                $('#number3').addClass('fa fa-users animated tada');

            }, 5000);
    setTimeout(
            function ()
            {
                $('#number2').removeClass('loading');
                $('#number2').addClass('fa fa-share-alt animated shake');

            }, 5500);
    setTimeout(
            function ()
            {
                $('#number4').removeClass('loading');
                $('#number4').addClass('fa fa-lock animated bounce');

            }, 6000);


    setTimeout(
            function ()
            {
                $('#number1-2').removeClass('loading');
                $('#number1-2').addClass('fa fa-book animated swing');

            }, 2500);
    setTimeout(
            function ()
            {
                $('#number6-2').removeClass('loading');
                $('#number6-2').addClass('fa fa-building animated swing');

            }, 4000);
    setTimeout(
            function ()
            {
                $('#number5-2').removeClass('loading');
                $('#number5-2').addClass('fa fa-comments animated wobble');

            }, 4300);
    setTimeout(
            function ()
            {
                $('#number3-2').removeClass('loading');
                $('#number3-2').addClass('fa fa-users animated tada');

            }, 5000);
    setTimeout(
            function ()
            {
                $('#number2-2').removeClass('loading');
                $('#number2-2').addClass('fa fa-share-alt animated shake');

            }, 5500);
    setTimeout(
            function ()
            {
                $('#number4-2').removeClass('loading');
                $('#number4-2').addClass('fa fa-lock animated bounce');

            }, 6000);



    var progress = setInterval(function () {
        var $bar = $('.main-progress-bar');
        var width = (100 * parseFloat($('.main-progress-bar').css('width')) / parseFloat($('.main-progress-bar').parent().css('width')));

        if (width >= 100) {
            clearInterval(progress);
            $('.main-progress').removeClass('active');
        } else {
            $bar.width(width + 2.5 + '%');
        }
    }, 100);

    // public
    var publicProgress = setInterval(function () {
        var $publicbar = $('.progress-bar-public');
        var width = (100 * parseFloat($('.progress-bar-public').css('width')) / parseFloat($('.progress-bar-public').parent().css('width')));

        if (width >= 100) {
            clearInterval(publicProgress);
            $('.public-progress').removeClass('active');
        } else {
            $publicbar.width(width + 30 + '%');
        }
    }, 100);

    // online profiles
    var onlineProgress = setInterval(function () {
        var $onlinebar = $('.progress-bar-online');
        var width = (100 * parseFloat($('.progress-bar-online').css('width')) / parseFloat($('.progress-bar-online').parent().css('width')));

        if (width >= 100) {
            clearInterval(onlineProgress);
            $('.online-progress').removeClass('active');
        } else {
            $onlinebar.width(width + 8 + '%');
        }
    }, 100);

    // relationships
    var relationshipsProgress = setInterval(function () {
        var $relationshipsbar = $('.progress-bar-relationships');
        var width = (100 * parseFloat($('.progress-bar-relationships').css('width')) / parseFloat($('.progress-bar-relationships').parent().css('width')));

        if (width >= 100) {
            clearInterval(relationshipsProgress);
            $('.relationships-progress').removeClass('active');
        } else {
            $relationshipsbar.width(width + 5 + '%');
        }
    }, 100);

    // criminal
    var criminalProgress = setInterval(function () {
        var $criminalbar = $('.progress-bar-criminal');
        var width = (100 * parseFloat($('.progress-bar-criminal').css('width')) / parseFloat($('.progress-bar-criminal').parent().css('width')));

        if (width >= 100) {
            clearInterval(criminalProgress);
            $('.criminal-progress').removeClass('active');
        } else {
            $criminalbar.width(width + 16 + '%');
        }
    }, 100);

    // phone
    var phoneProgress = setInterval(function () {
        var $phonebar = $('.progress-bar-phone');
        var width = (100 * parseFloat($('.progress-bar-phone').css('width')) / parseFloat($('.progress-bar-phone').parent().css('width')));

        if (width >= 100) {
            clearInterval(phoneProgress);
            $('.phone-progress').removeClass('active');
        } else {
            $phonebar.width(width + 3.5 + '%');
        }
    }, 100);

    // career
    var careerProgress = setInterval(function () {
        var $careerbar = $('.progress-bar-career');
        var width = (100 * parseFloat($('.progress-bar-career').css('width')) / parseFloat($('.progress-bar-career').parent().css('width')));

        if (width >= 100) {
            clearInterval(careerProgress);
            $('.career-progress').removeClass('active');
        } else {
            $careerbar.width(width + 5 + '%');
        }
    }, 100);

    setTimeout(
            function ()
            {
                $('.voter-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.voter').css('font-weight', 'bold');
            }, 2500);
    setTimeout(
            function ()
            {
                $('.criminal-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.criminal').css('font-weight', 'bold');
            }, 4000);
    setTimeout(
            function ()
            {
                $('.domain-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.domain').css('font-weight', 'bold');
            }, 18500);
    setTimeout(
            function ()
            {
                $('.social-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.social').css('font-weight', 'bold');
            }, 6500);
    setTimeout(
            function ()
            {
                $('.business-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.business').css('font-weight', 'bold');
            }, 10000);
    setTimeout(
            function ()
            {
                $('.dmv-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.dmv').css('font-weight', 'bold');
            }, 11000);
    setTimeout(
            function ()
            {
                $('.licenses-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.licenses').css('font-weight', 'bold');
            }, 15000);

    setTimeout(
            function ()
            {
                $('.loader').replaceWith('<div class="animated fadeInUp"><i class="fa fa-check-circle-o green fa-5x"></i></div>');
            }, 17500);

    //$('.warning').delay(10000).fadeIn();

    setTimeout(
            function ()
            {
                $('#map_outer').animate({width: "17.3%"}, 1000);
            }, 4000);

    setTimeout(
            function ()
            {
                $('.searching').modal('hide');
                $('.report').removeClass('blur');
                ga('send', 'event', {eventCategory: 'load', eventAction: 'basicNameReportLoaded'});
            }, 20000);

    setTimeout(
            function ()
            {
                map._onResize();
            }, 8000);

</script>
