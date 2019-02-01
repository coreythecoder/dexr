<div class="background-image"></div>
<div class='list-title'>
    <div class="page-header inner list-sub" style="z-index: 999; background-color:#5BC506;">
        <div class='row'>
            <div class='col-md-3 center-xs'>
                <h1 style='font-size: 24px; color:white; line-height: 1;'><i class='fa fa-plus white'></i> Create</h1>  
            </div>
        </div>
    </div>   
</div>
<div class="container">
    <div class='row' style='margin-top:10px;'>

        <div class="col-sm-12">
            <div class="panel panel-bordered mg-b">
                <div class="panel-heading">
                    <div class='row'>
                        <div class='col-md-6'>
                            Property Setup Wizard
                        </div>
                        <div class='col-md-6 text-right'>
                            Step 1 of 6 | Configuring Route53
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class='row'>
                        <div class='col-md-12 text-center' id='domainQuestion'>
                            <h4><i style="" class="green fa fa-cogs fa-3x"></i></h4><h4>Have you bought a domain name?</h4>
                            <p>
                                Note: If you've bought a domain name from another registrar you'll need to know how to point it's nameservers to Amazon's Route53 servers.
                            </p>
                            <div class='row buttons'>
                                <div class='col-xs-6 text-right'>
                                    <button class='btn btn-info' id='domainYes'>Yes</button>
                                </div>
                                <div class='col-xs-6 text-left'>
                                    <button class='btn btn-info' id='domainNo'>No</button>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-12 text-center display-none' id='hasDomain'>
                            <h4><i style="" class="green fa fa-cogs fa-3x"></i></h4><h4>What is the name of the domain?</h4>
                            <p>
                                Note: Please only enter the primary domain name and no subdomains. For example, domain.com and <strong>not</strong> www.domain.com.
                            </p>
                            <div class='row buttons'>
                                <div class='col-xs-12 text-center'>
                                    <form method='POST' name='existingURL'>
                                        <input type='url' name='url' class='form-control' placeholder='https://domain.com'>
                                        <input type='submit' class='btn btn-info' value='Next' name='submitURL'>
                                    </form
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>                            
        </div>

    </div>
</div>