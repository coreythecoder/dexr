<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-lock white'></i> Change Your Password</h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-right center-xs white'><a class="top-white-link white" href="/user_settings">Go To My Account Settings</a></div>
            </div>
        </div>
    </div>   
</div>
<div class="container">
    <div class='row'>
        <div class='col-md-12 stagerred-box'>
            <div class='inner '>
                <div class="white-area-content">

                    <div class="panel-default">
                        <div class="panel-body">
                            <?php echo $message; ?>
                            <?php echo form_open(site_url("user_settings/change_password_pro"), array("class" => "form-horizontal")) ?>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_238") ?></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_239") ?></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="new_pass1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"><?php echo lang("ctn_240") ?></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="new_pass2">
                                </div>
                            </div>
                            <input type="submit" name="s" value="<?php echo lang("ctn_241") ?>" class="btn btn-success btn-block" />
                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>