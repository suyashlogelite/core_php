<?php 
include "backend/UserSessionCheck.php"; 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- BOOTSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <h1 class="alert alert-primary">NEWS PORTAL VIEW</h1>
                <li class="nav-item d-none d-sm-inline-block">
                    <!-- <a href="views\login_form.php" class="btn btn-primary btn-sm text-white">Logout</a> -->
                    <a href="backend/userlogout.php" class="btn btn-primary btn-sm">Logout</a>
                </li>
            </div>
        </div>
    </div>
</body>

</html>