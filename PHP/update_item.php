<?php
require_once('../PHP/database/dbhelper.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && isset($_POST['productId']) && isset($_POST['quantity'])) {
    $userId = $_POST['userId'];
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Thực hiện xóa phần tử có id_user và id_product tương ứng trong cơ sở dữ liệu
    $sql = "UPDATE cart SET number = '$quantity' WHERE id_user = '$userId' AND id_product = '$productId'";
    execute($sql);

    $sql = "SELECT SUM(price * $quantity) AS total_price FROM product WHERE id = '$productId'";
    $result = executeSingleResult($sql);

    // Trả về kết quả (có thể trả về JSON nếu cần)
    echo $result['total_price'];
} else {
    http_response_code(400); // Bad request
    echo 'Lỗi: Request không hợp lệ!';
}
?>