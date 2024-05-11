<?php require "layout/header.php"; ?>
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
require_once('utils/utility.php');
// Lấy id từ trang index.php truyền sang rồi hiển thị nó
$id_user = $id = $num = $product = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Truy vấn để lấy thông tin sản phẩm
    $sql = 'SELECT * FROM product WHERE id = "' . $id . '"';
    $product = executeSingleResult($sql);

    // Kiểm tra nếu sản phẩm không tồn tại hoặc có status bằng 0
    if ($product == null || $product['status'] == 0) {
        header('Location: product_deleted.php');
        exit(); // Dừng việc thực thi mã ngay tại đây
    }
}

if (isset($_POST['num']) && isset($_COOKIE['username'])) {
    $num = $_POST['num'];
    $username = $_COOKIE['username'];

    $sql = 'SELECT id_user FROM user WHERE username = "' . $username . '"';
    $user = executeSingleResult($sql);
    $id_user = $user['id_user'];

    if (!empty($product)) {

        $status = 1;
    
        // Kiểm tra xem primary key đã tồn tại trong bảng cart chưa
        $sql_check = 'SELECT * FROM cart WHERE id_user = "' . $id_user . '" AND id_product = "' . $id . '"';
        $existing_cart_item = executeSingleResult($sql_check);

        if ($existing_cart_item) {
            // Nếu primary key đã tồn tại, thực hiện cập nhật cột number
            $sql = 'UPDATE cart SET number = "' . $num . '" WHERE id_user = "' . $id_user . '" AND id_product = "' . $id . '"';
        } else {
            // Nếu primary key chưa tồn tại, thực hiện insert mới
            $sql = 'INSERT INTO cart(id_user, id_product, number, status) 
            VALUES ("' . $id_user . '","' . $id . '","' . $num . '","' . $status . '") 
            ON DUPLICATE KEY UPDATE number = VALUES(number)';
        }

        execute($sql);
    }
}

