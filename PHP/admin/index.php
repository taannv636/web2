<?php require_once "database/dbhelper.php"; ?>
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
                <li class="nav-item">
                    <a class="nav-link" href="../index.php" style="font-weight: bold; color: red">Đăng xuất</a>
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
                            $conn = mysqli_connect(
                                HOST,
                                USERNAME,
                                PASSWORD,
                                DATABASE
                            );
                            $result = mysqli_query($conn, $sql);
                            echo "<span>" .
                                mysqli_num_rows($result) .
                                "</span>";
                            ?>
                            <p><a href="product/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp kh">
                            <p>Người dùng</p>
                            <?php
                            $sql = "SELECT * FROM `user`";
                            $result = mysqli_query($conn, $sql);
                            echo "<span>" .
                                mysqli_num_rows($result) .
                                "</span>";
                            ?>
                            <p><a href="user/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp dm">
                            <p>Danh mục</p>
                            <?php
                            $sql = "SELECT * FROM `category`";
                            $result = mysqli_query($conn, $sql);
                            echo "<span>" .
                                mysqli_num_rows($result) .
                                "</span>";
                            ?>
                            <p><a href="category/">xem chi tiết➜</a></p>
                        </div>
                        <div class="sp dh">
                            <p>Đơn hàng</p>
                            <?php
                            $sql = "SELECT * FROM `order_details`";
                            $result = mysqli_query($conn, $sql);
                            echo "<span>" .
                                mysqli_num_rows($result) .
                                "</span>";
                            ?>
                            <p><a href="dashboard.php">xem chi tiết➜</a></p>
                        </div>
                    </div>
                </section>

                <section class="dashboard">
                    <h2>Thống kê 5 khách hàng có mức mua hàng cao nhất</h2>
                    <form action="" method="GET">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <div class="form-group">
                                    <label for="start_date">Từ ngày:</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="form-group">
                                    <label for="end_date">Đến ngày:</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>
                            </div>
                            <div class="col-auto align-self-center">
                                <button type="submit" class="btn btn-primary">Thống kê</button>
                            </div>
                        </div>
                    </form>

                    <?php // Xử lý khi nhấn nút "Thống kê"
                    if (
                        $_SERVER["REQUEST_METHOD"] == "GET" &&
                        isset($_GET["start_date"]) &&
                        isset($_GET["end_date"])
                    ) {
                        $start_date = $_GET["start_date"];
                        $end_date = $_GET["end_date"];

                        // Truy vấn SQL để lấy dữ liệu khách hàng và tổng tiền mua hàng của họ trong khoảng thời gian đã chỉ định
                        $sql = "SELECT user.id_user, user.hoten, user.phone, COUNT(*) AS num_orders, SUM(order_details.number * product.price) AS total_spent
                FROM orders
                INNER JOIN order_details ON order_details.id_order = orders.id
                INNER JOIN user ON user.id_user = orders.id_user
                INNER JOIN product ON product.id = order_details.id_product
                WHERE orders.delivery_date BETWEEN '$start_date' AND '$end_date'
                GROUP BY user.id_user
                ORDER BY total_spent DESC
                LIMIT 5";

                        $top_customers = executeResult($sql);

                        // Hiển thị kết quả
                        if ($top_customers) {
                            echo '<div class="new-order">
                    <table class="table">
                        <tr class="bold">
                            <td>STT</td>
                            <td>Tên khách hàng</td>
                            <td>Số lượng đơn</td>
                            <td>Số điện thoại</td>
                            <td>Tổng tiền mua hàng</td>
                        </tr>';
                            $count = 0;
                            foreach ($top_customers as $customer) {
                                $count++;
                                echo '<tr>
                        <td>' .
                                    $count .
                                    '</td>
                        <td>' .
                                    $customer["hoten"] .
                                    '</td>
                        <td>' .
                                    $customer["num_orders"] .
                                    '</td>
                        <td>' .
                                    $customer["phone"] .
                                    '</td>
                        <td>' .
                                    number_format(
                                        $customer["total_spent"],
                                        0,
                                        ",",
                                        "."
                                    ) .
                                    ' VNĐ</td>
                    </tr>';
                            }
                            echo '</table>
                </div>';
                        } else {
                            echo "<p>Không có dữ liệu thống kê cho khoảng thời gian này.</p>";
                        }
                    } ?>
                </section>

                <section class="dashboard">
                    <h2>Biểu đồ doanh thu theo tháng trong năm 2024</h2>
                    <canvas id="revenueChart"></canvas>
                </section>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    var ctx = document.getElementById('revenueChart').getContext('2d');

                    var months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
                    var revenues = <?php echo json_encode(
                                        getMonthlyRevenue()
                                    ); ?>;

                    var revenueChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: months,
                            datasets: [{
                                label: 'Doanh thu',
                                data: revenues,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }

                    });

                    // Function to get monthly revenue data
                    <?php // Định nghĩa hàm getMonthlyRevenue
                    function getMonthlyRevenue()
                    {
                        // Thực hiện truy vấn để lấy dữ liệu doanh thu hàng tháng từ cơ sở dữ liệu
                        $sql = "SELECT MONTH(order_date) AS month, SUM(order_details.number * product.price) AS total_revenue
            FROM orders
            INNER JOIN order_details ON orders.id = order_details.id_order
            INNER JOIN product ON order_details.id_product = product.id
            WHERE YEAR(order_date) = YEAR(CURDATE())
            GROUP BY MONTH(order_date)
            ORDER BY MONTH(order_date)";

                        // Thực thi truy vấn và lấy kết quả
                        $result = executeResult($sql);

                        // Xử lý kết quả và trả về dữ liệu dưới dạng mảng
                        $revenues = array_fill(0, 12, 0);
                        foreach ($result as $data) {
                            $month = intval($data["month"]) - 1;
                            $revenues[$month] = intval($data["total_revenue"]);
                        }

                        // Trả về dữ liệu doanh thu hàng tháng dưới dạng JSON
                        return $revenues;
                    } ?>
                </script>


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