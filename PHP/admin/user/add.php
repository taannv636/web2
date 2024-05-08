<?php
require_once('../database/dbhelper.php');

$id_user = $hoten = $sex = $birthday = $email = $address = $phone = $username = $password = $right = $status = "";

// Check if the user is accessing the page to update an existing user
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];
    $sql = 'SELECT * FROM user WHERE id_user= "' . $id_user . '"';
    $user = executeSingleResult($sql);
    if ($user) {
        $hoten = $user['hoten'];
        $sex = $user['sex'];
        $birthday = $user['birthday'];
        $email = $user['email'];
        $address = $user['address'];
        $phone = $user['phone'];
        $username = $user['username'];
        $password = $user['password'];
        $right = $user['right'];
        $status = $user['status'];
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $hoten = $_POST['hoten'];
    $sex = $_POST['sex'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $username = $_POST['username']; // Add this line for username
    $password = $_POST['password'];
    $status = $_POST['status'];

    // Validate form data
    if (!empty($hoten) && !empty($password) && !empty($phone) && !empty($email) && !empty($username)) { // Add $username to validation

        // Construct SQL query
        if (!empty($id_user)) {
            // Update existing user
            $sql = 'UPDATE user SET hoten="' . $hoten . '", sex="' . $sex . '" , birthday="' . $birthday . '",
             email="' . $email . '",address="' . $address .'",phone="' . $phone . '", username="' . $username . '",
             password="' . $password . '", status="' . $status . '"
            WHERE id_user="' . $id_user . '"';

        } else {
            // Insert new user
            $right = 1;
            $id_user = generateID('id_user','user','KH');
            $sql = 'INSERT INTO user (id_user, hoten, sex, birthday, email, address, phone, username, password, `right`, status) 
            VALUES ("' . $id_user . '", "' . $hoten . '", "' . $sex . '", "' . $birthday . '", "' . $email . '",
            "' . $address . '", "' . $phone . '", "' . $username . '", "' . $password . '", "' . $right . '", "' . $status . '")';

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
            <a class="nav-link active" href="../user/">Quản lý người dùng</a>
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
                        <input type="text" id="id_user" name="id_user" value="<?= $id_user ?>" hidden='true'>
                        <input required="true" type="text" class="form-control" id="hoten" name="hoten" value="<?= $hoten ?>">
                    </div>
                    <div class="form-group">
                        <label for="gender">Giới tính:</label><br>
                        <input type="radio" id="male" name="sex" value="0" <?php echo ($sex == 0 || isset($sex)) ? 'checked' : ''; ?>>
                        <label for="male">Nam</label><br>
                        <input type="radio" id="female" name="sex" value="1" <?php echo ($sex == 1) ? 'checked' : ''; ?>>
                        <label for="female">Nữ</label><br>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh:</label>
                        <input required="true" type="date" class="form-control" id="birthday" name="birthday" value="<?= $birthday ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input required="true" type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                        <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Số Điện Thoại:</label>
                        <input required="true" type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input required="true" type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Mật Khẩu:</label>
                        <input required="true" type="password" class="form-control" id="password" name="password" value="<?= $password ?>">
                    </div>
                    <div class="form-group">
                        <label for="trang_thai">Trạng Thái:</label>
                        <select class="form-control" id="status" name="status">
                            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Hoạt động</option>
                            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Cấm</option>
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