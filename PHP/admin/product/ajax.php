<?php
require_once('../database/dbhelper.php');
if (!empty($_POST)) {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'checkExistence':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    // Check if the product has been sold
                    $result = checkExistence($id, 'id_product', 'order_details');
                    $result2 = checkExistence($id, 'id_product', 'cart');
                    $finalResult = ($result || $result2) ? true : false;
                    echo json_encode($finalResult); // Return the result as JSON
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    // Delete the product
                    $sql = 'DELETE FROM product WHERE id= "' . $id . '"';
                    execute($sql);
                }
                break;
            case 'changeStatus':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    // Change product status to 0 (stopped selling)
                    $sql = 'UPDATE product SET status = 0 WHERE id = "' . $id . '"';
                    execute($sql);
                }
                break;
        }
    }
}

?>