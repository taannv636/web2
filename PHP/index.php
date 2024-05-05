<?php require "layout/header.php"; ?>
<?php
require_once('database/config.php');
require_once('database/dbhelper.php');

// Thiết lập kết nối đến cơ sở dữ liệu
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . mysqli_connect_error());
}

// Tính tổng số sản phẩm
$sql_total_products = 'SELECT COUNT(*) as total FROM product';
$result_total_products = mysqli_query($conn, $sql_total_products);
$row_total_products = mysqli_fetch_assoc($result_total_products);
$total_products = $row_total_products['total'];

// Xác định trang hiện tại
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 8; // Số sản phẩm trên mỗi trang
$total_pages = ceil($total_products / $limit); // Tính tổng số trang
$start = ($current_page - 1) * $limit; // Vị trí bắt đầu lấy dữ liệu từ cơ sở dữ liệu

// Lấy dữ liệu sản phẩm cho trang hiện tại
$sql_product_list = "SELECT * FROM product LIMIT $start, $limit";
$productList = executeResult($sql_product_list);
?>
<main>
    <div class="container">
        <div id="ant-layout">
            <section class="search-quan">
                <i class="fas fa-search"></i>
                <form action="thucdon.php" method="GET">
                    <input name="search_name" type="text" placeholder="Tìm theo tên" value="<?php if (isset($_GET['search_name'])) echo $_GET['search_name']; ?>">
                </form>
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
                        $sql_most_popular = 'SELECT *, SUM(od.number) as total_number
                        FROM product p
                        JOIN order_details od ON od.id_product = p.id
                        GROUP BY p.id
                        ORDER BY total_number DESC
                        LIMIT 4;
                        ';
                        $productList_most_popular = executeResult($sql_most_popular);
                        foreach ($productList_most_popular as $item) {
                            if ($item['status'] != 0) {
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
                                                <!-- <span>15 comment</span> -->
                                                <span>Đã bán ' . $item['total_number'] . '</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                ';
                            }
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
                        foreach ($productList as $item) {
                            if ($item['status'] != 0) {
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
                        }
                        ?>
                    </div>
                    <div class="pagination">
                        <ul>
                            <?php
                            if ($current_page > 1) {
                                echo '<li><a href="?page=' . ($current_page - 1) . '">Previous</a></li>';
                            }

                            for ($i = 1; $i <= $total_pages; $i++) {
                                if ($i == $current_page) {
                                    echo '<li><a class="active-page">' . $i . '</a></li>';
                                } else {
                                    echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                                }
                            }

                            if ($current_page < $total_pages) {
                                echo '<li><a href="?page=' . ($current_page + 1) . '">Next</a></li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </section>
        </section>
    </div>
</main>
<style>
    .pagination ul li a.active-page {
        color: yellow;
    }

    .bg-grey {
        visibility: hidden;
    }
</style>
<?php require_once('layout/footer.php'); ?>
</div>
</body>

</html>

<?php
// Đóng kết nối đến cơ sở dữ liệu
mysqli_close($conn);
?>