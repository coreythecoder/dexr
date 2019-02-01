<div class="container">
    <div class="row animated fadeInUp">
        <div class="col-md-5 center-block-e">

            <a href="/">
                <div class="login-page-heade logo text-center" style="font-size:5em;">
                dexr.
                </div>
            </a>
            <br><br>
            <div class="login-pag">
                <form method="POST" action="/login/pro"
                <div class="input-group">
                    <span class="input-group-addon white-form-bg"><span class="fa fa-user"></span></span>
                    <input type="text" name="email" class="form-control" placeholder="<?php echo lang("ctn_303") ?>" autofocus>
                </div><br />

                <div class="input-group">
                    <span class="input-group-addon white-form-bg"><span class="fa fa-lock"></span></span>
                    <input type="password" name="pass" class="form-control" placeholder="<?php echo lang("ctn_180") ?>">
                </div>
                <p class="decent-margin"><input type="submit" class="btn btn-primary btn-block" value="Sign In"></p>

                <?php if (!$this->settings->info->disable_social_login && 1 == 2) : ?>
                    <div class="text-center decent-margin-top">
                        Or sign In Using<br><br>
                        <div style="position:relative; left:10px; margin-bottom:20px;">
                            <div class="btn-group">
                                <a href="<?php echo site_url("login/twitter_login") ?>" class="" >
                                    <img src="/images/social/twitter.png" height="20" class='social-icon' />
                                </a>
                            </div>

                            <div class="btn-group">
                                <a href="<?php echo site_url("login/facebook_login") ?>" class="" >
                                    <img src="/images/social/facebook.png" height="20" class='social-icon' />
                                </a>
                            </div>

                            <div class="btn-group">
                                <a href="<?php echo site_url("login/google_login") ?>" class="" >
                                    <img src="/images/social/google.png" height="20" class='social-icon' />
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php echo form_close() ?>

            </div>
            <p class=" text-center" style=''><a class="white small" href="/register">Create Account</a> <span class="white">|</span> <a href="<?php echo site_url("login/forgotpw") ?>" class='white small'>Forgot Password</a></p>

        </div>
    </div>
</div>