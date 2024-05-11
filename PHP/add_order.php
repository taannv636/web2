<?php
require_once('../PHP/database/dbhelper.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_user']) && isset($_POST['hoten']) && isset($_POST['phone'])
    && isset($_POST['address'])&& isset($_POST['payment'])&& isset($_POST['list_product'])) {
    $userId = $_POST['id_user'];
    $hoten = $_POST['hoten'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $payment = $_POST['payment'];
    $list_product = $_POST['list_product'];
    $product_array = explode(',', $list_product);

    

    $sql = "SELECT * FROM orders";
    $result = executeResult($sql);
    $count = count($result)+1;
    $id_order = "HD0000";
    switch($count){
        case ($count < 10): $id_order = "HD000" . $count;break;
        case ($count < 100): $id_order = "HD00" . $count;break;
        case ($count < 1000): $id_order = "HD0" . $count;break;
        case ($count < 10000): $id_order = "HD" . $count;break;
        default: $id_order = "lỗi";break;
    }
    $currentDateTime = date('Y-m-d H:i:s');
    $futureDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +2 hours'));
    

    // Thực hiện xóa phần tử có id_user và id_product tương ứng trong cơ sở dữ liệu
    $sql = "INSERT INTO `orders` (id, id_user, hoten, phone, address, order_date, delivery_date, payment, status) 
        VALUES ('$id_order', '$userId', '$hoten', '$phone', '$address', '$currentDateTime', '$futureDateTime','$payment','0')";
    execute($sql);

    foreach($product_array as $id_product){
        $sql_number = "SELECT * FROM cart  WHERE id_user = '$userId' AND id_product = '$id_product'";
        $result_number = executeSingleResult($sql_number);
        $number_product = $result_number['number'];
        $sql_add_order_detail = "INSERT INTO `order_details` (id_order, id_product, number) VALUES ('$id_order','$id_product','$number_product')";
        execute($sql_add_order_detail);
        $sql_delete_cart = "DELETE FROM cart WHERE id_user = '$userId' AND id_product = '$id_product'";
        execute($sql_delete_cart);
        $sql_max = "SELECT * FROM product WHERE id = '$id_product'";
        $re = executeSingleResult($sql_max);
        $number_pr = $re['number'];
        $conlai = $number_pr - $number_product;
        $sql_update_product ="UPDATE product SET number = '$conlai' WHERE id = '$id_product'";
        execute($sql_update_product);
    }

    


    // Trả về kết quả (có thể trả về JSON nếu cần)
    
    echo "Tạo đơn hàng thành công";
} else {
    http_response_code(400); // Bad request
    echo 'Lỗi: Request không hợp lệ!';
}
?>