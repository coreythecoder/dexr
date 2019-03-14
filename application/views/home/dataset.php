<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li ><a href="/datasets">My Datasets</a></li>
            <li class="active"><?php echo ucwords(strtolower($datasetInfo->name)); ?></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class='list-title'>
        <div class="inner list-sub" style="margin-top:8px;">
            <div class="row">        
                <div class="col-md-4">
                    <div class="btn-group">
                        <button data-toggle="modal" type="button" data-target="#editFilters" class="btn btn-default btn-xs"><i class="fa fa-toggle-on"></i> &nbsp;Edit Filter</button>
                        <?php if (isset($_POST['search'])) { ?>
                            <button data-toggle="modal" data-target="#saveFilters" type="button" id="saveButton" class="btn btn-default btn-xs"><i class="fa fa-save"></i> &nbsp;Save Filter</button>                        
                        <?php } ?>
                        <button data-toggle="modal" data-target="#setupZap" id="saveButton" type="button" class="btn btn-default btn-xs"><i class="fa fa-lightbulb-o"></i> &nbsp;Zaps</button>
                    </div>
                    <button data-toggle="modal" data-target="#setupZap" id="crawlButton" type="button" class="btn btn-default btn-xs"><i class="fa fa-bug"></i> &nbsp;Crawl</button>
                </div>
                <div class='col-md-4 col-xs-12 center-xs' style=''>
                    <h3 style="margin-top:15px;">Total Records: &nbsp;<?php
                        if (isset($count)) {
                            if ($count >= 10000) {
                                echo ">";
                            }
                            echo number_format($count);
                        }
                        ?>
                    </h3>
                </div> 

                <div class="col-md-2 pull-right text-right">
                    <?php if (($userType == 'admin' || $userType == 'free_pro') || hasSubscription($this->config->item('pro'))) { ?>
                        <button id="download_button" form="form" name="download" type="submit" class="btn btn-default btn-xs noThinker" style=""><i class="fa fa-download"></i> Download</button>
                    <?php } else { ?>
                        <button id="download_button" type="button" class="btn btn-default btn-xs noThinker" disabled><i class="fa fa-download"></i> Download</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
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


<!-- Modal -->
<div class="modal fade" id="editFilters" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
        <div class="modal-content">
            <form method="POST" id="form">
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
                                    <div class="row">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4 time">
                                            <label><input type="checkbox" name="daterangeTrue" id="daterangeTrue"> Select Date Range</label>
                                            <input type="text" style="display:none;" name="daterange" id="daterange" class="timepicker" value="<?php
                                            if (isset($_POST['daterange']) && !empty($_POST['daterange'])) {
                                                echo $this->input->post('daterange');
                                            } else {
                                                echo date('m/d/Y', strtotime('yesterday'));
                                                ?> - <?php
                                                       echo date('m/d/Y', strtotime('yesterday'));
                                                   }
                                                   ?>" /><br><br>
                                        </div>
                                        <div class="col-md-4"></div>
                                    </div>
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
                                                    if ($_POST['col'][$i] == 'contactEmail') {
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
                                                    <option value="equals" <?php
                                                    if ($_POST['type'][$i] == 'equals') {
                                                        echo "selected";
                                                    }
                                                    ?>>Equals (exact)</option>
                                                    <option value="contains" <?php
                                                    if ($_POST['type'][$i] == 'contains') {
                                                        echo "selected";
                                                    }
                                                    ?>>Contains (regexp)</option>
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
                                            <option value="equals">Equals (exact)</option>
                                            <option value="contains">Contains (regexp)</option>
                                            <option value="not_equals">Not Equals (exact)</option>
                                            <option value="not_contains">Not Contains (regexp)</option>
                                        </select>                       
                                    </div>
                                    <div class="col-md-5 text-center" style="">
                                        <input type="text" id="keyword_required" class="form-control" name="keyword[]" placeholder="">                        
                                    </div>
                                </div>
                            <?php } ?>
                            <div id="added"></div>                    
                            <div class="row">
                                <div class="col-md-12 text-center" style=""><br>
                                    <a class="add noThinker" href="#"><span class="badge badge-success"><i class="fa fa-plus"></i></span> Add Another Rule</a> <br><br>
                                    <p><strong>Tip:</strong> The "contains" and "equals" fields use the AND operator unless there are multiple occurrences of the same field then the OR operator will be used for all filters using that field. The "not contains" and "not equals" always use the AND operator.</p>

                                </div>                    
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" name="search" class="btn btn-success">Update View</button> 
                </div>
            </form>
        </div>
    </div>
</div>
</form>

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
                        <input form="form" type="text" name="filter_label" class="form-control" id="save-text" placeholder="Label Your New Filter...">
                    </div>
                </div>                
            </div>
            <div class="modal-footer">                    
                <button form="form" type="submit" name="save" class="btn btn-success">Save</button>   
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

<div class="modal fade" id="setupZap" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Setup your Zaps...</h4>                    
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6" style="">      
                        <div class="row">
                            <div class="col-md-12" style="">    
                                <form method="POST" name="webhook">
                                    <h3>Add New Zap</h3>
                                    <input type="text" name="name" class="form-control" placeholder="Zap Name...">
                                    <input type="url" name="webhook" class="form-control" placeholder="Zapier Webhook URL...">
                                    <button type="submit" name="save_zap" class="btn btn-default btn-xs" style="margin:5px;">Save Zap</button>
                                </form>                                    
                                <?php if ($existingZaps) { ?>
                                    <form method="POST" name="deletewebhook">
                                        <h3>Delete a Zap</h3>
                                        <select name="zap_list" class='form-control'><?php echo $existingZaps; ?></select>
                                        <button onclick="return confirm('Are you sure?');" type="submit" name="delete_zap" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="">      
                        <h3>What's a Zap?</h3>
                        <p>Zapier is an online automation tool that connects your favorite apps, such as Gmail, Slack, MailChimp, and over 1,000 more. You can connect two or more apps to automate repetitive tasks without coding or relying on developers to build the integration. Move info between dexr.io and other web apps automatically, so you can focus on your most important work. It's easy enough that anyone can build their own app workflows with just a few clicks.</p><p>Basically, you can send our data to any of 1000 other apps with the click of a button. Send emails, add data to a CRM, send an SMS, connect a phone call & much more.  Best of all, 2-step Zaps are free.</p><br><a href="http://zapier.com" target="_blank">Visit Zapier.com</a> to learn more & create an account.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">             

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