-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 26, 2025 at 07:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
(1, 'Suwoda Admin 1', 'bhanukap77@gmail.com', 'Bhanu@123');

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
(15, 'Curry Leaves (Karapincha)', 'Murraya koenigii', 'Supports digestion, lowers cholesterol, and improves hair health. Commonly used in cooking and herbal remedies.', 'karapincha.jpg'),
(16, 'Ceylon Cinnamon (Davul Kurundu)', 'Cinnamomum verum', 'Regulates blood sugar, reduces inflammation, and supports heart health. Native to Sri Lanka and widely used in cooking and medicine.', 'dawal-kurundu.jpg'),
(18, 'Centella (Gotukola)', 'Centella asiatica', 'Improves memory and brain function, heals wounds, and promotes longevity. Eaten as a sambol or juice.', 'Gotukola.png');

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
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `category_id`, `price`, `quantity`, `image`, `description`) VALUES
(1, 'Neem Oil', 1, 1850.00, 150, '../uploads/products/1753084677_NeemOil.png', 'Neem Oil (Neem Thaila) is a powerful Ayurvedic oil known for its antibacterial, antifungal, and anti-inflammatory properties. It is commonly used to treat various skin conditions and support healthy skin and scalp. Neem oil also helps purify the skin and soothe irritation.\r\n\r\nBenefits:\r\n\r\n● Effective for acne, eczema, and fungal infections\r\n● Promotes clear and healthy skin\r\n● Soothes scalp irritation and dandruff\r\n● Natural insect repellent and skin purifier'),
(2, 'Pinda Oil', 1, 1900.00, 100, '../uploads/products/1753083984_PindaOil.png', 'Pinda oil (Pinda thaila) is a blend of Ayurvedic oils that soothe skin diseases such as eczema and psoriasis. It also relieves symptoms of arthritis such as stiffness, burning sensations, and joint pain.\r\n\r\nBenefits :\r\n\r\n● Suitable for eczema and psoriasis\r\n● Arthritis pain reliever'),
(12, 'Mahanarayana Oil ', 1, 1900.00, 100, '../uploads/products/1753085109_MahanarayanaOil.jpg', 'Mahanarayana Oil is a classical Ayurvedic massage oil used to relieve joint and muscle pain. It strengthens bones and nerves, making it ideal for arthritis and physical weakness.\r\n\r\nBenefits:\r\n● Relieves joint and muscle stiffness\r\n● Strengthens nerves and bones\r\n● Useful in arthritis and paralysis management');

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
(25, 'Bhanuka Parakrama', 'bhanukap77@gmail.com', '$2y$10$e2wRhdccB6IQ0whCOAKrE.shYWnr9SSYIAGzYDo49dOM5jG7RSAqm', '834579898', 'Badulla', 'active', NULL),
(26, 'Dahami Tharushika', 'dahamitharushika9@gmail.com', '$2y$10$8YGT6wCJ9uirgmQaahBV.ew/Ss4rk5z7fnrUhmfbuk49rw5VCF4My', '53785797', 'Homagama', 'inactive', 'ce28cef1dc11e79e6f746e65850304420cb1ae1eb349743984925838a98f6cbf');

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
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `herb`
--
ALTER TABLE `herb`
  ADD PRIMARY KEY (`herb_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

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
  MODIFY `blog_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `herb`
--
ALTER TABLE `herb`
  MODIFY `herb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
