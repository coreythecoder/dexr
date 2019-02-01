<style>
    .panel-body {
        margin: 0px 0px 0px 0px;
    }
</style>
<div class="background-image"></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-3 center-xs'>
                <h1 style='font-size: 20px; color:white; line-height: 1;'><i class='fa fa-list white'></i> Email > Audiences</h1>  
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
                <div class='text-center center-xs'><a href="/email/targeting" class="btn btn-default btn-xs" ><i class="fa fa-list"></i></a>   </div>
            </div>
        </div>
    </div>   
</div>





<div class="container-fluid">
    
    <div class="col-sm-12">
                    <div class="panel panel-bordered mg-b">
                    <div class="panel-body">
    
    <div class="row">
        <div class="col-md-6" style="">
            <div class="row">
                <div class="col-md-12" style="">
                    <h2 class="page-header grey" style="display: inline;">Filters</h2><br><br>
                </div>
            </div>

            <form method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        if (!empty($error)) {
                            echo $error;
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center" style="">
                        <input type="text" name="name" value="<?php if (isset($_POST['name'])) {
                            echo $_POST['name'];
                        } ?>" placeholder="Audience Label (required to save)" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>The rules below use the AND operator unless there are multiple occurences of the same field then the OR operator will be used for that field.</p>
                    </div>
                </div>
                <?php
                if (isset($_POST['search']) || isset($_POST['save']) && !empty($_POST['keyword'][0])) {
                    $i = 0;
                    foreach ($_POST['keyword'] as $keyword) {
                        if (!empty($keyword)) {
                            ?>
                            <div class="row">
                                <div class="col-md-5 text-center" style="">
                                    <select name="col[]" class="form-control">
                                        <option value="domainName" <?php
                                        if ($_POST['col'][$i] == 'domainName') {
                                            echo "selected";
                                        }
                                        ?>>Domain Name</option>
                                        <option value="registrant_city" <?php
                                        if ($_POST['col'][$i] == 'registrant_city') {
                                            echo "selected";
                                        }
                                        ?>>City</option>
                                        <option value="registrant_state" <?php
                                        if ($_POST['col'][$i] == 'registrant_state') {
                                            echo "selected";
                                        }
                                        ?>>State</option>
                                        <option value="registrant_country" <?php
                                        if ($_POST['col'][$i] == 'registrant_country') {
                                            echo "selected";
                                        }
                                        ?>>Country</option>
                                        <option value="contactEmail" <?php
                                        if ($_POST['col'][$i] == 'contactDmail') {
                                            echo "selected";
                                        }
                                        ?>>Email Address</option>
                                        <option value="registrarName" <?php
                                        if ($_POST['col'][$i] == 'registrarName') {
                                            echo "selected";
                                        }
                                        ?>>Registrar</option>
                                        <option value="registrant_name" <?php
                                        if ($_POST['col'][$i] == 'registrant_name') {
                                            echo "selected";
                                        }
                                        ?>>Registrant Name (first & last)</option>
                                        <option value="registrant_organization" <?php
                                        if ($_POST['col'][$i] == 'registrant_organization') {
                                            echo "selected";
                                        }
                                        ?>>Organization Name</option>
                                        <option value="registrant_street1" <?php
                                        if ($_POST['col'][$i] == 'registrant_street1') {
                                            echo "selected";
                                        }
                                        ?>>Street Address</option>
                                        <option value="registrant_postalCode" <?php
                                        if ($_POST['col'][$i] == 'registrant_postalCode') {
                                            echo "selected";
                                        }
                                        ?>>Zip Code</option>
                                        <option value="registrant_telephone" <?php
                                        if ($_POST['col'][$i] == 'registrant_telephone') {
                                            echo "selected";
                                        }
                                        ?>>Phone</option>
                                    </select>                 
                                </div>
                                <div class="col-md-2 text-center" style="">
                                    <select name="type[]" class="form-control">
                                        <option value="contains">Contains (regexp)</option>
                                        <option value="equals" <?php
                                        if ($_POST['type'][$i] == 'equals') {
                                            echo "selected";
                                        }
                                        ?>>Equals (exact)</option>
                                    </select>                       
                                </div>
                                <div class="col-md-5 text-center" style="">
                                    <input type="text" class="form-control" name="keyword[]" placeholder="" value="<?php
                                    if (isset($keyword)) {
                                        echo $keyword;
                                    }
                                    ?>">                        
                                </div>
                            </div>
                            <?php
                        }
                        $i++;
                    }
                } else {
                    ?>
                    <div class="row">
                        <div class="col-md-5 text-center" style="">
                            <select name="col[]" class="form-control">
                                <option value="domainName">Domain Name</option>
                                <option value="registrant_city">City</option>
                                <option value="registrant_state">State</option>
                                <option value="registrant_country">Country</option>
                                <option value="contactEmail">Email Address</option>
                                <option value="registrarName">Registrar</option>
                                <option value="registrant_name">Registrant Name (first & last)</option>
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
                            </select>                       
                        </div>
                        <div class="col-md-5 text-center" style="">
                            <input type="text" class="form-control" name="keyword[]" placeholder="">                        
                        </div>
                    </div>
<?php } ?>
                <div id="added"></div>                    
                <div class="row">
                    <div class="col-md-12 text-center" style="">
                        <div class="badge badge-success"><i class="fa fa-plus"></i></div> <a class="add noThinker" href="#">Add Another Rule</a> 
                    </div>                    
                </div>
                <div class="row text-center">
                    <div class="col-md-12 text-center" style="">
                        <input type="submit" name="search" value="Search" class="btn btn-block btn-success">   
                    </div>
                </div>
