<?php
require_once('../database/config.php');
require_once('../database/dbhelper.php');

$id_user = $hoten = $sex = $birthday = $email = $address = $phone = '';

if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $user = executeSingleResult($sql);
    if ($user) {
        $id_user = $user['id_user'];
        $hoten = $user['hoten'];
        $sex = $user['sex'];
        $birthday = $user['birthday'];
        $email = $user['email'];
        $address = $user['address'];
        $phone = $user['phone'];
    } 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hoten = $_POST['hoten'];
    $sex = $_POST['sex'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if (!empty($hoten) && !empty($phone) && !empty($email)) {
        $sql = "UPDATE user SET hoten='$hoten', sex='$sex', birthday='$birthday', email='$email', address='$address', phone='$phone' WHERE username='$username'";
        execute($sql);

        // Handle password change
        if (!empty($_POST['password']) && !empty($_POST['password-new']) && !empty($_POST['repassword-new'])) {
            $password = $_POST["password"];
            $passwordnew = $_POST["password-new"];
            $repasswordnew = $_POST["repassword-new"];

            // Verify current password
            $sql = "SELECT * FROM user WHERE password ='$password'";
            $user = executeSingleResult($sql);
            if ($user && $password == $_COOKIE['password']) {
                if ($passwordnew == $repasswordnew) {
                    $sql = "UPDATE user SET password = '$passwordnew' WHERE username = '$username'";
                    execute($sql);
                    echo '<script language="javascript">
                        alert("Thay đổi thông tin và mật khẩu thành công!");
                        window.location = "changePass.php";
                    </script>';
                } else {
                    echo '<script language="javascript">
                        alert("Nhập không trùng mật khẩu mới, vui lòng nhập lại!");
                        window.location = "changePass.php";
                    </script>';
                }
            } else {
                echo '<script language="javascript">
                    alert("Mật khẩu hiện tại không chính xác!");
                    window.location = "changePass.php";
                </script>';
            }
        } else {
            echo '<script language="javascript">
                alert("Thay đổi thông tin thành công!");
                window.location = "changePass.php";
            </script>';
        }
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="header.css">

    <title>Đăng nhập</title>
</head>
<body>
    <div id="wrapper" style="padding-bottom: 4rem;">
    <header>
            <div class="container">
                <section class="logo">
                    <a href="../index.php"><img src="../images/logo-grabfood.svg" alt=""></a>
                </section>
                <nav style="padding: 15px 10px;">
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
                                <a href="changePass.php"><i class="fas fa-user"></i>Thông tin cá nhân</a> <br>
                                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Đăng xuất</a>
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
        <div class="container">
        <div class="panel panel-primary" style="text-align:center">
            <div class="panel-heading">
                <h2 class="text-center">Thông Tin Cá Nhân</h2>
            </div>
            <div class="panel-body mx-auto">
                <form method="POST">
                    <div class="form-group row">
                        <label for="hoten" class="col-sm-2 col-form-label" style="font-size:18px">Họ và tên:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="hoten" name="hoten" value="<?= $hoten ?>" style="width">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="sex" class="col-sm-2 col-form-label" style="font-size:18px">Giới tính:</label>
                        <div class="col-sm-10">
                            <input type="radio" id="male" name="sex" value="0" <?= ($sex == 0) ? 'checked' : '' ?>>
                            <label for="male">Nam</label>
                            <input type="radio" id="female" name="sex" value="1" <?= ($sex == 1) ? 'checked' : '' ?>>
                            <label for="female">Nữ</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthday" class="col-sm-2 col-form-label" style="font-size:18px">Ngày sinh:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $birthday ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label" style="font-size:18px">Email:</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label" style="font-size:18px">Địa chỉ:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="address" name="address" value="<?= $address ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label" style="font-size:18px">Số điện thoại:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label" style="font-size:18px" >Mật khẩu hiện tại:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu hiện tại">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password-new" class="col-sm-2 col-form-label" style="font-size:18px" >Mật khẩu mới:</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password-new" name="password-new" placeholder="Mật khẩu mới">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="repassword-new" class="col-sm-2 col-form-label" style="font-size:18px">Nhập lại mật khẩu</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="repassword-new" name="repassword-new" placeholder="Nhập lại mật khẩu mới">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" id="saveButton">Lưu</button>
                    <?php
                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                    ?>
                </form>
            </div>
        </div>
    <?php require_once('../database/config.php'); ?>
    <?php require_once('../database/dbhelper.php'); ?>
    
<script>
document.getElementById("saveButton").addEventListener("click", function() {
    alert("Thay đổi thông tin thành công!");
});
</script>

<style>
    #saveButton {
        display: block;
        margin: 0 auto;
        width: 200px; /* Điều chỉnh độ rộng tùy thích */
        font-size: 23px;
    }
    .form-group {
        
        margin-bottom: 15px; /* Khoảng cách giữa các input */
    }

</style>

</body>

</html>