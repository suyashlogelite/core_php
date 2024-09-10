<?php
include_once "dbconfig.php";

$response = array();

// Add
if (isset($_POST['add']) && $_POST['add'] !== "") {
    $tag_name = $_POST['tag_name'];
    $status = $_POST['status'];

    // Check if the tag name already exists
    $selectTag = "SELECT * FROM `tags` WHERE `tag_name` = '$tag_name'";
    $query_select_run = mysqli_query($conn, $selectTag);

    if ($query_select_run) {
        if (mysqli_num_rows($query_select_run) > 0) {
            $response['status'] = "error";
            $response['message'] = "Tag already exists! Please write another tag name.";
        } else {
            $query_insert = "INSERT INTO `tags` (`tag_name`, `status`) VALUES ('$tag_name','$status')";
            $query_insert_run = mysqli_query($conn, $query_insert);

            if ($query_insert_run) {
                $response['status'] = "success";
                $response['message'] = "Tag Details Inserted Successfully";
            } else {
                $response['status'] = "error";
                $response['message'] = "Failed to insert tag";
            }
        }
    } else {
        $response['status'] = "error";
        $response['message'] = "Unable to run query";   
    }
}

// Edit
elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_edit = "SELECT * FROM `tags` WHERE id = $id";

    $query_edit_run = mysqli_query($conn, $query_edit);

    if ($query_edit_run) {
        if (mysqli_num_rows($query_edit_run) > 0) {
            $row_edit = mysqli_fetch_assoc($query_edit_run);
            $response['status'] = "success";
            $response['message'] = "Data fetched successfully";
            $response['data'] = $row_edit;
        } else {
            $response['status'] = "error";
            $response['message'] = "No record found for editing";
        }
    } else {
        // Check for SQL error
        $response['status'] = "error";
        $response['message'] = "Failed to fetch data for editing: " . mysqli_error($conn);
    }
}

// Update
elseif (isset($_POST['tag_id']) && $_POST['tag_id'] !== "") {
    $id = $_POST['tag_id'];
    $updTagName = $_POST['tag_name'];

    $query_update = "UPDATE `tags` SET `tag_name` = '$updTagName', updated_at = NOW() WHERE id = $id";
    $query_update_run = mysqli_query($conn, $query_update);

    if ($query_update_run) {
        $response['status'] = "success";
        $response['message'] = "Tag updated successfully";
    } else {
        $response['status'] = "error";
        $response['message'] = "Failed to update tag";
    }
}

// Delete
elseif (isset($_GET['deleteTags'])) {
    $id = $_GET['deleteTags'];
    $query_delete = "DELETE FROM `tags` WHERE id = $id";
    $query_delete_run = mysqli_query($conn, $query_delete);

    if ($query_delete_run) {
        $response['status'] = "success";
        $response['message'] = "Record deleted successfully";
    } else {
        $response['status'] = "error";
        $response['message'] = "Failed to delete record";
    }
}

// Output the response
echo json_encode($response);
?>
