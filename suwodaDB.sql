-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Oct 06, 2025 at 07:27 AM
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
-- Database: `suwoda`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`) VALUES
(1, 'Suwoda Admin 1', 'admin1@gmail.com', 'Admin@123');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `published_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`blog_id`, `title`, `image`, `content`, `published_date`) VALUES
(1, ' What Is Ayurveda?', '../assets/images/uploads/Blogs1753081225_Blog1.jpg', 'Introduction\r\nAyurveda is one of the world’s oldest holistic healing systems. Originating more than 5,000 years ago in India and widely practiced in Sri Lanka, Ayurveda emphasizes balance between the body, mind, and spirit. The word “Ayurveda” comes from the Sanskrit words “Ayur” (life) and “Veda” (knowledge or science) — meaning the “Science of Life.”\r\n\r\nThe Core Principles of Ayurveda\r\nAyurveda is based on the belief that health and wellness depend on a delicate balance between the five elements:\r\n\r\nEarth (Prithvi)\r\n\r\nWater (Jala)\r\n\r\nFire (Teja)\r\n\r\nAir (Vayu)\r\n\r\nSpace (Akasha)\r\n\r\nThese elements combine in the body to form three energies or doshas:\r\n\r\nVata (Air + Space) – Controls movement and breathing\r\n\r\nPitta (Fire + Water) – Controls digestion and metabolism\r\n\r\nKapha (Earth + Water) – Controls structure and immunity\r\n\r\nEach person has a unique combination of doshas, called their Prakriti.\r\n', '2025-07-21 12:30:25'),
(2, 'Top 10 Ayurvedic Herbs and Their Benefits', '../assets/images/uploads1753082317_Blog2.jpg', '🌱 Introduction\r\nAyurveda is a treasure trove of powerful herbs that have been used for thousands of years to heal the body naturally. These herbs are used in the form of powders, oils, teas, and pills. In this blog, we’ll introduce you to 10 of the most powerful Ayurvedic herbs and their health benefits — many of which are found right here in Sri Lanka!\r\n\r\n🪴 1. Gotu Kola (Centella Asiatica) – Ponnanwela (පොන්නාන්වැල්ල)\r\n🧠 Boosts brain function and memory\r\n\r\n🧘‍♀️ Reduces anxiety and stress\r\n\r\n💉 Improves blood circulation\r\n\r\nUsed in: herbal teas, pastes for wounds\r\n\r\n🪴 2. Neem (Azadirachta indica) – Kohomba (කොහොඹ)\r\n🌿 Natural blood purifier\r\n\r\n🧼 Treats acne, skin infections, and dandruff\r\n\r\n🦷 Used in herbal toothpastes for gum care\r\n\r\nAvailable as: oil, powder, capsules\r\n\r\n🪴 3. Turmeric (Curcuma longa) – Kaha (කහ)\r\n🔥 Strong anti-inflammatory properties\r\n\r\n🛡️ Boosts immunity\r\n\r\n🧴 Improves skin tone and brightness\r\n\r\nPopular in: turmeric lattes, face packs\r\n\r\n🪴 4. Ashwagandha (Withania somnifera)\r\n⚡ Boosts energy levels and stamina\r\n\r\n😌 Reduces cortisol (stress hormone)\r\n\r\n💪 Strengthens muscles and bones\r\n\r\nUsed as: capsules, powders, tonic\r\n\r\n🪴 5. Amla (Indian Gooseberry) – Nelli (නෙල්ලි)\r\n🍋 Rich in Vitamin C\r\n\r\n🧬 Slows aging and strengthens immunity\r\n\r\n🧖‍♀️ Improves hair health and reduces greying\r\n\r\nFound in: oils, hair tonics, herbal drinks\r\n\r\n🪴 6. Brahmi (Bacopa monnieri)\r\n🧠 Supports mental clarity and focus\r\n\r\n💤 Helps treat insomnia and restlessness\r\n\r\n🫀 Supports heart health\r\n\r\nUsed in: memory-boosting supplements\r\n\r\n🪴 7. Coriander (Coriandrum sativum) – Kottamalli (කොත්තමල්ලි)\r\n🌿 Improves digestion and relieves gas\r\n\r\n🤧 Useful for treating colds and fevers\r\n\r\n☕ Commonly consumed as herbal tea\r\n\r\n🪴 8. Fenugreek (Trigonella foenum-graecum) – Uluhal (උලුහල)\r\n🥗 Controls blood sugar levels\r\n\r\n🍼 Supports milk production in lactating mothers\r\n\r\n🌱 Improves metabolism and weight loss\r\n\r\n🪴 9. Ceylon Cinnamon (Cinnamomum verum) – Kurundu (කුරුඳු)\r\n🍬 Regulates blood sugar\r\n\r\n❤️ Good for heart health\r\n\r\n💨 Aids digestion and reduces bloating\r\n\r\n🪴 10. Cardamom (Elettaria cardamomum) – Enasal (ඇනසල්)\r\n😌 Helps in relieving nausea and acidity\r\n\r\n🌬️ Freshens breath and improves oral health\r\n\r\n☕ Adds flavor and medicinal value to teas\r\n\r\n', '2025-07-21 12:48:37');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(40, 47, 20, 1),
(41, 52, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `image`) VALUES
(1, 'Herbal Oils', '../assets/images/herbal_oils.jpg'),
(2, 'Ayurvedic Teas', '../assets/images/ayurvedic tea.jpg'),
(3, 'Herbal Powders', '../assets/images/herbal powders.jpg'),
(4, 'Soaps & Skincare', '../assets/images/soap&skin.jpg'),
(5, 'Pain Relief Balms', '../assets/images/balms.jpg'),
(6, 'Wellness Syrups', '../assets/images/syrup.jpg'),
(7, 'Hair Care', '../assets/images/hair care.jpg'),
(11, 'Baby Care', '../uploads/categories/1753353235_baby_care.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `discount_percentage` decimal(5,2) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `product_id`, `discount_percentage`, `start_date`, `end_date`) VALUES
(2, 16, 10.00, '2025-09-13', '2025-09-13');

-- --------------------------------------------------------

--
-- Table structure for table `herb`
--

CREATE TABLE `herb` (
  `herb_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `scientific_name` varchar(150) NOT NULL,
  `uses` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herb`
--

INSERT INTO `herb` (`herb_id`, `name`, `scientific_name`, `uses`, `image`) VALUES
(8, 'Amla (Nelli)', 'Phyllanthus emblica', ' Rich in Vitamin C, supports immunity, improves digestion, and promotes healthy skin and hair.\r\n\r\n', 'Amla.png'),
(9, 'Aralu', 'Terminalia chebula', 'Constipation relief, detoxification, part of Thriphala formula, supports digestion.', 'Aralu.JPG'),
(10, 'Aloe Vera', 'Aloe barbadensis miller', 'Skin healing, burn treatment, digestive support, detoxificat', 'Aloe Vera.jpg'),
(11, 'Bovitiya', 'Osbeckia octandra', 'Used to treat liver problems, jaundice, and skin conditions. Often consumed as herbal tea or juice.', 'Bovitiya.jpg'),
(12, 'Bim Thamburu', 'Plumbago zeylanica', 'Improves digestion, treats skin diseases, and is used externally for joint pain relief.', 'binThambaru.jpg'),
(13, 'Binkohomba', 'Melia azedarach', 'Acts as an antiseptic and antifungal; helps with skin diseases and hair care.', 'BinKohomba.jpg'),
(14, 'Coriander (Kottamalli)', 'Coriandrum sativum', 'Used to treat fever, indigestion, and bloating. Widely consumed as a decoction (Kottamalli) for colds and flu.', 'koththamalli.jpg'),
(15, 'Curry Leaves (Karapincha)', 'Murraya koenigii', 'Supports digestion, lowers cholesterol, and improves h', 'karapincha.jpg'),
(16, 'Ceylon Cinnamon (Davul Kurundu)', 'Cinnamomum verum', 'Regulates blood sugar, reduces inflammation, and supports heart health. Native to Sri Lanka and widely used in cooking and medicine.', 'dawal-kurundu.jpg'),
(18, 'Centella (Gotukola)', 'Centella asiatica', 'Improves memory and brain function, heals wounds, and promotes longevity. Eaten as a sambol or juice.', 'Gotukola.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('Pending','Confirmed','Out for Delivery','Delivered') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`, `status`) VALUES
(78, 47, '2025-09-24 01:50:04', 200.00, 'Delivered'),
(81, 47, '2025-09-24 12:57:41', 200.00, 'Confirmed'),
(84, 47, '2025-09-25 08:59:18', 450.00, 'Pending'),
(87, 52, '2025-09-25 12:16:51', 320.00, 'Delivered'),
(88, 47, '2025-09-25 12:24:35', 1850.00, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`order_item_id`, `order_id`, `product_id`, `quantity`, `unit_price`, `subtotal`) VALUES
(143, 87, 19, 1, 320.00, 320.00),
(144, 88, 1, 1, 1850.00, 1850.00);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `original_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `price`, `quantity`, `image`, `description`, `original_price`) VALUES
(1, 'Neem Oil', 1, 1850.00, 118, '../uploads/products/1753084677_NeemOil.png', 'Neem Oil (Neem Thaila) is a powerful Ayurvedic oil known for its antibacterial, antifungal, and anti-inflammatory properties. It is commonly used to treat various skin conditions and support healthy skin and scalp.\r\n\r\nBenefits:\r\n● Effective for acne, eczema, and fungal infections\r\n● Promotes clear and healthy skin\r\n● Soothes scalp irritation and dandruff\r\n● Natural insect repellent and skin purifier', NULL),
(2, 'Pinda Oil', 1, 1900.00, 95, '../uploads/products/1753083984_PindaOil.png', 'Pinda oil (Pinda thaila) is a blend of Ayurvedic oils that soothe skin diseases such as eczema and psoriasis. It also relieves symptoms of arthritis such as stiffness, burning sensations, and joint pain.\r\n\r\nBenefits :\r\n\r\n● Suitable for eczema and psoriasis\r\n● Arthritis pain reliever', NULL),
(12, 'Mahanarayana Oil ', 1, 1600.00, 97, '../uploads/products/1753085109_MahanarayanaOil.jpg', 'Mahanarayana Oil is a classical Ayurvedic massage oil used to relieve joint and muscle pain. It strengthens bones and nerves, making it ideal for arthritis and physical weakness.\r\n\r\nBenefits:\r\n● Relieves joint and muscle stiffness\r\n● Strengthens nerves and bones\r\n● Useful in arthritis and paralysis management', NULL),
(15, 'Senna Tea', 2, 450.00, 150, '../uploads/products/Senna-Tea-570x570.jpg', 'Made from Ranawara flowers (Cassia auriculata) and green tea, this herbal blend is known for its natural cleansing and cooling properties.\r\n\r\nBenefits:\r\n●	Purifies the blood and enhances body complexion\r\n●	Provides a cooling effect and relieves urinary problems\r\n●	Aids in stomach cleansing and digestion\r\n●	Restores natural skin glow and freshness\r\n', NULL),
(16, 'Nil Katarolu Flowers Drink', 2, 450.00, 137, '../uploads/products/Nilkatarolu-570x570.jpg', ' Made from Nil Katarolu flowers (Clitoria ternatea), this vibrant herbal drink is packed with natural antioxidants and calming properties.\r\n\r\nBenefits:\r\n●	Fights free radicals and supports healthy aging\r\n●	Enhances memory, focus, and relaxation\r\n●	Promotes radiant skin and aids digestion\r\n●	Helps maintain weight balance and uplifts mood\r\n', NULL),
(17, 'Natural Gotukola Tea', 2, 400.00, 96, '../uploads/products/Gotukola.jpg', ' Made from Gotukola (Centella asiatica), this traditional Ayurvedic herbal tea is crafted to preserve its natural flavor and healing properties.\r\n\r\nBenefits:\r\n●	Enhances memory, focus, and mental alertness\r\n●	Reduces stress, fatigue, and promotes restful sleep\r\n●	Relieves joint swelling, varicose veins, and hemorrhoid pain', NULL),
(18, 'Kekulu Toothpaste', 11, 200.00, 243, '../uploads/products/kekulu-toothpaste.png', 'Specially formulated for children, this gentle herbal toothpaste is enriched with natural ingredients like clove, munamal, and miswak. Its mild, fluoride-free formula protects delicate teeth and gums while ensuring safe daily oral care for kids.\r\n\r\nBenefits:\r\n● Gently cleanses and protects children’s teeth\r\n● Fluoride-free and safe for daily use\r\n● Strengthens gums and prevents tooth decay\r\n● Provides natural freshness', NULL),
(19, 'Kohomba Baby Soap', 11, 320.00, 296, '../uploads/products/Khomba-Baby-Soap-Milk.png', 'A gentle baby soap with kohomba (neem), coconut milk, and aloe vera. Kohomba protects delicate skin, coconut milk moisturizes, and aloe vera soothes and refreshes. This mild formula keeps your baby’s skin clean, soft, and healthy.\r\n\r\nBenefits:\r\n● Protects delicate skin\r\n● Moisturizes and prevents dryness\r\n● Soothes and refreshes\r\n● Keeps skin soft and healthy', NULL),
(20, 'Camphor Balms', 5, 270.00, 139, '../uploads/products/Camphor-Cream-570x570.png', 'Camphor Cream is a soothing herbal preparation made with natural ingredients like Cinnamon Oil, Menthol, Camphor, and Bee’s Wax. It is designed for external application to relieve pain and discomfort.\r\n\r\nBenefits:\r\n●	Provides quick relief from body aches, rheumatism, sprains, and swelling\r\n●	Helps reduce chest pain caused by phlegm and lung congestion\r\n●	Soothes neuralgia and contusions with a cooling effect\r\n●	Safe for all user groups when applied externally\r\n', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` tinyint(4) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `product_id`, `rating`, `comment`, `review_date`) VALUES
(11, 52, 19, 3, 'Good ', '2025-09-25 12:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'inactive',
  `verification_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `name`, `email`, `password`, `phone`, `address`, `status`, `verification_token`) VALUES
(47, 'Dahami Tharushika', 'dahamitharushika9@gmail.com', '$2y$10$Z8OnYFiqGAD3LQ.Ig4wsAO4xVFtUf8/2cw/Fbu4LPhAm3OPDScmAe', '0745673329', '120,Homagama', 'active', NULL),
(51, 'Bhanuka achala', 'bhanukap77@gmail.com', '$2y$10$reJ9EnN5tpFno/DNTy.x3OkE8uO4SuE8udU6zsnhvGkspYHYGYG1S', '0754563465', '120,pasara road,badulla', 'inactive', 'e3aa09a7c01e98fbe3f69074b1611756e6a2b341df30d6bfe72b5943536a8341'),
(52, 'Bhanuka achala', 'iit22057@std.uwu.ac.lk', '$2y$10$tLgCUURPYDkz7jX2C2gLBerA47eiln5YW5bPWuy3TICvs2ppdh/.W', '0754563465', '120,pasara road,badulla', 'active', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_category`
--

CREATE TABLE `user_category` (
  `userCategory_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_category`
--

INSERT INTO `user_category` (`userCategory_id`, `user_id`, `category_id`) VALUES
(2, 47, 2),
(6, 52, 2),
(7, 52, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`blog_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`),
  ADD KEY `fk_discount_product` (`product_id`);

--
-- Indexes for table `herb`
--
ALTER TABLE `herb`
  ADD PRIMARY KEY (`herb_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user_order` (`user_id`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_order_item_order` (`order_id`),
  ADD KEY `fk_order_item_product` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_category`
--
ALTER TABLE `user_category`
  ADD PRIMARY KEY (`userCategory_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `herb`
--
ALTER TABLE `herb`
  MODIFY `herb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_category`
--
ALTER TABLE `user_category`
  MODIFY `userCategory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `discount`
--
ALTER TABLE `discount`
  ADD CONSTRAINT `fk_discount_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_order` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `fk_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `user_category`
--
ALTER TABLE `user_category`
  ADD CONSTRAINT `user_category_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `user_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
