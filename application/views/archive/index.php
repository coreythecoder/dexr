<style>
    .form div.row {
        margin-bottom:25px;
    }
</style>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class="container">
            <div class='row'>
                <div class='col-md-7'>
                    <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-archive white'></i> Report Archives</h1>  
                </div>
                <?php if ($isActive) { ?>
                    <div class='col-md-5' style='margin-top:23px;'>
                        <div class='text-right'>Questions or Feedback? Let us know! Hi@Yoliya.com</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>   
</div>
<div class="container">
    <div class='col-md-12 stagerred-box animated fadeInUp'>
        <div class='inner blue-background'>
            <div class="row">
                <div class="col-md-12">
                    <div class='row panels text-center'>

                        <?php if (!empty($reportList)) { ?>
                            <?php echo $reportList; ?>
                            <div class='col-sm-4 panel-item'>
                                <a href="/dash" style="color:inherit;" class='panel panel-circle-contrast panel-light pricing-table'>
                                    <div class='panel-icon'>
                                        <i class='fa fa-plus icon'></i>
                                    </div>
                                    <div class='panel-body'>
                                        <h3 class='panel-title'>New Report</h3>

                                    </div>
                                </a>
                            </div>  
                        <?php } else { ?>
                            <div class='col-sm-12'>
                                <div class="noReports"><h3>You haven't created any reports yet.</h3>
                                    <div>
                                        <a class="btn btn-success" style="margin:30px;" href="/dash"><i class="fa fa-plus"></i> &nbsp;Create A Report</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div style="height:20px;"></div>
        </div>
    </div>
</div>