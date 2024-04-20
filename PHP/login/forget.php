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
                                <a href="login/changePass.php"><i class="fas fa-exchange-alt"></i>Đổi mật khẩu</a> <br>
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
                <!--
                <div class="form-group">
                    <label>Tên của bạn:</label>
                    <input class="form-control" type="text" name="name" required="required" />
                </div>
                    -->
                <div class="form-group">
                    <label>Gmail của bạn:</label>
                    <input class="form-control" type="email" name="email" required="required" />
                </div>

                <!--
                <div class="form-group">
                    <label>Số điện thoại:</label>
                    <input class="form-control" type="text" name="subject" required="required" />
                </div>
                <div class="form-group">
                    <label>Lý do:</label>
                    <textarea class="form-control" name="message" id="" cols="30" rows="4"></textarea>
                </div>
                    -->
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
        /*
        //nhúng thư viện vào để dùng
        require "../PHPMailer-master/src/PHPMailer.php";
        require "../PHPMailer-master/src/SMTP.php";
        require '../PHPMailer-master/src/Exception.php';

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          //  $name = $_POST['name']; // lấy ra tên của bạn
            $email = $_POST['email']; // Email cần gửi đến
          //  $subject = $_POST['subject']; // Tiêu đề email
          //  $message = $_POST['message']; // Nội dung email
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);  //true: cho phép các trường hợp ngoại lệ


            $sql = "SELECT * FROM user WHERE email= '$email'";
            $kq = $conn->query($sql);
            $numrows_email = $kq->rowCount();
            if ($numrows_email == 1) {
                foreach ($kq as $item) {
                    $message = 'Xin chào ' . '<strong>' . $item['username'] . '</strong>' . '<br>Mật khẩu của bạn là: ' . '<strong>' . $item['password'] . '</strong>';
                }
            } else {
                echo '<script language="javascript">
                        alert("Tài khoản không tồn tại !");
                        window.location = "changePass.php";
                     </script>';
            }

            // TRY có thể nó sẽ xảy ra ngoại lệ
            try {
                //Server settings
                $mail->isSMTP(); // gửi mail SMTP
                $mail->CharSet  = "utf-8";
                $mail->Host = 'smtp.gmail.com';  // khai báo SMTP servers
                $mail->SMTPAuth = true; // Enable authentication
                $nguoigui = 'hellook332@gmail.com'; // Tài khoản Email
                $matkhau = 'thanh1010'; // Mật khẩu Email
                $mail->SMTPSecure = 'ssl';  // encryption TLS/SSL 
                $mail->Port = 465;  // Port kết nối: khai báo 465 hoặc 587                


                // Recipients - Người nhận
                $tennguoigui = 'Nguyễn Đăng Thành'; // Tên người gửi lấy từ form nhập
                $mail->Username = $nguoigui; // SMTP username
                $mail->Password = $matkhau;   // SMTP password
                $mail->setFrom($nguoigui, $tennguoigui); //mail và tên người nhận 
                $to = $email; // Email cần gửi đến lấy từ form nhập
                $to_name = "Nguyễn Đăng Thành"; // Tên người cần gửi đến

                // Content 
                $mail->addAddress($to, $to_name); //mail và tên người nhận  
                $mail->isHTML(true);  // Khai báo nội dung email hiển thị định dạng html
                $mail->Subject = 'Khôi phục mật khẩu'; // Tiêu đề email
                $mail->Body = $message; // Nội dung email

                $mail->send(); // Tiến hành gửi thư
                echo '<script language="javascript">
                        alert("Mật khẩu của bạn đã được gửi đến Email !");
                        window.location = "login.php";
                     </script>';
            }
            // nếu ở trên lỗi thì CATCH sẽ chạy
            catch (Exception $e) {
                echo 'Mail không gửi được. Lỗi: ', $mail->ErrorInfo;
            }
        }
        */

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require 'vendor/autoload.php';

        session_start();

        // Hàm tạo mã OTP ngẫu nhiên
        function generateOTP($length = 6) {
            $characters = '0123456789';
            $otp = '';
            for ($i = 0; $i < $length; $i++) {
                $otp .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $otp;
        }
        
       // Hàm gửi OTP qua email
function sendOTP($otp) {
    $mail = new PHPMailer(true);
    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your_email@example.com'; // SMTP username
        $mail->Password   = 'your_password'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Thiết lập thông tin người gửi và người nhận
        $mail->setFrom('your_email@example.com', 'Your Name');
        $mail->addAddress('recipient@example.com', 'Recipient Name');

        // Thiết lập tiêu đề và nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Mã OTP';
        $mail->Body    = 'Mã OTP của bạn là: ' . $otp;

        // Gửi email
        $mail->send();

        // Lưu mã OTP vào session
        $_SESSION['otp'] = $otp;

        return true;
    } catch (Exception $e) {
        // Nếu gửi email không thành công, bạn có thể xử lý ở đây, ví dụ: log lỗi, hiển thị thông báo cho người dùng, vv.
        return false;
    }
}
        
        // Kiểm tra nếu người dùng đã gửi OTP và nếu đúng thì chuyển hướng sang trang tạo mật khẩu mới
        if (isset($_POST['submit_otp'])) {
            if ($_POST['otp'] == $_SESSION['otp']) {
                header('Location: create_password.php');
                exit;
            } else {
                $error = "Mã OTP không đúng. Vui lòng thử lại!";
            }
        }
        
        // Xử lý khi người dùng nhấn nút "Khôi phục"
        if (isset($_POST['recover'])) {
            $otp = generateOTP();
            sendOTP($otp);
        }
        ?>


    </div>
</body>

</html>