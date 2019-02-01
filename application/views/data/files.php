<div class="container-fluid">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1>Uploaded Files</h1>
            </div>          
        </div>

    </div>
    <div class="row">
        <div class="col-md-12" style="margin:10px;">
            <a class="btn btn-success pull-right" href="/admin/upload">Upload Files</a> <a class="btn btn-info pull-right" href="/admin/datasets" style="margin-right:8px;">Datasets</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <?php echo $uploadedFiles; ?>
            </table>
        </div>
    </div>
</div>
