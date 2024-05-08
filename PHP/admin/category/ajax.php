<?php
require_once('../database/dbhelper.php');
if (!empty($_POST)) {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'checkExistence':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $result = checkExistence($id, 'id_category', 'product');
                    echo json_encode($result); // Trả về kết quả dưới dạng JSON
                }
                break;
            case 'delete':
                if (isset($_POST['id'])) {
                    $id = $_POST['id'];
                    $sql = 'DELETE FROM category WHERE id= "' . $id . '"';
                    execute($sql);
                }
                break;
        }
    }
}

?>