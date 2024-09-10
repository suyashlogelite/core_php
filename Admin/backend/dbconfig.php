<?php
$servername = "localhost";
$username = "phpmyadmin";
$password = "root123";
$dbname = "news_portal";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die ("Connection failed: " . mysqli_connect_error());
}