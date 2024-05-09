<?php
require_once('../database/dbhelper.php');

// Function to get product status text based on status code
function getStatus($stt)
{
    $status_text = '';
    switch ($stt) {
        case 0:
            $status_text = 'Ngừng kinh doanh';
            break;
        case 1:
            $status_text = 'Tạm ngừng kinh doanh';
            break;
        case 2:
            $status_text = 'Còn kinh doanh';
            break;
        default:
            $status_text = 'Không xác định';
            break;
    }
    return $status_text;
}

// Initialize $start with a default value
$start = 0;
$keyword = ''; // Initialize $keyword

if (isset($_GET['page'])) {
    $pg = $_GET['page'];
} else {
    $pg = 1;
}

try {
    $limit = 5;
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        // Count total search results
        $sqlCount = "SELECT COUNT(*) as total FROM product WHERE title LIKE '%$keyword%' OR title LIKE '%$keyword%'";
        $resultCount = executeSingleResult($sqlCount);
        $totalRecords = $resultCount['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);

        // Calculate start offset
        $start = ($pg - 1) * $limit;

        // Fetch search results for the current page
        $sql = "SELECT p.*,c.name FROM product AS p LEFT JOIN category AS c ON p.id_category = c.id
        WHERE title LIKE '%$keyword%' OR title LIKE '%$keyword%' 
        LIMIT $start, $limit";
    } else {
        // Fetch all users without search keyword
        $sqlCount = "SELECT COUNT(*) as total FROM product";
        $resultCount = executeSingleResult($sqlCount);
        $totalRecords = $resultCount['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);

        $start = ($pg - 1) * $limit;
        $sql = "SELECT p.*,c.name FROM product AS p LEFT JOIN category AS c ON p.id_category = c.id
        LIMIT $start, $limit";
    }

    $productList = executeResult($sql);

} catch (Exception $e) {
    die("Lỗi thực thi sql: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Sản Phẩm</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Navigation menu -->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../category/">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../user">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../index.php" style="font-weight: bold; color: red">Đăng xuất</a>
        </li>
    </ul>

    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý Sản Phẩm</h2>
            </div>
            <div class="panel-body"></div>

            <!-- Search form -->
            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Tìm kiếm theo tên">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
            <!-- Add product button -->
            <a href="add.php">
                <button class="btn btn-success" style="margin-bottom:20px">Thêm Sản Phẩm</button>
            </a>

            <!-- Product table -->
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="font-weight: 500;">
                        <td width="30px">STT</td>
                        <td width="30px">Mã sản phẩm</td>
                        <td>Tên Sản Phẩm</td>
                        <td>Thumbnail</td>
                        <td>Giá</td>
                        <td>Số lượng</td>
                        <td>Trạng thái</td>
                        <td>Danh mục</td>
                        <td width="50px"></td>
                        <td width="50px"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display search result
                    foreach ($productList as $index => $item) {
                        echo '<tr>
                                <td>' . ($index + 1) . '</td>
                                <td>' . $item['id'] . '</td>
                                <td>' . $item['title'] . '</td>
                                <td style="text-align:center">
                                    <img src="' . $item['thumbnail'] . '" alt="" style="width: 50px">
                                </td>
                                <td>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</td>
                                <td>' . $item['number'] . '</td>
                                <td>' . getStatus($item['status']) . '</td>   
                                <td>' . $item['name'] . '</td>
                                <td>
                                    <a href="add.php?id=' . $item['id'] . '">
                                        <button class="btn btn-warning">Sửa</button> 
                                    </a> 
                                </td>
                                <td>            
                                    <button class="btn btn-danger" onclick="deleteProduct(\'' . $item['id'] . '\')">Xoá</button>
                                </td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <ul class="pagination">
            <?php
            if (isset($totalPages)) {
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $pg) {
                        echo '
                            <li class="page-item active">
                                <a class="page-link" style="color: yellow; font-weight: bold;" href="?keyword=' . urlencode($keyword) . '&page=' . $i . '">' . $i . '</a>
                            </li>';
                    } else {
                        echo '
                            <li class="page-item">
                                <a class="page-link" href="?keyword=' . urlencode($keyword) . '&page=' . $i . '">' . $i . '</a>
                            </li>';
                    }
                }
            }
            ?>
        </ul>
        </div>
    </div>

    <!-- JavaScript function for deleting product -->
    <script type="text/javascript">
    function deleteProduct(id) {
        var option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
        if (!option) {
            return;
        }

        $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: {
                'id': id,
                'action': 'checkExistence'
            },
            success: function(data) {
                if (data === 'true') {
                    var option1 = confirm('Đã có đơn hàng được mua với sản phẩm này. \n Bạn có muốn đặt lại trạng thái của sản phẩm về "Ngừng kinh doanh" không?');
                    if (option1) {
                        // Change product status to 0 (stopped selling)
                        $.post('ajax.php', {
                            'id': id,
                            'action': 'changeStatus'
                        }, function(data) {
                            location.reload();
                        });
                    }
                } else {
                    // Delete the product
                    $.post('ajax.php', {
                        'id': id,
                        'action': 'delete'
                    }, function(data) {
                        location.reload();
                    });
                }
            }
        });
    }
</script>
<script type="text/javascript">
        document.addEventListener('keydown', function(event) {
            if (event.keyCode == 37) { // Mũi tên trái
                var currentPage = parseInt("<?php echo $pg; ?>");
                if (currentPage > 1) {
                    window.location.href = '?keyword=' + encodeURIComponent("<?php echo $keyword; ?>") + '&page=' + (currentPage - 1);
                }
            } else if (event.keyCode == 39) { // Mũi tên phải
                var currentPage = parseInt("<?php echo $pg; ?>");
                var totalPages = parseInt("<?php echo $totalPages; ?>");
                if (currentPage < totalPages) {
                    window.location.href = '?keyword=' + encodeURIComponent("<?php echo $keyword; ?>") + '&page=' + (currentPage + 1);
                }
            }
        });
    </script>

</body>

</html>
