<?php
include_once "dbconfig.php";
if(isset( $_GET['id_active'],$_GET['active_status'])){
    $id = $_GET['id_active'];
    $status = $_GET['active_status'];
    $update_status = "UPDATE `tags` SET status='$status' WHERE id=$id";
    $run_update_status = mysqli_query($conn,$update_status);
}
echo "Status Updated Successfully";
