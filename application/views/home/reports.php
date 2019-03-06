<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active">My Name Reports</li>
        </ol>
    </div>
</div>

<style>
    .dataset {
        padding:15px;
        border-radius:8px;
        min-height:100px;
        background-color:white;
        padding-left:30px;
    }
</style>
<div class="container">
    <div class='row' style='margin: 10px;'>

                    <div class="col-sm-12">
                <?php if (!empty($reportList)) { ?>
                    <table class="table table-striped">
                        <?php if (isset($reportList)) echo $reportList; ?>
                    </table>            
                <?php } else { ?>
                    <h1 class="text-center blue" style="margin-top:14%;">{ No Reports }<br><?php if ($userType !== 'admin' && $userType !== 'free_pro' && $userType !== 'free_premium' && (!hasSubscription("plan_EOP7ViqCXFPfte") || !hasSubscription("plan_EOP6GRC06U4CFz"))) {
                    echo "<div style='font-size:.7em; color:#ddd; margin:20px;'>You must have a paid plan to save reports.</div>";
                } else { ?><p style="font-size:.8em; color:#dedede;">Please create a report</p><?php } ?>
                        <div class="row">
                            <a class="btn btn-default btn-sm <?php if (!hasSubscription("plan_Ect6UjkS61gIb5") || !hasSubscription("plan_EOPfv7iEDXLQFy")) {
                    echo "noThinker";
                } ?>" type="button" <?php if (hasSubscription("plan_EOP7ViqCXFPfte") || hasSubscription("plan_EOP6GRC06U4CFz") || $userType == 'admin' || $userType == 'free_pro' || $userType == 'free_premium') { ?>href="/" <?php } else {
                    echo "disabled";
                } ?>><i class="fa fa-search"></i>&nbsp; Search Corpus</a> 
                        </div>                        
                </div>                
<?php } ?>                  
    </div>