?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0&appId=264339598396676&autoLogAppEvents=1" nonce="8sTfFiF4"></script>
<!-- END HEADR -->
<main>
    <div class="container">
        <div id="ant-layout">
            <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="thucdon.php" method="GET">
                    <input name="search" type="text" placeholder="Tìm món hoặc thức ăn">
                </form>
            </section>
        </div>
        <!-- <div class="bg-grey">
        
        </div> -->
        <!-- END LAYOUT  -->
        <section class="main">
            <section class="oder-product">
                <div class="title">
                    <section class="main-order">
                        <h1><?= $product['title'] ?></h1>
                        <div class="box">
                            <img src="<?= 'admin/product/' . $product['thumbnail'] ?>" alt="">
                            <div class="about">
                                <p><?= $product['content'] ?></p>
                                <div class="size">
                                    <p>Size:</p>
                                    <ul>
                                        <li><a href="">S</a></li>
                                        <li><a href="">M</a></li>
                                        <li><a href="">L</a></li>
                                    </ul>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="number">
                                        <span class="number-buy">Số lượng</span>
                                        <!-- Đặt tên "name" cho input number -->
                                        <input id="num" name="num" type="number" value="1" min="1" onchange="updatePrice()">
                                    </div>
                                    <p class="price">Giá: <span id="price"><?= number_format($product['price'], 0, ',', '.') ?></span><span> VNĐ</span><span class="gia none"><?= $product['price'] ?></span></p>
                                    <!-- <a class="add-cart" href="" onclick="addToCart(<?= $id ?>)"><i class="fas fa-cart-plus"></i>Thêm vào giỏ hàng</a> -->
                                    <button type="submit" class="add-cart" onclick="addToCart('<?= $id ?>')"><i class="fas fa-cart-plus"></i>Thêm vào giỏ hàng</button>
                                    <!-- <a class="buy-now" href="checkout.php" >Mua ngay</a> -->
                                </form>
                                <?php
                                if (isset($_COOKIE['username'])) {
                                     
                                    $username = $_COOKIE['username'];
                                    $sql_id = "SELECT * FROM user WHERE username = '$username'";
                                    $con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                    $result_id = mysqli_query($con, $sql_id);
                            
                                    // Lấy dữ liệu từ kết quả truy vấn
                                    $user = mysqli_fetch_assoc($result_id);
                                    $id_user = $user['id_user'];
                                }
                                ?>
                                <button class="buy-now" id_user='<?php echo $id_user ?>' id_product='<?php echo $id ?>'>Mua ngay</button>

                                <div id="alertNotSell" style="font-weight: bold; color: red"></div>
                                <div id="productNumber" style="font-weight: bold; color: red">Số lượng còn lại: <?= $product['number'] ?></div>
                                <div id="soldOut" style="font-weight: bold; color: red"></div>



                                <script>
                                    function updatePrice() {
                                        var price = document.getElementById('price').innerText; // giá tiền
                                        var num = document.querySelector('#num').value; // số lượng
                                        if (num > <?= $product['number'] ?>) {
                                            alert('Số lượng vượt quá số lượng tồn kho');
                                            document.getElementById('num').value = 1;
                                            num = 1;
                                        }

                                        var gia1 = document.querySelector('.gia').innerText;
                                        var gia = price.match(/\d/g);
                                        gia = gia.join("");
                                        var tong = gia1 * num;
                                        document.getElementById('price').innerHTML = tong.toLocaleString();
                                    }

                                    // Hàm kiểm tra status và hiển thị thông báo khi trang tải
                                    function checkStatusAndAlert() {
                                        // Kiểm tra status
                                        var status = <?= $product['status'] ?>;
                                        if (status == 1) {
                                            var buttons = document.querySelectorAll('.add-cart, .buy-now');
                                            buttons.forEach(function(button) {
                                                button.disabled = true;
                                                button.style.opacity = '0.1'; // Làm mờ button
                                            });
                                            document.getElementById('alertNotSell').innerHTML = 'Món ăn tạm thời ngừng kinh doanh. Quý khách vui lòng chọn món khác.';
                                            document.getElementById('productNumber').style.display = 'none';
                                        }

                                        // Kiểm tra còn hàng
                                        var numberRemain = <?= $product['number'] ?>;
                                        if (numberRemain == 0) {
                                            var buttons = document.querySelectorAll('.add-cart, .buy-now');
                                            buttons.forEach(function(button) {
                                                button.disabled = true;
                                                button.style.opacity = '0.1'; // Làm mờ button
                                            });
                                            document.getElementById('soldOut').innerHTML = 'Món ăn hết hàng. Quý khách vui lòng chọn món khác.';
                                        }
                                    }

                                    // Gọi hàm kiểm tra khi trang tải
                                    window.onload = checkStatusAndAlert;
                                </script>
                            </div>
                        </div>

                        <div class="fb-comments" data-href="http://localhost/PROJECT/details.php" data-width="750" data-numposts="5"></div>

                    </section>
                </div>
                <aside>
                    <h1>Gợi ý cho bạn</h1>
                    <div class="row">
                        <?php
                        $sql = 'select * from product limit 5';
                        $productList = executeResult($sql);
                        $index = 1;
                        foreach ($productList as $item) {
                            if ($item['status'] != 0)
                                echo '
                                    <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img src="admin/product/' . $item['thumbnail'] . '" alt="">
                                        <div class="about">
                                            <div class="title">
                                                <p>' . $item['title'] . '</p>
                                                <span>Giá: ' . number_format($product['price'], 0, ',', '.') . ' VNĐ' . '</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </aside>
            </section>
            <!--
                <section class="restaurants">
                <div class="title">
                    <h1>Thực đơn tại quán <span class="green"></span></h1>
                </div>
                <div class="product-restaurants">
                    <div class="row">
                        <?php
                        $sql = 'select * from product';
                        $productList = executeResult($sql);
                        $index = 1;
                        foreach ($productList as $item) {
                            echo '
                                <div class="col">
                                    <a href="details.php?id=' . $item['id'] . '">
                                        <img class="thumbnail" src="admin/product/' . $item['thumbnail'] . '" alt="">
                                        <div class="title">
                                            <p>' . $item['title'] . '</p>
                                        </div>
                                        <div class="price">
                                            <span>' . number_format($item['price'], 0, ',', '.') . ' VNĐ</span>
                                        </div>
                                        <div class="more">
                                            <div class="star">
                                                <img src="images/icon/icon-star.svg" alt="">
                                                <span>4.6</span>
                                            </div>
                                            <div class="time">
                                                <img src="images/icon/icon-clock.svg" alt="">
                                                <span>15 comment</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                        }
                        ?>
                    </div>
                </div>
            </section>
                    -->
        </section>
    </div>
</main>
<?php require_once('layout/footer.php'); ?>
</div>
<script type="text/javascript">
    function addToCart(id) {
        var num = document.querySelector('#num').value; // số lượng
        $.post('api/cookie.php', {
            'action': 'add',
            'id': id,
            'num': num
        }, function(data) {
            location.assign("cart.php");
        })
    }

    function buyNow(id) {
        $.post('api/cookie.php', {
            'action': 'add',
            'id': id,
            'num': 1
        }, function(data) {
            location.assign("checkout.php");
        })
    }

    // Lắng nghe sự kiện click của nút thanh toán
    document.querySelector('.buy-now').addEventListener('click', function(event) {
        var userId = this.getAttribute('id_user');
        var productId = this.getAttribute('id_product');
        var number = document.getElementById("num").value;
        
        // Gửi request xóa bằng AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../PHP/add_item_cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Xử lý kết quả nếu cần
                // Ví dụ: cập nhật giao diện sau khi xóa 
                //location.reload(); // Reload trang sau khi xóa
                var reponse = xhr.responseText;
                
                console.log(reponse);

            }
        };
        xhr.send('userId=' + userId + '&productId=' + productId + '&number='+number);
        // Lấy danh sách các món hàng được chọn
        var selectedOrders = [];
        selectedOrders.push(productId);
        var url = 'checkout.php?selectedOrders=' + JSON.stringify(selectedOrders);
        window.location.href = url;
                
    });
</script>
</body>

</html>