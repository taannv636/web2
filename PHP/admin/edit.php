<?php

use function PHPSTORM_META\type;

require_once('database/dbhelper.php');

// Khai báo biến
$id_order = $hoten = $email = $address = $phone = "";
$status = "";

// Xử lý khi nhận dữ liệu từ form POST
if (isset($_POST['id'])) {
    $id_order = $_POST['id'];
    // Kiểm tra và xử lý dữ liệu nếu cần
      $id_order = str_replace('"', '\\"', $id_order);
}

if (isset($_POST['status'])) {
    $status = $_POST['status'];
    // Kiểm tra và xử lý dữ liệu nếu cần
      $status = str_replace('"', '\\"', $status);
}


// Xử lý khi form được gửi đi và trạng thái không rỗng
if (!empty($status)) {
    // Thực hiện câu lệnh SQL cập nhật trạng thái đơn hàng
    
    $sql = 'UPDATE orders SET status="' . $status . '"
            WHERE id = "' . $id_order . '"';
    execute($sql);
    
    header('Location: dashboard.php');
    die();
}

// Truy vấn dữ liệu từ CSDL để hiển thị thông tin đơn hàng
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    // Truy vấn thông tin đơn hàng theo id
    $sql = "SELECT orders.id AS id_order,
            user.hoten, user.email, user.address, user.phone,
            orders.order_date, orders.payment, orders.status
            FROM orders
            INNER JOIN user ON user.id_user = orders.id_user
            WHERE orders.id = '$order_id'"; // Sử dụng single quotes để bọc $order_id
    $order = executeSingleResult($sql);
    // Kiểm tra nếu có kết quả trả về từ CSDL
    if ($order != null) {
        // Gán các giá trị từ kết quả truy vấn vào biến
        $id_order = $order['id_order'];
        $hoten = $order['hoten'];
        $email = $order['email'];
        $address = $order['address'];
        $phone = $order['phone'];
        $order_date = $order['order_date'];
        $payment = $order['payment'];
        $status = $order['status'];
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Giỏ hàng</title>
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
            <a class="nav-link active" href="dashboard.php">Quản lý giỏ hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="user/">Quản lý người dùng</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Sửa Đơn Hàng</h2>
            </div>
            <div class="panel-body">
            <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Mã đơn hàng:</label>
                        <input type="text" class="form-control" id="id_order" name="id" value="<?= $id_order ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Tên khách hàng:</label>
                        <input type="text" class="form-control" id="hoten" name="hoten" value="<?= $hoten ?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Số điện thoại:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Địa chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Email:</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="name">Ngày đặt hàng:</label>
                        <input type="text" class="form-control" id="order_date" name="order_date" value="<?= $order_date ?>" readonly>
                    </div>
                    

                    <div class="form-group">
                        <label for="name">Hình thức trả tiền:</label>
                        <?php
                        // Xử lý gán giá trị cho biến $status_text
                        $status_text = '';
                        switch ($payment) {
                            case 0:
                                $status_text = 'Trả tiền mặt';
                                break;
                            case 1:
                                $status_text = 'Chuyển khoản';
                                break;
                            default:
                                $status_text = 'Không xác định';
                                break;
                        }
                        ?>
                        <!-- Hiển thị giá trị của biến $status_text -->
                        <div class="form-control"id="payment" name="payment" value="<?= $payment ?> "><?= $status_text ?></div>
                    </div>

                    <!-- Status  -->
                    <div class="form-group">
                <label for="exampleFormControlSelect1">Trạng Thái Đơn Hàng</label>
                <select class="form-control" id="status" name="status">
                    <option>Chọn trạng thái</option>
                    <?php
                    // Lấy dữ liệu trạng thái từ cơ sở dữ liệu
                    $sql = 'SELECT DISTINCT status FROM orders';
                    $statusList = executeResult($sql);

                    // Duyệt qua danh sách trạng thái và hiển thị trong dropdown
                    foreach ($statusList as $item) {
                        // Chuyển đổi trạng thái sang văn bản
                        $status_text = '';
                        switch ($item['status']) {
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

                        // Kiểm tra xem trạng thái hiện tại có phải là trạng thái mặc định không
                        $selected = ($item['status'] == $status) ? 'selected' : '';

                        // Hiển thị option trong dropdown
                        echo '<option value="' . $item['status'] . '" ' . $selected . '>' . $status_text . '</option>';
                    }
                    ?>
                </select>
            </div>

                    </div>

                    <button type="submit" class="btn btn-success" name="save">Lưu</button>
               
                    <?php
                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                    ?>
                    <a href="<?= $previous ?>" class="btn btn-warning">Back</a>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function updateThumbnail() {
            $('#img_thumbnail').attr('src', $('#thumbnail').val())
        }
        $(function() {
            //doi website load noi dung => xu ly phan js
            $('#content').summernote({
                height: 200
            });
        })
    </script>
    
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

                    </tr>
                </thead>
                <tbody>
                <?php
                try {

                    if (!isset($_GET['page'])) {
                        $pg = 1;
                        echo 'Bạn đang ở trang: 1';
                    } else {
                        $pg = $_GET['page'];
                        echo 'Bạn đang ở trang: ' . $pg;
                    }

                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                       
                        $limit = 5;
                        $start = ($page - 1) * $limit;
                       
                       
              $sql = "SELECT product.id, product.title, product.thumbnail, product.price,
              order_details.number
              FROM order_details 
              LEFT JOIN product ON order_details.id_product = product.id 
              WHERE order_details.id_order = '$id_order'
              ORDER BY product.title ASC
                            LIMIT $start, $limit";

                    $productList = executeResult($sql);

                    $index = 1;

                    // Hiển thị danh sách sản phẩm
                    foreach ($productList as $item) {
                        echo '<tr>
                            <td>' . ($index++) . '</td>
                            <td>' . $item['id'] . '</td>
                            <td>' . $item['title'] . '</td>
                            <td style="text-align:center">
                                <img src="' . 'product/' . $item['thumbnail'] . '" alt="" style="width: 100px">
                                
                            </td>
                            <td>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</td>
                            <td>' . $item['number'] . '</td>
                        </tr>';
                    }
                }catch (Exception $e) {
                    die("Lỗi thực thi sql: " . $e->getMessage());
                }
            
                ?>
                <script>
                var currentThumbnail = "<?= $thumbnail ?>";
                var thumbnailInput = document.getElementById('thumbnail');
                var imgThumbnail = document.getElementById('img_thumbnail');

                // Kiểm tra xem người dùng đã chọn hình mới hay không
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function(){
                        imgThumbnail.src = reader.result;
                    };
                    
                    // Nếu người dùng đã chọn hình mới
                    if (event.target.files.length > 0) {
                        reader.readAsDataURL(event.target.files[0]);
                    } else {
                        // Nếu không có hình mới được chọn, giữ nguyên đường dẫn hình ảnh hiện tại
                        imgThumbnail.src = currentThumbnail;
                        // Đặt giá trị mặc định cho input file
                        thumbnailInput.value = "";
                    }
                }
            </script>
            </tbody>

            </table>
        </div>

        <ul class="pagination">
            <?php
            $sql = "SELECT product.id, product.title, product.thumbnail, product.price,order_details.number
            FROM order_details 
            LEFT JOIN product ON  order_details.id_product = product.id 
            WHERE order_details.id_order = ' . $id_order . '
            ORDER BY product.title ASC";
            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
            $result = mysqli_query($conn, $sql);
            $current_page = 0;
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
</body>
<style>
    .b-500 {
        font-weight: 500;
    }

    .red {
        color: red;
    }
</style>

</html>