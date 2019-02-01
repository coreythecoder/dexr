<div class="container-fluid">
        <div class="page-header" id="banner">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1>Find People In <?php $states = statesArray(); echo $states[$state]; ?>.</h1>
                    <p class="lead">Choose A City</p>
                </div>          
            </div>
            <div class="row">
                <?php echo $cities; ?>
            </div>
        </div>
    
