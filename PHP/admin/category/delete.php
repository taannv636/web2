<?php
require_once('..database/dbhelper.php');
?>
<?php


if (isset($POST['id'])) {
    $id = $POST['id'];

    if (!checkExistence($id, 'id_category', 'product')) {
			  
    $sql = 'DELETE FROM category WHERE id= "' . $id . '"';
        execute($sql);
        header('Location: index.php');
        die();
        
      }
      else
      {
        echo '<script language="javascript">
        alert("Tài khoản và mật khẩu không chính xác !");
        window.location = "../category/index.php";
     </script>';
      }
	
}

?>