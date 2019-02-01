<div class="report">
    <div id="map_outer" class="animated slideInLeft hidden-xs">
        <div id="map_canvas"></div>
    </div>
    <?php
    $state = strtoupper(strip_tags($_GET['state']));
    $city = ucwords(strtolower(strip_tags($_GET['city'])));
    $first = ucwords(strtolower(strip_tags($_GET['fname'])));
    $last = ucwords(strtolower(strip_tags($_GET['lname'])));
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 hidden-xs" style="">

            </div>
            <div class="col-md-10">
                <div class="page-header" id="1" style="margin-top:50px; border-bottom: 0px solid transparent;">                
                    <div class='row'>
                        <div class='col-md-8'>
                            <h4 style="color:#ddd; margin-bottom:-15px;">All Public Records for:</h4>
                            <h1><?php echo ucwords($first . ' ' . $last); ?> in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></h1>
                            <h4>
                                <i class="fa fa-map-marker"></i> <span class="blur">123 Main St.</span> <?php echo $city . ', ' . $state; ?>
                                <p><?php //echo $crumbs;  ?></p>                            
                        </div>
                        <div class='col-md-4 text-center' style='position:relative; top:30px;'>
                            <h4 style='position:relative; '><i class="fa fa-birthday-cake" style='position:relative;'></i>
                                <span class="blur">January 01, 1965</span></h4>
                            <h4><i class='fa fa-phone'></i> 
                                <span class="blur">972-555-5632</span>
                            </h4>

                            <div class="hidden-md hidden-lg hidden-sm" style="height:50px;"></div>
                        </div>
                    </div>
                    <div class="" style="height:30px;"></div>
                    <ul class="nav nav-tabs top-tabs">
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-onlineProfiles', eventLabel: ''});" aria-controls="online-profiles" role="tab" data-toggle="tab" class="col-md-2 text-center active" href="#online-profiles"><a href="#online-profiles"><i style="display:block; font-size:50px;" class="fa fa-share-alt" id="number2"></i> Online Profiles</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-relationships', eventLabel: ''});" aria-controls="relationships" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#relationships"><a data-toggle="modal" data-target="#upgradeModal" href="#relationships"><i style="display:block; font-size:50px;" class="fa fa-users" id="number3"></i> Relationships</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-criminalRecords', eventLabel: ''});" aria-controls="criminal-records" role="tab" data-toggle="tab" href="#criminal-records" class="col-md-2 text-center"><a data-toggle="modal" data-target="#upgradeModal" href="#criminal-records"><i style="display:block; font-size:50px;" class="fa fa-lock" id="number4"></i> Criminal Records</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-contactInfo', eventLabel: ''});" aria-controls="contact-info" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#contact-info"><a data-toggle="modal" data-target="#upgradeModal" href="#contact-info"><i style="display:block; font-size:50px;" class="fa fa-comments" id="number5"></i> Contact Info</a></li>
                        <li role="presentation" onClick="ga('send', 'event', {eventCategory: 'tabClicks', eventAction: 'reportTab-careerEducation', eventLabel: ''});" aria-controls="employer-history" role="tab" data-toggle="tab" class="col-md-2 text-center" href="#employer-history"><a data-toggle="modal" data-target="#upgradeModal" href="#employer-history"><i style="display:block; font-size:50px;" class="fa fa-building" id="number6"></i> Career & Education</a></li>

                    </ul>  
                </div>
                <div class="col-md-12">
                    <div>


                        <!-- Tab panes -->
                        <div class="tab-content">                            
                            <div role="tabpanel" class="tab-pane fade <?php
    if (isset($_GET['tab']) && $_GET['tab'] == 'criminal') {
        echo 'active';
    }
    ?> in" id="criminal-records">

                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="page-header"><h3>Nationwide Background Check (Local Level) <span class="pull-right"><i class="fa fa-check green"></i> FCRA Compliant <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-question-circle"></i></a></span></h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>Was <strong class="strike"><span style="color:black;">$14.99</span></strong></div>
                                                    <div class="big-number">$9.99</div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> All 50 States<br>
                                                    <i class="fa fa-check green"></i> FCRA Compliant<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'criminalCheckSelect'});" href="/register?nid=<?php //echo $name['id']['S'];  ?>&pid=3" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>                                                
                                                </div>
                                                <div class="col-md-5">
                                                    The Nationwide Background Check is a powerful, high-speed multi-state and federal search of our proprietary databases compiled from multiple sources consisting of court records, incarceration records, prison/inmate records, probation/parole/release information, arrest data, wants and warrants and/or other proprietary sources. Each search includes a 50-state sex offender screening, terrorist watch list report and our proprietary database derived from millions of historical searches.
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="page-header"><h3>Federal Background Check (Local & Federal Level) <span class="pull-right"><i class="fa fa-check green"></i> FCRA Compliant <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-question-circle"></i></a></span></h3></div>
                                                <div class="col-md-4 text-center">
                                                    <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <div>Was <strong class="strike"><span style="color:black;">$19.99</span></strong></div>
                                                    <div class="big-number">$14.99</div>
                                                    <i class="fa fa-check green"></i> Instant Results<br>
                                                    <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                                    <i class="fa fa-check green"></i> FCRA Compliant<br>
                                                    <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'federalCheckSelect'});" href="/register?nid=<?php //echo $name['id']['S'];  ?>&pid=4" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
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
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included in upgraded reports. &nbsp; <button onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-onlineProfiles', eventLabel: ''});" data-toggle="modal" data-target="#upgradeModal" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Upgrade This Report</button></div>
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
                                                <img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/11.jpg" class="img-circle blur big-circle-img">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/12.jpg" class="img-circle blur big-circle-img">
                                            </div>
                                            <div class="col-md-4 text-center">
                                                <img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/13.jpg" class="img-circle blur big-circle-img">
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
                                                    <tr><td><img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/13.jpg" class="img-circle table-img blur"></td><td class="vert-align">Facebook.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.facebook.com/people/100001489843289</a></td></tr>
                                                    <tr><td><img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/14.jpg" class="img-circle table-img blur"></td><td class="vert-align">Twitter.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.twitter.com/people/100001489843289</a></td></tr>
                                                    <tr><td><img src="https://randomuser.me/api/portraits/women<?php //echo $imageGender;  ?>/15.jpg" class="img-circle table-img blur"></td><td class="vert-align">Instagram.com</td><td class="vert-align"><a href="#" rel="nofollow" class="blur disabled-cursor">http://www.instagram.com/people/100001489843289</a></td></tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="relationships">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included in upgraded reports. &nbsp; <button onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-relationships', eventLabel: ''});" data-toggle="modal" data-target="#upgradeModal" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Upgrade This Report</button></div>
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
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included in upgraded reports. &nbsp; <button data-toggle="modal" onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-contactInfo', eventLabel: ''});" data-target="#upgradeModal" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Upgrade This Report</button></div>
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
                                        <div class="alert alert-info animated shake"><i class="fa fa-exclamation-triangle"></i> This data is only included in upgraded reports. &nbsp; <button onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'upgrade-employerHistory', eventLabel: ''});" data-toggle="modal" data-target="#upgradeModal" class="btn btn-success btn-xs"><i class="fa fa-arrow-up"></i> Upgrade This Report</button></div>
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
    <!-- Modal -->
    <div class="modal fade searching" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class='row'>
                        <div class='col-md-8'>
                            <h4 style="color:#ddd; margin-bottom:-15px;">Searching 13 Billion~ Public Records for:</h4>
                            <h1><?php echo ucwords($first . ' ' . $last); ?><div style="font-size:.7em; color:#D0d0d0;">in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></div></h1>
                        </div>
                        <div class='col-md-4 text-center' style='position:relative; top:30px;'>
                            <h4 style='position:relative; '><i class="fa fa-birthday-cake" style='position:relative;'></i>
                                Unknown
                        </div>
                    </div> 
                </div>
                <div class="modal-body">                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="voter"><img class="voter-img" src="/assets/images/loading2.gif" height="20"> Public Records</div>
                            <div class="social"><img class="social-img" src="/assets/images/loading2.gif" height="20"> Online Profiles</div>
                            <div class="business"><img class="business-img" src="/assets/images/loading2.gif" height="20"> Relationships</div>
                            <div class="criminal"><img class="criminal-img" src="/assets/images/loading2.gif" height="20"> Criminal Records</div>
                            <div class="licenses"><img class="licenses-img" src="/assets/images/loading2.gif" height="20"> Phone & Address History</div>
                            <div class="dmv"><img class="dmv-img" src="/assets/images/loading2.gif" height="20"> Current & Past Employers</div>

                        </div>
                        <div class="hidden-lg hidden-md hidden-sm" style="height:20px;"></div>
                        <div class="col-md-6 text-center">
                            <img class="loader" src="/assets/images/loading.gif">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="progress progress-animated" style="height:40px;">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                    <div class="warning alert alert-danger text-center animated shake" style="display:none;">
                        <div>
                            <i class="fa fa-exclamation-triangle fa-3x"></i>
                        </div>
                        <div><br>
                            Report may contain shocking facts & other sensitive information.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="upgradeModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="upgradeModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-bars"></i> Premium Reports</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <div><b>BASIC</b></div>
                                    <div>Was <strong class="strike"><span style="color:black;">$7.99</span></strong></div>
                                    <div class="big-number">$4.99</div>                                    
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
                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'selectReport', eventLabel: 'basic'});" href="/register?nid=<?php //echo $name['id']['S'];  ?>&pid=5" rel="nofollow" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                </div>
                                <div class="col-md-4">
                                    <div><b>THOROUGH</b></div>
                                    <div>Was <strong class="strike"><span style="color:black;">$14.99</span></strong></div>
                                    <div class="big-number">$9.99</div>
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
                                    <i class="fa fa-check green"></i> FCRA Compliant<br>
                                    <i class="fa fa-check green"></i> Instant Results<br><br>
                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'selectReport', eventLabel: 'thorough'});" href="/register?nid=<?php //echo $name['id']['S'];  ?>&pid=6" rel="nofollow" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                </div>
                                <div class="col-md-4">
                                    <div><b>COMPLETE</b></div>
                                    <div>Was <strong class="strike"><span style="color:black;">$19.99</span></strong></div>
                                    <div class="big-number">$14.99</div>
                                    <b>Everything From Basic Report + Thorough Report +</b><br><br>
                                    <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                    <i class="fa fa-check green"></i> FCRA Compliant<br>
                                    <i class="fa fa-check green"></i> Instant Results<br><br>
                                    <a onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'selectReport', eventLabel: 'complete'});" href="/register?nid=<?php //echo $name['id']['S'];  ?>&pid=7" rel="nofollow" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center"><br><br>
                            <h3><i class="fa fa-check green"></i> 100% Money-Back Guarantee.</h3>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

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
    $('#map_outer').animate({width: "100%"}, 0);
    $('.searching').modal('show');

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
            }, 18000);
    setTimeout(
            function ()
            {
                $('#2').show();
                $('#2').addClass('animated fadeInUp');
            }, 21000);
    setTimeout(
            function ()
            {
                $('#online-profiles').addClass('active animated fadeInUp');
            }, 25000);
    setTimeout(
            function ()
            {
                $('#searchAll').show();
                $('#searchAll').addClass('animated fadeInUp');
                $('#searchAll').removeClass('animated fadeInUp');
            }, 29000);

    setTimeout(
            function ()
            {
                $('#number1').removeClass('loading');
                $('#number1').addClass('fa animated swing');

            }, 29000);
    setTimeout(
            function ()
            {
                $('#number6').removeClass('loading');
                $('#number6').addClass('fa animated swing');

            }, 31000);
    setTimeout(
            function ()
            {
                $('#number5').removeClass('loading');
                $('#number5').addClass('fa animated wobble');

            }, 30000);
    setTimeout(
            function ()
            {
                $('#number3').removeClass('loading');
                $('#number3').addClass('fa animated tada');

            }, 33000);
    setTimeout(
            function ()
            {
                $('#number2').removeClass('loading');
                $('#number2').addClass('fa animated shake');

            }, 39000);
    setTimeout(
            function ()
            {
                $('#number4').removeClass('loading');
                $('#number4').addClass('fa animated bounce');

            }, 41000);


    var progress = setInterval(function () {
        var $bar = $('.progress-bar');
        var width = (100 * parseFloat($('.progress-bar').css('width')) / parseFloat($('.progress-bar').parent().css('width')));

        if (width >= 100) {
            clearInterval(progress);
            $('.progress').removeClass('active');
        } else {

            $bar.width(width + 1 + '%');
        }
    }, 300);

    setTimeout(
            function ()
            {

            }, 4000);

    setTimeout(
            function ()
            {
                $('.voter-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.voter').css('font-weight', 'bold');
            }, 5000);
    setTimeout(
            function ()
            {
                $('.criminal-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.criminal').css('font-weight', 'bold');
            }, 8000);
    setTimeout(
            function ()
            {
                $('.domain-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.domain').css('font-weight', 'bold');
            }, 37000);
    setTimeout(
            function ()
            {
                $('.social-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.social').css('font-weight', 'bold');
            }, 13000);
    setTimeout(
            function ()
            {
                $('.business-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.business').css('font-weight', 'bold');
            }, 20000);
    setTimeout(
            function ()
            {
                $('.dmv-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.dmv').css('font-weight', 'bold');
            }, 22000);
    setTimeout(
            function ()
            {
                $('.licenses-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.licenses').css('font-weight', 'bold');
            }, 30000);

    setTimeout(
            function ()
            {
                $('.loader').replaceWith('<div class="animated slideInUp"><h3>Success!</h3><i class="fa fa-check-circle-o green fa-5x"></i><h3>Loading Report...</h3></div>');
            }, 38000);

    $('.warning').delay(10000).fadeIn();

    setTimeout(
            function ()
            {
                $('#map_outer').animate({width: "17.3%"}, 1000);
            }, 8000);

    setTimeout(
            function ()
            {
                $('.searching').modal('hide');
                $('#upgradeModal').modal('show');
                $('.report').removeClass('blur');
                ga('send', 'event', {eventCategory: 'load', eventAction: 'basicNameReportLoaded-forceUpgrade'});
            }, 40000);

    setTimeout(
            function ()
            {
                map._onResize();
            }, 9000);

</script>
