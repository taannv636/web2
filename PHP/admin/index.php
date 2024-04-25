<?php require_once('database/dbhelper.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Thống kê</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- summernote -->
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="wrapper">
        <header>
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="category/index.php">Thống kê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category/index.php">Quản lý danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product/">Quản lý sản phẩm</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="dashboard.php">Quản lý đơn hàng</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link " href="user/">Quản lý người dùng</a>
                </li>
            </ul>
        </header>
        <div class="container">
            <main>
                <h1>Bảng thống kê</h1>
                <section class="dashboard">
                    <div class="table">
                        <div class="sp">
                            <p>Sản phẩm</p>
                            <?php
                            $sql = "SELECT * FROM `product`";
                            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                            $result = mysqli_query($conn, $sql);
                            echo '<span>' . mysqli_num_rows($result) . '</span>';
                            ?>
                            <p><a href="product/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp kh">
                            <p>Người dùng</p>
                            <?php
                            $sql = "SELECT * FROM `user`";
                            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                            $result = mysqli_query($conn, $sql);
                            echo '<span>' . mysqli_num_rows($result) . '</span>';
                            ?>
                            <p><a href="user/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp dm">
                            <p>Danh mục</p>
                            <?php
                            $sql = "SELECT * FROM `category`";
                            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                            $result = mysqli_query($conn, $sql);
                            echo '<span>' . mysqli_num_rows($result) . '</span>';
                            ?>
                            <p><a href="category/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp dh">
                            <p>Đơn hàng</p>
                            <?php
                            $sql = "SELECT * FROM `order_details`";
                            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                            $result = mysqli_query($conn, $sql);
                            echo '<span>' . mysqli_num_rows($result) . '</span>';
                            ?>
                            <p><a href="dashboard.php">xem chi tiết➜</a></p>
                        </div>
                    </div>
                </section>
                
            </main>
        </div>
    </div>
</body>
<style>
    #wrapper {
        padding-bottom: 5rem;
    }

    .b-500 {
        font-weight: 500;
    }

    .red {
        color: red;
    }

    .green {
        color: green;
    }
</style>

</html>