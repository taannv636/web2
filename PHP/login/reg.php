<?php
require_once('../database/config.php');
require_once('../database/dbhelper.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['hoten'])  
    && !empty($_POST['password']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
        
        $username = $_POST['username'];
        $hoten = $_POST['hoten'];
        $sex = $_POST['sex'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        // Check if passwords match
        if ($password != $repassword) {
            echo '<script language="javascript">
                        alert("Mật khẩu không trùng khớp, vui lòng nhập lại!");
                        window.location = "reg.php";
                  </script>';
            exit(); // Stop further execution
        }
        
        // Check if username or email is already in use
        $sql_check_duplicate = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
        $result_check_duplicate = executeSingleResult($sql_check_duplicate);
        if ($result_check_duplicate) {
            echo '<script language="javascript">
                     alert("Tài khoản hoặc Email đã được sử dụng!");
                     window.location = "reg.php";
                 </script>';
            exit(); // Stop further execution
        }
        
        // Insert new user into the database
        $status = 1;
        $right = 1;
        $id_user = generateID('id_user','user','KH');
        $sql_insert_user = "INSERT INTO user (id_user, username, hoten, sex, birthday, email, address, phone, password, `right`, status) 
                            VALUES ('$id_user', '$username', '$hoten', '$sex', '$birthday', '$email', '$address', '$phone', '$password', '$right', '$status')";
        execute($sql_insert_user);
        
        echo '<script language="javascript">
                  alert("Bạn đã đăng ký thành công!");
                  window.location = "login.php";
              </script>';
        exit(); // Stop further execution
    } else {
        echo '<script language="javascript">
                  alert("Vui lòng nhập đầy đủ thông tin!");
                  window.location = "reg.php";
              </script>';
        exit(); // Stop further execution
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="header.css">
</head>
<body>
    <div id="wrapper" style="padding-bottom: 4rem;">
        <header>
            <div class="container">
                <!-- Header content -->
            </div>
        </header>
        <div class="container">
            <form action="reg.php" method="POST">
                <h1 style="text-align: center;">Đăng ký hệ thống</h1>
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Tên đăng nhập" required="required">
                </div>
                <div class="form-group">
                    <label for="hoten">Họ và Tên:</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" placeholder="Họ tên" required="required">
                </div>
                <div class="form-group">
                    <label for="sex">Giới tính:</label><br>
                    <input type="radio" id="male" name="sex" value="0" checked>
                    <label for="male">Nam</label><br>
                    <input type="radio" id="female" name="sex" value="1">
                    <label for="female">Nữ</label><br>
                </div>
                <div class="form-group">
                    <label for="birthday">Ngày sinh:</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Ngày sinh" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="required">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Địa chỉ">
                </div>
                <div class="form-group">
                    <label for="phone">Số Điện Thoại:</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện thoại" required="required">
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="required">
                </div>
                <div class="form-group">
                    <label for="repassword">Nhập lại mật khẩu:</label>
                    <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu" required="required">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-primary" value="Đăng ký">
                    <p style="padding-top: 1rem;">Bạn đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
