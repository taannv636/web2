<?php
require_once('../database/dbhelper.php');

$id_user = $hoten = $username = $password = $phone = $email = $trang_thai = "";

// Check if the user is accessing the page to update an existing user
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $sql = "SELECT * FROM user WHERE id_user=$id_user";
    $user = executeSingleResult($sql);
    if ($user) {
        $hoten = $user['hoten'];
        $username = $user['username'];
        $password = $user['password'];
        $phone = $user['phone'];
        $email = $user['email'];
        $trang_thai = $user['trang_thai'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $hoten = $_POST['hoten'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $trang_thai = $_POST['trang_thai'];

    // Validate form data
    if (!empty($hoten) && !empty($username) && !empty($password) && !empty($phone) && !empty($email)) {
        // Construct SQL query
        if (!empty($id_user)) {
            // Update existing user
            $sql = "UPDATE user SET hoten='$hoten', username='$username', password='$password', phone='$phone', email='$email', trang_thai='$trang_thai' WHERE id_user=$id_user";
        } else {
            // Insert new user
            $sql = "INSERT INTO user (hoten, username, password, phone, email, trang_thai) VALUES ('$hoten', '$username', '$password', '$phone', '$email', '$trang_thai')";
        }

        // Execute SQL query
        execute($sql);

        // Redirect to user list page after saving
        header('Location: index.php');
        exit(); // Stop further execution
    } else {
        // Handle form validation errors
        echo "Please fill in all required fields.";
    }
}
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
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../category/">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý giỏ hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../user/">Quản lý User</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Thêm/Sửa Người Dùng</h2>
            </div>
            <div class="panel-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="hoten">Họ và Tên:</label>
                        <input required="true" type="text" class="form-control" id="hoten" name="hoten" value="<?= $hoten ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Tên Đăng Nhập:</label>
                        <input required="true" type="text" class="form-control" id="username" name="username" value="<?= $username ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại:</label>
                        <input required="true" type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input required="true" type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                    </div>
                    <div class="form-group">
                        <label for="trang_thai">Trạng Thái:</label>
                        <select class="form-control" id="trang_thai" name="trang_thai">
                            <option value="1" <?= $trang_thai == 1 ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="0" <?= $trang_thai == 0 ? 'selected' : '' ?>>Cấm</option>
                        </select>
                    </div>
                    <button class="btn btn-success">Lưu</button>
                    <?php
                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                    ?>
                    <a href="<?= $previous ?>" class="btn btn-warning">Quay Lại</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>