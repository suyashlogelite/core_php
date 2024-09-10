<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "dbconfig.php";
$email = $_SESSION['email'];
$statusUpd = "UPDATE `users` SET status = '0' WHERE email = '$email'";
$resUpd = mysqli_query($conn, $statusUpd);
unset($_SESSION['email']);
header("Location: ../views/login_form.php");
?>