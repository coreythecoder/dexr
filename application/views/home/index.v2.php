<div class=""></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-3 center-xs' style="width:285px;">
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-search white'></i> Discover &nbsp; <button data-toggle="modal" data-target="#editFilters" class="btn btn-default btn-xs"><i class="fa fa-toggle-on"></i> Edit View</button></h1>  
            </div>
            <?php if (isset($_POST['search'])) { ?>
                <div class='col-md-4 col-xs-12 center-xs' style='margin-top:21px; width:125px;'>
                    <div class="btn-group">
                        <button data-toggle="modal" data-target="#saveFilters" id="saveButton" class="btn btn-default btn-xs"><i class="fa fa-save"></i> Save Filter</button>                        
                    </div>
                </div>
                <div class='col-md-4 col-xs-12 center-xs' style='margin-top:21px;'>
                    <div class="btn-group">
                        <button data-toggle="modal" id="saveAutomate" data-target="#saveFilters" class="btn btn-default btn-xs"><i class="fa fa-recycle"></i> Save & Automate</button>

                    </div>
                </div>
            <?php } ?>
            <div class='pull-right' style='margin-top:21px; margin-right:30px;'>
                <div class="btn-group">
                    <button data-toggle="modal" id="configDefault" data-target="#configDefaults" class="btn btn-default btn-xs"><i class="fa fa-info-circle"></i> Configure Default Actions</button>

                </div>
            </div>
            <!-- <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'>Businesses: <?php //echo $businesses;                          ?></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'>Individuals: <strong><?php //echo $individuals;                          ?></strong></div>
            </div>  -->

        </div>
    </div>   
</div>
<div class="container-fluid">
    <div class='row' style='margin-top:10px;'>
        <div class="col-sm-12">
            <?php if (!empty($list)) { ?>
                <table class="table table-striped">
                    <?php echo $list; ?>
                </table>            
            <?php } else { ?>
                <h1 class="text-center blue" style="margin-top:15%;">{ Too Much Data }<br><p>Please limit your results</p>
                    <div class="row">
                        <button data-toggle="modal" data-target="#editFilters" class="btn btn-default btn-sm"><i class="fa fa-toggle-on"></i> Create A Filter</button> 
                    </div>
            </div>
            </h1>
        <?php } ?>
    </div>                        
</div>
</div>

