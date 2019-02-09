<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>"><?php echo $state; ?></a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>/<?php echo $city_slug; ?>"><?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></a></li>
        </ol>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12 city-list">
            <h1>
                <?php echo $city; ?>, <?php echo $state_abr; ?> Business Owners & Web Site Owners
            </h1>
            <div class="separator"></div>
            <?php echo $names; ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 nearby-cities">
            <h1>
                Cities Near <?php echo $city; ?>, <?php echo $state_abr; ?>
            </h1>
            <div class="separator"></div>
            <?php echo $nearby; ?>
        </div>
    </div>
</div>