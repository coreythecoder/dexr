
<div class="container" style="padding-left:0px; padding-right:0px;">
    <div class='col-md-12 animated fadeInUp'>
        <a href="/">
            <div class="login-page-heade logo text-center" style="font-size:5em; margin-bottom:40px;">
                dexr.
            </div>
        </a>
        <div class='inner blue-background'>
            <div class="row">
                <div class="col-md-12 center-block-e">
                    <div class="login-page">
                        <div class="row">   

                            <div class="col-md-6" style='padding-left:0px'>
                                <div class="page-header" style="margin-top:-10px;"><h3><i class="fa fa-user"></i> Create a Free Account.</h3></div>
                                <?php if (!empty($fail)) : ?>
                                    <div class="alert alert-danger"><?php echo $fail ?></div>
                                <?php endif; ?>
                                <?php echo form_open("/register?" . $_SERVER['QUERY_STRING'], array("class" => "form-horizontal")) ?>
                                    
                                <div class="form-group">
                                    <label for="name-in" class="col-md-3 label-heading"><?php echo lang("ctn_218") ?></label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="name-in" name="first_name" value="<?php if (isset($first_name)) echo $first_name ?>" autofocus="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email-in" class="col-md-3 label-heading"><?php echo lang("ctn_214") ?></label>
                                    <div class="col-md-9">
                                        <?php if (!isset($_SESSION['email'])) { ?>
                                            <input type="email" class="form-control" id="email-in" name="email" value="<?php if (isset($email)) echo $email; ?>">
                                        <?php } else { ?>
                                            <?php echo strip_tags($_SESSION['email']); ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password-in" class="col-md-3 label-heading"><?php echo lang("ctn_216") ?></label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" id="password-in" name="password" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cpassword-in" class="col-md-3 label-heading"><?php echo lang("ctn_217") ?></label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" id="cpassword-in" name="password2" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-left:-15px;">
                                <div class='row'>
                                    <div class='col-md-12'>
                                        <div style="margin-top:-10px;"><h3>America's #1 B2B Search Engine</h3></div>
                                        <p>Create an account at America's top business search engine.  You'll be able to create data subsets, save filters & send data to more than 1000 other apps.  Apps such as Agile CRM, Twilio, Gmail & many more.</p>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-12 text-center'>
                                        <span class="stateface stateface-replace" style="font-size:180px; color:#5dc3de; position:relative; bottom:20px;">z</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 center-block-e" style="margin-left:-30px;"><br>
                                <button onClick="ga('send', 'event', {eventCategory: 'buttonClicks', eventAction: 'register', eventLabel: ''});" type="submit" name="s" class="btn btn-success btn-block" />Next <i class="fa fa-caret-right"></i></button>
                                <?php echo form_close() ?><br>
                                <p class="decent-margin text-center">Already have an account?<br><a href="<?php echo site_url("login") ?>" class="" >Sign In</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>