<form method="POST" id="form">
    <!-- Modal -->
    <div class="modal fade" id="editFilters" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Geo-Targeting & Keyword Filters 
                        <span class="pull-right" style="margin-right:30px;">
                            <select name="load" id="userFilters" class="form-control input-sm">
                                <option value="">Load Saved Filter...</option>
                                <?php echo $userFilters; ?>
                            </select>
                        </span>
                    </h4>                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="">                            
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <p><strong>Tip:</strong> The "contains" and "equals" fields use the AND operator unless there are multiple occurrences of the same field then the OR operator will be used for all filters using that field. The "not contains" and "not equals" always use the AND operator.</p>
                                    <br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    if (!empty($error)) {
                                        echo $error;
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_POST['search']) || isset($_POST['save']) || isset($_POST['load']) && !empty($_POST['keyword'][0])) {
                                $i = 0;
                                foreach ($_POST['keyword'] as $keyword) {
                                    if (!empty($keyword)) {
                                        ?>
                                        <div class="row">
                                            <div class="col-md-5 text-center" style="">
                                                <select name="col[]" class="form-control">
                                                    <option value="domainName" <?php
                                                    if ($_POST['col'][$i] == 'domainName') {
                                                        echo "selected";
                                                    }
                                                    ?>>Domain Name</option>
                                                    <option value="registrant_city" <?php
                                                    if ($_POST['col'][$i] == 'registrant_city') {
                                                        echo "selected";
                                                    }
                                                    ?>>City</option>
                                                    <option value="registrant_state" <?php
                                                    if ($_POST['col'][$i] == 'registrant_state') {
                                                        echo "selected";
                                                    }
                                                    ?>>State</option>
                                                    <option value="registrant_country" <?php
                                                    if ($_POST['col'][$i] == 'registrant_country') {
                                                        echo "selected";
                                                    }
                                                    ?>>Country</option>
                                                    <option value="contactEmail" <?php
                                                    if ($_POST['col'][$i] == 'contactDmail') {
                                                        echo "selected";
                                                    }
                                                    ?>>Email Address</option>
                                                    <option value="registrarName" <?php
                                                    if ($_POST['col'][$i] == 'registrarName') {
                                                        echo "selected";
                                                    }
                                                    ?>>Registrar</option>
                                                    <option value="registrant_name" <?php
                                                    if ($_POST['col'][$i] == 'registrant_name') {
                                                        echo "selected";
                                                    }
                                                    ?>>Registrant Name (first & last)</option>
                                                    <option value="registrant_organization" <?php
                                                    if ($_POST['col'][$i] == 'registrant_organization') {
                                                        echo "selected";
                                                    }
                                                    ?>>Organization Name</option>
                                                    <option value="registrant_street1" <?php
                                                    if ($_POST['col'][$i] == 'registrant_street1') {
                                                        echo "selected";
                                                    }
                                                    ?>>Street Address</option>
                                                    <option value="registrant_postalCode" <?php
                                                    if ($_POST['col'][$i] == 'registrant_postalCode') {
                                                        echo "selected";
                                                    }
                                                    ?>>Zip Code</option>
                                                    <option value="registrant_telephone" <?php
                                                    if ($_POST['col'][$i] == 'registrant_telephone') {
                                                        echo "selected";
                                                    }
                                                    ?>>Phone</option>
                                                </select>                 
                                            </div>
                                            <div class="col-md-2 text-center" style="">
                                                <select name="type[]" class="form-control">
                                                    <option value="contains">Contains (regexp)</option>
                                                    <option value="equals" <?php
                                                    if ($_POST['type'][$i] == 'equals') {
                                                        echo "selected";
                                                    }
                                                    ?>>Equals (exact)</option>
                                                    <option value="not_equals" <?php
                                                    if ($_POST['type'][$i] == 'not_equals') {
                                                        echo "selected";
                                                    }
                                                    ?>>Not Equals (exact)</option>
                                                    <option value="not_contains" <?php
                                                    if ($_POST['type'][$i] == 'not_contains') {
                                                        echo "selected";
                                                    }
                                                    ?>>Not Contains (regexp)</option>
                                                </select>                       
                                            </div>
                                            <div class="col-md-5 text-center" style="">
                                                <input type="text" class="form-control" name="keyword[]" placeholder="" value="<?php
                                                if (isset($keyword)) {
                                                    echo $keyword;
                                                }
                                                ?>">                        
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    $i++;
                                }
                            } else {
                                ?>
                                <div class="row">
                                    <div class="col-md-5 text-center" style="">
                                        <select name="col[]" class="form-control">
                                            <option value="registrant_city">City</option>
                                            <option value="registrant_state">State</option>
                                            <option value="domainName">Domain Name</option>
                                            <option value="registrant_country">Country</option>
                                            <option value="contactEmail">Email Address</option>
                                            <option value="registrarName">Registrar</option>
                                            <option value="registrant_name">Registrant Name (first & last)</option>
                                            <option value="registrant_organization">Organization Name</option>
                                            <option value="registrant_street1">Street Address</option>
                                            <option value="registrant_postalCode">Zip Code</option>
                                            <option value="registrant_telephone">Phone</option>
                                        </select>                 
                                    </div>
                                    <div class="col-md-2 text-center" style="">
                                        <select name="type[]" class="form-control">
                                            <option value="contains">Contains (regexp)</option>
                                            <option value="equals">Equals (exact)</option>
                                            <option value="not_equals">Not Equals (exact)</option>
                                            <option value="not_contains">Not Contains (regexp)</option>
                                        </select>                       
                                    </div>
                                    <div class="col-md-5 text-center" style="">
                                        <input type="text" class="form-control" name="keyword[]" placeholder="" required="">                        
                                    </div>
                                </div>
                            <?php } ?>
                            <div id="added"></div>                    
                            <div class="row">
                                <div class="col-md-12 text-center" style=""><br>
                                    <a class="add noThinker" href="#"><span class="badge badge-success"><i class="fa fa-plus"></i></span> Add Another Rule</a> 
                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" name="search" class="btn btn-success">Update View</button> 
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="saveFilters" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:90%; max-width:1200px;">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Save This Filter As...</h4>        
                </div>
                <div class="modal-body">                    
                    <div class="row">
                        <div class="col-md-12" style="">                            
                            <input type="text" name="filter_label" class="form-control" id="save-text" placeholder="Label Your New Filter...">
                        </div>
                    </div>
                    <div class='panels-wrapper' id="automate-options" style="display:none;">
                        <div class="row">
                            <div class="col-md-12"><br>
                                <h4>Then Choose an Automation Campaign Type...</h4>
                            </div>
                        </div>
                        <div class='row panels'>
                            <div class='col-sm-3 panel-item' id="panel-email">
                                <a class='panel panel-big noThinker' href='#'>
                                    <div class='panel-icon'>
                                        <i class='fa fa-at icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>Email</h3>
                                        <p>Connect your email account, setup an email template, schedule and other options to send emails to this list.</p>
                                        <br><h4 style="display:inline;" class="blue">Free</h4><br>
                                        <small>*Requires 3rd Party Email Provider<br>Gmail, Yahoo, AWS SES, etc.</small>
                                    </div>
                                </a>
                            </div>                            
                            <div class='col-sm-3 panel-item' id="panel-robo">
                                <a class='panel panel-big noThinker' href='#'>
                                    <div class='panel-icon'>
                                        <i class='fa fa-cogs icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>RoboCalling</h3>
                                        <p>Setup a short audio message, link your phone number & setup a schedule to send automated phone calls to this list.</p>
                                        <br><h4 style="display:inline;" class="blue">$1/Phone #/Month<br>+ $.008/Minute Usage</h4><br>
                                        <small class="">*Requires Twilio API Key & Secret</small>
                                    </div>
                                </a>
                            </div>
                            </di>
                            <di class='ro panels'>

                                <div class='col-sm-3 panel-item' id="panel-sms">
                                    <a class='panel panel-big noThinker' href='#'>
                                        <div class='panel-icon'>
                                            <i class='fa fa-mobile-phone icon'></i>
                                        </div>
                                        <div class='panel-body'>
                                            <h3 class='panel-title'>Text Message (SMS)</h3>
                                            <p>Create a short (140 characters or less) text message & schedule to send to this list.</p>
                                            <br><h4 style="display:inline;" class="blue">$1/Phone #/Month<br>+ $.007/Message</h4><br>
                                            <small class="">*Requires Twilio API Key & Secret</small>
                                        </div>
                                    </a>
                                </div>
                                <div class='col-sm-3 panel-item' id="panel-alarm">
                                    <a class='panel panel-big noThinker' href='#'>
                                        <div class='panel-icon'>
                                            <i class='fa fa-flag icon'></i>
                                        </div>
                                        <div class='panel-body'>
                                            <h3 class='panel-title'>Alarm</h3>
                                            <p>Send an email or text message when a condition is met regarding this list.</p>
                                            <br><h4 style="display:inline;" class="blue">Free</h4><br>
                                            <small>*Text Messaging Requires Twilio API Key & Secret</small>
                                        </div>
                                    </a>
                                </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button type="submit" name="save" class="btn btn-success">Save</button>   
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="saveSetup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Save Filter & Setup Automation...</h4>                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="">                            
                            <input type="text" name="filter_label_auto" class="form-control" placeholder="Label your filter...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">             
                    <div class="btn-group">
                        <a class="btn btn-info dropdown-toggle noThinker" data-toggle="dropdown" href="#" style="position:relative; right:6px;">Save & Setup Automation &nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="margin-left:12px;">Automated Campaign Type</li>
                            <li class="divider"></li>
                            <li><a href="#">Email Campaign</a></li>
                            <li><a href="#">Voicemail Drop Campaign</a></li>
                            <li><a href="#">RoboCall Campaign</a></li> 
                            <li><a href="#">SMS Campaign</a></li> 
                            <li class="divider"></li> 
                            <li><a href="#">Alarm</a></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="configDefaults" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Configure Default Actions</h4>                    
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" style="">                            
                            <input type="text" name="filter_label_auto" class="form-control" placeholder="Label your filter...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">             
                    <div class="btn-group">
                        <a class="btn btn-info dropdown-toggle noThinker" data-toggle="dropdown" href="#" style="position:relative; right:6px;">Save & Setup Automation &nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li style="margin-left:12px;">Automated Campaign Type</li>
                            <li class="divider"></li>
                            <li><a href="#">Email Campaign</a></li>
                            <li><a href="#">Voicemail Drop Campaign</a></li>
                            <li><a href="#">RoboCall Campaign</a></li> 
                            <li><a href="#">SMS Campaign</a></li> 
                            <li class="divider"></li> 
                            <li><a href="#">Alarm</a></li> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <input type="hidden" id="hidden_campaign_type" name="hidden_campaign_type" value="">
</form>
<script>
    $(document).ready(function () {
<?php if (empty($list)) { ?>
            $('#editFilters').modal('show');
<?php } ?>
        $(".add").on("click", function () {
            $("#added").append('<div class="row animated fadeInDown"><div class="col-md-5 text-center" style=""><select name="col[]" class="form-control"><option value="domainName">Domain Name</option><option value="registrant_city">City</option><option value="registrant_state">State</option><option value="registrant_country">Country</option><option value="contactEmail">Email Address</option><option value="registrarName">Registrar</option><option value="registrant_name">Registrant Name (first & last)</option><option value="registrant_organization">Organization Name</option><option value="registrant_street1">Street Address</option><option value="registrant_postalCode">Zip Code</option><option value="phone">Phone</option></select></div><div class="col-md-2 text-center" style=""><select name="type[]" class="form-control"><option value="contains">Contains (regexp)</option><option value="equals">Equals (exact)</option><option value="not_equals">Not Equals (exact)</option><option value="not_contains">Not Contains (regexp)</option></select></div><div class="col-md-5 text-center" style=""><input type="text" class="form-control" name="keyword[]" placeholder=""></div></div>');
        });

        $("#saveAutomate").on("click", function () {
            $("#automate-options").show();
        });

        $("#saveButton").on("click", function () {
            $("#automate-options").hide();
        });

        $(".panel").on("click", function () {
            if ($("#save-text").val() !== "") {

                $("#panel-email").on("click", function () {
                    $("#hidden_campaign_type").val("email_redirect");
                    $("#form").submit();
                });
                $("#panel-robo").on("click", function () {
                    $("#hidden_campaign_type").val("robo_redirect");
                    $("#form").submit();
                });
                $("#panel-sms").on("click", function () {
                    $("#hidden_campaign_type").val("sms_redirect");
                    $("#form").submit();
                });
                $("#panel-alarm").on("click", function () {
                    $("#hidden_campaign_type").val("alarm_redirect");
                    $("#form").submit();
                });


            } else {
                alert("Please provide a filter label.");
                $("#save-text").focus();
            }
        });

        $(function () {
            $('#userFilters').change(function () {
                if ($('#userFilters').val() !== "") {
                    this.form.submit();
                }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>