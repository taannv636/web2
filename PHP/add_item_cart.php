<?php
require_once('../PHP/database/dbhelper.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && isset($_POST['productId']) && isset($_POST['number'])) {
    $userId = $_POST['userId'];
    $productId = $_POST['productId'];
    $number = $_POST['number'];

    // Kiểm tra xem đã tồn tại bản ghi trong bảng cart với id_user và id_product tương ứng hay chưa
    $checkSql = "SELECT * FROM `cart` WHERE id_user = '$userId' AND id_product = '$productId'";

    if (!empty(executeSingleResult($checkSql))) {
        // Nếu đã tồn tại, thực hiện cập nhật số lượng
        $updateSql = "UPDATE `cart` SET number = '$number' WHERE id_user = '$userId' AND id_product = '$productId'";
        execute($updateSql);
        echo 'Cập nhật thành công!';
    } else {
        // Nếu chưa tồn tại, thực hiện thêm mới
        $insertSql = "INSERT INTO `cart` (id_user, id_product, number, status) VALUES ('$userId', '$productId', '$number', '1')";
        execute($insertSql);
        echo 'Thêm thành công!';
    }
} else {
    http_response_code(400); // Bad request
    echo 'Lỗi: Request không hợp lệ!';
}
?>