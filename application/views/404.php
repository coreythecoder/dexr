<div class="background-image" style='position:fixed;'></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-exclamation white'></i> Ah geez. Can't seem to find this page.</h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-right center-xs'>Page Not Found</div>
            </div>
        </div>
    </div>   
</div>
<div class="container">
        <style>
            .inputs .input-group[class*="col-"] {
                float: left;
            }
        </style>
    <div id="home-search" class="animated fadeInUp hidden-xs">
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="white">Wanna try again?</h1>

                </div>          
            </div>
            <div class="row">
            </div>
        </div>
        <form action="/results" method="POST" class="form-inline" style=''>   
            <div class="row">

                <div class="inputs">
                    <div class="input-group col-md-4">
                        <input type="text" required="required" name="fName" value="<?php if (isset($fname)) echo ucwords($fname); ?>" style='border-radius: 8px 0px 0px 8px;' class="form-control input-md" placeholder="First Name..." autofocus="">                    
                    </div><!-- /input-group -->
                    <div class="input-group col-md-4">
                        <input type="text" required="required" name="lName" value="<?php if (isset($lname)) echo ucwords($lname); ?>" class="form-control input-md" placeholder="Last Name...">                    
                    </div><!-- /input-group -->                
                    <div class="input-group col-md-4">
                        <select required="required" name="state" class="form-control input-md" style='border-radius: 0px 8px 8px 0px;'>
                            <option value="">State...</option>
                            <?php
                            $statesArrayFlip = statesArray(true);
                            foreach (statesArray() as $stateList) {
                                if (isset($state) && strtolower($state) == strtolower($statesArrayFlip[$stateList])) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option value='" . $statesArrayFlip[$stateList] . "' " . $selected . ">" . $stateList . "</option>";
                            }
                            ?>
                        </select>                                
                    </div><!-- /input-group -->
                </div>

            </div>
            <div class="row">             
                <div class="input-group col-xs-12 text-center">
                    <span class="input-group-btn text-center">
                        <button type="submit" style="border-radius: 8px; margin-top:8px;" class="btn btn-success btn-block btn-md" type="button">Find Em'</button>
                    </span>
                </div>
            </div>
        </form>
    </div>

    <div id="home-search-mobile" class="animated fadeInUp hidden-sm hidden-md hidden-lg">
        <br><br>
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <h1 class="white">Wanna try again?</h1>

                </div>          
            </div>
            <div class="row">
            </div>
        </div>
        <form action="/results" method="POST" class="form-inline" style=''>   
            <div class="row">
                <div class="inputs-mobile">
                    <div class="input-group col-xs-12 text-center">
                        <input type="text" required="required" name="fName" value="<?php if (isset($fname)) echo ucwords($fname); ?>" style='border-radius:8px;' class="form-control input-md" placeholder="First Name..." autofocus="">                    
                    </div><!-- /input-group -->
                    <div class="input-group col-xs-12 text-center">
                        <input type="text" required="required" name="lName" value="<?php if (isset($lname)) echo ucwords($lname); ?>" style="border-radius:8px;" class="form-control input-md" placeholder="Last Name...">                    
                    </div><!-- /input-group -->                
                    <div class="input-group col-xs-12 text-center">
                        <select required="required" name="state" class="form-control input-md" style='border-radius:8px;'>
                            <option value="">State...</option>
                            <?php
                            $statesArrayFlip = statesArray(true);
                            foreach (statesArray() as $stateList) {
                                if (isset($state) && strtolower($state) == strtolower($statesArrayFlip[$stateList])) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                echo "<option value='" . $statesArrayFlip[$stateList] . "' " . $selected . ">" . $stateList . "</option>";
                            }
                            ?>
                        </select>                                
                    </div><!-- /input-group -->
                </div>
            </div>
            <div class="row">             
                <div class="input-group col-xs-12 text-center inputs-mobile">
                    <span class="input-group-btn text-center">
                        <button type="submit" class="btn btn-success btn-md text-center" style="border-radius:8px;" type="button">Find Em'</button>
                    </span>
                </div>
            </div>
        </form>
    </div>


</div>