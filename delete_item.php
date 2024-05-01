<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId']) && isset($_POST['productId'])) {
    $userId = $_POST['userId'];
    $productId = $_POST['productId'];

    // Thực hiện xóa phần tử có id_user và id_product tương ứng trong cơ sở dữ liệu
    $sql = "DELETE FROM cart WHERE id_user = 'KH0003' AND id_product = 'SP024'";
    mysqli_query($con, $sql);

    // Trả về kết quả (có thể trả về JSON nếu cần)
    echo 'Xóa thành công!';
} else {
    http_response_code(400); // Bad request
    echo 'Lỗi: Request không hợp lệ!';
}
?>
