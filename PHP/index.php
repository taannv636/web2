<?php require "layout/header.php"; ?>
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');
?>
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
            <section class="main-layout">
                <div class="row">
                    <?php
                    $sql = 'select * from category';
                    $categoryList = executeResult($sql);
                    $index = 1;
                    foreach ($categoryList as $item) {
                        echo '
                                    <div class="box">
                                        <a href="thucdon.php?id_category=' . $item['id'] . '">
                                            <p>' . $item['name'] . '</p>
                                            <div class="bg"></div>
                                            <img src="images/bg/gantoi.jpeg" alt="">
                                        </a>
                                    </div>
                                    ';
                    }
                    ?>
                </div>
            </section>
        </div>
        <div class="bg-grey">

        </div>
        <!-- END LAYOUT  -->
        <section class="main">
            <section class="recently">
                <div class="title">
                    <h1>Được yêu thích nhất</h1>
                </div>
                <div class="product-recently">
                    <div class="row">
                        <?php
                        $sql = 'SELECT * from product, order_details where order_details.product_id=product.id order by order_details.num DESC limit 4';
                        $productList = executeResult($sql);
                        $index = 1;
                        foreach ($productList as $item) {
                            echo '
                                <div class="col">
                                    <a href="details.php?id=' . $item['product_id'] . '">
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
            <!-- end Món ngon gần bạn -->

            <section class="restaurants">
                <div class="title">
                    <h1>Thực đơn tại quán <span class="green"></span></h1>
                </div>
                <div class="product-restaurants">
                    <div class="row">
                        <?php
                        try {
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $limit = 8;
                            $start = ($page - 1) * $limit;
                            $sql = "SELECT * FROM product limit $start,$limit";
                            executeResult($sql);
                            // $sql = 'select * from product limit $star,$limit';
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
                        } catch (Exception $e) {
                            die("Lỗi thực thi sql: " . $e->getMessage());
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        <ul>
                            <?php
                            $sql = "SELECT * FROM `product`";
                            $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)) {
                                $numrow = mysqli_num_rows($result);
                                $current_page = ceil($numrow / 8);
                                // Kiểm tra nếu có tham số trang được chuyển đến từ URL
                                $page = isset($_GET['page']) ? $_GET['page'] : 1;

                                if ($page > 1) {
                                    echo '<li><a href="?page=' . ($page - 1) . '">Previous</a></li>';
                                }

                                for ($i = 1; $i <= $current_page; $i++) {
                                    if ($i == $page) {
                                        echo '<li><a class="active-page">' . $i . '</a></li>';
                                    } else {
                                        echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                                    }
                                }

                                if ($page < $current_page) {
                                    echo '<li><a href="?page=' . ($page + 1) . '">Next</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>

                </div>
            </section>
        </section>
    </div>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.addEventListener("keydown", function(event) {
            if (event.key === "ArrowLeft") { // Nếu nhấn mũi tên trái
                event.preventDefault(); // Ngăn chặn hành động mặc định của trình duyệt
                navigateToPrevPage(); // Chuyển đến trang trước
            } else if (event.key === "ArrowRight") { // Nếu nhấn mũi tên phải
                event.preventDefault(); // Ngăn chặn hành động mặc định của trình duyệt
                navigateToNextPage(); // Chuyển đến trang kế tiếp
            }
        });

        function navigateToPrevPage() {
            var currentPage = parseInt("<?php echo isset($_GET['page']) ? $_GET['page'] : 1 ?>");
            if (currentPage > 1) {
                window.location.href = "?page=" + (currentPage - 1);
            }
        }

        function navigateToNextPage() {
            var currentPage = parseInt("<?php echo isset($_GET['page']) ? $_GET['page'] : 1 ?>");
            var totalPages = parseInt("<?php echo $current_page ?>"); // Số trang hiện có
            if (currentPage < totalPages) {
                window.location.href = "?page=" + (currentPage + 1);
            }
        }
    });
</script>

<style>
    .pagination ul li a.active-page {
        color: yellow;
    }
</style>
<?php require_once('layout/footer.php'); ?>
</div>


</body>

</html>