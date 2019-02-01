<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active">My Datasets</li>
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
<div class="container-fluid">
    <div class='row' style='margin: 10px;'>

        <!-- <div class="col-lg-4 col-md-6 stagerred-box animated fadeInUp">
            <div class="dataset">
                <h4>Dataset: Test Title</h4>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        Records: ~<br>
                        Created: ~<br>
                        Filters: ~
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="/assets/images/loading.gif" style="max-height:68px;"> <br>              
                        Processing...
                    </div>
                </div>

            </div>
        </div> -->

        

        <div class='row' style='margin-top:10px;'>
            <div class="col-sm-12">
                <?php if (!empty($datasetList)) { ?>
                    <table class="table table-striped">
                        <?php if (isset($datasetList)) echo $datasetList; ?>
                    </table>            
                <?php } else { ?>
                    <h1 class="text-center blue" style="margin-top:8%;">{ No Datasets }<br><?php if($userType !== 'admin' && $userType !== 'free_pro' && $userType !== 'free_premium' && (!hasSubscription("plan_EOP7ViqCXFPfte") || !hasSubscription("plan_EOP6GRC06U4CFz"))){ echo "<div style='font-size:.7em; color:#ddd; margin:20px;'>You must have a paid plan to save datasets.</div>"; } else { ?><p style="font-size:.8em; color:#dedede;">Please create a dataset</p><?php } ?>
                        <div class="row">
                            <a class="btn btn-default btn-sm <?php if(!hasSubscription("plan_EOP7ViqCXFPfte") || !hasSubscription("plan_EOP6GRC06U4CFz")){ echo "noThinker"; } ?>" type="button" <?php if(hasSubscription("plan_EOP7ViqCXFPfte") || hasSubscription("plan_EOP6GRC06U4CFz") || $userType == 'admin' || $userType == 'free_pro' || $userType == 'free_premium'){ ?>href="/" <?php } else { echo "disabled"; } ?>><i class="fa fa-toggle-on"></i> Create A Dataset</a> 
                        </div>                        
                </div>
                </h1>
            <?php } ?>
        </div>   

    </div>                        
</div>