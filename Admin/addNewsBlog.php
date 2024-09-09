<?php
include "backend/dbconfig.php";
include "backend/AdminSessionCheck.php";
?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- /.content-header -->
    <section class="content">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-success font-weight-bold">Add News Blogs</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-success active font-weight-bold">Add News Blog</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <div class="container-fluid">
            <div class="card-body shadow">
                <div id="category_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="addNews">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="heading" class="form-label">Heading</label>
                                        <input type="text" name="heading" class="form-control" id="heading">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" id="category" class="select2 form-select"
                                            aria-label="Default select example">
                                            <option value="0">choose Category</option>
                                            <?php
                                            $query = "SELECT * FROM `categories` WHERE parent_category = '0'";
                                            $result = mysqli_query($conn, $query);
                                            if ($result) {
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        ?>
                                            <option value="<?php echo $row['id']; ?>">
                                                <?php echo $row['category_name']; ?>
                                            </option>
                                            <?php }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control" type="file" id="image" name="image">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="tags" class="form-label">Related Tags</label>
                                        <select id="multipleSelect" style="width:100%" name="tags[]" class="select2 form-control"
                                            multiple="multiple" data-placeholder="Select a State">
                                            <?php
                                            $query_tags = "SELECT * FROM `tags_tbl`";
                                            $result_tags = mysqli_query($conn, $query_tags);
                                            if ($result_tags) {
                                                if (mysqli_num_rows($result_tags) > 0) {
                                                    while ($row_tags = mysqli_fetch_assoc($result_tags)) {
                                                        ?>
                                            <option value="<?php echo $row_tags['tag_name']; ?>">
                                                <?php echo $row_tags['tag_name']; ?>
                                            </option>
                                            <?php }
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="editor" class="col-2 form-label">Add Content</label>
                                        <textarea name="editor" class="col-10" id="editor" rows="10" cols="50">
                                                </textarea>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm form-control font-weight-bold"
                                    name="submit" onclick="addNews()">Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="ckeditor/ckeditor.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    CKEDITOR.replace('editor', {
        height: 400,
        filebrowserUploadUrl: 'backend/EditorImage.php',
        filebrowserUploadMethod: 'form',
        // Define the allowed content
        allowedContent: true, // Allow all content except what is disallowed explicitly
        // Define the content filtering rules
        extraAllowedContent: 'img[alt,src]', // Allow img tags with alt and src attributes
        disallowedContent: 'script; *[on*]', // Disallow script tags and all elements with inline event handlers
        // Define additional configurations if necessary
    });
});
</script>

<script type="text/javascript">
function addNews() {
    var form = document.querySelector('#addNews');
    var formData = new FormData(form);
    formData.append('editorData', CKEDITOR.instances.editor.getData());

    $.ajax({
        type: 'POST',
        url: 'backend/addNewsPost.php',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire(response);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

$(document).ready(function() {
    $('.select2').select2({
        tags: true, // Allows user to create new tags
        tokenSeparators: [',', ' '], // Define separators for multiple tags
        createTag: function(params) {
            var term = $.trim(params.term);

            if (term === '') {
                return null;
            }

            var found = false;
            // Check if the term already exists in the options
            $('.select2 option').each(function() {
                if ($.trim($(this).text()) === term) {
                    found = true;
                    return false; // Exit the loop early
                }
            });

            if (found) {
                return null; // Return null to prevent tag creation
            }

            return {
                id: term,
                text: term,
                newTag: true // Add custom property to identify new tag
            };
        }
    });
});
</script>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>