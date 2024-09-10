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
                            <h2 class="col-10 text-success font-weight-bold">NEWS BLOG TABLE</h2>
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
                                    <table id="newsBlogTable"
                                        class="table table-bordered table-hover dataTable dtr-inline text-center"
                                        aria-describedby="example2_info">
                                        <thead class="bg-primary">
                                            <tr class="font-weight-bold">
                                                <th>id</th>
                                                <th>Heading</th>
                                                <th>Image</th>
                                                <th>Created By</th>
                                                <th>Views</th>
                                                <th>Status</th>
                                                <th style="white-space:nowrap;">Created At</th>
                                                <th style="white-space:nowrap;">Updated At</th>
                                                <th>Manage Posts</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary">
                                            <th>id</th>
                                            <th>Heading</th>
                                            <th>Image</th>
                                            <th>Created By</th>
                                            <th>Views</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Manage Posts</th>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">

$(document).ready(function() {
    var id=1;
    var table = $('#newsBlogTable').dataTable({
        "bProcessing": true,
        "autoWidth":false,
        "sAjaxSource": "data.php?table=news",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aoColumns": [
            {
                mData: 'id',
                render :function(data, type, row){
                    return id++;                }
            },
            {
                mData: 'heading'
            },
            {
                mData: 'image',
                render:function(data, type, row){
                    var image = row.image;
                    var path = "backend/";
                    var imagepath = path + image;
                    return '<img src="'+imagepath+'" alt="" width="100">';
                }
            },
            {
                mData: 'created_by'
            },
            {
                mData: 'views'
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
                mData: 'created_at'
            },
            {
                mData: 'updated_at'
            },
            {
                mData: 'id',
                // Edit and Delete buttons
                render: function(data, type, row) {
                    var id = row.id;
                    var status = row.status;
                    var btnClass = status == 1 ? 'btn-success btn-sm font-weight-bold' :
                        'btn-danger btn-sm font-weight-bold';
                    var btnText = status == 1 ? '<i class="fas fa-toggle-on fa-lg"></i>' : '<i class="fas fa-toggle-off fa-lg"></i>';
                    var toggleStatus = status == 1 ? 0 : 1;

                    var output = '<div class="btn-group" role="group">';
                    
                    output += '<button type="button" class="btn ' + btnClass +
                        '" onclick="postStatusUpdate(' + id + ',' + toggleStatus + ')">' + btnText +
                        '</button>';
                    output += '<button type="button" onclick="viewPost(' + id + ')" class="btn btn-info btn-sm font-weight-bold mx-1"><i class="fas fa-eye fa-lg"></i></button>';
                        
                    output += '<button type="button" onclick="editPost(' + id + ')" class="btn btn-primary btn-sm font-weight-bold me-1"><i class="fas fa-edit fa-lg"></i></button>';

                    output += '<button type="button" onclick="deletePost(' + id + ')" class="btn btn-danger btn-sm font-weight-bold"><i class="fas fa-trash fa-lg"></i></button>';

                    output += '</div>';

                    return output;
                }
            },
        ]
    });
});


function postStatusUpdate(id, status) {

    $.ajax({
        url: "backend/postStatus.php",
        type: "GET",
        data: {
            id_active: id,
            active_status: status
        },
        success: function(data) {
            $('#newsBlogTable').DataTable().ajax.reload(null, false);
        }
    });
}

function viewPost(id) {
    window.location.href = "viewPost.php?id=" + id;
}

function editPost(editid) {
    window.location.href = "editNewsBlogs.php?editid=" + editid;
}


function deletePost(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this Post!",
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
                url: "backend/deletePost.php",
                type: "GET",
                data: {
                    delete_id: id, // Use delete_id instead of id for deletion
                },
                success: function(data) {
                    // console.log(data);
                    $('#newsBlogTable').find("[id='" + id + "']").remove();
                    $('#newsBlogTable').DataTable().ajax.reload(null, false);
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