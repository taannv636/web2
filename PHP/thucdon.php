<?php require('layout/header.php') ?>
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
        <!-- END LAYOUT  -->
        <section class="main">
            <?php
            if (isset($_GET['page'])) {
                $page = trim(strip_tags($_GET['page']));
            } else {
                $page = "";
            }
            switch ($page) {
                case "thucdon":
                    require('menu-con/trasua.php');
                    require('menu-con/caphe.php');
                    require('menu-con/monannhe.php');
                    require('menu-con/banhmi.php');
                    break;
                default:
                    // Hiển thị phần title và product-recently
                    if (isset($_GET['id_category'])) {
                        $id_category = trim(strip_tags($_GET['id_category']));
                    } else {
                        $id_category = 0;
                    }
            ?>
                    <section class="recently">
                        <div class="title">
                            <?php
                            $sql = "select * from category where id=$id_category";
                            $name = executeResult($sql);
                            foreach ($name as $ten) {
                                echo '<h1>' . $ten['name'] . '</h1>';
                            }
                            ?>
                        </div>
                        <div class="product-recently">
                            <div class="row">
                                <?php
                                // Kiểm tra xem trang đang ở đâu (nếu có)
                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                                // Tính toán offset dựa trên số trang hiện tại và số sản phẩm mỗi trang (8 sản phẩm/trang)
                                $offset = ($current_page - 1) * 8;

                                // Tạo query dựa trên id_category hoặc search
                                $query_condition = "";
                                if (isset($_GET['id_category'])) {
                                    $id_category = trim(strip_tags($_GET['id_category']));
                                    $query_condition = "WHERE id_category = $id_category";
                                } elseif (isset($_GET['search'])) {
                                    $search = $_GET['search'];
                                    $query_condition = "WHERE title LIKE '%$search%'";
                                }

                                // Thêm limit và offset vào query để lấy sản phẩm cho trang hiện tại
                                $sql = "SELECT * FROM product $query_condition LIMIT 8 OFFSET $offset";
                                $productList = executeResult($sql);

                                // Hiển thị sản phẩm
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
                            <!-- Phân trang -->
                            <div class="pagination">
                                <ul>
                                    <?php
                                    // Tạo query dựa trên id_category hoặc search
                                    $query_condition = "";
                                    if (isset($_GET['id_category'])) {
                                        $id_category = trim(strip_tags($_GET['id_category']));
                                        $query_condition = "WHERE id_category = $id_category";
                                    } elseif (isset($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $query_condition = "WHERE title LIKE '%$search%'";
                                    }

                                    // Lấy tổng số lượng sản phẩm dựa trên điều kiện query
                                    $sql = "SELECT COUNT(*) AS total FROM `product` $query_condition";
                                    $conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $total_products = $row['total'];

                                    // Tính số trang cần hiển thị dựa trên số lượng sản phẩm và số sản phẩm mỗi trang (8 sản phẩm/trang)
                                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $products_per_page = 8;
                                    $total_pages = ceil($total_products / $products_per_page);

                                    // Hiển thị nút Previous (Trang trước)
                                    if ($current_page > 1) {
                                        echo '<li><a href="?page=' . ($current_page - 1);
                                        if (isset($_GET['id_category'])) {
                                            echo '&id_category=' . $id_category;
                                        } elseif (isset($_GET['search'])) {
                                            echo '&search=' . urlencode($search);
                                        }
                                        echo '">Previous</a></li>';
                                    }

                                    // Hiển thị các trang
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        echo '<li><a ';
                                        if ($i == $current_page) {
                                            echo 'class="active-page"';
                                        }
                                        echo ' href="?page=' . $i;
                                        if (isset($_GET['id_category'])) {
                                            echo '&id_category=' . $id_category;
                                        } elseif (isset($_GET['search'])) {
                                            echo '&search=' . urlencode($search);
                                        }
                                        echo '">' . $i . '</a></li>';
                                    }

                                    // Hiển thị nút Next (Trang tiếp theo)
                                    if ($current_page < $total_pages) {
                                        echo '<li><a href="?page=' . ($current_page + 1);
                                        if (isset($_GET['id_category'])) {
                                            echo '&id_category=' . $id_category;
                                        } elseif (isset($_GET['search'])) {
                                            echo '&search=' . urlencode($search);
                                        }
                                        echo '">Next</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </section>
            <?php
                    break;
            }
            ?>
        </section>
    </div>
    <style>
        section.main section.recently .title h1 {
            border-bottom: 1px solid rgb(35, 54, 30);
        }

        .pagination ul li a.active-page {
            color: yellow;
        }
    </style>
    <?php require('layout/footer.php') ?>