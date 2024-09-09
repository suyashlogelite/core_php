<?php 
include "backend/AdminSessionCheck.php"; 
?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
                <div class="card shadow p-4">
                    <div class=" image d-flex flex-column justify-content-center align-items-center"> <button
                            class="btn btn-secondary"> <img src="..\Admin\assets\dist\img\adminImage.jpg" height="100"
                                width="100" /></button> <span class="name mt-3">Admin Profile</span> <span
                            class="idd">admin@gmail.com</span>
                        <div class="d-flex flex-row justify-content-center align-items-center gap-2"> <span
                                class="idd1">ID:1</span> <span><i class="fa fa-copy"></i></span> </div>
                        <div class=" d-flex mt-2"> <button class="btn1 btn-dark">Edit Profile</button> </div>
                        <div class="text-white mt-3"><span>Hello,I am Admin My role is to manage the Admin Panel of Logelite News Portal</span></div>
                        <div class="gap-3 mt-3 icons d-flex flex-row justify-content-center align-items-center">
                            <span><i class="fa fa-twitter"></i></span> <span><i class="fa fa-facebook-f"></i></span>
                            <span><i class="fa fa-instagram"></i></span> <span><i class="fa fa-linkedin"></i></span>
                        </div>
                        <div class=" px-2 rounded mt-4 date "> <span class="join">Joined 4th march,2024</span> </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>