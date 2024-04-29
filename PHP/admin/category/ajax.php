<?php
require_once('../database/dbhelper.php');
if (!empty($_POST)) {
	if (isset($_POST['action'])) {
	  $action = $_POST['action'];
  
	  switch ($action) {
		case 'delete':
		  if (isset($_POST['id'])) {
			$id = $_POST['id'];
  
			if (!checkExistence($id, 'id_category', 'product')) {
			  
			  $sql = 'DELETE FROM category WHERE id= "' . $id . '"';
			  execute($sql);
			  
			}
		  }
		  else
		  {
			echo '<script language="javascript">
            alert("Tài khoản và mật khẩu không chính xác !");
            window.location = "../category/index.php";
         </script>';
		  }
		  break;
	  }
	}
  }
?>