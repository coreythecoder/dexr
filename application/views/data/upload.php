<div class="container-fluid">
    <div class="page-header" id="banner">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h1>Upload CSV or Tab Delimited Files</h1>
            </div>          
        </div>

    </div>
    <div class="row">
        <div class="col-md-12" style="margin:10px;">
            <a class="btn btn-success pull-right" href="/admin/data/import">Importer</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form id="form" method="post" action="dump.php">
                <div id="uploader">
                    <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
                </div>
                <br />

            </form>

            <script type="text/javascript">
                // Initialize the widget when the DOM is ready
                $(function () {
                    $("#uploader").plupload({
                        // General settings
                        runtimes: 'html5,flash,silverlight,html4',
                        url: '/upload.php',
                        // User can upload no more then 20 files in one go (sets multiple_queues to false)
                        max_file_count: 20,
                        chunk_size: '1mb',
                        filters: {
                            // Maximum file size
                            max_file_size: '10000mb',
                            // Specify what files to browse for
                            mime_types: [
                                {title: "CSV files", extensions: "csv"}
                            ]
                        },
                        // Rename files by clicking on their titles
                        rename: true,
                        // Sort files
                        sortable: true,
                        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                        dragdrop: true,
                        // Views to activate
                        views: {
                            list: true,
                            thumbs: true, // Show thumbs
                            active: 'thumbs'
                        },
                        // Flash settings
                        flash_swf_url: '/plupload/js/Moxie.swf',
                        // Silverlight settings
                        silverlight_xap_url: '/plupload/js/Moxie.xap'
                    });


                    // Handle the case when form was submitted before uploading has finished
                    $('#form').submit(function (e) {
                        // Files in queue upload them first
                        if ($('#uploader').plupload('getFiles').length > 0) {

                            // When all files are uploaded submit form
                            $('#uploader').on('complete', function () {
                                $('#form')[0].submit();
                            });

                            $('#uploader').plupload('start');
                        } else {
                            alert("You must have at least one file in the queue.");
                        }
                        return false; // Keep the form from submitting
                    });
                });
            </script>
        </div>
    </div>
</div>
