<?php
require_once('../database/dbhelper.php');

if (!empty($_POST)) {
	if (isset($_POST['action'])) {
		$action = $_POST['action'];

		switch ($action) {
			case 'delete':
				if (isset($_POST['id_user'])) {
					$id_user = $_POST['id_user'];

					$sql = 'DELETE FROM user WHERE id_user= "' . $id_user . '"';
					execute($sql);
				}
				break;
		}
	}
}
