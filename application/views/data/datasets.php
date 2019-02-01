<div class="container-fluid">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2>Datasets</h2>
            </div>          
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin:10px;">
            <a class="btn btn-info pull-right" href="/admin/files">Files</a>
        </div>
    </div>
    <div class="page-header">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3>Create New Dataset</h3>
            </div>          
        </div>
    </div>
    <form method="POST">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <input type="text" class="form-control" name="name" placeholder="Dataset Name">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <input type="text" class="form-control" name="fileName" placeholder="Original File Name">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <input type="text" class="form-control" name="source" placeholder="Data Source (Exact URL)">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <textarea class="form-control" name="description" placeholder="Description"></textarea>
        </div>
    </div>
        <button type="submit" class="btn btn-success" name="newDatasetSubmit">Create</button>
    </form>
    <div class="row">
        <div class="col-md-12"><br><br>
            <table class="table table-striped">
                <tr><th>ID</th><th>Name</th><th>Description</th><th>File Name</th><th>Source</th></tr>
                <?php echo $datasets; ?>
            </table>
        </div>
    </div>
</div>
