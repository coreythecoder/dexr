<div class="container">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1>Opt-Out of Yoliya.</h1>
                <p class="lead">If you'd like to have your records removed from yoliya.com please submit the request form below.</p>
            </div>
            <div class="field">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <?php echo $messages; ?>
                </div>
            </div> 
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3>Important</h3>
                <p>All of our data is sourced from public records.  We do not publish private information.  We will not hide criminal records contained in purchased reports unless those records have been expunged or officially sealed/removed. Please understand that we're not required to remove information & we provide this service as a courtesy to our users. Due to the size of our datasets and the complexities of our systems it's nearly impossible to completely remove a single record and all data associated/linked. We will do our best but there is no guarantee of complete removal.</p>
                <p>This form is thorough and is designed to permanently remove a person's information unlike a simple URL removal. Please fill in all fields with accurate information to make sure your record does not reappear.</p>
                <h3>Inaccurate Information & Updates</h3>
                <p>If you've found inaccurate information please update the public record with the governing agency where you've found the discrepancy. We update our records as often as possible and our web site may eventually reflect those changes.</p>
                <h3>Limitation</h3>
                <p>This form will only remove your public record from yoliya.com and not the original source at which you submitted the information or any other web sites that may have published your records.</p>
            </div>
        </div>
    </div>

    <form method="POST">
        <div class="row field">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <p>Please copy the exact profile URL and paste it into this box. If the URL does not end in a random string of numbers/letters (e.g. 580e87d803d6a4.89576221) it is not correct.</p>
                <input type='text' class='form-control' name='url' value='<?php
                if (isset($_GET['url']) && !empty($_GET['url'])) {
                    echo $_GET['url'];
                }
                ?>' placeholder='Example: https://yoliya.com/state/city/first.last/99od4k4h499g9d87dkfv5443kk'  required="required">
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
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>Email Address</label>
                <input type='text' class='form-control' name='email' placeholder='you@email.com' required="required">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row field">
                    <div class="col-md-4 col-sm-12">
                        <label>Birth Month</label>
                        <input type='text' class='form-control' name='birthMonth' placeholder='09' maxlength="2" required="required">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label>Birth Day</label>
                        <input type='text' class='form-control' name='birthDay' placeholder='25' maxlength="2" required="required">
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <label>Birth Year</label>
                        <input type='text' class='form-control' name='birthYear' placeholder='1906' maxlength="4" required="required">
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="row field">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>Address</label>
                <input type='text' class='form-control' name='address' placeholder='123 Main St.' required="required">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>City</label>
                <input type='text' class='form-control' name='city' placeholder='Dallas' required="required">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>State (2 Character Abbreviation)</label>
                <input type='text' class='form-control' name='state' maxlength="2" placeholder='TX' required="required">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>Zip</label>
                <input type='text' class='form-control' name='zip' placeholder='75089' required="required">
            </div>            
            <div class="col-lg-6 col-md-6 col-sm-6">
                <label>Phone (no dashes or parenthesis)</label>
                <input type='text' maxlength="10" class='form-control' name='phone' placeholder='5555555555' required="required">
            </div>
        </div>
        <hr>
        <div class="row field">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <input type='checkbox' name='agree' required="required">
                By checking this box you're stating that this is your information you're requesting to have removed from yoliya.com.<br>You are also confirming that you have read and agree to our <a href="/privacy" rel="nofollow" target="_blank">Privacy Policy</a>.
            </div>            
        </div>
        <div class="row field">
            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                <button type='submit' class='btn btn-success' name='form'>Submit Request</button>
            </div>
        </div>
    </form>
</div>