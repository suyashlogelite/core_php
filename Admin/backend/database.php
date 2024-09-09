<?php
if(session_start() == PHP_SESSION_NONE){
    session_start();
}
include_once "dbconfig.php";

if (isset($_POST['submit'])) {
    $uemail = $_POST['email'];
    $pass = $_POST['password'];

    // Sanitize user input (if necessary)
    $uemail = mysqli_real_escape_string($conn, $uemail);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Construct the SQL query
    $sql = "SELECT * FROM user_tbl WHERE email='$uemail'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verify the password
            if (password_verify($pass, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                header('Location: ../index.php');
                exit();
            } else {
                $_SESSION['error_msg'] = 'Invalid email or password';
                header('Location: ../views/login_form.php');
                exit();
            }
        } else {
            $_SESSION['error_msg'] = 'Invalid email or password';
            header('Location: ../views/login_form.php');
            exit();
        }
    } else {
        // Handle database error
        $_SESSION['error_msg'] = 'Database error';
        header('Location: ../views/login_form.php');
        exit();
    }
}
?>
