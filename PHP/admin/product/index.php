<?php
require_once('../database/dbhelper.php');

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
            <a class="nav-link active" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý đơn hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../user">Quản lý người dùng</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Quản lý Sản Phẩm</h2>
            </div>
            <div class="panel-body"></div>
            <a href="add.php">
                <button class=" btn btn-success" style="margin-bottom:20px">Thêm Sản Phẩm</button>
            </a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="font-weight: 500;">
                        <td width="30px">STT</td>
                        <td width="30px">Mã sản phẩm</td>
                        <td>Tên Sản Phẩm
                        <div><br></div>
                        <div class="filter">
                            <label for="sort"></label></label>
                            <select id="sort">
                            <option value="" >Tất cả</option> <!-- Option mới để quay lại trạng thái ban đầu -->
                                <option value="name_az">A-Z</option>
                                <option value="name_za">Z-A</option>
                            </select>
                        </div>
                       
                        </td>
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
                    // Lấy danh sách Sản Phẩm
                    if (!isset($_GET['page'])) {
                        $pg = 1;
                        echo 'Bạn đang ở trang: 1';
                    } else {
                        $pg = $_GET['page'];
                        echo 'Bạn đang ở trang: ' . $pg;
                    }

                    try {

                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                       
                        $limit = 5;
                        $start = ($page - 1) * $limit;
                       
                        $sortOption = isset($_GET['sort']) ? $_GET['sort'] : '';
                            if ($sortOption == 'name_az') {
                                $sql = "SELECT p.*, c.name 
                                    FROM product AS p 
                                    LEFT JOIN category AS c ON p.id_category = c.id 
                                    ORDER BY p.title ASC 
                                    LIMIT $start, $limit";
                            }
                        
                        else{
                        $sql = "SELECT p.*, c.name 
                        FROM product AS p 
                        LEFT JOIN category AS c ON p.id_category = c.id 
                        LIMIT $start, $limit";
                        
                        //$sql = "SELECT * FROM product limit $start,$limit"; 
                        }
              
                        $productList = executeResult($sql);                        
                        $index = 1;

                        function getStatus($stt)
                        {
                            $status_text = '';
                            switch ($stt) {
                                case 0:
                                    $status_text = 'Ngừng kinh doanh';
                                    break;
                                case 1:
                                    $status_text = 'Còn kinh doanh';
                                    break;
                                case 2:
                                    $status_text = 'Tạm ngừng kinh doanh';
                                    break;
                                default:
                                    $status_text = 'Không xác định';
                                    break;
                            }
                            return $status_text;
                        }
                       
                        //bỏ content 
                        foreach ($productList as $item) {
                            echo '  <tr>
                    <td>' . ($index++) . '</td>
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
                            <button class=" btn btn-warning">Sửa</button> 
                        </a> 
                    </td>
                    <td>            
                    <button class="btn btn-danger" onclick="deleteProduct(\'' . $item['id'] . '\')">Xoá</button>
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
            $sql = "SELECT * FROM `product`";
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
    <script type="text/javascript">
        function deleteProduct(id) {
            var option = confirm('Bạn có chắc chắn muốn xoá sản phẩm này không?')
            if (!option) {
                return;
            }

            console.log(id)
            //ajax - lenh post
            $.post('ajax.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload()
            })
        }
    </script>
</body>

</html>