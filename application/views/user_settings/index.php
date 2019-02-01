<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active">My Account</li>
        </ol>
    </div>
</div>
<div class='container'>
    <div class="white-area-content animated fadeInUp">
        <div class="row">
            <div class='col-md-6 stagerred-box animated fadeInUp'>
                <div class='inner blue-background'>
                    <h4 class="panel-subheading">Basic Settings <a href="<?php echo site_url("user_settings/change_password") ?>" class="btn btn-primary btn-sm pull-right" style='position:relative; bottom:8px;'><?php echo lang("ctn_225") ?></a></h4>
                    <?php echo form_open_multipart(site_url("user_settings/pro"), array("class" => "form-horizontal")) ?>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo lang("ctn_230") ?></label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="<?php echo $this->user->info->email ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo lang("ctn_231") ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="first_name" value="<?php echo ucwords($this->user->info->first_name); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?php echo lang("ctn_232") ?></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="last_name" value="<?php echo ucwords($this->user->info->last_name); ?>">
                        </div>
                    </div>

                    <input type="submit" name="s" value="<?php echo lang("ctn_236") ?>" class="btn btn-success btn-block" />
                    <?php echo form_close() ?>

                </div>
            </div>
            <div class='col-md-6 stagerred-box animated fadeInUp'>
                <div class='inner blue-background' style='padding-bottom:20px;'>
                    <h4 class="panel-subheading">My Subscriptions</h4>
                    <?php echo $subList; ?>
                    <br><br>
                    <h4 class="panel-subheading">Billing History</h4>
                    <?php echo $chargeList; ?>
                </div>
            </div>
        </div>
    </div>
</div>