<?php if (isset($_POST['search'])) { ?>
                    <div class="row text-center">
                        <div class="col-md-12 text-center" style="">
                            <input type="submit" name="save" value="Save Audience" class="btn btn-block btn-info">   
                        </div>
                    </div>
<?php } ?>

            </form>            
        </div>
        <div class="col-md-6" style="">
            <div class="row">
                <div class="col-md-12" style="">
                    <h2 class="page-header grey" style="display: inline;">Reach</h2>          <br><br>            
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center" style="">
                    <h1><?php
                        if (empty($total)) {
                            echo "3,000,000~";
                        } else {
                            echo $total;
                        }
                        ?> Website Owners</h1>                      
                </div>
            </div>
        </div>
    </div>
                    </div></div></div>

    <div class="col-sm-12">
                    <div class="panel panel-bordered mg-b">
                    <div class="panel-body">
    <div class="row">
        <div class="col-md-12" style="margin-top:20px">
            <table class="table table-striped">
<?php echo $list; ?>
            </table>
        </div>
    </div>
                    </div></div></div>
</div>
</div>

<script>
    $(document).ready(function () {
    $(".add").on("click", function (){
    $("#added").append('<div class="row animated fadeInDown"><div class="col-md-5 text-center" style=""><select name="col[]" class="form-control"><option value="domainName">Domain Name</option><option value="registrant_city">City</option><option value="registrant_state">State</option><option value="registrant_country">Country</option><option value="contactEmail">Email Address</option><option value="registrarName">Registrar</option><option value="registrant_name">Registrant Name (first & last)</option><option value="registrant_organization">Organization Name</option><option value="registrant_street1">Street Address</option><option value="registrant_postalCode">Zip Code</option><option value="phone">Phone</option></select></div><div class="col-md-2 text-center" style=""><select name="type[]" class="form-control"><option value="contains">Contains (regexp)</option><option value="equals">Equals (exact)</option></select></div><div class="col-md-5 text-center" style=""><input type="text" class="form-control" name="keyword[]" placeholder=""></div></div>');
    });
    });
</script>