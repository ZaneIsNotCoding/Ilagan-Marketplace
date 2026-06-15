-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 28, 2024 at 07:04 AM
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
-- Database: `register`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pquantity` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `completed`
--

CREATE TABLE `completed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`id`, `user_id`, `name`, `number`, `email`, `method`, `flat`, `street`, `city`, `country`, `zipcode`, `image`, `pname`, `price`, `quantity`, `totalprice`) VALUES
(48, 37, 'mark gil', 12345, 'markgil@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 3326, '', '', 0, 0, 100),
(49, 38, 'arnie', 12345, 'arnie@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 1234, '', '', 0, 0, 100),
(50, 38, 'arnie', 12345, 'arnie@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 1234, '', '', 0, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveryship`
--

CREATE TABLE `deliveryship` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `user_id` int(22) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fname` varchar(22) NOT NULL,
  `lname` varchar(22) NOT NULL,
  `contact` varchar(22) NOT NULL,
  `email` varchar(22) NOT NULL,
  `pass` varchar(22) NOT NULL,
  `province` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `brgy` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`user_id`, `username`, `fname`, `lname`, `contact`, `email`, `pass`, `province`, `city`, `brgy`, `street`, `zipcode`, `age`, `gender`, `image`) VALUES
(37, 'mark', 'mark gil', 'gangan', '12345', 'markgil@gmail.com', '112233', 'isabela', 'delfin', 'ragansur', 'purok 2', 3326, '2024-06-22', 'Unicorn', 'butaka.jpg'),
(38, '', 'arnie', 'pogi', '12345', 'arnie@gmail.com', '12345', 'isabela', 'delfin', 'ragansur', 'purok 2', 1234, '', '', ''),
(39, '', 'stephen', 'sabate', '09690608277', 'stephensabate@gmail.co', '123456789', '', '', '', '', 0, '', '', ''),
(40, '', 'angelo', 'villamor', '12345', 'angelovillamor@gmail.c', '12345', '', '', '', '', 0, '', '', ''),
(41, '', 'angelo', 'villamor', '12345', 'angelovillamor@gmail.c', '123456789', '', '', '', '', 0, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pay`
--

CREATE TABLE `pay` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pay`
--

INSERT INTO `pay` (`id`, `user_id`, `name`, `number`, `email`, `method`, `flat`, `street`, `city`, `country`, `zipcode`, `image`, `pname`, `price`, `quantity`, `totalprice`) VALUES
(20, 38, 'arnie', 12345, 'arnie@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 1234, '', '', 0, 0, 100),
(21, 38, 'arnie', 12345, 'arnie@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 1234, '', '', 0, 0, 100),
(22, 38, 'arnie', 12345, 'arnie@gmail.com', 'cash on delivery', 'ragansur', 'purok 2', 'delfin', 'isabela', 1234, '', '', 0, 0, 840);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `quantity`, `image`) VALUES
(15, 'Corn-pops', ' Bite-sized, crunchy puffs of corn, bursting with a sweet and savory flavor. A classic snack for all ages.', 100.00, 58, 'corn_pops.jpg'),
(16, 'Corn-chips', ' Crispy, golden slices of ripe bananas, offering a sweet and crunchy tropical snack experience.', 120.00, 60, 'crunchy_cornicks.jpg'),
(17, 'Banana Chips', 'Made from ripe bananas, these delectable snacks are crafted by thinly slicing the fruit and then frying or baking them to perfection.', 100.00, 0, 'banana_chips.jpg'),
(18, 'Corn Coffee', 'With a nutty flavor and earthy aroma, it offers a unique twist on traditional coffee.', 120.00, 0, 'corn_coffee.jpg'),
(19, 'butaka dark', 'The butaka is crafted from dark, high-quality wood, often sourced locally. The wood has a deep, rich color, ranging from dark brown to almost black, giving it a sophisticated and elegant appearance.', 499.00, 49, 'butaka.jpg'),
(20, 'Light butaka', 'Made from light-colored, high-quality hardwood such as molave or narra. These woods are known for their durability and fine grain.', 499.00, 34, 'butaka_light1.jpg'),
(21, 'Hopia(ube)', 'Its blend of flaky pastry and sweet yam filling provides a unique taste experience that’s both satisfying and distinctly Filipino.', 99.00, 54, 'hopia_ube.jpg'),
(22, 'Hopia (baboy)', 'the filling reveals a mixture of finely minced pork fat, glistening with a slight sheen, and interspersed with pieces of candied wintermelon and green onions.', 99.00, 32, 'hopia_baboy.jpg'),
(23, 'Chicken Skin', 'rich, savory taste and delightful crunch, making it a favorite among locals and tourists alike.', 99.00, 53, 'chick-skin_orgflav.jpg'),
(24, 'Gasang (sauce)', 'Thick and hearty, with a somewhat chunky consistency due to the presence of minced or finely chopped ingredients.', 149.00, 23, 'gasang_sauce.jpg'),
(25, 'Tshirt (White)', ' printed highlight iconic symbols, landmarks, culture of  Ilagan Isabela.', 299.00, 64, 'tshirt2.jpg'),
(26, 'Tshirt (red)', 'Printed Highlight Iconic Symbols, Landmarks, Culture Of Ilagan Isabela.', 299.00, 32, 'tshirt1.jpg'),
(27, 'Cup(i love ilagan)', 'I Love Ilagan', 149.00, 32, 'love_cup1.jpg'),
(28, 'Cup(city of ilagan)', 'City of Ilagan', 149.00, 54, 'love_cup2.jpg'),
(29, 'Cup(Corn Capital)', 'City of Ilagan', 149.00, 23, 'corn_capital2.jpg'),
(30, 'Cup(Corn)', 'City of Ilagan', 149.00, 53, 'corn_capital1.jpg'),
(31, 'keychain(4)', ' crafted with care', 99.00, 23, 'keychain.jpg'),
(32, 'Keychain(3)', ' crafted with care', 99.00, 65, 'keychain2.jpg'),
(33, 'Keychain(2)', ' crafted with care', 99.00, 34, 'keychain3.jpg'),
(34, 'Keychain(corn)', '  crafted with care', 99.00, 19, 'keychain4.jpg'),
(35, 'Keychain(carabao)', '  crafted with care', 99.00, 20, 'keychain5.jpg'),
(36, 'Keychain(1)', '  crafted with care', 99.00, 19, 'keychain6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `receive`
--

CREATE TABLE `receive` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `flat` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `zipcode` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `totalprice` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `completed`
--
ALTER TABLE `completed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordered_user` (`user_id`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deliveryship`
--
ALTER TABLE `deliveryship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordered_user` (`user_id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordered_user` (`user_id`);

--
-- Indexes for table `pay`
--
ALTER TABLE `pay`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ordered_user` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `receive`
--
ALTER TABLE `receive`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `completed`
--
ALTER TABLE `completed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deliveryship`
--
ALTER TABLE `deliveryship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `user_id` int(22) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `pay`
--
ALTER TABLE `pay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `receive`
--
ALTER TABLE `receive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `form` (`user_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `completed`
--
ALTER TABLE `completed`
  ADD CONSTRAINT `fk_ordered_user` FOREIGN KEY (`user_id`) REFERENCES `form` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
