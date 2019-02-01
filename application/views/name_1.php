
<div id="map_outer" class="animated slideInLeft hidden-xs">
    <div id="map_canvas"></div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 hidden-xs" style="">

        </div>
        <div class="col-md-10">
            <div class="page-header" style="margin-top:50px;">                
                <div class='row'>
                    <div class='col-md-8'>
                        <h4 style="color:#ddd; margin-bottom:-15px;">All Public Records for:</h4>
                        <h1><?php echo ucwords($first . ' ' . $middle . ' ' . $last); ?> in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></h1>

                        <h4>
                            <i class="fa fa-map-marker"></i> <?php echo ucwords($name['fullAddress']['S']); ?>. <?php
                            if (isset($name['apt']['S'])) {
                                echo ucwords($name['apt']['S']);
                            }
                            ?>
                            <?php echo ucwords($name['city']['S']); ?>, <?php echo strtoupper($name['state']['S']); ?> <?php echo $name['zip']['S']; ?></h4>
                        <p><?php echo $crumbs; ?></p>
                    </div>
                    <div class='col-md-4 text-center' style='position:relative; top:30px;'>
                        <h4 style='position:relative; '><i class="fa fa-birthday-cake" style='position:relative;'></i>
                            <?php echo date('F d, Y', $name['dob']['S']); ?></h4>

                        <h4><i class='fa fa-phone'></i> 
                            <?php
                            if (isset($name['phone']['S'])) {
                                echo formatPhoneNumber($name['phone']['S']);
                            }
                            ?>
                        </h4>
                        <div class="hidden-md hidden-lg hidden-sm" style="height:50px;"></div>
                    </div>
                </div> 
            </div>
            <div class="col-md-12">
                <div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs hidden-xs" role="tablist">
                        <li role="presentation" class="<?php
                        if (!isset($_GET['tab'])) {
                            echo 'active';
                        }
                        ?> col-md-2 text-center">
                            <a href="#neighbors" aria-controls="neighbors" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        <?php echo ($neighborCount + $sameAddressCount); ?>
                                    </div>
                                    Near <?php echo ucwords($first); ?>
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class="col-md-2 text-center">
                            <a href="#voter" aria-controls="voter" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        <?php echo $voterRecordCountByNameAddress; ?>
                                    </div>
                                    Voter Records
                                </div>
                            </a>
                        </li>

                        <li role="presentation" class=" col-md-2 text-center">
                            <a href="#business" aria-controls="business" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        0
                                    </div>
                                    Business Records
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class=" col-md-2 text-center">
                            <a href="#whois" aria-controls="whois" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        0
                                    </div>
                                    WhoIs Records
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class=" col-md-2 text-center">
                            <a href="#licensing" aria-controls="licensing" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        0
                                    </div>
                                    Licensing Records
                                </div>
                            </a>
                        </li>
                        <li role="presentation" class="<?php
                        if (isset($_GET['tab']) && $_GET['tab'] == 'criminal') {
                            echo 'active';
                        }
                        ?> col-md-2 text-center">
                            <a href="#criminal" aria-controls="criminal" role="tab" data-toggle="tab">
                                <div>
                                    <div class='big-number text-center'>
                                        ?
                                    </div>
                                    Criminal Records
                                </div>
                            </a>
                        </li>

                    </ul>

                    <div class="col-sm-2 hidden-md hidden-lg">
                        <ul class="nav nav-tabs nav-stacked" role="tablist">
                            <li role="presentation" class="active col-md-2 text-center">
                                <a href="#neighbors" aria-controls="neighbors" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            <?php echo ($neighborCount + $sameAddressCount); ?>
                                        </div>
                                        Near<br><?php echo ucwords($first); ?>
                                    </div>
                                </a>
                            </li>
                            <li role="presentation" class="col-md-2 text-center">
                                <a href="#voter" aria-controls="voter" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            <?php echo $voterRecordCountByNameAddress; ?>
                                        </div>
                                        Voter Records
                                    </div>
                                </a>
                            </li>

                            <li role="presentation" class=" col-md-2 text-center">
                                <a href="#business" aria-controls="business" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            0
                                        </div>
                                        Business Records
                                    </div>
                                </a>
                            </li>
                            <li role="presentation" class=" col-md-2 text-center">
                                <a href="#whois" aria-controls="whois" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            0
                                        </div>
                                        WhoIs Records
                                    </div>
                                </a>
                            </li>
                            <li role="presentation" class=" col-md-2 text-center">
                                <a href="#licensing" aria-controls="licensing" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            0
                                        </div>
                                        Licensing Records
                                    </div>
                                </a>
                            </li>
                            <li role="presentation" class=" col-md-2 text-center">
                                <a href="#criminal" aria-controls="criminal" role="tab" data-toggle="tab">
                                    <div>
                                        <div class='big-number text-center'>
                                            ?
                                        </div>
                                        Criminal Records
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?php
                        if (!isset($_GET['tab'])) {
                            echo 'active in';
                        }
                        ?>" id="neighbors">
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
                        <div role="tabpanel" class="tab-pane fade in" id="voter">
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
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="business">
                            <div class="row">
                                <div class='col-md-1 big-number-side text-center'>
                                    0
                                </div>
                                <div class="col-md-11">
                                    <div class="page-header" style="margin-top:50px;">
                                        <h3></h3>
                                    </div>
                                    <div class="row">
                                        <?php //echo $neighborList;     ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="whois">3</div>
                        <div role="tabpanel" class="tab-pane fade" id="licensing">4</div>
                        <div role="tabpanel" class="tab-pane fade <?php
                        if (isset($_GET['tab']) && $_GET['tab'] == 'criminal') {
                            echo 'active in';
                        }
                        ?>" id="criminal">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="page-header"><h3>Statewide Background Check (<?php echo strtoupper($name['state']['S']); ?>)</h3></div>
                                            <div class="col-md-4 text-center">
                                                <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;"><?php echo getStateFromJson(strtoupper($name['state']['S'])); ?></span>
                                            </div>
                                            <div class="col-md-3">
                                                <div>Was <strong class="strike"><span style="color:black;">$14.99</span></strong></div>
                                                <div class="big-number">$9.99</div>
                                                <i class="fa fa-check green"></i> Instant Results<br>
                                                <i class="fa fa-check green"></i> All 67 Counties In Florida<br>
                                                <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                <a rel="nofollow" onClick="ga('send', 'event', { eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'stateCheckSelect'});" href="/register?state=fl&nid=<?php echo $name['id']['S']; ?>&pid=2" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
                                            </div>
                                            <div class="col-md-5">
                                                <p>The Local Background Check is an affordable & quick way to check a persona criminal history at the state level.  This check is currently only available in Florida.  We'll query our large database of Florida offenders & return any matching records from the Florida Department of Corrections.</p>
                                                <p>This database includes currently incarcerated, released & parolees. 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="page-header"><h3>Nationwide Background Check (Local Level) <span class="pull-right"><i class="fa fa-check green"></i> FCRA Compliant <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-question-circle"></i></a></span></h3></div>
                                            <div class="col-md-4 text-center">
                                                <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                            </div>
                                            <div class="col-md-3">
                                                <div>Was <strong class="strike"><span style="color:black;">$19.99</span></strong></div>
                                                <div class="big-number">$14.99</div>
                                                <i class="fa fa-check green"></i> Instant Results<br>
                                                <i class="fa fa-check green"></i> All 50 States<br>
                                                <i class="fa fa-check green"></i> FCRA Compliant<br>
                                                <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                <a onClick="ga('send', 'event', { eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'criminalCheckSelect'});" href="/register?nid=<?php echo $name['id']['S']; ?>&pid=3" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>                                                
                                            </div>
                                            <div class="col-md-5">
                                                The Nationwide Background Check is a powerful, high-speed multi-state and federal search of our proprietary databases compiled from multiple sources consisting of court records, incarceration records, prison/inmate records, probation/parole/release information, arrest data, wants and warrants and/or other proprietary sources. Each search includes a 50-state sex offender screening, terrorist watch list report and our proprietary database derived from millions of historical searches.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="page-header"><h3>Federal Background Check (Federal Level) <span class="pull-right"><i class="fa fa-check green"></i> FCRA Compliant <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-question-circle"></i></a></span></h3></div>
                                            <div class="col-md-4 text-center">
                                                <span class="stateface stateface-replace" style="font-size:150px; color:#5dc3de;">z</span>
                                            </div>
                                            <div class="col-md-3">
                                                <div>Was <strong class="strike"><span style="color:black;">$14.99</span></strong></div>
                                                <div class="big-number">$9.99</div>
                                                <i class="fa fa-check green"></i> Instant Results<br>
                                                <i class="fa fa-check green"></i> U.S.A. Federal Records<br>
                                                <i class="fa fa-check green"></i> FCRA Compliant<br>
                                                <i class="fa fa-check green"></i> Money-Back Guarantee<br><br>
                                                <a onClick="ga('send', 'event', { eventCategory: 'buttonClicks', eventAction: 'name', eventLabel: 'federalCheckSelect'});" href="/register?nid=<?php echo $name['id']['S']; ?>&pid=4" class="btn btn-success btn-xs"><i class="fa fa-paypal"></i> Select</a>
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

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="page-header" style="margin-top:50px; margin-bottom: 100px;">
                                <h3>Not The <?php echo ucwords($first . ' ' . $last); ?> You're Looking For? <a rel="nofollow" href="/results?fName=<?php echo $first; ?>&lName=<?php echo $last; ?>">See Em' All</a></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">What is the Fair Credit Reporting Act? (FCRA)</h4>
                    </div>
                    <div class="modal-body">
                        The Fair Credit Reporting Act, 15 U.S.C. § 1681 (“FCRA”) is U.S. Federal Government legislation enacted to promote the accuracy, fairness, and privacy of consumer information contained in the files of consumer reporting agencies. It was intended to protect consumers from the willful and/or negligent inclusion of inaccurate information in their credit reports. To that end, the FCRA regulates the collection, dissemination, and use of consumer information, including consumer credit information.[1] Together with the Fair Debt Collection Practices Act ("FDCPA"), the FCRA forms the foundation of consumer rights law in the United States. It was originally passed in 1970,[2] and is enforced by the US Federal Trade Commission, the Consumer Financial Protection Bureau and private litigants.
                        <br><br>
                        For more information: <a href="https://en.wikipedia.org/wiki/Fair_Credit_Reporting_Act" target="_blank" rel="nofollow">https://en.wikipedia.org/wiki/Fair_Credit_Reporting_Act</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>