<?php
include "backend/dbconfig.php";
include "backend/AdminSessionCheck.php";
?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="alert alert-warning d-none" id="alert3" role="alert">
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2 class="col-10 text-success font-weight-bold">TAGS TABLE</h2>
                            <div class="col-2 container d-flex justify-content-end">
                                <button type="button" class="btn btn-success btn-sm shadow font-weight-bold"
                                    data-bs-toggle="modal" id="addClick" data-bs-target="#tagsModal">
                                    ADD TAGS
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
                                <div class="col-sm-12">
                                    <table id="tagsTable"
                                        class="table table-bordered table-hover dataTable dtr-inline text-center"
                                        aria-describedby="example2_info">
                                        <thead class="bg-primary">
                                            <tr class="font-weight-bold">
                                                <th>id</th>
                                                <th>Tag Name</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary">
                                            <tr>
                                                <th>id</th>
                                                <th>Tag Name</th>
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
<!-- Add/Edit Tags -->
<div class="modal fade" id="tagsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-primary font-weight-bold" id="categoryForm">Add Tags Form</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card shadow">
                    <div class="card-footer">
                        <form action="backend/tagsUpdate.php" method="POST" id="tag-form">
                            <div class="mb-3">
                                <label for="" class="text-success">Tags Name</label>
                                <input type="text" class="form-control" placeholder="Tag Name" name="tag_name"
                                    id="tag_name">
                            </div>
                            <div class="mb-3">
                                <label for="" class="text-success">Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div>
                            <input type="hidden" name="add" value="add" id="add">
                            <input type="hidden" name="tag_id" id="Tag_id">
                            <div class="modal-footer">
                                <button type="button" onclick="addTags()" id="saveBtn"
                                    class="btn btn-info btn-sm">Save</button>
                                <button type="button" onclick="updateTags()" id="updBtn"
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

$(document).ready(function() {
    var table = $('#tagsTable').dataTable({
        "bProcessing": true,
        "autoWidth":false,
        "sAjaxSource": "data.php?table=tags",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aoColumns": [
            {
                mData: 'id'
            },
            {
                mData: 'tag_name'
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

                    var output = '<button type="button" class="btn ' + btnClass +
                        '" onclick="tagsStatusUpdate(' + id + ',' + toggleStatus + ')">' + btnText +
                        '</button>';
                        
                    output += '<button type="button" onclick="editTags(' + id + ')" class="btn btn-primary btn-sm font-weight-bold mx-1" data-bs-toggle="modal" data-bs-target="#tagsModal">Edit</button>';

                    output += '<button type="button" onclick="deleteTag(' + id + ')" class="btn btn-danger btn-sm font-weight-bold">Delete</button>';

                    return output;
                }
            },
        ]
    });
});

$('#addClick').click(function() {
    $('#tag-form')[0].reset();
    var modal = $('#tagsModal');
    modal.find('#updBtn').hide();
    modal.find('#saveBtn').show();
    modal.find('.modal-title').html('Add Tags Form');
});

function tagsStatusUpdate(id, status) {
    $.ajax({
        url: "backend/tagStatus.php",
        type: "GET",
        data: {
            id_active: id,
            active_status: status
        },
        success: function(data) {
            $('#tagsTable').DataTable().ajax.reload(null, false);
        }
    });
}

function addTags() {
    var form = document.querySelector('#tag-form');
    var formData = new FormData(form);

    $.ajax({
        url: "backend/tagsUpdate.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(data) {
            try {
                data = JSON.parse(data); // Parse response as JSON
                if (data.status === 'success') {
                    Swal.fire("Success!", data.message, "success");
                    $("#tagsModal").modal("hide");
                    $('#tagsTable').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
            } catch (e) {
                console.error("Error parsing JSON response:", e);
                Swal.fire("Error!", "Invalid response from server", "error");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire("Error!", "Failed to add tag", "error");
        }
    });
}


function editTags(id) {
    var modal = $('#tagsModal');
    modal.find('#saveBtn').hide();
    modal.find('#updBtn').show();
    modal.find('.modal-title').html('Update Tags Form');
    modal.find('#add').val(null);

    $("#Tag_id").val(id);

    $.ajax({
        url: "backend/tagsUpdate.php",
        type: "GET",
        data: {
            id: id
        },
        // processData:false,
        // contentType:false,

        success: function(data) {
            var tag = JSON.parse(data);
            // console.log(tag);
            $("#tag_name").val(tag.data['tag_name']);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            Swal.fire("Error!", "Failed to fetch data for editing", "error");
        }
    });
}

function updateTags() {
    Swal.fire({
        title: "Do you want to save the changes?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Save",
        denyButtonText: "Don't save"
    }).then((result) => {
        if (result.isConfirmed) {
            var form = document.querySelector('#tag-form');
            var formData = new FormData(form);
            $.ajax({
                url: "backend/tagsUpdate.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    var tags = JSON.parse(data);
                    if (tags.status === 'success') {
                        Swal.fire("Updated Successfully!", "", "success");
                        $("#tagsModal").modal("hide");
                        $('#tagsTable').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire("Error!", tags.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "Failed to Update", "error");
                }
            });
        } else if (result.isDenied) {
            Swal.fire("Changes are not Updated", "", "info");
            $("#tagsModal").modal("hide");
        }
    });
}

function deleteTag(id) {
    Swal.fire({
        title: "Do you really want to delete?",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "No, cancel",
        icon: "warning"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "backend/tagsUpdate.php",
                type: "GET",
                data: {
                    deleteTags: id,
                },
                success: function(data) {
                    var delTags = JSON.parse(data); 
                    if (delTags.status === 'success') {
                        $('#tagsTable').DataTable().ajax.reload(null, false);
                        Swal.fire("Success!", delTags.message, "success");
                    } else {
                        Swal.fire("Error!", delTags.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "Failed to delete", "error");
                }
            });
        } else {
            Swal.fire("Cancelled", "Delete operation cancelled", "info");
        }
    });
}
</script>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>