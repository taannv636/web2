
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
    <link rel="stylesheet" href="plugin/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/cart.css">
    <title>Giỏ hàng</title>
</head>

<body>
    <div id="wrapper">
        <?php require_once('layout/header.php'); ?>
        <!-- END HEADR -->
        <main style="padding-bottom: 4rem;">
            <section class="cart">
                <div class="container-top">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="padding: 1rem 0;">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="cart.php">Giỏ hàng</a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="history.php">Lịch sử mua hàng</a>
                                </li>
                            </ul>
                            <h2 style="padding-top:2rem" class="">Giỏ hàng</h2>
                        </div>
                        <div class="panel-body"></div>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr style="font-weight: 500;text-align: center;">
                                    <td width="50px"></td>
                                    <td>Ảnh</td>
                                    <td>Tên Sản Phẩm</td>
                                    <td>Giá</td>
                                    <td>Số lượng</td>
                                    <td>Tổng tiền</td>
                                    <td width="50px"></td>
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
                                    $sql = "SELECT product.id as id, cart.number as numbers, product.title as title, product.thumbnail as thumbnail, product.price as price
                                            FROM cart JOIN product ON cart.id_product = product.id WHERE cart.id_user = '$id_user'";
                                    $result = executeResult($sql);
                                    foreach ($result as $item) {
                                        echo '
                                            <tr style="text-align: center;">
                                                <td width="50px">
                                                    <input type="checkbox" class="checkbox" id="myCheckbox" name="myCheckbox" value="1">
                                                </td>
                                                <td style="text-align:center">
                                                    <img src="admin/product/' . $item['thumbnail'] . '" alt="" style="width: 50px">
                                                </td>
                                                <td>' . $item['title'] . '</td>
                                                <td class="b-500 red" id="price">' . number_format($item['price'], 0, ',', '.') . '<span> VNĐ</span></td>
                                                <td width="100px" class="quantity">
                                                    <input type="number" id="quantity" value="' . $item['numbers'] . '" min="1">
                                                </td>
                                                <td class="b-500 red" ><span class = "total_item">' . number_format($item['price'] * $item['numbers'], 0, ',', '.') . '</span><span> VNĐ</span></td>
                                                <td>
                                                    <a>
                                                    <button class="btn btn-danger delete-btn" data-user-id="' . $id_user . '" data-product-id="' . $item['id'] . '">Xoá</button>
                                                    </a>
                                                </td>
                                            </tr>';
                                    }
                                }
                                ?>
                                <script>
                                    function updatePrice() {
                                        var price = document.getElementById('price').innerText; // giá tiền
                                        var num = document.querySelector('#quantity').value; // số lượng
                                        if (num > <?= $result['number'] ?>)
                                        {
                                            alert('Số lượng vượt quá số lượng tồn kho');
                                            document.getElementById('quantity').value = 1;
                                            num = 1;
                                        }

                                        var gia1 = document.querySelector('.gia').innerText;
                                        var gia = price.match(/\d/g);
                                        gia = gia.join("");
                                        var tong = gia1 * num;
                                        document.getElementById('price').innerHTML = tong.toLocaleString();  
                                    }
                                    </script>
                            </tbody>
                        </table>
                        <p>Tổng đơn hàng: <span class="red bold" id="total"><?= number_format(0, 0, ',', '.') ?><span> VNĐ</span></span></p>
                        <a href="checkout.php" onclick="checkLogin()"><button class="btn btn-success">Thanh toán</button></a>
                    </div>
                </div>
            </section>
        </main>
        <?php require_once('layout/footer.php'); ?>
    </div>
    <script type="text/javascript">
        function deleteCart(id) {
            // $.post('api/cookie.php', {
            //     'action': 'delete',
            //     'id': id
            // }, function(data) {
            //     location.reload()
            // })
        }

        function checkLogin() {

        }

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                var userId = this.getAttribute('data-user-id');
                var productId = this.getAttribute('data-product-id');
                var cf = confirm(userId +" "+productId)
                var confirmation = confirm("Bạn có chắc muốn xoá sản phẩm này?");
                if (confirmation) {
                    // Gửi request xóa bằng AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', '/delete_item.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                            // Xử lý kết quả nếu cần
                            // Ví dụ: cập nhật giao diện sau khi xóa 
                            location.reload(); // Reload trang sau khi xóa

                        }
                    };
                    xhr.send('userId=' + userId + '&productId=' + productId);
                }
            });
        });


        function number_format_script(number, decimals, dec_point, thousands_sep) {
            // Chuyển đổi số thành chuỗi, nếu số này không phải là số thì trả về số ban đầu
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number, // Kiểm tra số có hợp lệ không
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals), // Xác định số thập phân
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep, // Xác định ký tự phân cách hàng nghìn
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point, // Xác định ký tự phân cách số thập phân
                s = '',

                // Hàm để thêm ký tự phân cách hàng nghìn
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };

            // Xử lý số thập phân
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');

            // Xử lý hàng nghìn
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(s[0])) {
                s[0] = s[0].replace(rgx, '$1' + sep + '$2');
            }

            // Nối lại kết quả
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }

            return s.join(dec);
        }

        function convertCurrencyToNumber(currencyString) {
            // Loại bỏ các ký tự không phải số từ chuỗi
            var numberString = currencyString.replace(/[^\d]/g, '');
            // Chuyển đổi chuỗi số thành số nguyên
            var number = parseInt(numberString);
            return number;
        }
        var total = 0;
        document.querySelectorAll('.checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('click', function() {
                if (this.checked) {
                    var total_item = this.closest('tr').querySelector('.total_item').innerHTML;
                    total = total + convertCurrencyToNumber(total_item);
                    alert("Kiểu dữ liệu là: " + total);
                    document.getElementById('total').innerHTML = number_format_script(total, 0, ',', '.') + " VNĐ";
                } else {
                    var total_item = this.closest('tr').querySelector('.total_item').innerHTML;
                    total = total - convertCurrencyToNumber(total_item);
                    alert("Kiểu dữ liệu là: " + total);
                    document.getElementById('total').innerHTML = number_format_script(total, 0, ',', '.') + " VNĐ";
                }
            });
        });
    </script>
</body>
<style>
    .b-500 {
        font-weight: 500;
    }

    .bold {
        font-weight: bold;
    }

    .red {
        color: rgba(207, 16, 16, 0.815);
    }

    .quantity {

        align-items: center;

    }

    .quantity input {
        width: 100%;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin: 0 5px;
        padding: 5px;
    }
</style>

</html>