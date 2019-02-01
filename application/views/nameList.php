
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-9 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-check white'></i> <?php
                    echo 'Found ' . ucwords(unformatForSearch($first . ' ' . $last) . ' In ' . unformatForSearch($city)) . ', ' . strtoupper($state) . ' (' . $count . ' Total)';
                    ?></h1>  
            </div>
            <div class='col-md-3' style='margin-top:23px;'>
                <div class='text-right center-xs'><?php echo $crumbs; ?></div>
            </div>
        </div>
    </div>   
</div>
<div id="map_outer" class="animated slideInLeft hidden-xs">
    <div id="map_canvas"></div>
</div> 
<div class="container-fluid">

    <div class="row">
        <div class="col-md-2 hidden-xs hidden-sm text-center" style="position:relative; top: 70px;">

        </div>
        <div class="col-md-10 results"> 
            <div class="center-xs" style="padding-left:20px; padding-right:20px;">
                <div class="addthis_inline_share_toolbox"></div>
            </div>
            <?php echo $nameList; ?>
            <br>
        </div>
    </div>    
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <div class="page-header" style="margin-top:0px; padding-left: 20px;">                    
                <div class="fb-like" data-href="https://www.facebook.com/yoliyainc" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div>            </div>
        </div>
    </div>
</div>
<?php if (!empty($otherCities)) { ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 stagerred-box">
            <div class='inner'>
                <div class="page-header" style="margin-top:0px; padding-left: 20px;">                    
                    <h3><i class='fa fa-plus'></i> <?php echo ucwords(unformatForSearch($first . ' ' . $last)); ?> Also Found In</h3>
                </div>
                <div class='row' style='padding-left: 20px; padding-bottom:20px;'>
                    <?php echo $otherCities; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (!empty($lastList)) { ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 stagerred-box">
            <div class='inner'>
                <div class="page-header" style="margin-top:0px; padding-left: 20px;">                    
                    <h3><i class='fa fa-plus'></i> Other <?php echo ucwords(unformatForSearch($last)); ?>s In <?php echo ucwords(unformatForSearch($city)); ?>, <?php echo strtoupper($state); ?></h3>
                </div>
                <div class='row' style='padding-left: 20px; padding-bottom:20px;'>
                    <?php echo $lastList; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<?php if (!empty($firstList)) { ?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9 stagerred-box">
            <div class='inner'>
                <div class="page-header" style="margin-top:0px; padding-left: 20px;">                    
                    <h3><i class='fa fa-plus'></i> Other <?php echo ucwords(unformatForSearch($first)); ?>s In <?php echo ucwords(unformatForSearch($city)); ?>, <?php echo strtoupper($state); ?></h3>
                </div>
                <div class='row' style='padding-left: 20px; padding-bottom:20px;'>
                    <?php echo $firstList; ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-9 stagerred-box">
        <div class='inner'>
            <div class="page-header" style="margin-top:0px; padding-left: 20px;">
                <h3><i class='fa fa-search-plus'></i> Don't See Who You're Looking for?</h3>
            </div>
            <h4 style='padding-left: 20px;'>It's okay, we can run an instant background check on anyone. &nbsp; <a href="/reports?src=nameList-footer" rel="nofollow" class="btn btn-success btn-sm">See Pricing</a></h4>
        </div>
    </div>
</div>
</div>
<div style='height:0px;'></div>
