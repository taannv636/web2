<?php
require_once('../database/dbhelper.php');

// Initialize $start with a default value
$start = 0;
$keyword = ''; // Initialize $keyword

if (isset($_GET['page'])) {
    $pg = $_GET['page'];
} else {
    $pg = 1;
}

try {
    function getStatus($stt)
    {
        $status_class = '';
        $status_text = '';

        switch ($stt) {
            case 0:
                $status_class = 'text-danger';
                $status_text = 'Cấm';
                break;
            case 1:
                $status_class = 'text-success';
                $status_text = 'Hoạt động';
                break;
            default:
                $status_class = 'text-warning';
                $status_text = 'Không xác định';
                break;
        }
        return '<span class="' . $status_class . '">' . $status_text . '</span>';
    }

    $limit = 5;
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
        // Count total search results
        $sqlCount = "SELECT COUNT(*) as total FROM user WHERE hoten LIKE '%$keyword%' OR hoten LIKE '%$keyword%'";
        $resultCount = executeSingleResult($sqlCount);
        $totalRecords = $resultCount['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);

        // Calculate start offset
        $start = ($pg - 1) * $limit;

        // Fetch search results for the current page
        $sql = "SELECT * FROM user WHERE hoten LIKE '%$keyword%' OR hoten LIKE '%$keyword%' LIMIT $start, $limit";
    } else {
        // Fetch all users without search keyword
        $sqlCount = "SELECT COUNT(*) as total FROM user";
        $resultCount = executeSingleResult($sqlCount);
        $totalRecords = $resultCount['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);

        $start = ($pg - 1) * $limit;
        $sql = "SELECT * FROM user LIMIT $start, $limit";
    }

    $userList = executeResult($sql);
} catch (Exception $e) {
    die("Lỗi thực thi sql: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Người Dùng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .text-danger {
            color: red;
        }

        .text-success {
            color: green;
        }

        .text-warning {
            color: yellow;
        }
    </style>
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="../category/">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý giỏ hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../user/">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../../index.php" style="font-weight: bold; color: red">Đăng xuất</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý Người Dùng</h2>
            </div>
            <div class="panel-body"></div>
            <form action="" method="get" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Tìm kiếm theo họ tên">
                </div>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
            <br>
            <a href="add.php">
                <button class=" btn btn-success" style="margin-bottom:20px">Thêm Người dùng</button>
            </a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="font-weight: 500;">
                        <td width="70px">STT</td>
                        <td>ID</td>
                        <td>Họ tên</td>
                        <td>Username</td>
                        <td>SĐT</td>
                        <td>Email</td>
                        <td>Trạng thái</td>
                        <td width="50px"></td>
                        <td width="50px"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = $start + 1;
                    foreach ($userList as $item) {
                        echo '
                            <tr>
                                <td>' . ($index++) . '</td>
                                <td>' . $item['id_user'] . '</td>
                                <td>' . $item['hoten'] . '</td>
                                <td>' . $item['username'] . '</td>
                                <td>' . $item['phone'] . '</td>
                                <td>' . $item['email'] . '</td>
                                <td>' . getStatus($item['status']) . '</td>
                                <td>
                                    <a href="add.php?id_user=' . $item['id_user'] . '">
                                        <button class=" btn btn-warning">Sửa</button> 
                                    </a> 
                                </td>
                                <td>            
                                    <button class="btn btn-danger" onclick="deleteUser(\'' . $item['id_user'] . '\')">Xoá</button>
                                </td>
                            </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

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

    <script type="text/javascript">
        function deleteUser(id_user) {
            var option = confirm('Bạn có chắc chắn muốn xoá user này không?')
            if (!option) {
                return;
            }

            console.log(id_user)
            $.post('ajax.php', {
                'id_user': id_user,
                'action': 'delete'
            }, function(data) {
                console.log("Xóa thành công")
                location.reload()
            })
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