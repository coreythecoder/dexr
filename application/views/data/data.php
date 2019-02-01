<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-lock white'></i> Management Menu</h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-right center-xs'></div>
            </div>
        </div>
    </div>   
</div>
<div class="container">
    <div class='row' style='margin:10px;'>
        <div class="col-sm-12">
            <?php echo $messages; ?>
        </div>
    </div>
    <div class='row' style='margin:10px;'>
        <div class="col-sm-6">
            <a href="/data/import" class="panel panel-bordered mg-b">
                <div class="panel-body">
                    <div class='row vertical-align'>
                        <div class='col-md-3 text-center'>
                            <i style="" class="blue fa fa-database fa-3x"></i>
                        </div>
                        <div class='col-md-9' style='display:block;'>
                            <h5>Import Raw Data Console</h5>
                        </div>

                    </div>
                </div>
            </a>                            
        </div>
        <div class="col-sm-6">
            <a href="/data?action=clear_opt_outs" class="panel panel-bordered mg-b">
                <div class="panel-body">
                    <div class='row vertical-align'>
                        <div class='col-md-3 text-center'>
                            <i style="" class="blue fa fa-user fa-3x"></i>
                        </div>
                        <div class='col-md-9' style='display:block;'>
                            <h5>Clear Opt-Outs</h5>
                        </div>

                    </div>
                </div>
            </a>                            
        </div>        
    </div>
</div>