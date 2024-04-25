<?php
require_once('config.php');

function execute($sql)
{
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Execute SQL query
	mysqli_query($con, $sql);

    // Close connection
    mysqli_close($con);
}

function executeResult($sql)
{
	//save data into table
	// open connection to database
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	//insert, update, delete
	$result = mysqli_query($con, $sql);
	$data   = [];
	while ($row = mysqli_fetch_array($result, 1)) {
		$data[] = $row;
	}

	//close connection
	mysqli_close($con);

	return $data;
}

function executeSingleResult($sql)
{
    // Open connection to database
    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

    // Execute query
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die('Query failed: ' . mysqli_error($con));
    }

    // Fetch the result
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    // Close connection
    mysqli_close($con);

    return $row;
}


function generateID($ID, $TABLE, $SAMPLE) {
    // Kết nối đến cơ sở dữ liệu
    $dsn = "mysql:host=localhost;dbname=asm_php1;charset=utf8mb4";
    $username = "root";
    $password = "";

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        // Xử lý lỗi kết nối
        echo "Kết nối đến cơ sở dữ liệu thất bại: " . $e->getMessage();
        return false;
    }

    // Tìm ID cuối cùng trong bảng
    $query = "SELECT MAX($ID) AS max_id FROM $TABLE";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $maxID = $result['max_id'];

    // Trích xuất số từ ID cuối cùng
    $number = preg_replace('/[^0-9]/', '', $maxID);
    $prefix = preg_replace('/[0-9]/', '', $maxID);

    // Tăng số lên 1 và tạo ID mới
    $newNumber = $number + 1;
    $newID = $prefix . str_pad($newNumber, strlen($number), '0', STR_PAD_LEFT);

    return $newID;
}