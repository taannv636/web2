-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 01:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asm_php1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_user` varchar(50) NOT NULL,
  `id_product` varchar(50) NOT NULL,
  `number` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id_user`, `id_product`, `number`, `status`) VALUES
('KH0001', 'SP002', 7, 1),
('KH0001', 'SP008', 5, 1),
('KH0001', 'SP015', 5, 1),
('KH0001', 'SP020', 10, 1),
('KH0002', 'SP022', 1, 1),
('KH0003', 'SP003', 10, 1),
('KH0003', 'SP015', 9, 1),
('KH0003', 'SP024', 9, 1),
('KH0004', 'SP003', 1, 1),
('KH0005', 'SP010', 9, 1),
('KH0006', 'SP009', 2, 1),
('KH0006', 'SP014', 8, 1),
('KH0007', 'SP008', 2, 1),
('KH0007', 'SP013', 2, 1),
('KH0007', 'SP022', 2, 1),
('KH0008', 'SP018', 3, 1),
('KH0009', 'SP024', 5, 1),
('KH0010', 'SP002', 10, 1),
('KH0010', 'SP007', 5, 1),
('KH0010', 'SP008', 7, 1),
('KH0010', 'SP013', 5, 1),
('KH0010', 'SP019', 5, 1),
('KH0011', 'SP001', 1, 1),
('KH0012', 'SP020', 5, 1),
('KH0013', 'SP020', 2, 1),
('KH0014', 'SP015', 10, 1),
('KH0015', 'SP015', 10, 1),
('KH0016', 'SP024', 6, 1),
('KH0017', 'SP018', 3, 1),
('KH0018', 'SP012', 7, 1),
('KH0019', 'SP012', 5, 1),
('KH0020', 'SP018', 9, 1),
('KH0021', 'SP003', 4, 1),
('KH0022', 'SP009', 3, 1),
('KH0023', 'SP010', 8, 1),
('KH0024', 'SP023', 8, 1),
('KH0025', 'SP023', 9, 1),
('KH0026', 'SP026', 2, 1),
('KH0027', 'SP015', 10, 1),
('KH0028', 'SP005', 4, 1),
('KH0029', 'SP022', 8, 1),
('KH0030', 'SP020', 2, 1),
('KH0031', 'SP020', 4, 1),
('KH0032', 'SP013', 2, 1),
('KH0033', 'SP016', 9, 1),
('KH0034', 'SP025', 10, 1),
('KH0035', 'SP023', 3, 1),
('KH0036', 'SP023', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Trà sữa'),
(2, 'Món ăn nhẹ'),
(3, 'Bánh mì'),
(4, 'Cà phê');

-- --------------------------------------------------------

--
-- Table structure for table `new_address`
--

CREATE TABLE `new_address` (
  `id_user` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `order_date` datetime NOT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `payment` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `order_date`, `delivery_date`, `payment`, `status`) VALUES
('HD0001', 'KH0001', '2024-03-01 10:00:00', '2024-12-01 12:00:00', 1, 1),
('HD0002', 'KH0002', '2024-03-02 10:00:00', '2024-12-01 12:00:00', 0, 2),
('HD0003', 'KH0003', '2024-03-03 10:00:00', '2024-12-01 12:00:00', 0, 3),
('HD0004', 'KH0004', '2024-03-04 10:00:00', '2024-12-01 12:00:00', 1, 4),
('HD0005', 'KH0005', '2024-03-05 10:00:00', '2024-12-01 12:00:00', 1, 1),
('HD0006', 'KH0006', '2024-03-06 10:00:00', '2024-12-01 12:00:00', 1, 2),
('HD0007', 'KH0007', '2024-03-07 10:00:00', '2024-12-01 12:00:00', 1, 1),
('HD0008', 'KH0008', '2024-03-08 10:00:00', '2024-12-01 12:00:00', 1, 4),
('HD0009', 'KH0009', '2024-03-09 10:00:00', '2024-12-01 12:00:00', 0, 1),
('HD0010', 'KH0010', '2024-03-10 10:00:00', '2024-12-01 12:00:00', 1, 3),
('HD0011', 'KH0011', '2024-03-11 10:00:00', '2024-12-01 12:00:00', 1, 2),
('HD0012', 'KH0012', '2024-03-12 10:00:00', '2024-12-01 12:00:00', 1, 1),
('HD0013', 'KH0013', '2024-03-13 10:00:00', '2024-12-01 12:00:00', 1, 3),
('HD0014', 'KH0014', '2024-03-14 10:00:00', '2024-12-01 12:00:00', 1, 4),
('HD0015', 'KH0015', '2024-03-15 10:00:00', '2024-12-01 12:00:00', 1, 1),
('HD0016', 'KH0016', '2024-03-16 10:00:00', '2024-12-01 12:00:00', 1, 4),
('HD0017', 'KH0017', '2024-03-17 10:00:00', '2024-12-01 12:00:00', 1, 3),
('HD0018', 'KH0018', '2024-03-18 10:00:00', '2024-12-01 12:00:00', 0, 1),
('HD0019', 'KH0019', '2024-03-19 10:00:00', '2024-12-01 12:00:00', 0, 2),
('HD0020', 'KH0020', '2024-03-20 10:00:00', '2024-12-01 12:00:00', 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id_order` varchar(50) NOT NULL,
  `id_product` varchar(50) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id_order`, `id_product`, `number`) VALUES
('HD0001', 'SP001', 4),
('HD0001', 'SP002', 5),
('HD0002', 'SP012', 2),
('HD0002', 'SP013', 1),
('HD0003', 'SP001', 2),
('HD0004', 'SP005', 3),
('HD0005', 'SP006', 5),
('HD0006', 'SP007', 9),
('HD0007', 'SP008', 7),
('HD0008', 'SP009', 10),
('HD0009', 'SP010', 3),
('HD0010', 'SP011', 5),
('HD0011', 'SP012', 2),
('HD0012', 'SP013', 5),
('HD0013', 'SP014', 4),
('HD0014', 'SP015', 5),
('HD0015', 'SP016', 1),
('HD0016', 'SP017', 1),
('HD0017', 'SP018', 8),
('HD0018', 'SP019', 10),
('HD0019', 'SP020', 2),
('HD0020', 'SP021', 7);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `price` float NOT NULL,
  `number` int(11) NOT NULL,
  `id_category` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `content` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `title`, `thumbnail`, `price`, `number`, `id_category`, `status`, `content`) VALUES
