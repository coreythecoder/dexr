<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-search white'></i> <?php echo ucwords($fname . ' ' . $lname); ?><?php if(!empty($city) || !empty($state)) { echo ' in '; } else { echo ' in the United States of America'; } ?><?php if(!empty($city)) echo ucwords($city).', '; ?><?php if(isset($state)) echo strtoupper($state); ?></h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-right center-xs'></div>
            </div>
        </div>
    </div>   
</div>
<?php if (isset($mapAddresses)) { ?>   
    <div id="map_outer" class="animated slideInLeft hidden-xs">
        <div id="map_canvas"></div>
    </div>
<?php } ?>

<div class="container-fluid">
    <div class="row">
        <?php if (!isset($mapAddresses)) { ?>        
        </div>
        <div class="col-md-12">
        <?php } else { ?>
            <div class="col-md-2" style="">
            </div>
            <div class="col-md-10">
            <?php } ?>

            <?php if (isset($stateFilters) && !empty($stateFilters)) { ?>
                <div class="row">
                    <div class="col-md-12 stagerred-box">
                        <div class="inner">

                            <div class="row">
                                <div class="col-md-2"><strong>Filter by State:</strong></div><?php echo $stateFilters; ?>
                            </div>

                        </div>
                    </div>
                </div>
            <?php } ?>    
            <?php if (isset($cityFilters) && !empty($cityFilters)) { ?>
                <div class="row">
                    <div class="col-md-12 stagerred-box">
                        <div class="inner">
                            <div class="row">
                                <div class="col-md-3"><strong>Filter by City:</strong></div><?php echo $cityFilters; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="results">                 
                <?php echo $nameList; ?>
            </div>
            
        </div>
    </div>
</div>