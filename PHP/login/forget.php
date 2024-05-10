<?php require('connect.php') ?>
<?php
require_once('../database/dbhelper.php');
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">

    <link rel="stylesheet" href="header.css">
</head>

<body>
    <div id="wrapper">
        <header>
            <div class="container">
                <section class="logo">
                    <a href="../index.php"><img src="../images/logo-grabfood.svg" alt=""></a>
                </section>
                <nav>
                    <ul>
                        <li><a href="../index.php">Trang chủ</a></li>
                        <li class="nav-cha">
                            <a href="../thucdon.php?page=thucdon">Thực đơn</a>
                            <ul class="nav-con">
                                <?php
                                $sql = "SELECT * FROM category";
                                $result = executeResult($sql);
                                foreach ($result as $item) {
                                    echo '<li><a href="../thucdon.php?id_category=' . $item['id'] . '">' . $item['name'] . '</a></li>';
                                }
                                ?>
                                <!-- <li><a href="thucdon.php?page=trasua">Trà sữa</a></li>
                                <li><a href="thucdon.php?page=monannhe">Món ăn nhẹ</a></li>
                                <li><a href="thucdon.php?page=banhmi">Bánh mì</a></li>
                                <li><a href="thucdon.php?page=caphe">Cà phê</a></li> -->
                            </ul>
                        </li>
                        <li><a href="../about.php">Về chúng tôi</a></li>
                        <li><a href="../sendMail.php">Liên hệ</a></li>
                    </ul>
                </nav>
                <section class="menu-right">
                    <div class="cart">
                        <a href="../cart.php"><img src="../images/icon/cart.svg" alt=""></a>
                        <?php
                        $cart = [];
                        if (isset($_COOKIE['cart'])) {
                            $json = $_COOKIE['cart'];
                            $cart = json_decode($json, true);
                        }
                        $count = 0;
                        foreach ($cart as $item) {
                            $count += $item['num']; // đếm tổng số item
                        }
                        ?>
                    </div>
                    <div class="login">
                        <?php
                        if (isset($_COOKIE['username'])) {
                            echo '<a style="color:black;" href="">' . $_COOKIE['username'] . '</a>
                            <div class="logout">
                                <a href="login/changePass.php"><i class="fas fa-exchange-alt"></i>Thông Tin Cá Nhân</a> <br>
                                <a href="login/logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
                            </div>
                            ';
                        } else {
                            echo '<a href="login.php"">Đăng nhập</a>';
                        }

                        ?>


                    </div>
                </section>
            </div>
        </header>
        <h2 style="text-align: center;">Quên mật khẩu</h2>
        <div class="container">
            <form method="POST" action="">
                <div class="form-group">
                    <label>Gmail của bạn:</label>
                    <input class="form-control" type="email" name="email" required="required" />
                </div>
                <button name="send" class="btn btn-primary">Khôi phục</button>
                <?php
                $previous = "javascript:history.go(-1)";
                if (isset($_SERVER['HTTP_REFERER'])) {
                    $previous = $_SERVER['HTTP_REFERER'];
                }
                ?>
                <a href="<?= $previous ?>" class="btn btn-warning">Quay lại</a>
            </form>
        </div>
    
        <?php

//require_once('../layout/header.php');

// Include PHPMailer library
require "../PHPMailer-master/src/PHPMailer.php";
require "../PHPMailer-master/src/SMTP.php";
require '../PHPMailer-master/src/Exception.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign form data to variables
    $email = $_POST['email'];

    // Kiểm tra xem email tồn tại trong cơ sở dữ liệu không
    $sql_check_email = "SELECT COUNT(*) AS count FROM user WHERE email = '$email'";
    $result_check_email = executeSingleResult($sql_check_email);
    
    if ($result_check_email['count'] == 0) {
        // Nếu không có email trong cơ sở dữ liệu, dừng việc tiếp tục thực hiện câu lệnh
        echo '<script language="javascript">
        alert("Email chưa được đăng ký tài khoản!"); 
        </script>';
        exit; // Dừng thực hiện script
    }
    
    // Nếu email tồn tại, tiếp tục thực hiện câu lệnh để lấy mật khẩu
    $sql_get_password = "SELECT password FROM user WHERE email = '$email'";
    $user = executeSingleResult($sql_get_password);
    $pass = $user['password'];
    
    // Tiếp tục thực hiện các công việc khác ở đây...
    

    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nguyenvantan1k98@gmail.com';
        $mail->Password = 'iysormyrjnqjxybh';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Set sender
        $mail->setFrom('nguyenvantan1k98@gmail.com');

        // Add recipient
        $mail->addAddress($email);

        // Set email content as HTML
        $mail->isHTML(true);

        // Set email subject and body
        $mail->Subject = "Email Confirmation";
        $mail->Body = "Xin chào: $email,<br><br>Cảm ơn bạn đã nhắn tin cho chúng tôi!<br>Mật khẩu của bạn là: $pass <br>";

        // Send email
        $mail->send();

        // Redirect after successful sending
        echo '<script>alert("Send Successfully"); document.location.href = "forget.php";</script>';
    } catch (Exception $e) {
        // Handle exceptions
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '");</script>';
    }
}
?>
       
</body>

</html>