<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>"><?php echo $state; ?></a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>/<?php echo $city_slug; ?>"><?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></a></li>
            <li class="active"><a href="/<?php echo $state_abr; ?>/<?php echo $city_slug; ?>/<?php echo $name_slug; ?>"><?php echo ucwords(strtolower($name)); ?> in <?php echo $city; ?>, <?php echo strtoupper($state_abr); ?></a></li>
        </ol>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <h1>
                <?php echo ucwords(strtolower($name)); ?> in <?php echo $city; ?>, <?php echo $state_abr; ?>
            </h1>
            <?php if ($total >= 5) { ?>
                <h4>Showing 5 of <?php
                    if ($total >= 50) {
                        echo ">";
                    }
                    ?><?php echo $total; ?> Registration(s)</h4>
            <?php } else { ?>
                <h4>Showing <?php echo $total; ?> of <?php
                    if ($total >= 50) {
                        echo ">";
                    }
                    ?><?php echo $total; ?> Registration(s)</h4>
            <?php } ?>         
            <div class="separator"></div>
            <?php echo $domains; ?>
        </div>        
    </div>
    <div class="row other-names">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <?php echo $names; ?>  
        </div>
    </div>

</div>