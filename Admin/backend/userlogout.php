<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "dbconfig.php";
$userEmail = $_SESSION['userEmail'];
$statusUpd = "UPDATE `user_tbl` SET status = '0' WHERE email = '$userEmail'";
$resUpd = mysqli_query($conn, $statusUpd);
unset($_SESSION['userEmail']);
header("Location: ../views/login_form.php");
?>