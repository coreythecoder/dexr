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
                <h1 style='font-size: 20px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Email > Create Inbox</h1>  
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
                <div class='text-center center-xs'><a href="/email/inboxes" class="btn btn-default btn-xs" ><i class="fa fa-list"></i></a>   </div>
            </div>
        </div>
    </div>   
</div>





<div class="container">

    <div class="col-sm-12">
        <div class="panel panel-bordered mg-b">
            <div class="panel-body">

                <div class="row">
                    <div class="col-md-12" style="">
                        <div class="row">
                            <div class="col-md-12" style="">
                                <h2 class="page-header grey" style="display: inline;">Email Address</h2><br><br>
                            </div>
                        </div>

                        <form method="POST">
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
                                <div class="col-md-12 text-center" style="">
                                    <input type="email" autofocus="" name="address" value="<?php
                                    if (isset($_POST['address'])) {
                                        echo $_POST['address'];
                                    }
                                    ?>" placeholder="Email Address - Example: boxname@provider.com" class="form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">IMAP Server</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <input type="url" value="<?php
                                    if (isset($_POST['imap_server'])) {
                                        echo $_POST['imap_server'];
                                    }
                                    ?>" placeholder="IMAP Server - Example: imap.gmail.com:993" name="imap_server" class="form-control">                                            
                                </div>                                    
                                
                            </div>
                            
                            <div class="row">
                                                                   
                                <div class="col-md-12 text-center" style="">
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($_POST['imap_password'])) {
                                        echo $_POST['imap_password'];
                                    }
                                    ?>" name="imap_password" placeholder="Password">                        
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">SMTP Server</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <input type="url" placeholder="SMTP Server - Example: smtp.gmail.com:465" value="<?php
                                    if (isset($_POST['smtp_server'])) {
                                        echo $_POST['smtp_server'];
                                    }
                                    ?>" name="smtp_server" class="form-control">                                            
                                </div>                                    
                                
                            </div>
                            
                            <div class="row">
                                                                 
                                <div class="col-md-12 text-center" style="">
                                    <input type="text" class="form-control" value="<?php
                                    if (isset($_POST['smtp_password'])) {
                                        echo $_POST['smtp_password'];
                                    }
                                    ?>" name="smtp_password" placeholder="Password">                        
                                </div>
                            </div>

                            <div class="row text-center">
                                <div class="col-md-12 text-center" style="">
                                    <input type="submit" name="test_save" value="Test & Save" class="btn btn-block btn-success">   
                                </div>
                            </div>
                            

                        </form>            
                    </div>

                </div>
            </div></div></div>


</div>
</div>

