<?php
include_once "backend/dbconfig.php";
include "backend/AdminSessionCheck.php";
?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="alert alert-warning d-none" id="alert" role="alert">
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2 class="col-10 text-success font-weight-bold">CATEGORY TABLE</h2>
                            <div class="col-2 container d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-sm shadow font-weight-bold"
                                    data-bs-toggle="modal" id="addClick" data-bs-target="#CategoryModal">
                                    ADD CATEGORY
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="category_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"></div>
                                <div class="col-sm-12 col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table id="categoryTable"
                                        class="table table-bordered table-hover dataTable dtr-inline text-center"
                                        aria-describedby="example2_info">
                                        <thead class="bg-primary">
                                            <tr class="font-weight-bold">
                                                <th>id</th>
                                                <th>Category Name</th>
                                                <th>Parent Category</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary">
                                            <tr>
                                                <th>id</th>
                                                <th>Category Name</th>
                                                <th>Parent Category</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add/Insert Category Modal -->
<div class="modal fade" id="CategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary font-weight-bold" id="categoryForm">Add Category Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-footer">
                        <form action="backend/categoryUpdate.php" method="POST" id="cat-form">
                            <div class="mb-3">
                                <div class="mb-2" id="defaultParent">
                                    <label for="">Default Parent Category</label>
                                    <input type="text" id="updParentName" class="form-control" readonly>
                                </div>
                                <label for="" class="text-success">Category Parent</label>
                                <select name="parent_category" id="parent_category" class="form-select"
                                    aria-label="Default select example">
                                    <option value="0">No Parent</option>
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
                            <div class="mb-3">
                                <label for="" class="text-success">Category Name</label>
                                <input type="text" class="form-control" placeholder="Category Name" name="category_name"
                                    id="category_name">
                            </div>
                            <div class="mb-3">
                                <label for="" class="text-success">Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                            <input type="hidden" name="add" value="add" id="add">
                            <input type="hidden" name="cat_id" id="cat_id">
                            <div class="modal-footer">
                                <button type="button" onclick="addCategory()" id="saveBtn"
                                    class="btn btn-info btn-sm">Save</button>
                                <button type="button" onclick="updateCategory()" id="updBtn"
                                    class="btn btn-info btn-sm">Update</button>
                                <button type="button" class="btn btn-secondary btn-sm"
                                    data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('#addClick').click(function() {

    $('#cat-form')[0].reset();

    var modal = $('#CategoryModal');
    modal.find('#updBtn').hide();
    modal.find('#saveBtn').show();
    modal.find('.modal-title').html('Add Category Form');
    modal.find('#defaultParent').hide();
});

$(document).ready(function() {
    var table = $('#categoryTable').dataTable({
        "bProcessing": true,
        "autoWidth":false,
        "sAjaxSource": "data.php?table=categories",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aoColumns": [{
                mData: 'id'
            },
            {
                mData: 'parent_category', // This indicates the data field to be used for rendering
                render: function(data, type, row) { // Render function
                    var root = "Root"; // String "Root" to be displayed if parent_category is 0
                    if (row.parent_category === 0) {
                        return root;
                    } else if (row.parent_category === null || row.parent_category ===
                        undefined) {
                        return root; // Return "Root" for null or undefined values
                    } else {
                        return row.parent_category;
                    }
                }
            },
            {
                mData: 'category_name'
            },
            {
                mData: 'created_at'
            },
            {
                mData: 'updated_at'
            },
            {
                mData: 'status',
                render: function(data, type, row) {
                    return (row.status == 1) ?
                        '<p class="text-success font-weight-bold">Active</p>' :
                        '<p class="text-danger font-weight-bold">Inactive</p>';
                }
            },
            {
                mData: 'id',
                // Edit and Delete buttons
                render: function(data, type, row) {
                    var id = row.id;
                    var status = row.status;
                    
                    var btnClass = status == 1 ? 'btn-success btn-sm font-weight-bold' :
                        'btn-danger btn-sm font-weight-bold';

                    var btnText = status == 1 ? 'Active' : 'Inactive';
                    var toggleStatus = status == 1 ? 0 : 1;

                    return '<button type="button" class="btn ' + btnClass +
                        '" onclick="statusUpdate(' + id + ',' + toggleStatus + ')">' + btnText +
                        '</button>' +
                        '<button type="button" onclick="editCategory(' + id +
                        ')" class="btn btn-primary btn-sm font-weight-bold mx-1" data-bs-toggle="modal" data-bs-target="#CategoryModal">Edit</button>' +
                        '<button type="button" onclick="deleteCategory(' + id +
                        ')" class="btn btn-danger btn-sm font-weight-bold">Delete</button>';
                }
            },
        ]
    });
});


