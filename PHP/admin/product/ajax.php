<?php
require_once('../database/dbhelper.php');
if (!empty($_POST)) {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'checkExistence':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $result = checkExistence($id, 'id_product', 'order_details');
					$result2 = checkExistence($id, 'id_product', 'cart');
					$finalResult = true;
					if ($result == false && $result2 == false)
					{
						$finalResult = false;
					}
					else
					{
						$finalResult = true;
					}
                    echo json_encode($finalResult); // Trả về kết quả dưới dạng JSON
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $sql = 'DELETE FROM product WHERE id= "' . $id . '"';
                    execute($sql);
                }
                break;
        }
    }
}
?>