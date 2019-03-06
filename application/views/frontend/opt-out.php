<div class="container">
    <div class='row' style='margin: 10px;'>

        <div class="main col-md-12">

            <!-- page-title start -->
            <!-- ================ -->
            <h1 class="page-title">Opt Out Request.</h1>
            <div class="separator-2"></div>
            <div class="container">
                <form method="POST" id="opt-out" name="opt_out">
                    <div class="row field">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Please provide us with accurate information below.  If the information doesn't match the registration information the record WILL NOT be removed.</p>
                            <?php echo $messages; ?>
                        </div>
                    </div>    
                    <hr>
                    <div class="row field">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your First Name</label>
                            <input type='text' class='form-control' name='first' placeholder='John' required="required" value="<?php
                            if (isset($_POST['first']) && !empty($_POST['first'])) {
                                echo $this->input->post("first");
                            }
                            ?>">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your Last Name</label>
                            <input type='text' class='form-control' name='last' placeholder='Doe' required="required" value="<?php
                            if (isset($_POST['last']) && !empty($_POST['last'])) {
                                echo $this->input->post("last");
                            }
                            ?>">
                        </div>
                    </div>
                    <div class="row field" style="margin-top:25px;">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your Current Email Address</label>
                            <input type='text' class='form-control' name='email' placeholder='you@email.com' required="required" value="<?php
                            if (isset($_POST['email']) && !empty($_POST['email'])) {
                                echo $this->input->post("email");
                            }
                            ?>">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>The Email Address Used To Register The Domain(s)</label>
                            <input type='text' class='form-control' name='reg_email' placeholder='you@email.com' required="required" value="<?php
                            if (isset($_POST['reg_email']) && !empty($_POST['reg_email'])) {
                                echo $this->input->post("reg_email");
                            }
                            ?>"><br>
                            <small><b>Please note: this is required.</b> If you do not know the email address used at the time of domain registration the domain will not be removed. If you need a hint; please visit the page that contains the obfuscated email address.</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row field">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <div class="g-recaptcha" style="display:inline-block;" data-sitekey="6LeJnJIUAAAAAPxdG9MXKiMyCIbWHeObtU3xAi_r"></div><br><br>

                            By submitting this form you're stating that this is YOUR information that you're requesting to have removed from Dexr.
                        </div>            
                    </div>
                    <div class="row field">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <button type='button' id="submit_opt" name='submit_opt' class='btn btn-default'>Submit Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>                        
</div>


