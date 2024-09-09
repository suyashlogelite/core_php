<?php
session_start();

include "dbconfig.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $editId = $_POST['editId'];
    $heading = $_POST["heading"];
    $slug = preg_replace(['/[^A-Za-z0-9\s]+/', "/\s+/"], ['', '-'], strtolower(str_replace(["'", ':'], '', $heading)));
    $category = $_POST["category"];
    $editorData = $_POST["editor"];
    $tags = $_POST["tags"];
    $tags1 = implode(',', $tags);
    if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
        $createdBy = $_SESSION['email'];
    } elseif ($_SESSION['userEmail'] !== "") {
        $createdBy = $_SESSION['userEmail'];
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . "original_" . basename($_FILES['image']['name']);

        // Check file type and size
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            echo "Error: Unsupported file format. Please upload a JPG, JPEG, PNG, or GIF file.";
            exit();
        }
        if ($_FILES['image']['size'] > 5 * 1024 * 1024) { // 5 MB
            echo "Error: File size exceeds the limit of 5 MB.";
            exit();
        }

        list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

        // Set new dimensions for the resized image
        $newWidth = 300;
        $newHeight = 600;
        $newWidth1 = 100;
        $newHeight1 = 100;

        // Create a new image resource with desired dimensions
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        $resizedImage1 = imagecreatetruecolor($newWidth1, $newHeight1);

        // Load the original image
        $originalImage = imagecreatefromstring(file_get_contents($_FILES['image']['tmp_name']));

        // Resize the original image to fit the new dimensions
        imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagecopyresampled($resizedImage1, $originalImage, 0, 0, 0, 0, $newWidth1, $newHeight1, $width, $height);

        // Save the resized image
        $resizedImagePath = $uploadDir . 'resized_300X600_' . basename($_FILES['image']['name']);
        $resizedImagePath1 = $uploadDir . 'resized_100X100_' . basename($_FILES['image']['name']);

        imagejpeg($resizedImage, $resizedImagePath);
        imagejpeg($resizedImage1, $resizedImagePath1);

        // Free up memory
        imagedestroy($originalImage);
        imagedestroy($resizedImage);
        imagedestroy($resizedImage1);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {

            $image = $_FILES["image"]["name"];
            $tag_new = explode(',', $tags1);

            foreach ($tag_new as $value) {
                $selectTags = "SELECT * FROM `tags_tbl` WHERE tag_name = '$value'";
                $query_Tags = mysqli_query($conn, $selectTags);
                if ($query_Tags) {
                    $sql2 = "UPDATE tags_tbl SET `tag_name` = '$value' WHERE tag_name = '$value'";
                    $query_r2 = mysqli_query($conn, $sql2);
                } else {
                    echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                }
            }

            // Get the old image name from the database
            $oldImageQuery = "SELECT image FROM news_tbl WHERE id = '$editId'";
            $oldImageResult = mysqli_query($conn, $oldImageQuery);
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
                
                if (file_exists($ImagePath)) {
                    unlink($ImagePath);
                }
                if (file_exists($ImagePath1)) {
                    unlink($ImagePath1);
                }

                // Update the database with the new image file name
                $sql1 = "UPDATE news_tbl SET heading = '$heading', slug = '$slug', category_id = '$category', content = '$editorData', image ='$uploadPath', tags = '$tags1', created_by = '$createdBy' WHERE id = $editId;";

                $query_r1 = mysqli_query($conn, $sql1);

                if ($query_r1) {
                    // Delete the old image files from the upload directory
                    if (!empty($oldImage) && file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                    echo "New Record Updated Successfully";
                } else {
                    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
            } else {
                echo "Error in oldImageQuery";
            }
        } else {
            echo "Error occurred while updating image";
        }
    } else {
        // If no new image is uploaded, keep the previous image
        $sql1 = "UPDATE news_tbl SET heading = '$heading', slug = '$slug', category_id = '$category', content = '$editorData', tags = '$tags1', created_by = '$createdBy' WHERE id = $editId;";

        $query_r1 = mysqli_query($conn, $sql1);

        if ($query_r1) {
            echo "New Record Updated Successfully";
        } else {
            echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);
    }
}
?>