<?php include "backend/AdminSessionCheck.php"; ?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<?php
include "backend/dbconfig.php";
if (isset($_GET['editid'])) {

    $editid = $_GET['editid'];
    $select_news = "SELECT * FROM `news` WHERE id = $editid";
    $query_news = mysqli_query($conn, $select_news);
    if ($query_news) {
        if (mysqli_num_rows($query_news) > 0) {
            $row_news = mysqli_fetch_assoc($query_news);
        }
    } else {
        echo "error" . mysqli_error($conn);
    }
    $selectedTags = explode(',', $row_news['tags']);
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- /.content-header -->
    <section class="content">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-success font-weight-bold">Edit News Blogs</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item text-success active font-weight-bold">Edit News Blog</li>
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
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-10">
                            <form id="updateNews" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="editId" value='<?php echo $editid ?>' id="">
                                    <div class="col-md-12 form-group">
                                        <label for="heading" class="form-label">Heading</label>
                                        <input type="text" value='<?php echo str_replace("'", ' ', $row_news['heading']); ?>'
                                            name="heading" class="form-control" id="heading">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="category" class="form-label">Category</label>
                                        <select name="category" id="category" class="select2 form-select"
                                            aria-label="Default select example">
                                            <?php
                                            $query = "SELECT * FROM `categories` WHERE parent_category = '0'";
                                            $result = mysqli_query($conn, $query);

                                            $sql = "SELECT * FROM `news`";
                                            $result2 = mysqli_query($conn, $sql);
                                            $fetch = mysqli_fetch_assoc($result2);
                                            $category_id = $fetch['category_id'];
                                            while($row = mysqli_fetch_assoc($result)){
                                                if($row['id'] == $category_id){
                                                    $category = $row['id'];
                                                }
                                            }
                                            ?>
                                            <option value='<?php echo $category; ?>' selected>
                                                <?php
                                                $query = "SELECT * FROM `categories` WHERE id = $category_id";
                                                $result = mysqli_query($conn, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                if ($row['category_name']) {
                                                    echo $row['category_name'];
                                                } else {
                                                    echo "No Category";
                                                }
                                                ?>
                                            </option>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="tags" class="form-label">Related Tags</label>
                                        <select id="multipleSelect" name="tags[]" class="select2 form-control"
                                            multiple="multiple" data-placeholder="Select a State">
                                            <?php
                                            $query_tags = "SELECT * FROM `tags`";
                                            $result_tags = mysqli_query($conn, $query_tags);
                                            if ($result_tags) {
                                                if (mysqli_num_rows($result_tags) > 0) {
                                                    while ($row_tags = mysqli_fetch_assoc($result_tags)) {
                                                        ?>
                                                        <option value="<?php echo $row_tags['tag_name']; ?>" <?php echo in_array($row_tags['tag_name'], $selectedTags) ? 'selected' : '' ?>>
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
                                        <label for="editor" class="form-label">Add Content</label>
                                        <textarea name="editor" class="col-10" id="editor" rows="10" cols="50">
                                        <?php echo $row_news['content']; ?>
                                                </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="image" class="form-label">Image</label>
                                        <input class="form-control" type="file" id="image" name="image">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="prev-image" class="form-label">Image Preview</label><br>
                                        <img src="<?php echo "backend/" . $row_news['image']; ?>" height="100"
                                            id="prev-image" alt="preview">
                                    </div>
                                </div>
                                <button type="button" onclick="updateNews()" class="btn btn-success btn-sm form-control font-weight-bold"
                                    name="submit">Update
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
    $(document).ready(function () {
        CKEDITOR.replace('editor', {
            height: 200,
            filebrowserUploadUrl: 'backend/EditorImage.php',
            filebrowserUploadMethod: 'form',
        });
    });
</script>

<script type="text/javascript">
    function updateNews() {
        var form = document.querySelector('#updateNews');
        var formData = new FormData(form);
        formData.append('editor', CKEDITOR.instances.editor.getData());

        $.ajax({
            type: 'POST',
            url: 'backend/updateNewsPost.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // console.log(response);
                window.location.href = "manageNewsBlog.php";
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        $('.select2').select2({
            tags: true, // Allows user to create new tags
            tokenSeparators: [',', ' '], // Define separators for multiple tags
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                var found = false;
                // Check if the term already exists in the options
                $('.select2 option').each(function () {
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

    $('#image').change(function () {
        var input = this;
        var Preview = $('#prev-image');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                Preview.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            Preview.attr('src', "backend/uploads/dummy.jpg");
        }
    });
</script>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>