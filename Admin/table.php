<?php include "includes/header.php"; ?>
<?php include "includes/sideBar.php"; ?>
<?php include "includes/topBar.php"; ?>

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
                        <div id="category_wrapper">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"></div>
                                <div class="col-sm-12 col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 table-responsive">

                                    <table id="categoryTable" class="display" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Parent Category</th>
                                                <th>Category Name</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>id</th>
                                                <th>Parent Category</th>
                                                <th>Category Name</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Status</th>
                                                <th>Actions</th>
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

<script>
$(document).ready(function() {
    var table = $('#categoryTable').dataTable({
        "bProcessing": true,
        "sAjaxSource": "data.php?id=categories",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 6,
        "aoColumns": [{
                mData: 'id'
            },
            {
                mData: 'parent_category'
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
                mData: 'status'
            },
            {
                mData: 'id',
                // Edit and Delete buttons
                render: function(data, type, row) {
                    return '<button type="button" onclick="editRow(' + row.id +
                        ')" class="btn btn-primary btn-sm font-weight-bold m-1">Edit</button>' +
                        '<button type="button" onclick="deleteRow(' + row.id +
                        ')" class="btn btn-danger btn-sm font-weight-bold m-1">Delete</button>';
                }
            },
        ]
    });
});
</script>
<?php include "includes/footer.php"; ?>