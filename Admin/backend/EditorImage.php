<?php
// Function to recursively create a directory if it doesn't exist
function createDir($dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Check if a file was uploaded
if(isset($_FILES['upload']) && $_FILES['upload']['error'] == 0) {
    $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp", "pdf");

    $fileExtension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

    // Check if the file extension is allowed
    if(in_array(strtolower($fileExtension), $allowedExtensions)) {
        $uploadDir = 'uploads/';
        
        // Create the directory if it doesn't exist
        createDir($uploadDir);

        $uploadPath = $uploadDir . uniqid() . basename($_FILES['upload']['name']);


        // Try to move the uploaded file to the designated directory
        if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadPath)) {
            // File uploaded successfully
            $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/' . $uploadPath;
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $_GET['CKEditorFuncNum'] . ', "' . $url . '", "File uploaded successfully.");</script>';
        } else {
            // Error in uploading file
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $_GET['CKEditorFuncNum'] . ', "", "Error uploading file.");</script>';
        }
    } else {
        // File extension not allowed
        echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $_GET['CKEditorFuncNum'] . ', "", "File extension not allowed.");</script>';
    }
} else {
    // No file uploaded or error in uploading
    echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction(' . $_GET['CKEditorFuncNum'] . ', "", "No file uploaded or invalid request.");</script>';
}
?>
