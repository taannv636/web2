<?php
require_once('database/dbhelper.php');

// Initialize variables for pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 10;
$start = ($page - 1) * $limit;

// Initialize variables for search conditions
$condition = '';
$params = [];

// Build search conditions
if (!empty($_GET['status'])) {
    $params[] = "orders.status = " . $_GET['status'];
}
if (!empty($_GET['delivery_date'])) {
    $params[] = "orders.delivery_date = '" . $_GET['delivery_date'] . "'";
}
if (!empty($_GET['address'])) {
    $params[] = "user.address LIKE '%" . $_GET['address'] . "%'";
}

// Handle date range
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $params[] = "orders.delivery_date BETWEEN '$start_date' AND '$end_date'";
}

// Combine conditions
if (!empty($params)) {
    $condition = "WHERE " . implode(" AND ", $params);
}

// SQL query to fetch orders
$sql = "SELECT orders.id AS order_id, 
                order_details.id_order AS order_detail_id, 
                user.hoten, user.address, user.phone, 
                product.price, orders.status, order_details.number,
                SUM(order_details.number * product.price) AS totalPrice
        FROM orders
        INNER JOIN order_details ON order_details.id_order = orders.id
        INNER JOIN user ON user.id_user = orders.id_user
        INNER JOIN product ON product.id = order_details.id_product
        $condition
        GROUP BY order_detail_id
        ORDER BY orders.order_date DESC";

// Get total records
$total_sql = "SELECT COUNT(*) as total FROM ($sql) as sub";
$total_records = executeSingleResult($total_sql)['total'];

// Calculate total pages for pagination
$total_pages = ceil($total_records / $limit);

// Append pagination to the main query
$sql .= " LIMIT $start, $limit";

$order_details_List = executeResult($sql);

// Function to get status text
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

// Function to get CSS class based on status
function getStatusColorClass($status)
{
    switch ($status) {
        case 0:
            return 'brown';
        case 1:
            return 'blue';
        case 2:
            return 'green';
        case 3:
            return 'red';
        default:
            return ''; // Default class if status does not match
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quản lý Đơn Hàng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
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
        <li class="nav-item">
            <a class="nav-link" href="../index.php" style="font-weight: bold; color: red">Đăng xuất</a>
        </li>
    </ul>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý đơn hàng</h2>
            </div>
            <div class="panel-body">
                <!-- Search form -->
                <form action="" method="GET" class="mt-3 mb-3">
                    <div class="form-row align-items-end">
                        <div class="col-auto">
                            <label for="status">Tình trạng</label>
                            <select class="custom-select" id="status" name="status">
                                <option value="">Chọn tình trạng</option>
                                <option value="1" <?= ($_GET['status'] ?? '') == '1' ? 'selected' : '' ?>>Đang chuẩn bị hàng</option>
                                <option value="2" <?= ($_GET['status'] ?? '') == '2' ? 'selected' : '' ?>>Đang giao hàng</option>
                                <option value="3" <?= ($_GET['status'] ?? '') == '3' ? 'selected' : '' ?>>Đã giao hàng</option>
                                <option value="4" <?= ($_GET['status'] ?? '') == '4' ? 'selected' : '' ?>>Đã hủy đơn hàng</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <label for="start_date">Từ ngày</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>">
                        </div>
                        <div class="col-auto">
                            <label for="end_date">Đến ngày</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>">
                        </div>
                        <div class="col-auto">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ" value="<?= $_GET['address'] ?? '' ?>">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
                <!-- End of search form -->

                <!-- Table for displaying orders -->
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr style="font-weight: 500;text-align: center;">
                            <th width="50px">STT</th>
                            <th width="50px">Mã đơn</th>
                            <th width="250px">Tên khách hàng</th>
                            <th width="350px">Địa chỉ</th>
                            <th width="150px">Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th width="100px">Chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $count = 0;
                        foreach ($order_details_List as $item) {
                            $count++;
                        ?>
                            <tr style="text-align: center;">
                                <td><?= $count ?></td>
                                <td><?= $item['order_id'] ?></td>
                                <td><?= $item['hoten'] ?></td>
                                <td><?= $item['address'] ?></td>
                                <td class="b-500 red"><?= number_format($item['totalPrice'], 0, ',', '.') ?><span> VNĐ</span></td>
                                <td style="color: <?= getStatusColorClass($item['status']) ?>"><?= getStatus($item['status']) ?></td>
                                <td>
                                    <a href="edit.php?order_id=<?= $item['order_id'] ?>" class="btn btn-success">Edit</a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <!-- End of table -->

                <!-- Pagination -->
                <ul class="pagination">
                    <?php
                    // Display pagination links
                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            echo '<li class="page-item active"><a class="page-link" style="color: yellow; font-weight: bold;" href="?page=' . $i . '">' . $i . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                        }
                    }
                    ?>
                </ul>
                <!-- End of pagination -->
            </div>
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
