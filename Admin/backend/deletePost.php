<?php
include_once "dbconfig.php";
if (isset($_GET['delete_id'])) {

    $id = $_GET['delete_id'];

    $oldImageQuery = "SELECT image FROM news WHERE id = $id";
    $oldImageResult = mysqli_query($conn, $oldImageQuery);
    $uploadDir = "uploads/";
    if ($oldImageResult) {
        $oldImageRow = mysqli_fetch_assoc($oldImageResult);
        $oldImage = $oldImageRow['image'];
        $path_parts = pathinfo($oldImage);
        $filename = $path_parts['basename'];
        $parts = explode('_', $filename);
        $original_part = $parts[1];
        // Construct paths for resized images
        $ImagePath = $uploadDir . 'resized_300X600_' . $original_part;
        $ImagePath1 = $uploadDir . 'resized_100X100_' . $original_part;

        if (!empty($ImagePath) && file_exists($ImagePath)) {
            unlink($ImagePath);
        }
        if (!empty($ImagePath1) && file_exists($ImagePath1)) {
            unlink($ImagePath1);
        }
        $query = "DELETE FROM `news` WHERE id = $id";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            if (!empty($oldImage) && file_exists($oldImage)) {
                unlink($oldImage);
            }
            echo "Record Deleted Successfully";
        } else {
            echo "Failed To Delete Record";
        }
    }
}