<?php
session_start();

include "dbconfig.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['heading']) && !empty($_POST['category']) && !empty($_POST['editorData']) && !empty($_POST['tags'])) {

        $heading = mysqli_real_escape_string($conn, $_POST["heading"]);
        $slug = preg_replace(['/[^A-Za-z0-9\s]+/', "/\s+/"], ['', '-'], strtolower(str_replace(["'", ':'], '', $heading)));
        $category = mysqli_real_escape_string($conn, $_POST["category"]);

        $editorData = $_POST["editorData"];

        // Escape each tag individually
        $tags = $_POST["tags"];
        $escapedTags = array();
        foreach ($tags as $tag) {
            $escapedTags[] = mysqli_real_escape_string($conn, $tag);
        }
        $tags1 = implode(',', $escapedTags);

        if (isset($_SESSION['email']) && $_SESSION['email'] !== "") {
            $createdBy = $_SESSION['email'];
        } elseif ($_SESSION['userEmail'] !== "") {
            $createdBy = $_SESSION['userEmail'];
        }

        // Check if heading already exists
        $headingExistsQuery = "SELECT * FROM news_tbl WHERE heading = '$heading'";
        $headingExistsResult = mysqli_query($conn, $headingExistsQuery);

        if (mysqli_num_rows($headingExistsResult) > 0) {
            // Heading already exists, handle the error
            echo "Error: Heading already exists. Please choose a different heading.";
        } else {
            // Heading is unique, proceed with insertion
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = 'uploads/';

                // Create the folder if it doesn't exist
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadPath = $uploadDir . basename($_FILES['image']['name']);

                // Check if the image already exists in the directory
                if (file_exists($uploadPath)) {
                    echo "Error: Image with the same name already exists.";
                    exit();
                }

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

                // Get image dimensions
                list($width, $height) = getimagesize($_FILES['image']['tmp_name']);

                // Display image dimensions
                // echo "Image Dimensions: $width x $height";

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

                // Save the original image
                $originalImagePath = $uploadDir . 'original_' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $originalImagePath);

                // Free up memory
                imagedestroy($originalImage);
                imagedestroy($resizedImage);

                // Insert tags into the database if they don't exist already
                foreach ($escapedTags as $value) {
                    $selectTags = "SELECT * FROM `tags_tbl` WHERE tag_name = '$value'";
                    $query_Tags = mysqli_query($conn, $selectTags);
                    if (mysqli_num_rows($query_Tags) == 0) {
                        $sql2 = "INSERT INTO tags_tbl (`tag_name`) VALUES ('$value')";
                        $query_r2 = mysqli_query($conn, $sql2);
                        if (!$query_r2) {
                            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                        }
                    }
                }

                // Insert news post into the database
                $sql1 = "INSERT INTO news_tbl (heading, slug, category_id, content, image, tags, created_by) VALUES ('$heading', '$slug', '$category', '$editorData', '$originalImagePath', '$tags1', '$createdBy')";
                $query_r1 = mysqli_query($conn, $sql1);

                if ($query_r1) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
                }
                mysqli_close($conn);
            } else {
                echo "Error occurred while uploading image";
            }
        }
    }
}
?>