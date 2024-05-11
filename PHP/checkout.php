<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!-- <link rel="stylesheet" href="css/index.css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/cart.css">
    <title>Giỏ hàng</title>
</head>

<?php
if (!isset($_COOKIE['username'])) {
    echo '<script>
            alert("Vui lòng đăng nhập để tiến hành mua hàng");
            window.location="login/login.php";
        </script>';
}
?>

<body>
    <div id="wrapper">
        <?php require_once('layout/header.php'); ?>
        <?php
        $username = $_COOKIE['username'];
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = executeSingleResult($sql);
        ?>

        <!-- END HEADR -->
        <main>
            <section class="cart">

                <div class="container">
                    <h3 style="text-align: center;">Tiến hành đặt hàng</h3>
                    <div class="row">
                        <div class="panel panel-primary col-md-6">
                            <h4 style="padding: 2rem 0; border-bottom:1px solid black;">Nhập thông tin mua hàng </h4>
                            <div class="form-group">
                                <label for="usr">Họ và tên:</label>
                                <input required="true" type="text" class="form-control" id="usr" name="fullname" value="<?= $result['hoten'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $result['email'] ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="phone_number">Số điện thoại:</label>
                                <input required="true" type="text" class="form-control" id="phone_number" name="phone_number" value="<?= $result['phone'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ:</label>
                                <input required="true" type="text" class="form-control" id="address" name="address" value="<?= $result['address'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="payment">Hình thức thanh toán:</label><br>
                                <input type="radio" id="male" name="payment" value="0" checked>
                                <label for="cash">Trả tiền mặt</label><br>
                                <input type="radio" id="female" name="payment" value="1">
                                <label for="banking">Chuyển khoản</label><br>
                            </div>

                        </div>
                        <!-- <button onclick="hienthi()"><i class="fas fa-angle-down"></i> Xem lại đơn hàng</button> -->

                        <div class="panel panel-primary col-md-6">
                            <h4 style="padding: 2rem 0; border-bottom:1px solid black;">Đơn hàng</h4>
                            <table class="table table-bordered table-hover none">
                                <thead>
                                    <tr style="font-weight: 500;text-align: center;">
                                        <td width="50px">STT</td>
                                        <td>Tên Sản Phẩm</td>
                                        <td>Số lượng</td>
                                        <td>Tổng tiền</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($_COOKIE['username'])) {
                                        $username = $_COOKIE['username'];
                                        $sql_id = "SELECT * FROM user WHERE username = '$username'";
                                        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                        $result_id = mysqli_query($con, $sql_id);

                                        // Lấy dữ liệu từ kết quả truy vấn
                                        $user = mysqli_fetch_assoc($result_id);
                                        $id_user = $user['id_user'];
                                        // Lấy danh sách các đơn hàng được chọn từ tham số truyền vào
                                        $selectedOrders = json_decode($_GET['selectedOrders']);
                                        $total = 0;
                                        $stt = 1;

                                        // Lặp qua danh sách các đơn hàng và hiển thị chúng trong bảng
                                        foreach ($selectedOrders as $order) {
                                            $sql = "SELECT cart.number as numbers, product.title as title, product.price as price
                                                    FROM cart JOIN product ON cart.id_product = product.id WHERE cart.id_user = '$id_user' AND cart.id_product = '$order'";
                                            $result = executeSingleResult($sql);

                                            $productName = $result['title'];
                                            $quantity = $result['numbers'];
                                            $price = $result['price'] * $result['numbers'];
                                            $total = $total + $price;

                                            // Hiển thị thông tin của đơn hàng trong bảng
                                            echo "<tr>";
                                            echo "<td>$stt</td>";
                                            echo "<td>$productName</td>";
                                            echo "<td>$quantity</td>";
                                            echo "<td>$price</td>";
                                            echo "</tr>";
                                            $stt = $stt + 1;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <p>Tổng đơn hàng: <span class="bold red"><?= number_format($total, 0, ',', '.') ?><span> VNĐ</span></span></p>
                            <button class="btn btn-success" list_id_product = '<?php echo json_encode($selectedOrders); ?>' id_user = '<?php echo $id_user?>'>Đặt hàng</button>
                        </div>
                    </div>

                </div>


            </section>
        </main>
        <?php require_once('layout/footer.php'); ?>
    </div>
    <script type="text/javascript">
        // function deleteCart(id) {
        //     $.post('api/cookie.php', {
        //         'action': 'delete',
        //         'id': id
        //     }, function(data) {
        //         location.reload()
        //     })
        // }
        // sử dụng thư viện pdfmake
        window.addEventListener('DOMContentLoaded', function() {
            // Gắn sự kiện cho nút "Back"
            window.addEventListener('popstate', function(event) {
                // Điều hướng lại trang khi người dùng nhấp vào nút "Back"
                window.location.href = "index.php";
            });
        });
        document.querySelector('.btn.btn-success').addEventListener('click', function() {
            // Lưu tên, số điện thoại, địa chỉ và hình thức thanh toán
            var fullname = document.getElementById('usr').value;
            var phone_number = document.getElementById('phone_number').value;
            var address = document.getElementById('address').value;
            var payment = document.querySelector('input[name="payment"]:checked').value;
            var total = document.querySelector('.bold.red').innerText;
            
            var orderDetails = [];
            var tableRows = document.querySelectorAll('.table tbody tr');

            tableRows.forEach(function(row) {
                var rowData = [];
                var cells = row.querySelectorAll('td');

                cells.forEach(function(cell) {
                    rowData.push(cell.innerText);
                });

                orderDetails.push(rowData);
            });

            // Tạo đối tượng dữ liệu PDF
            var docDefinition = {
                content: [{
                        text: 'Thông tin mua hàng:',
                        style: 'header'
                    },
                    {
                        text: 'Họ và tên: ' + fullname
                    },
                    {
                        text: 'Số điện thoại: ' + phone_number
                    },
                    {
                        text: 'Địa chỉ: ' + address
                    },
                    {
                        text: 'Hình thức thanh toán: ' + (payment === '0' ? "Trả tiền mặt" : "Chuyển khoản")
                    },
                    {
                        text: 'Thông tin đơn hàng:',
                        style: 'subheader'
                    },
                    {
                        table: {
                            headerRows: 1,
                            widths: ['*', '*', '*', '*'],
                            body: [
                                ['Mã sản phẩm', 'Tên sản phẩm', 'Số lượng', 'Tổng tiền'],
                                ...orderDetails
                            ]
                        }
                    },
                    {
                        text: 'Tổng tiền: '+total,
                        margin: [0,5,0,0],
                        alignment: 'right'
                    }
                ],
                styles: {
                    header: {
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    },
                    subheader: {
                        fontSize: 14,
                        bold: true,
                        margin: [0, 10, 0, 5]
                    }
                }
            };

            // Tạo tài liệu PDF và tải xuống
            pdfMake.createPdf(docDefinition).download('invoice.pdf');

            var id_user = document.querySelector('.btn-success').getAttribute('id_user');
            var list_product = JSON.parse(document.querySelector('.btn-success').getAttribute('list_id_product'));
            
            var payment_id = (payment === "Trả tiền mặt") ? 0 : 1; 
            //Lưu đơn hàng vào hóa đơn
            // Gửi yêu cầu AJAX để cập nhật giá trị trong cơ sở dữ liệu
            var xhr = new XMLHttpRequest();
                xhr.open('POST', '../PHP/add_order.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                        // Xử lý kết quả nếu cần
                        var response = xhr.responseText;
                        alert(response);
                        window.location.href = "index.php";
                        
                    }
                };
                xhr.send('id_user=' + id_user + '&hoten=' + fullname + '&phone=' + phone_number + '&address='+ address + '&payment='+payment_id + '&list_product='+list_product);
        });
    </script>
</body>
<style>
    .xemlai {
        font-size: 18px;
        font-weight: 500;
        color: blue;
    }

    .b-500 {
        font-weight: 500;
    }

    .bold {
        font-weight: bold;
    }

    .red {
        color: rgba(207, 16, 16, 0.815);
    }
</style>

</html>