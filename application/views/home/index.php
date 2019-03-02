<div class="breadcrumb-container" style="position:fixed; left:0px; right:0px;">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active">Search Corpus</li>
        </ol>
        <?php if (isset($_POST['search'])) { ?><span class="pull-right small" style="position:absolute; right:20px; bottom:8px;"><i class="fa fa-exclamation-triangle orange"></i> Results limited to 25. Create a dataset for records up to 10,000 & <a href="https://zapier.com" target="_blank">Zaps <i class="fa fa-external-link"></i></a></span><?php } ?>
    </div>
</div>

<div style="position:fixed; left:0px; top:153px; bottom:70px; background-color:white; border-right:2px solid #f1f1f1; width:25%; z-index:2; padding:20px;">
    <form method="POST" id="form">
        <div class="row">
            <div class="col-md-12">



                <div class="<?php if (isset($_POST['search'])) { ?>input-group<?php } ?>">

                    <select name="load" id="userFilters" form="form" class="form-control input-sm">
                        <option value="">Load Saved Filter...</option>
                        <?php echo $userFilters; ?>
                    </select>    


                    <?php if (isset($_POST['search'])) { ?>
                        <span class="input-group-addon" style="padding:0px;">
                            <button type="button" style="margin:0px; border-radius:0px 3px 3px 0px;" data-toggle="modal" autocomplete="off" data-target="#saveFilters" id="saveFilters" class="btn btn-default btn-sm"><i class="fa fa-save"></i> Save Filter</button>
                        </span>
                    <?php } ?>
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="">                            
                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="row">
                            <div class="col-md-12 time">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php
                                        if (!empty($error)) {
                                            echo "<hr>";
                                            echo $error;
                                            echo "<hr>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <label><input type="checkbox" name="daterangeTrue" id="daterangeTrue" <?php
                                    if (isset($_POST['daterangeTrue'])) {
                                        echo "checked";
                                    }
                                    ?>> Select Date Range</label>
                                <input autocomplete="off" type="text" style="<?php if (!isset($_POST['daterangeTrue'])) { ?>display:none;<?php } ?> outline: none;border:0px;margin-left:10px;" name="daterange" id="daterange" class="timepicker" value="<?php
                                if (isset($_POST['daterange']) && !empty($_POST['daterange'])) {
                                    echo $this->input->post('daterange');
                                } else {
                                    echo date('m/d/Y', strtotime('yesterday'));
                                    ?> - <?php
                                           echo date('m/d/Y', strtotime('yesterday'));
                                       }
                                       ?>" /><br><br>
                            </div>
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

                <div class="row">
                    <div class="col-md-12">
                        <input form="form" type="hidden" name="col[]" value="domainName">
                        <input form="form" type="hidden" name="type[]" value="contains">
                        <input form="form" type="text" name="keyword[]" value="<?php
                        if (isset($_POST['keyword'][0])) {
                            echo $this->input->post('keyword')[0];
                        }
                        ?>" class="form-control input-sm" placeholder="Domain Name Contains..." autocomplete="new-password">                                
                    </div>                    
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_city">                                
                                <input type="text" form="form" name="keyword[]" autocomplete="off" class="form-control input-sm" style="width:100%" placeholder="City..." value="<?php
                                if (isset($_POST['keyword'][1])) {
                                    echo $this->input->post('keyword')[1];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select form="form" name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][1]) && $_POST['type'][1] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][1]) && $_POST['type'][1] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_state">
                                <input name="keyword[]" autocomplete="off" form="form" type="text" class="form-control input-sm" style="width:100%" placeholder="State..." value="<?php
                                if (isset($_POST['keyword'][2])) {
                                    echo $this->input->post('keyword')[2];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][2]) && $_POST['type'][2] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][2]) && $_POST['type'][2] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                           
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="contactEmail">
                                <input autocomplete="off" name="keyword[]" form="form" type="text" class="form-control input-sm" style="width:100%" placeholder="Email..." value="<?php
                                if (isset($_POST['keyword'][3])) {
                                    echo $this->input->post('keyword')[3];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][3]) && $_POST['type'][3] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][3]) && $_POST['type'][3] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                      
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_name">
                                <input name="keyword[]" autocomplete="off" form="form" type="text" class="form-control input-sm" style="width:100%" placeholder="Registrant Name..." value="<?php
                                if (isset($_POST['keyword'][4])) {
                                    echo $this->input->post('keyword')[4];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][4]) && $_POST['type'][4] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][4]) && $_POST['type'][4] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                              
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_organization">                                
                                <input name="keyword[]" form="form" autocomplete="off" type="text" class="form-control input-sm" style="width:100%" placeholder="Organization Name..." value="<?php
                                if (isset($_POST['keyword'][5])) {
                                    echo $this->input->post('keyword')[5];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][5]) && $_POST['type'][5] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][5]) && $_POST['type'][5] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option> 
                                    <option value="contains" <?php
                                    if (isset($_POST['type'][5]) && $_POST['type'][5] == 'contains') {
                                        echo 'selected';
                                    }
                                    ?>>Contains</option>
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_street1">
                                <input type="text" autocomplete="off" name="keyword[]" form="form" class="form-control input-sm" style="width:100%" placeholder="Street Address..." value="<?php
                                if (isset($_POST['keyword'][6])) {
                                    echo $this->input->post('keyword')[6];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][6]) && $_POST['type'][6] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][6]) && $_POST['type'][6] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                              
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_postalCode">
                                <input name="keyword[]" autocomplete="off" form="form" type="text" class="form-control input-sm" style="width:100%" placeholder="Zip Code..." value="<?php
                                if (isset($_POST['keyword'][7])) {
                                    echo $this->input->post('keyword')[7];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][7]) && $_POST['type'][7] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][7]) && $_POST['type'][7] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                              
                                </select>    
                            </span>
                        </div>

                        <div class="input-group search-field">
                            <span class="input-group-addon" style="padding:0px;">
                                <input form="form" type="hidden" name="col[]" value="registrant_telephone">
                                <input name="keyword[]" autocomplete="off" form="form" type="text" class="form-control input-sm" style="width:100%" placeholder="Phone..." value="<?php
                                if (isset($_POST['keyword'][8])) {
                                    echo $this->input->post('keyword')[8];
                                }
                                ?>">
                            </span>
                            <span class="input-group-addon" style="padding:0px;margin:0px;">
                                <select name="type[]" id="userFilters" form="form" class="form-control input-sm">
                                    <option value="equals" <?php
                                    if (isset($_POST['type'][8]) && $_POST['type'][8] == 'equals') {
                                        echo 'selected';
                                    }
                                    ?>>Equals</option>
                                    <option value="not_equals" <?php
                                    if (isset($_POST['type'][8]) && $_POST['type'][8] == 'not_equals') {
                                        echo 'selected';
                                    }
                                    ?>>Not Equals</option>                                             
                                </select>    
                            </span>
                        </div>
                    </div>                    
                </div>                    

                <hr>
                <div class="<?php if (isset($_POST['search'])) { ?>input-group<?php } ?>">

                    <button form="form" type="submit" value="search" name="search" class="btn btn-default btn-block btn-sm"><i class="fa fa-refresh"></i> Update Data</button>
                    <?php if (isset($_POST['search'])) { ?>
                        <span class="input-group-addon" style="padding:0px; background-color:white; border:0px;">


                            <button data-toggle="modal" style=" margin:0px;" data-target="#createDataset" id="saveButton" class="btn btn-default-transparent btn-sm noThinker btn-block" type="button" <?php if ($userType == 'admin' || $userType == 'free_pro' || $userType == 'free_premium' || (hasSubscription("plan_EOP7ViqCXFPfte") || hasSubscription("plan_EOP6GRC06U4CFz"))) { ?> <?php
                            } else {
                                echo "disabled";
                            }
                            ?>><i class="fa fa-database"></i> Create Dataset</button> 

                        </span>
                    <?php } ?>
                </div>

            </div>

        </div>
    </form>

