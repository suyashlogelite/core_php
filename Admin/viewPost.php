<?php
include "backend/AdminSessionCheck.php";
include "backend/fetchPost.php"
    ?>
<?php include ("includes/header.php"); ?>
<?php include ("includes/topBar.php"); ?>
<?php include ("includes/sideBar.php"); ?>

<div class="content-wrapper">
    <section class="content">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-success font-weight-bold">View Post</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active text-success font-weight-bold">View Post</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <?php
            if ($_GET['id']) {

                $id = $_GET['id'];

                $select_post ="SELECT `id`, `heading`,`category_id`,`content`, `image`, `created_by`, `views`, `status`,DATE_FORMAT(created_at, '%d-%m-%Y') AS created_at, DATE_FORMAT(updated_at, '%d-%m-%Y %h:%i:%s') AS updated_at FROM `news_tbl` where id=$id";

                $query_post = mysqli_query($conn, $select_post);

                if ($query_post) {
                    if (mysqli_num_rows($query_post) > 0) {
                        $row = mysqli_fetch_assoc($query_post);
                    } else {
                        echo "Failed to fetch post record";
                    }
                }
            } ?>
        <div class="container-fluid">
            <div class="card border">
                <div class="flash-news-banner p-3">
                    <div class="container">
                        <div class="d-lg-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-dark font-weight-bold mr-3">News Headline</span>
                                <p class="mb-0 font-weight-bold">
                                    <?php echo $row['heading'];?>
                                </p>
                            </div>
                            <div class="d-flex">
                                <span class="mr-3 text-danger font-weight-bold"><span class="text-primary">Post
                                        Date:</span>&nbsp<?php echo $row['created_at']; ?></span>
                                <span class="text-danger font-weight-bold"><span class="text-primary">Post
                                        By:</span>&nbsp
                                    <?php if(isset($_SESSION['name'])){
                                    echo $_SESSION['name'];
                                } ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row container-fluid">
            <div class="col-md-8">
                <div class="card">
                    <div class="flash-news-banner p-3">
                        <div class="container">
                            <div class="d-lg-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <h2 class="mb-3">
                                        <?php echo $row['heading'];?>
                                    </h2>
                                </div>
                            </div>
                            <div>
                                <p><?php echo $row['content']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="flash-news-banner p-3">
                        <div class="container">
                            <div>
                                <?php
                                    $catId = $row['category_id'];
                                    $category = "SELECT * FROM `categories` WHERE id = $catId";
                                    $cat_run = mysqli_query($conn, $category);
                                    if($cat_run){
                                        if(mysqli_num_rows($cat_run) == 1){
                                            $catRow = mysqli_fetch_assoc($cat_run);
                                        }
                                    }
                                    ?>
                                <div class="d-flex">
                                    <h4><span
                                            class="font-weight-bold">Category:&nbsp</span><?php echo $catRow['category_name']; ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="d-lg-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <p><img src="<?php echo "backend/" . $row['image']; ?>" width="300" alt=""></p>
                                </div>
                            </div>
                            <div>
                                <p class="mb-3">
                                    <?php echo $row['heading'];?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<?php include ("includes/footer.php"); ?>