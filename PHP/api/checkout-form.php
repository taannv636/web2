<?php
require_once('database/dbhelper.php');

if (!empty($_POST)) {
    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $json = $_COOKIE['cart'];
        $cart = json_decode($json, true);
    }

    // Check if the cart is empty
    if ($cart == null || count($cart) == 0) {
        header('Location: index.php');
        die();
    }

    // Extracting data from the form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $orderDate = date('Y-m-d H:i:s');
    $deliveryDate = date('Y-m-d H:i:s');
    $payment = $_POST['payment'];
    $status = 0;

    // Get user id based on email
    $sql = "SELECT id_user FROM user WHERE email = '$email'";
    $id_user_result = executeResult($sql);
    $id_user = $id_user_result[0]['id_user']; // Assuming there is only one user for one email

    // Generate order id
    $orderId = generateID('id', 'orders', 'HD');

    // Insert data into orders table
    $sql = "INSERT INTO orders (id, id_user, hoten, phone, address, order_date, delivery_date, payment, status) 
            VALUES ('$orderId', '$id_user', '$fullname', '$phone_number', '$address', '$orderDate', '$deliveryDate', '$payment', '$status')";
    execute($sql);

    // Iterate through cart items
    foreach ($cart as $item) {
        $productId = $item['id'];
        $quantity = $item['num'];

        // Insert data into order_details table
        $sql = "INSERT INTO order_details(id_order, id_product, number) 
                VALUES ('$orderId', '$productId', '$quantity')";
        execute($sql);

        
        echo '<script language="javascript">
                alert("Đặt hàng thành công!"); 
                window.location = "history.php";
            </script>';

    }

    // Clear the cart after successful order
    setcookie('cart', '[]', time() - 1000, '/');
}
?>
