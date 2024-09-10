<?php
include ("includes/header.php");
include "backend/AdminSessionCheck.php";
?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<?php
include_once "backend/dbconfig.php";
$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);
if ($result) {
    $num = mysqli_num_rows($result);
}
?>

<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="alert alert-warning d-none" id="alert2" role="alert"></div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <h2 class="col-10 text-success font-weight-bold">USER TABLE</h2>
                            <div class="col-2 container d-flex justify-content-end">
                                <button type="button" id="addUserClick"
                                    class="btn btn-success btn-sm shadow font-weight-bold" data-bs-toggle="modal"
                                    data-bs-target="#UserModal">
                                    ADD USER
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6"></div>
                                <div class="col-sm-12 col-md-6"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="userListTable"
                                        class="table table-bordered table-hover dataTable dtr-inline text-center"
                                        aria-describedby="example2_info">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th scope="col">id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Country</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Login Time</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tfoot class="bg-primary">
                                            <th scope="col">id</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Country</th>
                                            <th scope="col">Created At</th>
                                            <th scope="col">Login Time</th>
                                            <th scope="col">Actions</th>
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
<!-- Add/Edit User Modal -->
<div class="modal fade" id="UserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="font-weight-bold text-primary" id="addUserTitle">Add User Form</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card-footer">
                <form id="userForm">
                    <div class="mb-1">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name">
                    </div>
                    <div class="mb-1">
                        <label for="email" class="form-label">Email Id</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="mb-1">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" maxlength="10" minlength="10" name="phone" class="form-control" id="phone">
                    </div>
                    <div class="mb-1" id="password">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>
                    <div class="mb-1">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select">
                            <option>Select Role</option>
                            <option value="admin">admin</option>
                            <option value="user">user</option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label for="country" class="form-label">Country</label>
                        <select name="country" id="country" class="form-select">
                            <option value="India">India</option>
                        </select>
                    </div>
                    <input type="text" name="user_id" id="user_id">
                    <input type="hidden" value="addUser" name="addUser" id="addUser">
                    <div class="modal-footer">
                        <button type="button" onclick="saveUser()" id="saveBtn"
                            class="btn btn-primary btn-sm">Save</button>
                        <button type="button" onclick="updateUser()" id="updBtn"
                            class="btn btn-info btn-sm">Update</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="text" value='<?php $_SESSION['email']; ?>' name="" id="email">
    <input type="text" value='<?php $_SESSION['userEmail']; ?>' name="" id="userEmail">
</div>

<script type="text/javascript">
$(document).ready(function() {
    var id=1;
    var table = $('#userListTable').dataTable({
        "bProcessing": true,
        "autoWidth": false,
        "sAjaxSource": "data.php?table=users",
        "bPaginate": true,
        "sPaginationType": "full_numbers",
        "iDisplayLength": 10,
        "aoColumns": [{
                mData: 'id',
                render :function(data, type, row){
                    return id++;    
                }
            },
            {
                mData: 'name'
            },
            {
                mData: 'email'
            },
            {
                mData: 'phone'
            },
            {
                mData: 'gender'
            },
            {
                mData: 'role'
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
                mData: 'country'
            },

            {
                mData: 'created'
            },

            {
                mData: 'login_time'
            },
            
            {
                mData: 'id',
                // Edit and Delete buttons
                render: function(data, type, row) {
                    var id = row.id;
                    var output = (row.status == 1) ?
                        '<button type="button" class="btn btn-success btn-sm font-weight-bold">Active</button>' :
                        '<button type="button" class="btn btn-danger btn-sm font-weight-bold">Inactive</button>';

                    output += '<button type="button" onclick="editUser(' + id +
                        ')" class="btn btn-primary btn-sm mx-1 font-weight-bold" data-bs-toggle="modal" data-bs-target="#UserModal">Edit</button>' +
                        '<button type="button" onclick="deleteUser(' + id +
                        ')" class="btn btn-danger btn-sm font-weight-bold">Delete</button>';

                    return output;
                }
            },
        ]
    });
});

$('#addUserClick').click(function() {
    $('#addUserTitle').html('Add User Form');
    $('#userForm')[0].reset();
    $('#updBtn').hide();
    $('#saveBtn').show();
    $('#password').show();
});

// Function to save user
function saveUser() {
    let form = document.querySelector('#userForm');
    var formData = new FormData(form);
    console.log("run");
    $.ajax({
        type: "POST",
        url: "backend/updateUser.php",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,

        success: function(data) {
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.success
                });
                $('#UserModal').modal('hide');
                $('#userListTable').DataTable().ajax.reload(null, false);
            }
        }
    });
}

// Function to edit user
function editUser(userid) {
    console.log("hello");
    var modal = $('#UserModal');
    modal.find('#addUserTitle').html('Update User Form');
    $("#addUser").val(null);
    $('#gender').show();
    $('#role').show();
    $('#country').show();
    $('#updBtn').show();
    $('#saveBtn').hide();
    $('#password').hide();

    $("#user_id").val(userid);

    $.ajax({
        url: "backend/updateUser.php", // Corrected the URL to match the PHP script
        type: "GET",
        data: {
            userid: userid
        },
        success: function(data) {
            var user = JSON.parse(data);
            console.log(user);
            $('#name').val(user.name);
            $('#email').val(user.email);
            $('#phone').val(user.phone);
            $('#gender').val(user.gender);
            $('#role').val(user.role);
            $('#country').val(user.country);
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to fetch user data. Please try again later.'
            });
        }
    });
}

// Function to update user
function updateUser() {
    let form = document.querySelector('#userForm');
    var formData = new FormData(form);
    console.log("run");
    $.ajax({
        type: "POST",
        url: "backend/updateUser.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data) {
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.success
                });
                $('#UserModal').modal('hide');
                $('#userListTable').DataTable().ajax.reload(null, false);
            }
        }
    });
}

// Function to delete user
function deleteUser(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this data!",
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
                url: "backend/updateUser.php",
                type: "GET",
                data: {
                    delete_id: id, // Use delete_id instead of id for deletion
                },
                success: function(data) {
                    $('#userListTable').find("[id='" + id + "']").remove();
                    $('#userListTable').DataTable().ajax.reload(null, false);
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