<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-lock white'></i> <?php echo ucwords($first . ' ' . $middle . ' ' . $last); ?> in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
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
        <div class="col-md-2 hidden-xs" style="">

        </div>
        <div class="col-md-10">
            <div class="page-header" id="1" style="margin-top:0px; border-bottom: 0px solid transparent;">
                <div class='row'>
                    <div class='col-md-12 stagerred-box' style="padding-left:20px;">
                        <div class='inner blue-background'>
                            <div class='row '>
                                <div class='col-md-8 col-xs-12 center-xs'>
                                    <h4>
                                        <i class="fa fa-map-marker"></i> <span><?php echo ucwords($name['fullAddress']['S']); ?>. <?php
                                            if (isset($name['apt']['S'])) {
                                                echo ucwords($name['apt']['S']);
                                            }
                                            ?></span>
                                        <?php echo ucwords($name['city']['S']); ?>, <?php echo strtoupper($name['state']['S']); ?> <?php echo $name['zip']['S']; ?></h4>
                                </div>                        
                                <div class='col-md-4 col-xs-12 text-right center-xs'>
                                    <h4><i class="fa fa-birthday-cake" style=''></i>
                                        <?php
                                        if ($age > 17) {
                                            echo 'Born ' . date('Y', $name['dob']['S']);
                                        }
                                        ?></h4>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row' style='margin:10px;'>
                    <div class='col-md-12 text-center'>
                        <h3 style='margin-top:0px;'><i class='fa fa-exclamation-triangle' style='color:orange;'></i> You must be signed in to view this report.</h3>
                        <div class='col-md-6 text-center'>
                            <a href='/register' rel='nofollow' class='btn btn-success btn-block btn-lg'><i class='fa fa-unlock'></i>&nbsp; Create An Account</a>
                        </div>
                        <div class='col-md-6 text-center'>
                            <a href='/login' rel='nofollow' class='btn btn-info btn-block btn-lg'><i class='fa fa-sign-in'></i>&nbsp; Sign In</a>
                        </div>
                    </div>
                </div>
                <div class='row' style='margin:10px;'>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number1"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Public Records</h5>
                                        <p style='position:relative; bottom:8px;'>Voter records, business registrations, domain registrations, business licenses & more.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number2"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Online Profiles & Images</h5>
                                        <p style='position:relative; bottom:8px;'>Profile links & images from top social media web sites & business/people directories.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number3"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Relatives & Relationships</h5>
                                        <p style='position:relative; bottom:8px;'>List of family members, spouses & other possible relatives.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number4"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Nationwide Criminal Records</h5>
                                        <p style='position:relative; bottom:8px;'>Nationwide state & federal criminal records as well as wants & warrants.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number5"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Contact Info & Location History</h5>
                                        <p style='position:relative; bottom:8px;'>Email addresses, phone history, address history & more.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-bordered mg-b">
                            <div class="panel-body">
                                <div class='row vertical-align'>
                                    <div class='col-md-3 text-center'>
                                        <i style="display:block; font-size:50px;" class="blue" id="number6"><span class="fa fa-check badge-absolute" style="font-size:18px; color:#5BC506;"></span></i>
                                    </div>
                                    <div class='col-md-9' style='display:block;'>
                                        <h5>Career & Education</h5>
                                        <p style='position:relative; bottom:8px;'>List of schools, colleges, employers & more.</p>
                                    </div>

                                </div>
                            </div>
                        </div>                            
                    </div>     

                </div>

                <div class='row'>
                    <div class='col-md-12 stagerred-box'>
                        <div class='inner blue-background'>
                            <div class="row">
                                <div class='col-md-12'>
                                    <div class="owl-carousel content-slider white-text dark-translucent-bg">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <div class="testimonial text-center" style='margin:20px;'>
                                                    <div class="testimonial-image">
                                                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Jane Doerty" title="Jane Doerty" height="60" class="img-circle">
                                                    </div>
                                                    <h3 class="white-text">What a huge help! Thanks again.</h3>
                                                    <div class="separator"></div>
                                                    <div class="testimonial-body">
                                                        <blockquote>
                                                            <p>I couldn't be happier.  Thanks to yoliya I found my step sister that I haven't seen in more than 20 years! You guys are doing great things. Keep up the awesome work.</p>
                                                        </blockquote>
                                                        <div class="testimonial-info-1"><strong>Janice</strong></div>
                                                        <div class="testimonial-info-2">Dallas, TX</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-12 stagerred-box'>
                        <div class='inner' style='background-color: #5dc3de;'>
                            <div class="row">
                                <div class='col-md-12 text-center' style='margin-bottom:8px;'>
                                    <h2 class='white'>100% Satisfaction Guarantee</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade searching" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class='row'>
                    <div class='col-md-8'>
                        <h4 style="color:#ddd; margin-bottom:-15px;">Gathering Records for:</h4>
                        <h1><?php echo ucwords($first . ' ' . $middle . ' ' . $last); ?><div style="font-size:.7em; color:#D0d0d0;">in <?php echo ucwords($city) . ', ' . strtoupper($state); ?></div></h1>
                    </div>
                    <div class='col-md-4 text-center' style='position:relative; top:30px;'>
                        <img class="loader" style="height:80px;" src="/assets/images/loading.gif">                            
                    </div>
                </div> 
            </div>
            <div class="modal-body">                  
                <div class="row">
                    <div class="col-md-6">
                        <div class="voter"><img class="voter-img" src="/assets/images/loading2.gif" height="20"> Public Records</div>
                        <div class="progress public-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-public progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="social"><img class="social-img" src="/assets/images/loading2.gif" height="20"> Online Profiles</div>
                        <div class="progress online-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-online progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="business"><img class="business-img" src="/assets/images/loading2.gif" height="20"> Relationships</div>
                        <div class="progress relationships-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-relationships progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="criminal"><img class="criminal-img" src="/assets/images/loading2.gif" height="20"> Criminal Records</div>
                        <div class="progress criminal-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-criminal progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="licenses"><img class="licenses-img" src="/assets/images/loading2.gif" height="20"> Phone & Address History</div>
                        <div class="progress phone-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-phone progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                        <div class="dmv"><img class="dmv-img" src="/assets/images/loading2.gif" height="20"> Current & Past Employers</div>
                        <div class="progress career-progress progress-animated" style="height:10px;">
                            <div class="progress-bar progress-bar-career progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="progress main-progress progress-animated" style="height:40px;">
                    <div class="progress-bar main-progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                </div>
                <div class="warning alert alert-danger text-center animated shake" style="display:none;">
                    <div>
                        <i class="fa fa-exclamation-triangle fa-3x"></i>
                    </div>
                    <div><br>
                        Report may contain shocking facts & other sensitive information.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .label {
        font-size:18px;
    }
    p {
        margin-bottom:20px;
    }
