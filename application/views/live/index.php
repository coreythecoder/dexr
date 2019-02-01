<style>.container .row { margin-top:8px;} h1 {color:white;}p{color:white; margin:15px;}</style>
<div class="background-image"></div>
<div class="container">
    <form method="POST" id="form" action="http://app.dexr.io">
    <div class="row" style="margin-top:20%;">
        <h1>Business Owner & Webmaster Database</h1>
        <p>We've compiled millions of historical WHOIS data points & made them easily searchable.  5,000 to 50,000 domain contacts added daily at 12pm EST.</p>
        <div class="col-md-12" style="">                            
           
            <div class="row">
                <div class="col-md-12">
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 text-center" style="">
                    <select name="col[]" class="form-control">
                        <option value="domainName">Domain Name</option>
                        <option value="registrant_city">City</option>
                        <option value="registrant_state">State</option>
                        <option value="registrant_country">Country</option>
                        <option value="contactEmail">Email Address</option>
                        <option value="registrarName">Registrar</option>
                        <option value="registrant_name">Registrant Name (first &amp; last)</option>
                        <option value="registrant_organization">Organization Name</option>
                        <option value="registrant_street1">Street Address</option>
                        <option value="registrant_postalCode">Zip Code</option>
                        <option value="registrant_telephone">Phone</option>
                    </select>                 
                </div>
                <div class="col-md-2 text-center" style="">
                    <select name="type[]" class="form-control">
                        <option value="contains">Contains (regexp)</option>
                        <option value="equals">Equals (exact)</option>
                        <option value="not_equals">Not Equals (exact)</option>
                        <option value="not_contains">Not Contains (regexp)</option>
                    </select>                       
                </div>
                <div class="col-md-5 text-center" style="">
                    <input required="" type="text" class="form-control" name="keyword[]" placeholder="" value="">                        
                </div>
            </div>
            <div id="added"></div>                    
            <div class="row">
                <div class="col-md-12 text-center" style=""><br>
                    <a class="add noThinker" href="#"><span class="badge badge-success"><i class="fa fa-plus"></i></span> Add Another Rule</a> <br><br>
                <button type="submit" name="search" class="btn btn-success">Search</button>
                </div>                    
            </div>
        </div>
    </div>
    </form>
    <script>
    $(document).ready(function () {
            $('#editFilters').modal('show');
        $(".add").on("click", function () {
            $("#added").append('<div class="row animated fadeInDown"><div class="col-md-5 text-center" style=""><select name="col[]" class="form-control"><option value="domainName">Domain Name</option><option value="registrant_city">City</option><option value="registrant_state">State</option><option value="registrant_country">Country</option><option value="contactEmail">Email Address</option><option value="registrarName">Registrar</option><option value="registrant_name">Registrant Name (first & last)</option><option value="registrant_organization">Organization Name</option><option value="registrant_street1">Street Address</option><option value="registrant_postalCode">Zip Code</option><option value="phone">Phone</option></select></div><div class="col-md-2 text-center" style=""><select name="type[]" class="form-control"><option value="contains">Contains (regexp)</option><option value="equals">Equals (exact)</option><option value="not_equals">Not Equals (exact)</option><option value="not_contains">Not Contains (regexp)</option></select></div><div class="col-md-5 text-center" style=""><input type="text" class="form-control" name="keyword[]" placeholder=""></div></div>');
        });

        $("#saveAutomate").on("click", function () {
            $("#automate-options").show();
        });

        $("#saveButton").on("click", function () {
            $("#automate-options").hide();
        });

        $(".panel").on("click", function () {
            if ($("#save-text").val() !== "") {

                $("#panel-email").on("click", function () {
                    $("#hidden_campaign_type").val("email_redirect");
                    $("#form").submit();
                });
                $("#panel-robo").on("click", function () {
                    $("#hidden_campaign_type").val("robo_redirect");
                    $("#form").submit();
                });
                $("#panel-sms").on("click", function () {
                    $("#hidden_campaign_type").val("sms_redirect");
                    $("#form").submit();
                });
                $("#panel-alarm").on("click", function () {
                    $("#hidden_campaign_type").val("alarm_redirect");
                    $("#form").submit();
                });


            } else {
                alert("Please provide a filter label.");
                $("#save-text").focus();
            }
        });

        $(function () {
            $('#userFilters').change(function () {
                if ($('#userFilters').val() !== "") {
                    this.form.submit();
                }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    });
</script>
</div>