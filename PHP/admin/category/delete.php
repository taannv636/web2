<?php
require_once('..database/dbhelper.php');
?>
<?php
if (isset($POST['id'])) {
    $id = $POST['id'];

$sql = 'DELETE FROM category WHERE id= "' . $id . '"';
execute($sql);
header('Location: index.php');
die();
}

?>