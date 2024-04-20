<?php
session_start();

if (isset($_POST['submit_password'])) {
    // Lấy thông tin mật khẩu từ form
    $password = $_POST['password'];
    
    // Lưu mật khẩu vào cơ sở dữ liệu (Bạn cần thay thế thông tin kết nối và thực hiện lưu vào cơ sở dữ liệu ở đây)
    // Ví dụ:
    // $conn = new mysqli('localhost', 'username', 'password', 'database');
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
    // $conn->query($sql);
    
    // Sau khi lưu mật khẩu thành công, chuyển hướng người dùng đến trang đăng nhập hoặc trang chính của ứng dụng
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo mật khẩu mới</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Tạo mật khẩu mới</h2>
        <form action="" method="post">
            <input type="password" name="password" placeholder="Nhập mật khẩu mới" required>
            <input type="submit" name="submit_password" value="Lưu mật khẩu">
        </form>
    </div>
</body>
</html>
