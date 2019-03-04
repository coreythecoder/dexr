<div class="breadcrumb-container">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li><i class="fa fa-home pr-10"></i><a href="/">dexr.</a></li>
            <li class="active">My Name Reports</li>
        </ol>
    </div>
</div>

<style>
    .dataset {
        padding:15px;
        border-radius:8px;
        min-height:100px;
        background-color:white;
        padding-left:30px;
    }
</style>
<div class="container">
    <div class='row' style='margin: 10px;'>

        <div class='row' style='margin-top:10px;'>
            <div class="col-sm-12">
                <?php if (!empty($reportList)) { ?>
                    <table class="table table-striped">
                        <?php if (isset($reportList)) echo $reportList; ?>
                    </table>            
                <?php } ?>
            </div>   

        </div>                        
    </div>