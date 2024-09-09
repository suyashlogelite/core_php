<?php
session_start();
if (!isset ($_SESSION['userEmail']) && $_SESSION['userEmail'] == "") {
    header("Location: views/login_form.php");
}
?>