function statusUpdate(id, status) {

    $.ajax({
        url: "backend/active.php",
        type: "GET",
        data: {
            id_active: id,
            active_status: status
        },
        success: function(data) {
            $('#categoryTable').DataTable().ajax.reload(null, false);
        }
    });
}

function addCategory() {
    var form = document.querySelector('#cat-form');
    var formData = new FormData(form);

    $.ajax({
        url: "backend/categoryUpdate.php",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            var response = JSON.parse(data);
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    $("#CategoryModal").modal("hide");
                    $('#categoryTable').DataTable().ajax.reload(null, false);
                });
            } else {
                // Handle error case
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        }
    });
}


function editCategory(id) {
    var modal = $('#CategoryModal');

    modal.find('#saveBtn').hide();
    modal.find('#updBtn').show();
    modal.find('.modal-title').html('Update Category Form');
    modal.find('#defaultParent').show();
    modal.find('#add').val(null);

    // Set the category ID in a hidden input field
    $("#cat_id").val(id);

    $.ajax({
        url: "backend/categoryUpdate.php",
        type: "GET",
        data: {
            id: id
        },
        success: function(data) {
            var response = JSON.parse(data);
            if (response.status === 'success') {
                // Populate form fields with retrieved data
                $("#updParentName").val(response.data.parent_category);
                $("#category_name").val(response.data.category_name);
            } else {
                // Handle error case
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch category data. Please try again later.'
            });
        },
        complete: function() {
            // Close modal and reload table regardless of success or failure
            $("#CategoryModal").modal("hide");
            $('#categoryTable').DataTable().ajax.reload(null, false);
        }
    });
}

function updateCategory() {
    var form = document.querySelector('#cat-form');
    var formData = new FormData(form);
    $.ajax({
        url: "backend/categoryUpdate.php",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            var response = JSON.parse(data);
            if (response.status === 'success') {
                // Show a SweetAlert notification on success
                Swal.fire({
                    icon: response.status === 'success' ? 'success' : 'error',
                    title: response.status === 'success' ? 'success' : 'error',
                    text: response.message
                }).then(() => {
                    if (response.status === 'success') {
                        // If the operation was successful, close the modal and reload the table
                        $("#CategoryModal").modal("hide");
                        $('#categoryTable').DataTable().ajax.reload(null, false);
                    }
                });
            } else {
                // Handle error case
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update category. Please try again later.'
            });
        }
    });
}

function deleteCategory(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this category!",
        icon: "warning",
        showCancelButton: true, // Ensure showCancelButton is explicitly set to true
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            // User clicked "OK", proceed with deletion
            $.ajax({
                url: "backend/categoryUpdate.php",
                type: "GET",
                data: {
                    delete_id: id, // Use delete_id instead of id for deletion
                },
                success: function(data) {
                    $('#categoryTable').find("[id='" + id + "']").remove();
                    $('#categoryTable').DataTable().ajax.reload(null, false);
                }
            });
        } else {
            // User clicked "Cancel" or closed the dialog, do nothing
        }
    });
}
</script>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>