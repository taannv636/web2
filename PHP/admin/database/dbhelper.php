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

function checkExistence($sample, $id, $table) {
    // Escape any special characters to prevent SQL injection
    $conn = new mysqli('localhost', 'root', '', 'asm_php1');
   // $conn = new mysqli($servername, $username, $password, $database);

    $category_id = mysqli_real_escape_string($conn, $sample);
    $id = mysqli_real_escape_string($conn, $id);
    $table = mysqli_real_escape_string($conn, $table);

    // Query to check existence
    $sql_check_existence = "SELECT COUNT(*) AS count FROM $table WHERE $id = '$category_id'";

    // Execute the query
    $result_check_existence = $conn->query($sql_check_existence);

    // Check if result is not empty and count > 0
    if ($result_check_existence && $result_check_existence->num_rows > 0) {
        $row = $result_check_existence->fetch_assoc();
        if ($row['count'] > 0) {
            echo "<script>alert('ID tồn tại');</script>";
            return true; // ID exists
        } else {
            echo "<script>alert('ID không tồn tại');</script>";
            return false; // ID does not exist
        }
    } else {
        echo "<script>alert('Có lỗi xảy ra khi kiểm tra ID');</script>";
        return false; // Error occurred while checking ID existence
    }
}
