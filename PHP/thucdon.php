<?php require('layout/header.php') ?>
<main>
    <div class="container">
        <div id="ant-layout">
            <section class="search-quan">
                <form action="thucdon.php" method="GET">
                    <input type="text" name="search_name" placeholder="Tìm theo tên" value="<?php if (isset($_GET['search_name'])) echo $_GET['search_name']; ?>">
                    <input type="number" name="search_price_min" placeholder="Giá từ" style="margin-top: 10px;">
                    <input type="number" name="search_price_max" placeholder="Giá đến" style="margin-top: 10px;">
                    <!-- Thêm Input List cho Category -->
                    <select name="id_category">
                        <option value="">Tất cả</option>
                        <?php
                        // Truy vấn để lấy tất cả các category từ CSDL
                        $sql_categories = "SELECT * FROM category";
                        $categories = executeResult($sql_categories);

                        // Hiển thị các option cho input list
                        foreach ($categories as $category) {
                            echo '<option value="' . $category['id'] . '"';
                            if (isset($_GET['id_category']) && $_GET['id_category'] == $category['id']) {
                                echo ' selected';
                            }
                            echo '>' . $category['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit">Tìm kiếm</button>
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
                    if (isset($_GET['id'])) {
                        $id = trim(strip_tags($_GET['id']));
                    } else {
                        $id = 0;
                    }
            ?>
                    <section class="recently">
                        <div class="title">
                            <?php
                            $sql = 'SELECT * FROM category WHERE id ="' . $id . '"';
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

                        // Tạo query dựa trên id_category, search terms, and price range
                        $query_condition = "";
                        if (isset($_GET['id_category'])) {
                            $id_category = trim(strip_tags($_GET['id_category']));
                            $query_condition = "WHERE id_category = '$id_category'";
                        } elseif (isset($_GET['search'])) {
                            $search = $_GET['search'];
                            $query_condition = "WHERE title LIKE N'%$search%'";
                        }

                        // Thêm limit và offset vào query để lấy sản phẩm cho trang hiện tại
                        $sql = "SELECT * FROM product $query_condition LIMIT 8 OFFSET $offset";
                        $productList = executeResult($sql);


                                // Hiển thị sản phẩm
                                foreach ($productList as $item) {
                                    if ($item['status'] != 0)
                                    {
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

                            <?php
                             $query_condition = "";
                             if (isset($_GET['id_category'])) {
                                 $id_category = trim(strip_tags($_GET['id_category']));
                                 $query_condition = "WHERE id_category = ' . $id_category . '";
                             } elseif (isset($_GET['search'])) {
                                 $search = $_GET['search'];
                                 $query_condition = "WHERE title LIKE N'%$search%'";
                             }

                            // Tính tổng số sản phẩm
                            $query_total = "SELECT COUNT(id) AS total FROM product $query_condition";
                            $result_total = executeResult($query_total);
                            $total_records = $result_total[0]['total'];

                            // Tính tổng số trang
                            $total_pages = ceil($total_records / 8);

                            // Tạo chuỗi URL cho các tham số tìm kiếm để giữ nguyên khi phân trang
                            $additional_params = "";
                            if (isset($_GET['search_name'])) {
                                $additional_params .= "&search_name=" . urlencode($_GET['search_name']);
                            }
                            if (isset($_GET['search_price_min'])) {
                                $additional_params .= "&search_price_min=" . $_GET['search_price_min'];
                            }
                            if (isset($_GET['search_price_max'])) {
                                $additional_params .= "&search_price_max=" . $_GET['search_price_max'];
                            }
                            if (isset($_GET['id_category'])) {
                                $additional_params .= "&id_category=" . $_GET['id_category'];
                            }
                            ?>

                            <!-- Thanh phân trang HTML -->
                            <div class="pagination">
                                <ul>
                                    <?php
                                    // Tạo query dựa trên id_category hoặc search
                                    $query_condition = "";
                                    if (isset($_GET['id_category'])) {
                                        $id_category = trim(strip_tags($_GET['id_category']));
                                        $query_condition = "WHERE id_category = ' . $id_category . '";
                                    } elseif (isset($_GET['search'])) {
                                        $search = $_GET['search'];
                                        $query_condition = "WHERE title LIKE N'%$search%'";
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
                                        $prev_page = $current_page - 1;
                                        echo '<li><a href="?page=' . $prev_page . $additional_params . '">Prev</a></li>';
                                    }

                                    // Hiển thị các nút số trang
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        if ($i == $current_page) {
                                            echo '<li><span class="active-page">' . $i . '</span></li>';
                                        } else {
                                            echo '<li><a href="?page=' . $i . $additional_params . '">' . $i . '</a></li>';
                                        }
                                    }

                                    // Nếu không phải trang cuối cùng thì hiển thị nút Next
                                    if ($current_page < $total_pages) {
                                        $next_page = $current_page + 1;
                                        echo '<li><a href="?page=' . $next_page . $additional_params . '">Next</a></li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <!-- Kết thúc thanh phân trang HTML -->
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

        .active-page {
            color: yellow;
        }

        main section.search-quan select {
            width: 87%;
            padding: 15px 50px;
            /* Điều chỉnh giữa các phần tử */
            border-radius: 10px;
            outline: 0;
            border: 0;
            background-color: #f7f7f7;
            margin-top: 10px;
            /* Để giống với các input khác */
        }

        main section.search-quan select:hover {
            border-width: 2px;
            border-style: solid;
            border-color: #00b14c;
        }

        main section.search-quan button[type="submit"] {
            width: auto;
            /* Để nút có chiều rộng tự động theo nội dung */
            padding: 15px 30px;
            /* Điều chỉnh kích thước nút */
            border-radius: 10px;
            outline: 0;
            border: 0;
            background-color: #4caf50;
            /* Màu nền */
            color: white;
            /* Màu chữ */
            cursor: pointer;
            margin-left: 10px;
            /* Để tạo khoảng cách giữa nút và select */
        }

        main section.search-quan button[type="submit"]:hover {
            background-color: #45a049;
            color: yellow;
            /* Màu nền hover */
        }
    </style>
    <?php require('layout/footer.php') ?>