</style>
<script>
    $('a').click(function () {
        $('html, body').animate({
            scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
        }, 800);
        return false;
    });
    //$('#map_outer').animate({width: "100%"}, 0);

    if (localStorage.getItem('nid') !== '<?php echo $nid; ?>') {
        localStorage.nid = '<?php echo $nid; ?>';
        $('.searching').modal('show');
    }

    //$('#1').hide();
    //$('#2').hide();
    $('#searchAll').hide();
    $('.top-tabs i').addClass('loading');
    setTimeout(
            function ()
            {
                //$('#1').show();
                //$('#1').addClass('animated fadeInUp');
            }, 9000);
    setTimeout(
            function ()
            {
                //$('#2').show();
                //$('#2').addClass('animated fadeInUp');
            }, 10500);
    setTimeout(
            function ()
            {
                $('#public-records').addClass('active animated fadeInUp');
            }, 3000);
    setTimeout(
            function ()
            {
                $('#searchAll').show();
                $('#searchAll').addClass('animated fadeInUp');
                $('#searchAll').removeClass('animated fadeInUp');
            }, 14500);

    setTimeout(
            function ()
            {
                $('#number1').removeClass('loading');
                $('#number1').addClass('fa fa-book animated swing');

            }, 2500);
    setTimeout(
            function ()
            {
                $('#number6').removeClass('loading');
                $('#number6').addClass('fa fa-building animated swing');

            }, 4000);
    setTimeout(
            function ()
            {
                $('#number5').removeClass('loading');
                $('#number5').addClass('fa fa-comments animated wobble');

            }, 4300);
    setTimeout(
            function ()
            {
                $('#number3').removeClass('loading');
                $('#number3').addClass('fa fa-users animated tada');

            }, 5000);
    setTimeout(
            function ()
            {
                $('#number2').removeClass('loading');
                $('#number2').addClass('fa fa-share-alt animated shake');

            }, 5500);
    setTimeout(
            function ()
            {
                $('#number4').removeClass('loading');
                $('#number4').addClass('fa fa-bank animated bounce');

            }, 6000);


    setTimeout(
            function ()
            {
                $('#number1-2').removeClass('loading');
                $('#number1-2').addClass('fa fa-book animated swing');

            }, 2500);
    setTimeout(
            function ()
            {
                $('#number6-2').removeClass('loading');
                $('#number6-2').addClass('fa fa-building animated swing');

            }, 4000);
    setTimeout(
            function ()
            {
                $('#number5-2').removeClass('loading');
                $('#number5-2').addClass('fa fa-comments animated wobble');

            }, 4300);
    setTimeout(
            function ()
            {
                $('#number3-2').removeClass('loading');
                $('#number3-2').addClass('fa fa-users animated tada');

            }, 5000);
    setTimeout(
            function ()
            {
                $('#number2-2').removeClass('loading');
                $('#number2-2').addClass('fa fa-share-alt animated shake');

            }, 5500);
    setTimeout(
            function ()
            {
                $('#number4-2').removeClass('loading');
                $('#number4-2').addClass('fa fa-lock animated bounce');

            }, 6000);



    var progress = setInterval(function () {
        var $bar = $('.main-progress-bar');
        var width = (100 * parseFloat($('.main-progress-bar').css('width')) / parseFloat($('.main-progress-bar').parent().css('width')));

        if (width >= 100) {
            clearInterval(progress);
            $('.main-progress').removeClass('active');
        } else {
            $bar.width(width + 2.5 + '%');
        }
    }, 100);

    // public
    var publicProgress = setInterval(function () {
        var $publicbar = $('.progress-bar-public');
        var width = (100 * parseFloat($('.progress-bar-public').css('width')) / parseFloat($('.progress-bar-public').parent().css('width')));

        if (width >= 100) {
            clearInterval(publicProgress);
            $('.public-progress').removeClass('active');
        } else {
            $publicbar.width(width + 30 + '%');
        }
    }, 100);

    // online profiles
    var onlineProgress = setInterval(function () {
        var $onlinebar = $('.progress-bar-online');
        var width = (100 * parseFloat($('.progress-bar-online').css('width')) / parseFloat($('.progress-bar-online').parent().css('width')));

        if (width >= 100) {
            clearInterval(onlineProgress);
            $('.online-progress').removeClass('active');
        } else {
            $onlinebar.width(width + 8 + '%');
        }
    }, 100);

    // relationships
    var relationshipsProgress = setInterval(function () {
        var $relationshipsbar = $('.progress-bar-relationships');
        var width = (100 * parseFloat($('.progress-bar-relationships').css('width')) / parseFloat($('.progress-bar-relationships').parent().css('width')));

        if (width >= 100) {
            clearInterval(relationshipsProgress);
            $('.relationships-progress').removeClass('active');
        } else {
            $relationshipsbar.width(width + 5 + '%');
        }
    }, 100);

    // criminal
    var criminalProgress = setInterval(function () {
        var $criminalbar = $('.progress-bar-criminal');
        var width = (100 * parseFloat($('.progress-bar-criminal').css('width')) / parseFloat($('.progress-bar-criminal').parent().css('width')));

        if (width >= 100) {
            clearInterval(criminalProgress);
            $('.criminal-progress').removeClass('active');
        } else {
            $criminalbar.width(width + 16 + '%');
        }
    }, 100);

    // phone
    var phoneProgress = setInterval(function () {
        var $phonebar = $('.progress-bar-phone');
        var width = (100 * parseFloat($('.progress-bar-phone').css('width')) / parseFloat($('.progress-bar-phone').parent().css('width')));

        if (width >= 100) {
            clearInterval(phoneProgress);
            $('.phone-progress').removeClass('active');
        } else {
            $phonebar.width(width + 3.5 + '%');
        }
    }, 100);

    // career
    var careerProgress = setInterval(function () {
        var $careerbar = $('.progress-bar-career');
        var width = (100 * parseFloat($('.progress-bar-career').css('width')) / parseFloat($('.progress-bar-career').parent().css('width')));

        if (width >= 100) {
            clearInterval(careerProgress);
            $('.career-progress').removeClass('active');
        } else {
            $careerbar.width(width + 5 + '%');
        }
    }, 100);

    setTimeout(
            function ()
            {
                $('.voter-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.voter').css('font-weight', 'bold');
            }, 2500);
    setTimeout(
            function ()
            {
                $('.criminal-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.criminal').css('font-weight', 'bold');
            }, 4000);
    setTimeout(
            function ()
            {
                $('.domain-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.domain').css('font-weight', 'bold');
            }, 18500);
    setTimeout(
            function ()
            {
                $('.social-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.social').css('font-weight', 'bold');
            }, 6500);
    setTimeout(
            function ()
            {
                $('.business-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.business').css('font-weight', 'bold');
            }, 10000);
    setTimeout(
            function ()
            {
                $('.dmv-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.dmv').css('font-weight', 'bold');
            }, 11000);
    setTimeout(
            function ()
            {
                $('.licenses-img').replaceWith('<i class="fa fa-check green"></i>');
                $('.licenses').css('font-weight', 'bold');
            }, 15000);

    setTimeout(
            function ()
            {
                $('.loader').replaceWith('<div class="animated fadeInUp"><i class="fa fa-check-circle-o green fa-5x"></i></div>');
            }, 17500);

    //$('.warning').delay(10000).fadeIn();

    setTimeout(
            function ()
            {
                $('#map_outer').animate({width: "17.3%"}, 1000);
            }, 4000);

    setTimeout(
            function ()
            {
                $('.searching').modal('hide');
                $('.report').removeClass('blur');
                ga('send', 'event', {eventCategory: 'load', eventAction: 'basicNameReportLoaded'});
            }, 20000);

    setTimeout(
            function ()
            {
                map._onResize();
            }, 8000);

</script>
