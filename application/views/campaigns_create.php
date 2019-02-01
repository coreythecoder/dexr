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
                <h1 style='font-size: 20px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Email > Create Campaign</h1>  
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
                <div class='text-center center-xs'><a href="/email/campaigns" class="btn btn-default btn-xs" ><i class="fa fa-list"></i></a>   </div>
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
                                <div class="col-md-12" style="">
                                    <h2 class="page-header grey" style="display: inline;">Campaign Label</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <input name="name" class="form-control" placeholder="Identifier" autofocus="">                                
                                </div>                                    

                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">Target Audience</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <select name="target" class="form-control">
                                        <?php echo $targets; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">Box</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <select name="inbox" class="form-control">
                                        <?php echo $boxes; ?>
                                    </select>                                 
                                </div>                                    

                            </div>



                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">Template</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <select name="template" class="form-control">
                                        <?php echo $templates; ?>
                                    </select>                                          
                                </div>                                    

                            </div>

                            <div class="row">
                                <div class="col-md-12" style="margin-top: 20px;">
                                    <h2 class="page-header grey" style="display: inline;">Schedule</h2><br><br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <select name="schedule" class="form-control">
                                        <option value="manual">Manual</option>
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly (Mondays)</option>
                                    </select>                                       
                                </div>                                    

                            </div>


                            <div class="row text-center">
                                <div class="col-md-12 text-center" style="">
                                    <input type="submit" name="save" value="Save & Launch" class="btn btn-block btn-success">   
                                </div>
                            </div>


                        </form>            
                    </div>

                </div>
            </div></div></div>


</div>
</div>

