<?php
require_once('database/dbhelper.php');

if (!empty($_POST)) {
    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $json = $_COOKIE['cart'];
        $cart = json_decode($json, true);
    }
    var_dump($cart);
    if ($cart == null || count($cart) == 0) {
        header('Location: index.php');
        die();
    }
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $note = $_POST['note'];
    $orderDate = date('Y-m-d H:i:s');

    $sql = "SELECT id_user FROM user 
    WHERE email = '$email'";
    $id_user = executeResult($sql);

    // thêm vào order 
    $id = generateID('id', 'orders','HD');
    $sql = "INSERT INTO orders (id, id_user,order_date, delivery_date, payment, status) 
    values ('$id','$id_user','$orderDate','$address','$note')";
    execute($sql);

    $sql = "SELECT * FROM orders WHERE order_date = '$orderDate'";
    $order = executeResult($sql); // in ra 1 dòng 
    foreach ($order as $item) {
        $orderId = $item['id'];
    }

    if (isset($_COOKIE['username'])) {
        $username = $_COOKIE['username'];
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $user = executeResult($sql); // in ra 1 dòng 
        foreach ($user as $item) {
            $userId = $item['id_user'];
        }
    }



    // lấy cartList ra
    $idList = [];
    foreach ($cart as $item) {
        $idList[] = $item['id'];
    }
    if (count($idList) > 0) {
        $idList = "'" . implode("','", $idList) . "'"; // transform
        //['SP001', 'SP002', 'SP003'] => 'SP001', 'SP002', 'SP003'
        
        $sql = "SELECT * FROM product WHERE id IN ($idList)";
        $cartList = executeResult($sql);    
    } else {
        $cartList = [];
    }
    $status = 'Đang chuẩn bị';
    
    foreach ($cartList as $item) {
        $num = 0;
        foreach ($cart as $value) {
            if ($value['id'] == $item['id']) {
                $num = $value['num'];
                break;
            }
        }
        $sql = "INSERT into order_details(order_id, product_id,id_user, num, price,status) values ('$orderId', " . $item['id'] . ",'$userId','$num', " . $item['price'] . ",'$status')";
        execute($sql);
        echo '<script language="javascript">
                alert("Đặt hàng thành công!"); 
                window.location = "history.php";
            </script>';
    }
    setcookie('cart', '[]', time() - 1000, '/');
}
