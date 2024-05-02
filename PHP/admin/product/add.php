<?php
require_once('../database/dbhelper.php');

$id = $title = $price = $number = $thumbnail = $content = $id_category = "";
if (!empty($_POST['title'])) {
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
        $title = str_replace('"', '\\"', $title);
    }
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $id = str_replace('"', '\\"', $id);
    }
    if (isset($_POST['price'])) {
        $price = $_POST['price'];
        $price = str_replace('"', '\\"', $price);
    }
    if (isset($_POST['number'])) {
        $number = $_POST['number'];
        $number = str_replace('"', '\\"', $number);
    }
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        // Dữ liệu gửi lên server không bằng phương thức post
        echo "Phải Post dữ liệu";
        die;
    }


    // Kiểm tra có dữ liệu thumbnail trong $_FILES không
    // Nếu không có thì dừng
    if (!isset($_FILES["thumbnail"])) {
        echo "Dữ liệu không đúng cấu trúc";
        die;
    }

    //không có hình tải lên thì add, update có error dữ liệu upload bị lỗi
    
    // Kiểm tra dữ liệu có bị lỗi không
    if ($_FILES["thumbnail"]['error'] != 0 && $thumbnail != "") {
        echo "Dữ liệu upload bị lỗi";
        die;
    }


    // Đã có dữ liệu upload, thực hiện xử lý file upload

    //Thư mục bạn sẽ lưu file upload
    $target_dir    = "uploads/";
    //Vị trí file lưu tạm trong server (file sẽ lưu trong uploads, với tên giống tên ban đầu)
    $target_file   = $target_dir . basename($_FILES["thumbnail"]["name"]);

    $allowUpload   = true;

    //Lấy phần mở rộng của file (jpg, png, ...)
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    // Cỡ lớn nhất được upload (bytes)
    $maxfilesize   = 800000;

    ////Những loại file được phép upload
    $allowtypes    = array('jpg', 'png', 'jpeg', 'gif');


    if (isset($_POST["submit"])) {
        //Kiểm tra xem có phải là ảnh bằng hàm getimagesize
        $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
        if ($check !== false) {
            echo "Đây là file ảnh - " . $check["mime"] . ".";
            $allowUpload = true;
        } else {
            echo "Không phải file ảnh.";
            $allowUpload = false;
        }
    }
    // Kiểm tra kích thước file upload cho vượt quá giới hạn cho phép
    if ($_FILES["thumbnail"]["size"] > $maxfilesize) {
        echo "Không được upload ảnh lớn hơn $maxfilesize (bytes).";
        $allowUpload = false;
    }

    // Kiểm tra kiểu file
    if (!in_array($imageFileType, $allowtypes)) {
        echo "Chỉ được upload các định dạng JPG, PNG, JPEG, GIF";
        $allowUpload = false;
    }

    if ($allowUpload) {
        // Xử lý di chuyển file tạm ra thư mục cần lưu trữ, dùng hàm move_uploaded_file
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        } else {
            echo "Có lỗi xảy ra khi upload file.";
        }
    } else {
        echo "Không upload được file, có thể do file lớn, kiểu file không đúng ...";
    }

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $status = str_replace('"', '\\"', $status);
    }

    if (isset($_POST['content'])) {
        $content = $_POST['content'];
        $content = str_replace('"', '\\"', $content);
    }
    if (isset($_POST['id_category'])) {
        $id_category = $_POST['id_category'];
        $id_category = str_replace('"', '\\"', $id_category);
    }
    if (!empty($title)) {
        // Lưu vào DB
        if ($id == '') {
            // Thêm sản phẩm
            $id = generateId('id','product','SP');
            $sql = 'INSERT INTO product(id, title, thumbnail, price, number , id_category , status, content ) 
            VALUES ("' . $id . '","' . $title . '","' . $target_file . '","' . $price . '","' . $number . '",
            "' . $id_category . '","' . $status . '","' . $content . '")';     
    }
        else {
            //Sừa sản phẩm
            // Kiểm tra xem có hình ảnh mới được tải lên hay không
            if (!empty($_FILES['thumbnail']['name'])) {
                // Nếu có hình ảnh mới, thực hiện cập nhật
                $sql = 'UPDATE product SET title="' . $title . '", thumbnail="' . $target_file . '", 
                price="' . $price . '", number="' . $number . '", id_category="' . $id_category . '", status="' . $status . '", content="' . $content . '" 
                WHERE id = "' . $id . '"';
            } else {
                // Nếu không có hình ảnh mới, chỉ cập nhật các trường dữ liệu khác
                $sql = 'UPDATE product SET title="' . $title . '", price="' . $price . '", number="' . $number . '",
                 id_category="' . $id_category . '", status="' . $status . '", content="' . $content . '"
                WHERE id = "' . $id . '"';
            }

            /*
$sql = 'UPDATE product SET title="' . $title . '", thumbnail="' . $target_file . '", price="' . $price . '", number="' . $number . '",
            id_category="' . $id_category . '", status="' . $status . '", content="' . $content . '"
                WHERE id = "' . $id . '"';  
            */
           
        }
        execute($sql);
        header('Location: index.php');
        die();
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM product WHERE id ="' . $id . '"';
    $product = executeSingleResult($sql);
    if ($product != null) {
        $title = $product['title'];
        $thumbnail = $product['thumbnail'];
        $price = $product['price'];
        $number = $product['number'];
        $id_category = $product['id_category'];
        $status = $product['status'];
        $content = $product['content'];
    }

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Sản Phẩm</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- summernote -->
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="../index.php">Thống kê</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../category/">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="../product/">Quản lý sản phẩm</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../dashboard.php">Quản lý giỏ hàng</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../user/">Quản lý người dùng</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Thêm/Sửa Sản Phẩm</h2>
            </div>
            <div class="panel-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Tên Sản Phẩm:</label>
                        <input type="text" id="id" name="id" value="<?= $id ?>" hidden="true">
                        <input required="true" type="text" class="form-control" id="title" name="title" value="<?= $title ?>">
                    </div>

        <div class="form-group">
        <label for="exampleFormControlSelect1">Chọn Danh Mục</label>
            <select class="form-control" id="id_category" name="id_category">
                <option>Chọn danh mục</option>
                <?php
                $sql = 'SELECT * FROM category';
                $categoryList = executeResult($sql);
                foreach ($categoryList as $item) {
                    if ($item['id'] == $id_category ) {
                        echo '<option selected value="' . $item['id'] . '">' . $item['name'] . '</option>';
                    } else {
                        echo '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
                    }
                }
                ?>
               
            </select>
        </div>

                    <div class="form-group">
                        <label for="name">Giá Sản Phẩm:</label>
                        <input required="true" type="text" class="form-control" id="price" name="price" value="<?= $price ?>">
                    </div>
                    <div class="form-group">
                        <label for="name">Số Lượng Sản Phẩm:</label>
                        <input required="true" type="number" class="form-control" id="number" name="number" value="<?= $number ?>">
                    </div>

                    <!-- Status  -->
                    <div class="form-group">
                    <label for="exampleFormControlSelect1">Chọn Trạng Thái</label>
                        <select class="form-control" id="status" name="status">
                            <option value="0" <?= $status == 0 ? 'selected' : '' ?>>Ngừng kinh doanh</option>
                            <option value="1" <?= $status == 1 ? 'selected' : '' ?>>Tạm ngừng kinh doanh</option>
                            <option value="2" <?= $status == 2 ? 'selected' : '' ?>>Còn kinh doanh</option>
                        </select>
                    </div>
                
                    <div class="form-group">
                        <!-- <label for="exampleFormControlFile1">Thumbnail:<label> -->
                        <label for="name">Thumbnail:</label>
            <input type="hidden" name="current_thumbnail" value="<?= $thumbnail ?>">
            <input type="file" class="form-control-file" id="exampleFormControlFile1" id="thumbnail" name="thumbnail" onchange="previewImage(event)">
            <img src="<?= $thumbnail ?>" style="max-width: 200px" id="img_thumbnail">

            <script>
                var currentThumbnail = "<?= $thumbnail ?>";
                var thumbnailInput = document.getElementById('thumbnail');
                var imgThumbnail = document.getElementById('img_thumbnail');

                // Kiểm tra xem người dùng đã chọn hình mới hay không
                function previewImage(event) {
                    var reader = new FileReader();
                    reader.onload = function(){
                        imgThumbnail.src = reader.result;
                    };
                    
                    // Nếu người dùng đã chọn hình mới
                    if (event.target.files.length > 0) {
                        reader.readAsDataURL(event.target.files[0]);
                    } else {
                        // Nếu không có hình mới được chọn, giữ nguyên đường dẫn hình ảnh hiện tại
                        imgThumbnail.src = currentThumbnail;
                        // Đặt giá trị mặc định cho input file
                        thumbnailInput.value = "";
                    }
                }
            </script>
                 </div>

                        
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Nội dung</label>
                       <textarea class="form-control" id="content" rows="3" name="content"><?= $content ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success" name="save">Lưu</button>
               
                    <?php
                    $previous = "javascript:history.go(-1)";
                    if (isset($_SERVER['HTTP_REFERER'])) {
                        $previous = $_SERVER['HTTP_REFERER'];
                    }
                    ?>
                    <a href="<?= $previous ?>" class="btn btn-warning">Back</a>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function updateThumbnail() {
            $('#img_thumbnail').attr('src', $('#thumbnail').val())
        }
        $(function() {
            //doi website load noi dung => xu ly phan js
            $('#content').summernote({
                height: 200
            });
        })
    </script>
</body>

</html>