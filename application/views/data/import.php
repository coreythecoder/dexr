<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-7 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-database white'></i> Bulk Import</h1>  
            </div>
            <div class='col-md-5 col-xs-12 center-xs' style='margin-top:23px;'>
                <div class='text-right center-xs'></div>
            </div>
        </div>
    </div>   
</div>
<form method="POST">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <?php if (!empty($errors) || !empty($alerts)) { ?>
                    <div class="page-header" id="banner">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="panel panel-border mg-b">
                                    <div class="panel-body">                        
                                        <?php echo $errors; ?>
                                        <?php echo $alerts; ?>
                                    </div>
                                </div>
                            </div>          
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-md-12">                    
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="panel panel-border mg-b">
                                    <div class="panel-body">
                                        <h3>Transferred Files:</h3>
                                        <table class="table table-striped">
                                            <?php echo $uploadedFiles; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="panel panel-border mg-b">
                                    <div class="panel-body">
                                        <h3>Splits: <?php if (!empty($splitFiles) && isset($_SESSION['key-state'])) { ?><a href="/admin/data/import?importAll=true" class="btn btn-warning btn-xs">Import All</a><?php } ?></h3>
                                        <table class="table table-striped">
                                            <?php echo $splitFiles; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($_GET['load'])) { ?>                        
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-border mg-b">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <h3>Default State:</h3>
                                                    <select name="state" class="form-control" required="required">
                                                        <option value="">Choose Default State...</option>
                                                        <?php echo $states; ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <h3>Throttling:</h3>
                                                    <input type="number" class="form-control" name="throttle" value="<?php
                                                    if (isset($_POST['throttle'])) {
                                                        echo $_POST['throttle'];
                                                    } elseif (isset($_SESSION['key-throttle'])) {
                                                        echo $_SESSION['key-throttle'];
                                                    }
                                                    ?>" placeholder="Microseconds (1 millionth of a sec)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-border mg-b">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <h3>Original Fields (untouched data, public) <?php if (isset($_GET['load'])) { ?>(<?php echo $total; ?> Lines In File)<?php } ?></h3>
                                                    <p>Blank attributes will not be imported.</p>
                                                </div>       

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-striped">
                                                        <?php echo $columns; ?>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="" style="position:fixed; right:0; width:23.7%; bottom:0px; top:40px; z-index: 999; overflow: scroll;">
                <div class="panel panel-bordered mg-b">
                    <div class="panel-body">                    
                        <div>
                            <input type="submit" value="Start Import" name="submitImport" onclick="return confirm('Check your map & table capacity before continuing.')" type="submit" class="btn btn-lg btn-success btn-block">                        
                        </div>
                        <hr style="margin-bottom: 10px; margin-top:10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div style="position:relative; top:10px;">
                                    <?php
                                    if (isset($_SESSION['key-mapDescription'])) {
                                        echo "<strong>Current Map Name:</strong><br>" . $_SESSION['key-mapName'] . '<br><br>';
                                    }
                                    if (isset($_SESSION['key-mapDescription'])) {
                                        echo "<strong>Map Description:</strong><br>" . $_SESSION['key-mapDescription'] . '<br><br>';
                                    }
                                    ?>                            
                                </div>
                                <hr style="margin-bottom: 10px; margin-top:10px;">
                                <h6>Current Capacity 
                                    <button type="button" class="btn btn-info btn-xs pull-right" data-toggle="modal" data-target="#myModal">
                                        Change Capacity
                                    </button>
                                </h6>
                                <div class="row">
                                    <?php echo $tables; ?>
                                </div>
                                <hr style="margin-bottom: 10px; margin-top:10px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">

                                <h6>Load Existing Map</h6>
                                <select name="loadMapName" class="form-control">
                                    <option value="">Select a Map...</option>
                                    <?php echo $mapList; ?>
                                </select>
                                <input name="loadMap" type="submit" class="btn btn-info btn-sm btn-block" value="Load Map To Session">
                                <input name="deleteMap" type="submit" onclick="return confirm('Forever delete map?')" class="btn btn-danger btn-sm btn-block" value="Delete Map from DB">
                                <hr style="margin-bottom: 10px; margin-top:10px;">
                                <h6>Save New Map</h6>
                                <input type="text" class="form-control" name="mapName" placeholder="Map Name... (leave blank to save to session only)">
                                <textarea name="mapDescription" class="form-control" placeholder="Description (optional)"></textarea>
                                <input name="saveMap" type="submit" class="btn btn-warning btn-sm btn-block" value="Save This Map">                 
                                <hr style="margin-bottom: 10px; margin-top:10px;">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Provisioned Capacity (r/w)</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Load Capacity Settings</h6>
                            <select name="loadCapacityName" class="form-control">
                                <option value="">...</option>
                                <?php echo $settingsList; ?>
                            </select>
                            <input type="submit" class="btn btn-block btn-success btn-xs" name="loadCapacity" value="Load Settings">
                            <input type="submit" class="btn btn-block btn-danger btn-xs" name="deleteCapacity" value="Delete Settings from DB">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Save Settings</h6>
                            <input type="text" name="saveCapacityName" class="form-control" placeholder="Settings Description">
                            <input type="submit" class="btn btn-block btn-info btn-xs" name="saveCapacity" value="Save Settings" onclick="return confirm('This will overite capacities with same name!')">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Current</h6>
                            <p>Both read & write must be changed for AWS to not throw an exception.</p>
                            <p><i class="fa fa-exclamation-triangle" style="color:red;"></i> Limit 4 Decreases Per 24 Hours!</p>
                            <?php echo $editableTables; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-xs" data-dismiss="modal">Close</button>
                    <input type="submit" name="commitSettings" class="btn btn-success btn-xs" value="Commit">
                </div>
            </form>
        </div>
    </div>
</div>

<?php if (isset($_POST['loadCapacity']) || isset($_POST['deleteCapacity']) || isset($_POST['saveCapacity'])) { ?>
    <script>
        $('#myModal').modal('show');
    </script>
<?php } ?>