('SP001', 'BÁNH SÔ-CÔ-LA', 'uploads/SOCOLAHL.png', 25000, 34, 4, 0, '<p style=\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; line-height: 44px; padding: 0px;\"><span style=\"color: rgb(0, 0, 0);\">Thức uống chinh phục những thực khách khó tính! Sự kết hợp độc đáo giữa trà Ô long, hạt sen thơm bùi và củ năng giòn tan. Thêm vào chút sữa sẽ để vị thêm ngọt ngào.</span><br></p>'),
('SP002', 'Trà Sen Vàng', 'uploads/TRASENVANG.png', 35000, 39, 1, 2, '<font color=\"#000000\">Thức uống chinh phục những thực khách khó tính! Sự kết hợp độc đáo giữa trà Ô long, hạt sen thơm bùi và củ năng giòn tan. Thêm vào chút sữa sẽ để vị thêm ngọt ngào.</font><br>'),
('SP003', 'Bánh Mì Thịt Nướng', 'uploads/BMTHITNUONG.png', 25000, 30, 3, 2, 'Đặc sản của Việt Nam! Bánh mì giòn với nhân thịt nướng, rau thơm và gia vị đậm đà, hòa quyện trong lớp nước sốt tuyệt hảo.'),
('SP004', 'BÁNH MOUSSE ĐÀO', 'uploads/MOUSSEDAO.png', 35000, 10, 4, 1, '<span style=\"color: rgb(83, 56, 44); font-family: \"Open Sans\", sans-serif; font-size: 15px; text-align: justify;\">Một sự kết hợp khéo léo giữa kem và lớp bánh mềm, được phủ lên trên vài lát đào ngon tuyệt.</span><br>'),
('SP005', 'Trà sữa trân trâu đen', 'uploads/Trà-sữa-Trân-châu-đen-1.png', 50000, 10, 1, 1, '<p><span style=\"color: rgb(0, 0, 0); font-family: \" times=\"\" new=\"\" roman\";=\"\" font-size:=\"\" 20px;=\"\" font-weight:=\"\" 700;=\"\" text-align:=\"\" center;\"=\"\">Trà sữa trân trâu đường đen</span><br></p>'),
('SP006', 'Trà sữa Matcha', 'uploads/TRATHANHDAO.png', 25000, 46, 1, 1, '<p>Trà sữa Matcha<br></p>'),
('SP007', 'Cafe Phin Đen Nóng', 'uploads/AMERICANO.png', 50000, 44, 2, 1, '<p><font color=\"#53382c\">Dành cho những tín đồ cà phê đích thực! Hương vị cà phê truyền thống được phối trộn độc đáo tại Highlands. Cà phê đậm đà pha từ Phin, cho thêm 1 thìa đường, mang đến vị cà phê đậm đà chất Phin.</font><br></p>'),
('SP008', 'Bạc Xỉu Đá', 'uploads/Trà-sữa-Trân-châu-đen-1.png', 30000, 15, 2, 2, '<p>Nếu Phin Sữa Đá dành cho các bạn đam mê vị đậm đà, thì Bạc Xỉu Đá là một sự lựa chọn nhẹ “đô\" cà phê nhưng vẫn thơm ngon, chất lừ không kém!<br></p>'),
('SP009', 'BÁNH CHUỐI', 'uploads/BANHCHUOI.jpg', 19000, 20, 4, 1, '<span style=\"color: rgb(83, 56, 44); font-family: \"Open Sans\", sans-serif; font-size: 15px; text-align: justify;\">Bánh chuối truyền thống, sự kết hợp của 100% chuối tươi và nước cốt dừa Việt Nam.</span><br>'),
('SP010', 'Bánh Mousse Cacao', 'uploads/MOUSSECACAO.png', 35000, 5, 4, 2, '<span style=\"color: rgb(83, 56, 44); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Bánh Mousse Ca Cao, là sự kết hợp giữa ca-cao Việt Nam đậm đà cùng kem tươi.</span><br>'),
('SP011', 'Bánh Mì Xíu Mại', 'uploads/BMXIUMAI.png', 20000, 30, 3, 1, 'Bánh mì Việt Nam giòn thơm, với nhân thịt viên hấp dẫn, phủ thêm một lớp nước sốt cà chua ngọt, cùng với rau tươi và gia vị đậm đà.'),
('SP012', 'Bánh Caramel Phô Mai', 'uploads/CARAMELPHOMAI.jpg', 35000, 10, 4, 1, 'Ngon khó cưỡng! Bánh phô mai thơm béo được phủ bằng lớp caramel ngọt ngào.'),
('SP013', 'Trà Thạch Đào', 'uploads/TRATHANHDAO.png', 50000, 10, 1, 0, '<p><span style=\"color: rgb(0, 0, 0); font-size: 1rem;\">Vị trà đậm đà kết hợp cùng những miếng đào thơm ngon mọng nước cùng thạch đào giòn dai. Thêm vào ít sữa để gia tăng vị béo</span><br></p><p><br></p>'),
('SP014', 'Trà Thạch Vải', 'uploads/TRATHACHVAI_1.png', 50000, 46, 1, 1, '<p>Một sự kết hợp thú vị giữa trà đen, những quả vải thơm ngon và thạch giòn khó cưỡng, mang đến thức uống tuyệt hảo!<br></p>'),
('SP015', 'Trà Đào', 'uploads/TRATHANHDAO (1).png', 50000, 44, 1, 1, '<p><span style=\"color: rgb(83, 56, 44); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" font-size:=\"\" 14px;=\"\" text-align:=\"\" justify;\"=\"\">Một sự kết hợp thú vị giữa trà đen, những quả vải thơm ngon và thạch giòn khó cưỡng, mang đến thức uống tuyệt hảo!</span><br></p>'),
('SP016', 'Cà Phê Đá', 'uploads/CFD.png', 30000, 15, 2, 0, '<p>Dành cho những tín đồ cà phê đích thực! Hương vị cà phê truyền thống được phối trộn độc đáo tại Highlands. Cà phê đậm đà pha hoàn toàn từ Phin, cho thêm 1 thìa đường, một ít đá viên mát lạnh, tạo nên Phin Đen Đá mang vị cà phê đậm đà chất Phin.<br></p>'),
('SP017', 'Bánh Tiramisu', 'uploads/TIRAMISU.jpg', 35000, 100, 4, 1, '<p>Tiramisu thơm béo, làm từ ca-cao Việt Nam đậm đà, kết hợp với phô mai ít béo, vani và chút rum nhẹ nhàng.<br></p>'),
('SP018', 'Chả Lụa Xá Xíu', 'uploads/BMCHALUAXAXIU.png', 20000, 90, 3, 1, '<p>Bánh mì Việt Nam giòn thơm với chả lụa và thịt xá xíu thơm ngon, kết hợp cùng rau và gia vị, hòa quyện cùng nước sốt độc đáo.<br></p>'),
('SP019', 'Gà Xé Tương Ớt', 'uploads/BMGAXE.png', 19000, 20, 3, 1, '<p>Bánh mì Việt Nam giòn thơm với nhân gà xé, rau, gia vị hòa quyện cùng nước sốt đặc biệt.<br></p>'),
('SP020', 'Cafe Phindi Hồng Trà', 'uploads/270_crop_PHINDI_Hong_Tra.png', 35000, 100, 2, 1, '<p>PhinDi Kem Sữa - Cà phê Phin thế hệ mới với chất Phin êm hơn, lần đầu tiên kết hợp cùng Hồng Trà mang đến hương vị quyện êm, phiên bản giới hạn chỉ trong mùa lễ hội 2020!<br></p>'),
('SP021', 'Cafe Phindi Kem Sữa', 'uploads/270_crop_phindi_kem_sua_new.png', 35000, 90, 2, 2, '<p>PhinDi Kem Sữa - Cà phê Phin thế hệ mới với chất Phin êm hơn, kết hợp cùng Kem Sữa béo ngậy mang đến hương vị mới lạ, không thể hấp dẫn hơn!<br></p>'),
('SP022', 'Pepsi', '', 15000, 102, 1, 1, ''),
('SP023', 'Sprite', '', 15000, 171, 1, 1, ''),
('SP024', 'Fanta', '', 15000, 193, 1, 1, ''),
('SP025', 'Nước ép cà rốt', '', 20000, 74, 1, 1, ''),
('SP026', 'Nước ép dưa hấu', '', 20000, 76, 4, 1, ''),
('SP027', 'Bánh mì cheese', 'uploads/', 40000, 34, 2, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(50) NOT NULL,
  `hoten` varchar(100) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `birthday` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `right` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `hoten`, `sex`, `birthday`, `email`, `address`, `phone`, `username`, `password`, `right`, `status`) VALUES