</div>

<div class='list-title'>
    <div class="inner list-sub" style="padding-left:20px; margin-top:-20px;">
        <div class='row'>                



        </div>
    </div>   
</div>

<div class="container-fluid">
    <div class='row' style='margin-top:70px;'>
        <div class="col-sm-3"></div>
        <div class="col-sm-9">
            <?php if (!empty($list)) { ?>
                <table class="table table-striped">
                    <?php echo $list; ?>
                </table>            
            <?php } else { ?>
                <h1 class="text-center blue" style="margin-top:11%;">{ Too Much Data }<br><p style="font-size:.8em; color:#dedede;">Please limit your results</p></h1>
                <p class="text-center" style="margin-top:45px;">
                    <?php if (!isset($_POST['search'])) { ?><i class="fa fa-exclamation-triangle orange"></i> Results limited to 25.<br>Create a dataset for records up to 10,000 & <a href="https://zapier.com" target="_blank">Zaps <i class="fa fa-external-link"></i></a><?php } ?>
                </p>


            <?php } ?>
        </div>
    </div>                        
</div>


<!-- Modal -->



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
                        <input autocomplete="off" form="form" type="text" name="filter_label" class="form-control" id="save-text" placeholder="Label Your New Filter...">
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
                        <input autocomplete="off" type="text" name="filter_label_auto" class="form-control" placeholder="Label your filter...">
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
                        <input type="text" autocomplete="off" name="filter_label_auto" class="form-control" placeholder="Label your filter...">
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

<div class="modal fade" id="createDataset" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:80%; max-width:900px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Dataset Name...</h4>                    
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" style="">                            
                        <input autocomplete="off" type="text" form="form" name="datasetName" id="datasetInput" class="form-control" placeholder="Name your dataset...">
                    </div>
                </div>
            </div>
            <div class="modal-footer">             
                <div class="btn-group">
                    <button name="create_dataset_name" id="saveDataset" form="form" type="button" class="btn btn-default btn-xs"><i class="fa fa-database"></i> Create Dataset</button>   
                    <button data-dismiss="modal" data-target="#createDataset" id="closeDataset" class="btn btn-default btn-xs"><i class="fa fa-database"></i> Close</button>   


                </div>
            </div>
        </div>
    </div>
</div>

