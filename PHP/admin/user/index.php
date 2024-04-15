<?php
require_once('../database/dbhelper.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Quản Lý Người Dùng</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScrseipt -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
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
                        <td>username</td>
                        <td>SĐT</td>
                        <td>Email</td>
                        <td>Trạng thái</td>
                        <td width="50px"></td>
                        <td width="50px"></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Lấy danh sách Sản Phẩm
                    if (!isset($_GET['page'])) {
                        $pg = 1;
                        //echo 'Bạn đang ở trang: 1';
                    } else {
                        $pg = $_GET['page'];
                        //echo 'Bạn đang ở trang: ' . $pg;
                    }

                    try {
                        if (isset($_GET['keyword'])) {
                            $keyword = $_GET['keyword'];
                            $sql = "SELECT * FROM user WHERE hoten LIKE '%$keyword%'";
                        } else {
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $limit = 5;
                            $start = ($page - 1) * $limit;
                            $sql = "SELECT * FROM user limit $start,$limit";
                        }

                        executeResult($sql);
                        $userList = executeResult($sql);

                        $index = 1;
                        foreach ($userList as $item) {
                            echo '  <tr>
                    <td>' . ($index++) . '</td>
                    
                    <td>' . $item['id_user'] . '</td>
                    <td>' . $item['hoten'] . '</td>
                    <td>' . $item['username'] . '</td>
                    <td>' . $item['phone'] . '</td>
                    <td>' . $item['email'] . '</td>
                    <td>' . $item['trang_thai'] . '</td>
                    <td>
                        <a href="add.php?id_user=' . $item['id_user'] . '">
                            <button class=" btn btn-warning">Sửa</button> 
                        </a> 
                    </td>
                    <td>            
                    <button class="btn btn-danger" onclick="deleteUser(' . $item['id_user'] . ')">Xoá</button>
                    </td>
                </tr>';
                        }
                    } catch (Exception $e) {
                        die("Lỗi thực thi sql: " . $e->getMessage());
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <ul class="pagination">
            <?php
            $sql = "SELECT * FROM `user`";
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result)) {
                $numrow = mysqli_num_rows($result);
                $current_page = ceil($numrow / 5);
                // echo $current_page;
            }
            for ($i = 1; $i <= $current_page; $i++) {
                // Nếu là trang hiện tại thì hiển thị thẻ span
                // ngược lại hiển thị thẻ a
                if ($i == $pg) {
                    echo '
        <li class="page-item active"><a class="page-link" style="color: yellow; font-weight: bold;" href="?page=' . $i . '">' . $i . '</a></li>';
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


    <script type="text/javascript">
        function deleteUser(id_user) {
            var option = confirm('Bạn có chắc chắn muốn xoá user này không?')
            if (!option) {
                return;
            }

            console.log(id_user)
            //ajax - lenh post
            $.post('ajax.php', {
                'id_user': id_user,
                'action': 'delete'
            }, function(data) {
                console.log("Xóa thành công")
                location.reload()
            })
        }
    </script>
</body>

</html>