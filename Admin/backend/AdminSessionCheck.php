<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset ($_SESSION['email']) && $_SESSION['email'] == "") {
    header("Location: views/login_form.php");
}
?>
