<div class="container">
    <div class="row">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <h1>
                <?php echo $state; ?><?php
                if ($thisPage > 1) {
                    echo " - Page " . $thisPage;
                }
                ?>
            </h1>
            <div class="separator"></div>
<?php echo $cities; ?>
        </div>
    </div>
</div>