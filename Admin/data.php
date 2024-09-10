<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_portal_db";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_GET['table'] === 'categories') {

    $sql = "SELECT child.id, 
    parent.category_name as parent_category, 
    child.category_name, 
    DATE_FORMAT(child.created_at, '%d-%m-%Y') AS created_at, 
    DATE_FORMAT(child.updated_at, '%d-%m-%Y %h:%i:%s') AS updated_at, 
    child.status
    FROM categories AS child
    LEFT JOIN categories AS parent ON child.parent_category = parent.id;";
    
    $resultset = mysqli_query($conn, $sql) or
        die("database error:" . mysqli_error($conn));
    $data = array();
    while ($rows = mysqli_fetch_assoc($resultset)) {
        $data[] = $rows;
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
} elseif ($_GET['table'] === 'users') {
    $sql = "SELECT `id`, `name`, `email`, `phone`, `gender`, `role`, `status`, `country`,DATE_FORMAT(created, '%d-%m-%Y') AS created, DATE_FORMAT(login_time, '%d-%m-%Y %h:%i:%s') AS login_time FROM `users` where role !='admin'";
    $resultset = mysqli_query($conn, $sql) or
        die("database error:" . mysqli_error($conn));
    $data = array();
    while ($rows = mysqli_fetch_assoc($resultset)) {
        $data[] = $rows;
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
} elseif ($_GET['table'] === 'news') {
    
    session_start();
    $emailsess=$_SESSION['email'];
    $role=$_SESSION['role'];
    if($role=='user'){
        $sql = "SELECT `id`, `heading`, `image`, `created_by`, `views`, `status`,DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at, DATE_FORMAT(updated_at, '%d-%m-%Y %h:%i:%s') AS updated_at FROM `news` where created_by='$emailsess' ORDER BY id DESC";
    }else{
        $sql = "SELECT `id`, `heading`, `image`, `created_by`, `views`, `status`,DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at, DATE_FORMAT(updated_at, '%d-%m-%Y %h:%i:%s') AS updated_at FROM `news`";
    }
  

    $resultset = mysqli_query($conn, $sql) or
        die("database error:" . mysqli_error($conn));
    $data = array();
    while ($rows = mysqli_fetch_assoc($resultset)) {
        $data[] = $rows;
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
}  elseif ($_GET['table'] === 'tags') {
    
    $sql = "SELECT `id`, `tag_name`,DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at, DATE_FORMAT(updated_at, '%d-%m-%Y %h:%i:%s') AS updated_at, `status` FROM `tags`";

    $resultset = mysqli_query($conn, $sql) or
        die("database error:" . mysqli_error($conn));
    $data = array();
    while ($rows = mysqli_fetch_assoc($resultset)) {
        $data[] = $rows;
    }
    $results = array(
        "sEcho" => 1,
        "iTotalRecords" => count($data),
        "iTotalDisplayRecords" => count($data),
        "aaData" => $data
    );
    echo json_encode($results);
}

else {
    echo "Table Not Found";
}