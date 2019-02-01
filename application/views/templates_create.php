<style>
    .panel-body {
        margin: 0px 0px 0px 0px;
    }
</style>
<div class="background-image"></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-3 center-xs'>
                <h1 style='font-size: 20px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Email > Templates</h1>  
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/campaigns"><i class="fa fa-lightbulb-o"></i> Campaigns</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/targeting"><i class="fa fa-bullseye"></i> Targeting</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/inboxes"><i class="fa fa-inbox"></i> Inboxes</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/templates"><i class="fa fa-pencil-square"></i> Templates</a></div>
            </div>
            <div class='col-md-1 col-xs-12 center-xs' style='margin-top:12px; margin-bottom:-8px;'>
                <div class='text-center center-xs'><a href="/email/templates" class="btn btn-default btn-xs" ><i class="fa fa-list"></i></a>   </div>
            </div>
        </div>
    </div>   
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12"><br>
            <?php if (isset($error) && !empty($error)) {
                echo $error;
            }
            ?>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="col-sm-6">
        <div class="panel panel-bordered mg-b">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="">
                        <h2 class="page-header grey" style="display: inline;">Email Template</h2><br><br>
                    </div>
                </div>
                <form method="POST" name="template_form">
                    <div class="row">
                        <div class="col-md-12" style="">
                            <input type="text" class="form-control" required="" name="name" value="<?php
                                   if (isset($_POST['name'])) {
                                       echo $_POST['name'];
                                   }
                                   ?>" placeholder="Template Name" autofocus="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="">
                            <input type="text" class="form-control" required="" value="<?php
                                   if (isset($_POST['subject'])) {
                                       echo $_POST['subject'];
                                   }
                                   ?>" id="subject" name="subject" style="margin-top: 20px;" placeholder="Email Subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="">
                            <p>HTML accepted.</p>
                            <textarea class="form-control" id="body" required="" name="body" placeholder="Email Body"><?php
                                   if (isset($_POST['body'])) {
                                       echo $_POST['body'];
                                   }
                                   ?></textarea>
                            <p>The variables below will be replaced with the actual individual registrant's information before being sent.</p>
                            <p>Available variables: %domain_name% %first_name% %last_name% %city% %state% %domain_created_date% %domain_expires_date% %registrant_organization% %registrant_telephone%</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="">
                            <input type="text" class="form-control" required="" style="margin-top: 20px;" name="address" value="<?php
                                   if (isset($_POST['address'])) {
                                       echo $_POST['address'];
                                   }
                                   ?>" placeholder="Your Business Name & Mailing Address (for Can-Spam compliance) - Example: Business, LLC 1234 Big Rd. Gainesville, FL 32608">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="">
                            <input type="submit" class="btn btn-success btn-block" value="Save" style="margin-top: 20px;" name="save">
                        </div>
                    </div>
                </form>
            </div>                
        </div>            
    </div>
    <div class="col-sm-6">
        <div class="panel panel-bordered mg-b">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12" style="">
                        <h2 class="page-header grey" style="display: inline;">Preview</h2><br><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="">
                        <h3 id='prev_subject'><?php
                            if (isset($_POST['name'])) {
                                echo ucwords(strtolower($_POST['subject']));
                            }
                            ?></h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="">
                        <div id='prev_body'>
<?php
if (isset($_POST['body'])) {
    echo $_POST['body'];
}
?>
                            <br><br><br>
                            <small>To no longer receive emails please <a href="">Unsubscribe</a></small><br>
                            <small>This can-spam compliant email sent by: <span id="address_prev"><?php
if (isset($_POST['address'])) {
    echo ucwords(strtolower($_POST['address']));
}
?></span></small>
                        </div>
                    </div>
                </div>
            </div>                
        </div>            
    </div>
</div>
