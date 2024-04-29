<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <?php
    require_once('config.php');
    $id_user = $_GET['id_user'];
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    // Kiểm tra kết nối
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Xóa dữ liệu dựa trên id
    $sql = "DELETE FROM cart WHERE id_user = '$id_user'";
    mysqli_query($con, $sql);
 

    // Đóng kết nối
    mysqli_close($con); 
    header('Location: cart.php')
    ?>
</body>

</html>