('KH0000', 'admin', 0, '2000-03-31', 'phatnguyen98@gmail.com', '10 Đường 13, Phường 4, Quận 8, Thành Phố Hồ Chí Minh', '0581151429', 'admin', '12345678', 0, 1),
('KH0001', 'Lê Thị Ngọc Ánh', 0, '2000-03-31', 'lethingocanh@gmail.com', '10 Đường Nguyễn Huệ, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0581151429', 'lethingocanh', '12345678', 0, 1),
('KH0002', 'Lê Văn Bắc', 1, '2000-07-23', 'levanbac@gmail.com', '22 Đường Lê Lai, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0363037771', 'levanbac', '12345678', 1, 0),
('KH0003', 'Bùi Thị Ngọc Dung', 1, '2000-10-20', 'buithingocdung@gmail.com', '33 Đường Hai Bà Trưng, Phường Cầu Kho, Quận 1, Thành Phố Hồ Chí Minh', '0577929217', 'buithingocdung', '12', 1, 1),
('KH0004', 'Vũ Thị Dung', 0, '2000-06-10', 'vuthidung@gmail.com', '44 Đường Tôn Đức Thắng, Phường Nguyễn Thái Bình, Quận 1, Thành Phố Hồ Chí Minh', '0372723280', 'vuthidung', '12345678', 1, 1),
('KH0005', 'Đinh Đăng Điện', 1, '2000-09-03', 'dinhdangdien@gmail.com', '55 Đường Lê Thánh Tôn, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0857519139', 'dinhdangdien', '03092000', 1, 1),
('KH0006', 'Nguyễn Anh Đức', 1, '2000-09-05', 'nguyenanhduc@gmail.com', '66 Đường Đông Du, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0214068953', 'nguyenanhduc', '05092000', 1, 1),
('KH0007', 'Dương Minh Hải', 1, '2000-04-01', 'duongminhhai@gmail.com', '77 Đường Phan Đình Phùng, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0471415644', 'duongminhhai', '01042000', 1, 1),
('KH0008', 'Trần Thị Hạnh', 0, '2000-12-16', 'tranthihanh@gmail.com', '88 Đường Võ Văn Tần, Phường 3, Quận 3, Thành Phố Hồ Chí Minh', '0908011088', 'tranthihanh', '16122000', 1, 1),
('KH0009', 'Nguyễn Thị Hiền', 0, '2000-09-15', 'nguyenthihien@gmail.com', '99 Đường 3 Tháng 2, Phường 11, Quận 10, Thành Phố Hồ Chí Minh', '0644962027', 'nguyenthihien', '15092000', 1, 1),
('KH0010', 'Đồng Thị Hà Linh', 0, '2000-09-02', 'dongthihalinh@gmail.com', '100 Đường Nguyễn Trãi, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0562133662', 'dongthihalinh', '02092000', 1, 1),
('KH0011', 'Nguyễn Thùy Linh', 0, '2000-10-19', 'nguyenthuylinh@gmail.com', '111 Đường Huỳnh Thúc Kháng, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0513279946', 'nguyenthuylinh', '19102000', 1, 1),
('KH0012', 'Trần Ngọc Linh', 1, '2000-08-20', 'tranngoclinh@gmail.com', '122 Đường Trần Hưng Đạo, Phường Phan Chu Trinh, Quận 1, Thành Phố Hồ Chí Minh', '0194294893', 'tranngoclinh', '20082000', 1, 1),
('KH0013', 'Phạm Hồng Lộc', 0, '1999-11-16', 'phamhongloc@gmail.com', '133 Đường Phó Đức Chính, Phường Nguyễn Thái Bình, Quận 1, Thành Phố Hồ Chí Minh', '0212295130', 'phamhongloc', '16111999', 1, 1),
('KH0014', 'Nguyễn Khánh Ly', 0, '2000-09-02', 'nguyenkhanhly@gmail.com', '144 Đường Lý Tự Trọng, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0984577447', 'nguyenkhanhly', '02092000', 1, 1),
('KH0015', 'Trần Bích Ngân', 0, '1999-05-28', 'tranbichngan@gmail.com', '155 Đường Nguyễn Công Trứ, Phường Nguyễn Thái Bình, Quận 1, Thành Phố Hồ Chí Minh', '0624408370', 'tranbichngan', '28051999', 1, 1),
('KH0016', 'Đỗ Thị Bích Ngọc', 0, '2000-10-25', 'dothibichngoc@gmail.com', '166 Đường Nguyễn Thị Minh Khai, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0404239114', 'dothibichngoc', '25102000', 1, 1),
('KH0017', 'Phạm Hồng Ngọc', 1, '1999-11-10', 'phamhongngoc@gmail.com', '177 Đường Phan Kế Bính, Phường Đa Kao, Quận 1, Thành Phố Hồ Chí Minh', '0551977851', 'phamhongngoc', '10111999', 1, 1),
('KH0018', 'Dương Hà Bảo Phương', 0, '2000-01-14', 'duonghabaophuong@gmail.com', '188 Đường Nguyễn Du, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0658071059', 'duonghabaophuong', '14012000', 1, 1),
('KH0019', 'Nguyễn Thanh Tú', 0, '2000-06-13', 'nguyenthanhtu@gmail.com', '199 Đường Tôn Thất Thuyết, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0494331134', 'nguyenthanhtu', '13062000', 1, 1),
('KH0020', 'Phạm Thị Thanh Thảo', 0, '2000-01-29', 'phamthithanhthao@gmail.com', '200 Đường Nguyễn Cư Trinh, Phường Nguyễn Cư Trinh, Quận 1, Thành Phố Hồ Chí Minh', '0480787840', 'phamthithanhthao', '29012000', 1, 1),
('KH0021', 'Nguyễn Minh Trang', 0, '2000-12-20', 'nguyenminhtrang@gmail.com', '211 Đường Đồng Khởi, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0940691706', 'nguyenminhtrang', '20122000', 1, 1),
('KH0022', 'Vũ Thị Thùy Dung', 0, '1999-09-19', 'vuthithuydung@gmail.com', '222 Đường Mạc Thị Bưởi, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0642231529', 'vuthithuydung', '19091999', 1, 1),
('KH0023', 'Đoàn Thị Sen', 0, '1999-04-05', 'doanthisen@gmail.com', '233 Đường Nguyễn Thị Minh Khai, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0925170996', 'doanthisen', '05041999', 1, 1),
('KH0024', 'Nguyễn Minh Anh', 0, '2000-10-12', 'nguyenminhanh@gmail.com', '244 Đường Lê Thị Riêng, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0204044268', 'nguyenminhanh', '12102000', 1, 1),
('KH0025', 'Hà Thị Hồng Chuyên', 0, '2000-03-19', 'hathihongchuyen@gmail.com', '255 Đường Lê Lai, Phường Phạm Ngũ Lão, Quận 1, Thành Phố Hồ Chí Minh', '0666645233', 'hathihongchuyen', '19032000', 1, 1),
('KH0026', 'Lê Phương Dung', 0, '2000-12-21', 'lephuongdung@gmail.com', '266 Đường Phạm Viết Chánh, Phường Nguyễn Cư Trinh, Quận 1, Thành Phố Hồ Chí Minh', '0891128380', 'lephuongdung', '21122000', 1, 1),
('KH0027', 'Nguyễn Minh Dũng', 1, '2000-05-20', 'nguyenminhdung@gmail.com', '277 Đường Nguyễn Bỉnh Khiêm, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0389519161', 'nguyenminhdung', '20052000', 1, 1),
('KH0028', 'Lê Thị Hoài', 0, '2000-01-04', 'lethihoai@gmail.com', '288 Đường Lê Thánh Tôn, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0574067640', 'lethihoai', '04012000', 1, 1),
('KH0029', 'Phạm Thị Thu Huyền', 0, '2000-06-10', 'phamthithuhuyen@gmail.com', '299 Đường Đồng Khởi, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0231701800', 'phamthithuhuyen', '10062000', 1, 1),
('KH0030', 'Nguyễn Thị Lan', 0, '2000-09-29', 'nguyenthilan@gmail.com', '300 Đường Nguyễn Thị Minh Khai, Phường Nguyễn Cư Trinh, Quận 1, Thành Phố Hồ Chí Minh', '0710141127', 'nguyenthilan', '29092000', 1, 1),
('KH0031', 'Lê Thị Ngọc Loan', 0, '2000-10-08', 'lethingocloan@gmail.com', '311 Đường Lê Lợi, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0559928317', 'lethingocloan', '08102000', 1, 1),
('KH0032', 'Lê Thị Thanh Lâm', 0, '2000-05-21', 'lethithanhlam@gmail.com', '322 Đường Lê Đại Hành, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0561266694', 'lethithanhlam', '21052000', 1, 1),
('KH0033', 'Lê Thị Ngọc Lan', 0, '2000-02-17', 'lethingoclan@gmail.com', '333 Đường Phạm Viết Chánh, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0513386578', 'lethingoclan', '17022000', 1, 1),
('KH0034', 'Lê Thị Thùy Linh', 0, '2000-08-28', 'lethithuylinh@gmail.com', '344 Đường Nguyễn Bỉnh Khiêm, Phường Bến Nghé, Quận 1, Thành Phố Hồ Chí Minh', '0393353031', 'lethithuylinh', '28082000', 1, 1),
('KH0035', 'Lê Thị Ngọc Mai', 0, '2000-06-02', 'lethingocmai@gmail.com', '355 Đường Phó Đức Chính, Phường Nguyễn Thái Bình, Quận 1, Thành Phố Hồ Chí Minh', '0224575132', 'lethingocmai', '02062000', 1, 1),
('KH0036', 'Phạm Thị Thùy Trang', 0, '2000-03-11', 'phamthithuytrang@gmail.com', '366 Đường Nguyễn Cư Trinh, Phường Nguyễn Cư Trinh, Quận 1, Thành Phố Hồ Chí Minh', '0957881478', 'phamthithuytrang', '11032000', 1, 1),
('KH0037', 'Lê Thị Thùy Trang', 0, '2000-11-25', 'lethithuytrang@gmail.com', '377 Đường Lê Thị Riêng, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0211727739', 'lethithuytrang', '25112000', 1, 1),
('KH0038', 'Lê Thị Phương Trinh', 0, '2000-05-23', 'lethiphuongtrinh@gmail.com', '388 Đường Lý Tự Trọng, Phường Bến Thành, Quận 1, Thành Phố Hồ Chí Minh', '0664559846', 'lethiphuongtrinh', '23052000', 1, 1),
('KH0039', 'Lê Thị Bích Trâm', 0, '2000-08-07', 'lethibichtram@gmail.com', '399 Đường Đinh Tiên Hoàng, Phường Đa Kao, Quận 1, Thành Phố Hồ Chí Minh', '0412651974', 'lethibichtram', '07082000', 1, 1),
('KH0040', 'Lê Thị Thanh Trúc', 0, '2000-04-14', 'lethithanhtruc@gmail.com', '400 Đường Đinh Công Tráng, Phường Nguyễn Thái Bình, Quận 1, Thành Phố Hồ Chí Minh', '0640663244', 'lethithanhtruc', '14042000', 1, 1);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_user`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_address`
--
ALTER TABLE `new_address`
  ADD PRIMARY KEY (`id_user`,`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`);

--
-- Constraints for table `new_address`
--
ALTER TABLE `new_address`
  ADD CONSTRAINT `new_address_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
