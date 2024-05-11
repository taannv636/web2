<?php
require_once('database/dbhelper.php');
require_once('utils/utility.php');

// $order_id = $order_details_List['order_id'];
// $product_id = $order_details_List['product_id'];
// $num = $order_details_List['num'];
// $price = $order_details_List['price'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/cart.css">
    <title>Giỏ hàng</title>
</head>

<body>
    <div id="wrapper">
        <?php require('layout/header.php') ?>
        <main>
            <section class="cart">
                <div class="container-top">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding: 1rem 0;">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link" href="cart.php">Giỏ hàng</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link active" href="dashboard.php">Lịch sử mua hàng</a>
                                </li>
                            </ul>
                            <h2 style="padding-top:2rem" class="">Lịch sử mua hàng</h2>
                        </div>
                        <div class="panel-body"></div>
                        <tbody>
                            <?php
                            function getStatus($status)
                            {
                                switch ($status) {
                                    case 0:
                                        return 'Đang chuẩn bị hàng';
                                    case 1:
                                        return 'Đang giao hàng';
                                    case 2:
                                        return 'Đã giao hàng';
                                    case 3:
                                        return 'Đã hủy đơn hàng';
                                    default:
                                        return 'Không xác định';
                                }
                            }

                            if (isset($_COOKIE['username'])) {
                                $username = $_COOKIE['username'];
                                $sql = "SELECT orders.order_date as order_date, orders.delivery_date as delivery_date, 
                                orders.hoten, orders.address, orders.phone, orders.id as id, orders.status as order_status 
                                FROM user JOIN orders ON user.id_user = orders.id_user 
                                WHERE user.username = '$username'
                                ORDER BY orders.order_date DESC";
                                $result = executeResult($sql);
                                foreach ($result as $row) {
                                    $total = 0;
                                    $status = getStatus($row['order_status']);

                                    echo '<div class="product-list">
                                    <div class="product-date-status">
                                        <div class="product-date">Ngày mua: ' . $row['order_date'] . '</div>
                                        <div class="product-status">Status: ' . $status . '</div>
                                        <div class="product-date">Ngày giao hàng: ' . $row['delivery_date'] . '</div>
                                    </div>
                                    <div class="product-date-status">
                                        <div class="product-date">Họ tên: ' . $row['hoten'] . '</div>
                                        <div class="product-status">Số điện thoại: ' . $row['phone'] . '</div>
                                    </div>
                                    <div class="product-date"> Địa chỉ: ' . $row['address'] . '</div>';

                                    $id_orders = $row['id'];
                                    $sql_product = "SELECT product.thumbnail as thumbnail, product.title as title, order_details.number as numbers, 
                                    product.price as price
                                    FROM order_details JOIN product ON order_details.id_product = product.id 
                                    WHERE order_details.id_order = '$id_orders'";

                                    $result_product = executeResult($sql_product);
                                    foreach ($result_product as $row_product) {
                                        echo '<div class="product">
                                                <div class="product-image-title-number">
                                                    <img src="admin/product/' . $row_product['thumbnail'] . '" alt="Bánh" class="product-image" style="width: 200px; height:200px">
                                                    <div class="product-title-number">
                                                        <div class="product-title">' . $row_product['title'] . '</div>
                                                        <div class="product-number">Số lượng: ' . $row_product['numbers'] . '</div>
                                                    </div>
                                                </div>
                                                <div class="product-price">' . number_format($row_product['numbers'] * $row_product['price'], 0, ',', '.') . '<span> VNĐ</span></div>
                                            </div>';
                                        $total += $row_product['numbers'] * $row_product['price'];
                                    }
                                    echo '<div class="product-total">Tổng tiền: ' . number_format($total, 0, ',', '.') . '<span> VNĐ</span></div>
                                        </div>
                                        <hr>';
                                }
                            }
                            ?>
                        </tbody>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once('layout/footer.php'); ?>
    </div>
</body>
<style>
    main {
        padding-bottom: 4rem;
    }

    .b-500 {
        font-weight: 500;
    }

    .bold {
        font-weight: bold;
    }

    .red {
        color: rgba(207, 16, 16, 0.815);
    }

    .orange {
        color: #a25437;
    }

    .product-list {
        font-family: Arial, sans-serif;
        background-color: #F5FCFF;
        margin-top: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .product {
        display: flex;
        justify-content: space-between;
        /* Phân chia không gian đều giữa các phần tử */
        width: 100%;
    }

    .product-image-title-number {
        display: flex;
    }

    .product-image,
    .product-title-number,
    .product-price {
        padding: 10px;
    }

    .product-image {
        width: 50px;
        height: 50px;
    }

    .product-date-status {
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    .product-total {
        text-align: right;
        padding: 10px;
    }
</style>

</html>