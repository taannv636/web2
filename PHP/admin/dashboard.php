<?php require_once('database/dbhelper.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản lý Đơn Hàng</title>
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
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="category/index.php">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item ">
            <a class="nav-link active" href="dashboard.php">Quản lý đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user/">Quản lý người dùng</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý đơn hàng</h2>
            </div>
            <div class="panel-body">
                <form action="" method="POST">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="font-weight: 500;text-align: center;">
                                <td width="50px">STT</td>
                                <td width="50px">Mã đơn</td>
                                <td width="250px">Tên khách hàng</td>
                                <td width="350px">Địa chỉ</td>
                                <td width="150px">Tổng tiền</td>
                                <td>Trạng thái</td>
                                <!-- <td width="50px">Lưu</td> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {

                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                $limit = 10;
                                $start = ($page - 1) * $limit;
                                
                                $sql = "SELECT orders.id AS order_id, 
                                order_details.id_order AS order_detail_id, 
                                user.hoten, user.address, user.phone, 
                                product.price, orders.status, order_details.number,
                                SUM(order_details.number * product.price) AS totalPrice
                        FROM orders
                        INNER JOIN order_details ON order_details.id_order = orders.id
                        INNER JOIN user ON user.id_user = orders.id_user
                        INNER JOIN product ON product.id = order_details.id_product
                        GROUP BY order_detail_id
                        ORDER BY orders.order_date DESC LIMIT $start, $limit";
                
                
                      $order_details_List = executeResult($sql);


                        $total = 0;
                        $count = 0;
                        
                        //combobox status for orders
                        function getStatus($stt)
                        {
                            $status_text = '';
                            switch ($stt) {
                                case 1:
                                    $status_text = 'Đang chuẩn bị hàng';
                                    break;
                                case 2:
                                    $status_text = 'Đang giao hàng';
                                    break;
                                case 3:
                                    $status_text = 'Đã giao hàng';
                                    break;
                                case 4:
                                    $status_text = 'Đã hủy đơn hàng';
                                    break;
                                default:
                                    $status_text = 'Không xác định';
                                    break;
                            }
                            return $status_text;
                        }
                      
                        // Hàm trả về class CSS tương ứng với trạng thái
                        function getStatusColorClass($status) {
                            switch ($status) {
                                case 1:
                                    return 'brown';
                                case 2:
                                    return 'blue';
                                case 3:
                                    return 'green';
                                case 4:
                                    return 'red';
                                default:
                                    return ''; // Trả về class mặc định nếu không có trạng thái nào khớp
                            }
                        }
                                                 
                        foreach ($order_details_List as $item) {
                           
                            echo '
                                <tr style="text-align: center;">
                                    <td width="50px">' . (++$count) . '</td>
                                    <td style="text-align:center" id="id_order" value="' . $item['order_id'] . '">' . $item['order_id'] . '</td>
                                    <td>' . $item['hoten'] . '</td>
                                    <td width="100px">' . $item['address'] . '</td>
                                    <td class="b-500 red">' . number_format($item['totalPrice'], 0, ',', '.') . '<span> VNĐ</span></td>
                                    <td width="100px" style="color: ' . getStatusColorClass($item['status']) . '">' . getStatus($item['status']) . '</td>
                                    <td width="100px">
                                        <a href="edit.php?order_id=' . $item['order_id'] . '" class="btn btn-success">Edit</a>
                                    </td>
                                </tr>
                            ';
                        }
                        
                        
                            } catch (Exception $e) {
                                die("Lỗi thực thi sql: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <ul class="pagination">
                <?php
                $sql = "SELECT * from orders, order_details, product
                where order_details.id_order=orders.id and product.id=order_details.id_product";
                $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                $result = mysqli_query($conn, $sql);
                $current_page = 0;
                if (mysqli_num_rows($result)) {
                    $numrow = mysqli_num_rows($result);
                    $current_page = ceil($numrow / 10);
                }
                for ($i = 1; $i <= $current_page; $i++) {
                    // Nếu là trang hiện tại thì hiển thị thẻ span
                    // ngược lại hiển thị thẻ a
                    if ($i == $current_page) {
                        echo '
            <li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                    } else {
                        echo '
            <li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>
                    ';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</body>
<style>
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