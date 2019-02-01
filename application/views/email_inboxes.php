<div class="background-image"></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-3 center-xs'>
                <h1 style='font-size: 20px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Email > Inboxes</h1>  
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/campaigns"><i class="fa fa-lightbulb-o"></i> Campaigns</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/targeting"><i class="fa fa-bullseye"></i> Targeting</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/inboxes"><i class="fa fa-inbox"></i> Inboxes</a></div>
            </div>
            <div class='col-md-2 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-center center-xs'><a style="color: #fff;" href="/email/templates"><i class="fa fa-pencil-square"></i> Templates</a></div>
            </div>
            <div class='col-md-1 col-xs-12 center-xs' style='margin-top:12px; margin-bottom:-8px;'>
                <div class='text-center center-xs'><a href="/email/inboxes/create" class="btn btn-default btn-xs" ><i class="fa fa-plus"></i></a>   </div>
            </div>
        </div>
    </div>   
</div>


<div class="container-fluid">

    <div class="row">
        <div class="col-md-12" style="margin-top:20px">

            <?php echo $list; ?>

        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
    $(".add").on("click", function (){
    $("#added").append('<div class="row animated fadeInDown"><div class="col-md-5 text-center" style=""><select name="col[]" class="form-control"><option value="domainName">Domain Name</option><option value="registrant_city">City</option><option value="registrant_state">State</option><option value="registrant_country">Country</option><option value="contactEmail">Email Address</option><option value="registrarName">Registrar</option><option value="registrant_name">Registrant Name (first & last)</option><option value="registrant_organization">Organization Name</option><option value="registrant_street1">Street Address</option><option value="registrant_postalCode">Zip Code</option><option value="phone">Phone</option></select></div><div class="col-md-2 text-center" style=""><select name="type[]" class="form-control"><option value="contains">Contains (regexp)</option><option value="equals">Equals (exact)</option></select></div><div class="col-md-5 text-center" style=""><input type="text" class="form-control" name="keyword[]" placeholder=""></div></div>');
    });
    });
</script>