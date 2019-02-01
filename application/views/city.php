<div class="background-image" style="position:fixed;"></div>

<div class="container-fluid">


    <div id="city-search" class="animated fadeInUp hidden-xs">
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="white">Find People in <?php echo ucwords(unformatForSearch($city)).', '.strtoupper($state); ?>.</h1>

                </div>          
            </div>
            <div class="row">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form action="/results" method="GET" class="form-inline">
                    <div class="form-group">

                        <input type="text" name="fName" class="form-control" placeholder="John"><br>
                        <label class="white">First Name</label>
                    </div>
                    <div class="input-group">

                        <input type="text" name="lName" class="form-control" placeholder="Doe">
                        <label class="white">Last Name</label>
                        <span class="input-group-btn" style="position:relative; bottom:11px;">
                            <button type="submit" class="btn btn-success" type="button">Find Em'</button>
                        </span>

                    </div><!-- /input-group -->
                </form>                
            </div>
        </div>
    </div>
    
    <div class="animated fadeInUp hidden-md hidden-lg text-center" style="position:relative; top:40px; width:90%;">
                <div class="page-header" id="banner">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-10">
                            <h1 class="white">Find People in <?php echo ucwords(unformatForSearch($city)).', '.strtoupper($state); ?>.</h1>

                        </div>          
                    </div>
                    <div class="row">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="/results" method="GET" class="form-inline">
                            <div class="form-group text-left">

                                <input type="text" name="fName" class="form-control" placeholder="John" autofocus>
                                <label class="white">First Name</label>
                            </div>
                            <div class="input-group text-left">

                                <input type="text" name="lName" class="form-control" placeholder="Doe">
                                <label class="white">Last Name</label>
                                <span class="input-group-btn" style="position:relative; bottom:11px;">
                                    <button type="submit" class="btn btn-success" type="button">Find Em'</button>
                                </span>

                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>
            </div>

    <div class="row">
        <div class="col-md-12" style="margin-top:350px;">
            <div class="row">
                <div class="col-md-12">
                   <?php echo $crumbs; ?> 
                </div>
            </div>
            
            <?php echo $alpha; ?>
        </div>
    </div>
</div>
