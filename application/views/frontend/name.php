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
    <section>
    <div class="row">
        <div class="col-md-12 text-center" style='margin-top:-30px; margin-bottom:80px;'>
            <h2 style="padding:15px;">We're Integrated with Zapier!</h2>
            <p class='text-center large' style="padding:15px;">Send our data to any of over 1000 other apps connected by Zapier!<br><small>**requires a Zapier account</small></p>
            <img src='https://static.dexr.io/images/zapier.png' style='display:inline;'>
        </div>
    </div>
</section>
    <div class="row other-names">
        <div class="col-md-12" style="margin-top:25px; margin-bottom:80px;">
            <?php echo $names; ?>  
        </div>
    </div>

</div>

<section class="section default-bg clearfix">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="call-to-action text-center">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="title">Ready To Take A Test Drive?</h1>
                            <p>Create a free forever account. No credit card required.<br>We're also offering a 7 day free trial on our Pro membership.</p>
                        </div>
                        <div class="col-sm-4">
                            <br>
                            <p><a href="https://app.dexr.io/register" rel="nofollow" class="btn btn-lg btn-gray-transparent btn-animated">Create a Free Account<i class="fa fa-arrow-right pl-20"></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>