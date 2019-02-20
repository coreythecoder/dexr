<div class="container">
    <div class='row' style='margin: 10px;'>

        <div class="main col-md-12">

            <!-- page-title start -->
            <!-- ================ -->
            <h1 class="page-title">Opt Out Request.</h1>
            <div class="separator-2"></div>
            <div class="container">


                <form method="POST" id="opt-out">
                    <div class="row field">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <p>Please copy the exact profile URL and paste it into this box. If the URL does not end in a random string of numbers/letters (e.g. 580e87d803d6a4.89576221) it is not correct.</p>
                        </div>
                    </div>    
                    <hr>
                    <div class="row field">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your First Name</label>
                            <input type='text' class='form-control' name='fName' placeholder='John' required="required">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your Last Name</label>
                            <input type='text' class='form-control' name='lName' placeholder='Doe' required="required">
                        </div>
                    </div>
                    <div class="row field" style="margin-top:25px;">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>Your Current Email Address</label>
                            <input type='text' class='form-control' name='email' placeholder='you@email.com' required="required">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <label>The Email Address Used To Register The Domain(s)</label>
                            <input type='text' class='form-control' name='email' placeholder='you@email.com' required="required"><br>
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
                            <button type='submit' id="submit" class='btn btn-default' name='form'>Submit Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>                        
</div>


