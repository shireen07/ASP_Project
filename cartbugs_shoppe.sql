-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2018 at 09:50 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cartbugs_shoppe`
--
CREATE DATABASE IF NOT EXISTS `cartbugs_shoppe` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `cartbugs_shoppe`;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`) VALUES
(1, 'Levis'),
(3, 'Body Shop'),
(4, 'Loft'),
(6, 'Good American'),
(7, 'Macys'),
(37, 'Forever 21');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `shipped` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `items`, `expire_date`, `paid`, `shipped`) VALUES
(16, '[{"id":"26","size":"12","quantity":"2"}]', '2018-05-17 23:14:59', 1, 1),
(17, '[{"id":"27","size":"1","quantity":3}]', '2018-05-17 23:30:44', 1, 1),
(31, '[{"id":"39","size":"8","quantity":"1"},{"id":"42","size":"NA","quantity":"1"},{"id":"34","size":"8","quantity":"1"},{"id":"35","size":"8","quantity":"1"}]', '2018-05-20 21:22:31', 1, 1),
(32, '[{"id":"51","size":"NA","quantity":"1"},{"id":"42","size":"NA","quantity":"1"},{"id":"29","size":"10","quantity":"2"}]', '2018-05-20 23:21:03', 1, 1),
(33, '[{"id":"41","size":"10","quantity":"1"}]', '2018-05-20 23:22:17', 1, 1),
(34, '[{"id":"31","size":"14","quantity":"1"}]', '2018-05-20 23:23:29', 1, 1),
(35, '[{"id":"43","size":"NA","quantity":"1"}]', '2018-05-20 23:38:49', 1, 1),
(36, '[{"id":"54","size":"1Oz","quantity":"1"}]', '2018-05-20 23:39:50', 1, 1),
(37, '[{"id":"36","size":"8","quantity":"1"}]', '2018-05-20 23:44:24', 1, 1),
(38, '[{"id":"45","size":"NA","quantity":2},{"id":"48","size":"3OZ","quantity":1},{"id":"41","size":"12","quantity":1}]', '2018-05-21 06:21:07', 1, 0),
(39, '[{"id":"35","size":"10","quantity":"1"}]', '2018-05-22 06:30:04', 0, 0),
(40, '[{"id":"62","size":"NA","quantity":1}]', '2018-05-23 06:13:32', 1, 1),
(41, '[{"id":"74","size":"10","quantity":"1"}]', '2018-05-23 16:46:25', 1, 1),
(42, '[{"id":"69","size":"10","quantity":"1"}]', '2018-05-23 17:00:45', 1, 1),
(43, '[{"id":"30","size":"8","quantity":"1"}]', '2018-05-23 17:07:54', 1, 0),
(44, '[{"id":"29","size":"8","quantity":"1"}]', '2018-05-24 22:34:28', 0, 0),
(45, '[{"id":"48","size":"3OZ","quantity":1}]', '2018-05-30 19:49:07', 1, 0),
(47, '[{"id":"65","size":"NA","quantity":1}]', '2018-06-01 16:54:15', 1, 0),
(48, '[{"id":"33","size":"10","quantity":4}]', '2018-06-01 18:56:49', 1, 1),
(52, '[{"id":"78","size":"12","quantity":"3"}]', '2018-06-02 21:11:48', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `parent`) VALUES
(1, 'Women&#039;s Apparel', 0),
(3, 'Skincare', 0),
(4, 'Fragrances', 0),
(5, 'Gifts', 0),
(6, 'Dresses', 1),
(7, 'Tops', 1),
(8, 'Jeans', 1),
(10, 'Jackets', 1),
(14, 'Cleansers', 3),
(15, 'Lotions', 3),
(19, 'EauDeParfum', 4),
(20, 'Candles', 4),
(21, 'BodyCareGifts', 5),
(22, 'FragranceGifts', 5);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `list_price` decimal(10,2) NOT NULL,
  `brand` int(11) NOT NULL,
  `categories` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `featured` tinyint(4) NOT NULL DEFAULT '0',
  `sizes` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `list_price`, `brand`, `categories`, `image`, `description`, `featured`, `sizes`, `deleted`) VALUES
(24, 'Ribbed Knit Wrap Dress', '32.00', '35.21', 37, '6', '/ASP_Project/images/products/00a9e8d0bd363323c7607d96d4f8842e.jpg', 'A ribbed knit wrap dress featuring a surplice neckline with a self-tie waist, short sleeves, and a front slit.\nContent + Care&lt:\n- 95% rayon, 5% spandex\n- Hand wash cold\n- Made in Philippines\n', 0, '6:5:2,8:5:2,10:5:2,12:5:2', 1),
(27, 'British Rose Essential Selection', '26.00', '29.00', 3, '21', '/ASP_Project/images/products/fccfd7b11f4ae5f0179e3831c72d1f23.jpg,/ASP_Project/images/products/6029cb4299aab0f1db5a6440b4dfbbbe.jpg', 'Treat someone to a bouquet of favorites plucked from our fragrant British Rose collection with this brilliant value bundle of rose-scented goodies, beautifully boxed and ready to gift.\r\n #British Rose Shower Gel 8.4 FL OZ  #British Rose Body Scrub 1.69 OZ  #British Rose Body Butter 1.69 OZ #British Rose Soap 3.5 Ounce  #Cream Bath Lily', 0, 'NA:1:2', 0),
(28, 'Semi-Sheer Floral Top', '11.99', '21.99', 6, '7', '/ASP_Project/images/products/d98ae06bdcc297e4f344c966469e81a0.jpg,/ASP_Project/images/products/e344a1e186b02f172a9f2394b9376373.jpg', 'A semi-sheer woven top featuring an allover colorful floral pattern, a round neck, butterfly cap sleeves, a split back design with self-tie closure and a secure strip, and a curved dolphin hem.\r\nContent + Care\r\n- 100% polyester | Hand wash cold', 1, '6:5:2,8:5:2,10:5:2,12:5:2', 0),
(29, 'Floral High-Low Wrap Dress', '22.52', '32.52', 4, '6', '/ASP_Project/images/products/63f0847c4e399e9a0813c542e8f029ef.jpg,/ASP_Project/images/products/1ea02319680c5c7cd492aa15aacbd4c6.jpg', 'A woven wrap dress in allover floral motif featuring adjustable cami straps, an open-shoulder design, cap sleeves, surplice neckline, self-tie closure, ruffle trim throughout, and a high-low tulip hem.\r\nContent + Care\r\n- 100% rayon\r\n- Hand wash cold', 1, '6:3:2,8:2:2,10:3:2,12:4:2', 0),
(30, 'Lace Embroidered Midi Dress', '21.55', '29.66', 7, '6', '/ASP_Project/images/products/f54624be1a787e7142648b8edc666660.jpg,/ASP_Project/images/products/b8926e2b217fce4039caba059e68d40e.jpg', 'A woven midi dress featuring a strapless neckline, smocked bodice, an elasticized waist, embroidered scalloped hem, and a flowy silhouette.\r\nContent + Care\r\n- Shell: 100% rayon | Other: 100% cotton\r\n- Hand wash cold', 1, '6:5:2,8:4:2,10:5:2,12:5:2,14:5:2', 0),
(31, 'Stirrup Button-Fly Jeans', '44.23', '50.66', 7, '8', '/ASP_Project/images/products/7db86ec99f4b424a0d323e26829ac0e0.jpg,/ASP_Project/images/products/aa1886d2878a8b203a744b9ca95ed3e8.jpg', 'A pair of skinny jeans featuring an exposed button fly, five-pocket construction, high-rise, and an elasticized stirrup design.\r\nContent + Care\r\n- 82% cotton, 16% polyester, 2% spandex\r\n- Machine wash cold\r\n- Made in Egypt', 1, '8:3:2,10:3:2,12:3:2,14:3:2,16:3:2', 0),
(32, 'Crepe High-Waist Trousers', '25.00', '30.00', 4, '8', '/ASP_Project/images/products/409b4f3907ec561820e4edb419d22fde.jpg,/ASP_Project/images/products/ba106cea9c295dc28a5d13d28c10325b.jpg', 'A pair of crepe woven trousers featuring a removable self-tie belt, high-waist, a zip fly, press folds, front slant pockets, and a straight-leg cut.\r\nContent + Care\r\n- 100% polyester\r\n- Dry clean\r\n- Made in Vietnam', 1, '8:4:2,10:4:2,12:4:2,14:4:2', 0),
(33, 'High-Rise Wide Leg Jeans', '55.00', '62.00', 6, '8', '/ASP_Project/images/products/95f73a69e000f3095ea85c53e00c7db5.jpg,/ASP_Project/images/products/f38a29827b7e0c187a67396188826050.jpg', 'A pair of high-rise mom jeans featuring a distressed knee slit, a button-up fly, five-pocket construction, and a classic stone wash.\r\nContent + Care\r\n- 100% cotton\r\n- Machine wash cold\r\n- Made in Egypt', 1, '10:0:2,12:2:2,14:4:2', 0),
(34, 'High-Rise Knee-Slit Jeans', '29.00', '35.00', 37, '8', '/ASP_Project/images/products/1b81a3bc054d71c570c4e807c0a48083.jpg', 'A pair of high-rise mom jeans featuring a distressed knee slit, a button-up fly, five-pocket construction, and a classic stone wash.\r\nContent + Care\r\n- 100% cotton\r\n- Machine wash cold\r\n- Made in Egypt', 1, '8:4:2,10:3:2,12:4:2,14:2:2', 0),
(35, 'Textured Marled Wrap Dress', '15.00', '22.00', 1, '6', '/ASP_Project/images/products/3a93a3e73914ee76eddffa1ea69ae393.jpg,/ASP_Project/images/products/8ccea1a15ecb2aa6cb9796fbb4250a2e.jpg,/ASP_Project/images/products/1df5fcbb2499f310645c01789c190c8d.jpg', 'A textured marled woven linen and cotton mini dress featuring a banded round neckline, short ruffle sleeves, princess seams, wrap-front skirt with self-tie closure at the side, back keyhole with button-loop closure, and a ruffled tulip hem.\r\nContent + Care\r\n- 73% cotton, 27% linen\r\n- Dry clean', 1, '8:3:2,10:3:2,12:3:2,14:3:2', 0),
(36, 'Foliage Print Shirt Dress', '25.00', '32.00', 1, '6', '/ASP_Project/images/products/97ed39cb12016a229540a2885b4376f6.jpg,/ASP_Project/images/products/a869a34626625a6cb0cfe2548a228c65.jpg,/ASP_Project/images/products/c4ce65f2fdb587efd5a70c44ab8288f2.jpg', 'A woven shirt dress featuring an allover foliage print, button front, basic collar, long buttoned sleeves, waist self-tie, and a flounce hem.\r\nContent + Care\r\n- 100% rayon\r\n- Dry clean', 1, '8:3:2,10:3:2,12:3:2,14:3:2', 0),
(37, 'Love Graphic Tee', '15.00', '11.25', 4, '7', '/ASP_Project/images/products/bf904a131b2d94407582fc6e22631d66.jpg,/ASP_Project/images/products/6143130263af47e72915b9ea67995bc6.jpg', 'A knit tee featuring a round neckline, short sleeves, and repeating front &quot;Love&quot; graphics with velvet heart details.\r\nContent + Care\r\n- 100% cotton\r\n- Machine wash warm\r\n- Made in Bangladesh', 1, '8:3:2,10:3:2,12:3:2,14:3:2', 0),
(38, 'Billowy Tie-Hem Keyhole Top', '15.00', '22.00', 7, '7', '/ASP_Project/images/products/12d14d7bbc0d88b97528a997535703c4.jpg', 'A textured woven top featuring a V-neckline, center seam constructions leading to a keyhole cutout with tie-hem closure, and a billowy silhouette.\r\nContent + Care\r\n- 100% rayon | Hand wash cold', 1, '8:4:2,10:4:2,12:4:2,14:0:2', 0),
(39, 'I&#039;m Having A Good Day Muscle Tee', '15.00', '22.00', 37, '7', '/ASP_Project/images/products/1a5918d32723c4cab4ff1fef085a2182.jpg,/ASP_Project/images/products/6e396f35514ab01ffeb08ca08150eca4.jpg', 'A marled muscle ringer-style tee featuring a contrast round neckline, contrast shoulders, dropped arm holes, and a front &quot;I&#039;m Having A Good Day (&hellip;Don&#039;t Ruin It)&quot; text.\r\nContent + Care\r\n- 65% polyester, 35% rayon | Machine wash cold', 1, '8:4:2,10:4:2,12:4:2', 0),
(40, 'Glen Plaid Double-Breasted Blazer', '55.00', '87.00', 4, '10', '/ASP_Project/images/products/a5b4d2b1bb1ca6a8b973af3e5b9c14a7.jpg,/ASP_Project/images/products/a4dbb19a1ab0ac8fabcdb6a2fba858fd.jpg', 'A woven blazer featuring an allover glen plaid pattern, notched lapels, long buttoned sleeves, double-breasted design, front flap pockets, padded shoulders, and single chest pocket.\r\nContent + Care\r\n- Shell: 99% polyester, 1% spandex Lining: 100% polyester\r\n- Dry clean', 1, '6:3:2,8:3:2,10:5:2,12:5:2', 0),
(41, ' Open-Front Crepe Blazer', '43.00', '55.00', 7, '10', '/ASP_Project/images/products/e54177d8770419a27e6cf13fbd472fcf.jpg,/ASP_Project/images/products/4dfddd31cf6f75eaeedb2f74df6f66b0.jpg', 'A crepe woven blazer featuring an open-front with single button closure, notched lapels, long buttoned sleeves, and front mock welt pockets.\r\nContent + Care\r\n- Shell: 100% viscose | Lining: 100% polyester\r\n- Machine wash cold', 1, '8:3:2,10:3:2,12:3:2,14:4:2', 0),
(42, 'Drops Of Youth&trade; Youth Essence Lotion', '25.00', '30.00', 3, '14', '/ASP_Project/images/products/34f8e6d98b48eb6adc5043a88a05e66a.jpg,/ASP_Project/images/products/99ae8b966271bef4a4cf00709bc0d228.jpg', 'Smooths, plumps, and leaves skin more luminous. Fresh gel-to-water formula leaves skin feeling replenished with moisture.Pores are minimized and look refined. Enriched with Edelweiss from the Italian alps, Criste Marine and Sea Holly from France', 1, 'NA:4:2', 0),
(43, 'Seaweed Oil Balancing Cleanser', '15.00', '22.00', 3, '14', '/ASP_Project/images/products/33e8a92d870b1eb8c9dd03c7bd6f20c5.jpg,/ASP_Project/images/products/dca5fdf5b4fef96f405b9ea300e1ad9b.jpg', 'Suitable for combination/oily skin. Mineral rich seaweed from Roaring Water Bay, Ireland. Alcohol-free. Algae and cucumber extract. Clarifying and purifying.', 1, 'NA:3:2', 0),
(44, 'Fuji Green Tea&trade; Body Butter', '12.00', '15.00', 4, '15', '/ASP_Project/images/products/86521e8e0b50bd15ea62179f17db8074.jpg,/ASP_Project/images/products/8b6449ec4eb94e6047795bf5a4b77c40.jpg', 'Smooth on replenishing hydration with our crisp and refreshingly scented Fuji Green Tea&trade; Body Butter.', 1, 'NA:3:2', 0),
(45, 'British Rose Body Butter', '12.00', '15.00', 3, '15', '/ASP_Project/images/products/c4c0980c05c87c918d856d63fb5edece.jpg,/ASP_Project/images/products/071fab8479a26e4fd85538d9d0ab4599.jpg', 'Indulge in dewy hydration with our first Body Butter with glow enhancing rose essence. Beautifully pearlescent, this velvety-soft moisturizer is light to the touch but rich on moisture. Non-sticky and perfect for normal to dry skin.', 1, 'NA:2:2', 0),
(46, 'White Musk&reg;', '32.00', '44.00', 37, '19', '/ASP_Project/images/products/4027cafb1864d69fca6851dd50bb3c98.jpg,/ASP_Project/images/products/7e7b35f3e907d41266a02070f643128b.jpg', 'a scented symphony of pure, cruelty-free musk. The perfect light, sensual, floral fragrance. ', 1, '1.7Oz:2:2', 0),
(47, 'Kistna', '42.00', '66.00', 1, '19', '/ASP_Project/images/products/34dbdb20874c589468d0998b193f9a9a.jpg,/ASP_Project/images/products/4fd5bf0029876019fb07c01846a63816.jpg', 'Fresh and light, he&#039;ll love spritzing on this contemporary scent with notes of basil and birch leaf.', 1, '1Oz:5:2,3OZ:5:2', 0),
(48, 'Black Musk', '42.00', '55.00', 3, '19', '/ASP_Project/images/products/63795fef8b00f071cfa69daaac81fe58.jpg,/ASP_Project/images/products/51013393b8458e60f753014de98440b2.jpg', 'Our deepest, darkest, most sensual musk. The sweet notes of bambinella pear, pink pepper and bergamot are contrasted with the fierce black musk.', 1, '1Oz:4:2,3OZ:3:2', 0),
(49, 'Hawaiian Kukui Candle', '12.00', '15.00', 3, '20', '/ASP_Project/images/products/944ae9fdfdcb9a6499a1c7471b5b4440.jpg,/ASP_Project/images/products/9dd3f8de7fa3f0c8328aac295fdb481b.jpg', 'Our blissful Spa of the World&trade; Hawaiian Kukui Candle is a wax, paraffin-free candle with a fruity and floral scent. Found on the golden beaches of Hawaii, the kukui nut absorbs the radiance of the sun&#039;s rays. ', 1, 'NA:5:2', 0),
(50, 'Vanilla Chai Candle', '12.00', '15.00', 7, '20', '/ASP_Project/images/products/592c18d12f55f49422d6e872d1573886.jpg,/ASP_Project/images/products/54f337f129e35cf0223bde46d93c396e.jpg', 'Fill your home with a warm wintertime fragrance of our Vanilla Chai candle. Sweet, spicy and festive, this special edition candle features a warm vanilla and cardamom spices scent .', 1, 'NA:2:2', 0),
(51, 'Japanese Camellia Candle', '12.00', '15.00', 3, '20', '/ASP_Project/images/products/725521c432d9ba272fdacf61d6ed06fe.jpg,/ASP_Project/images/products/d7c64b3b65b7cb55fe272a33fa359034.jpg', 'A wax, paraffin-free candle with a delicate, musky floral scent. Since the 8th century, Japanese women have used camellia flower for its relaxing and delicate fragrance. This flower&#039;s exquisite and pure scent allows mind and body to reconnect with a moment of profound peace. ', 1, 'NA:4:2', 0),
(52, 'Fuji Green Tea&trade; Essential Selection', '42.00', '55.00', 3, '21', '/ASP_Project/images/products/e9be000fa483ce5f989f276ff84fbc57.jpg,/ASP_Project/images/products/7a494e95d8dcbd915463278ee05c3d6c.jpg', 'Shower Gel Fuji Green Tea&trade; 8.4 FL OZ , Body Scrub Fuji Green Tea&trade; 1.69 FL OZ, Body Butter Fuji Green Tea&trade; 1.69 FL OZ, Soap Fuji Green Tea&trade; 3.5 Ounce, Bath Lily Green', 1, 'NA:4:2', 0),
(53, 'Wild Argan Oil Essential Selection', '32.00', '39.00', 6, '21', '/ASP_Project/images/products/768cb6e7c9346179446ee893497fbd03.jpg,/ASP_Project/images/products/4e54615a986db02d35e5a02caa40c4f4.jpg', 'Argan Shower Gel 8.4 FL OZ, Argan Body Scrub 1.69 FL OZ, Argan Body Butter 1.69 FL OZ, Argan Soap 3.5 Ounce, Cream Bath Lily', 1, 'NA:4:2', 0),
(54, 'Fijian Water Lotus Eau De Toilette', '30.00', '40.00', 1, '22', '/ASP_Project/images/products/edd97b531d05e214892bc3656f4d3547.jpg,/ASP_Project/images/products/02317073eaa59ab72b99b08bd1557f7c.jpg', 'The Fijan Water Lotus Eau de Toilette is a sparkling, floral-marine eau de toilette that delicately scents your skin with luscious notes of sparkling mandarin, subtly aquatic water lotus, and a transparent touch of marine freshness.', 1, '1Oz:4:2,3Oz:4:2', 0),
(55, 'English Dawn RoseFragrance Mist', '32.00', '44.00', 6, '22', '/ASP_Project/images/products/05502f760b04cb0b4a2b3726fa4ae4f7.jpg,/ASP_Project/images/products/ff3ace5d728e67febcfd75e6b22d56b8.jpg', 'This delicate, fresh, floral fragrance mist subtly scents your entire body with a sumptuous blend of enticing tuberose and hundreds of English white gardenias blooming in the first light of dawn. Layer with other English Dawn Gardenia products to build the fragrance.', 1, 'NA:4:2', 0),
(57, 'Mango Body Mist', '25.00', '29.00', 3, '22', '/ASP_Project/images/products/3758e2b6ee4a95175694d6de287b84f0.jpg,/ASP_Project/images/products/4d86dc7dccb5ab98a2027c97a2b28d9e.jpg', 'Generously splash or lightly spritz Mango Body mist for a fresh tropical fragreance. nfused with Community Trade sugar and the scent of fresh mango.', 1, 'NA:4:2', 0),
(58, 'Pink Grapefruit Body Mist', '20.00', '25.00', 37, '22', '/ASP_Project/images/products/5e676b485237bcbfe83a4f9ed573bf9b.jpg,/ASP_Project/images/products/f494c59ae28215edba587ebdce75f8bd.jpg', 'Generously splash or lightly spritz Pink Grapefruit Body Mist for long lasting zestiness. Infused with cold-pressed pink grapefruit seed oil and sugarcane essence.', 1, 'NA:4:2', 0),
(59, 'Coconut Body Mist', '15.00', '24.00', 3, '22', '/ASP_Project/images/products/1e31b8518a41e6f13c562b6d4761445e.jpg,/ASP_Project/images/products/45289515d59692a75f17884589d20e8a.jpg', 'Escape to a tropical island as you spritz on the Coconut Body mist, a light, freshly scented body mist. Infused with sugar and fresh coconut, this body mist is irresistible.', 1, 'NA:4:2', 0),
(60, 'Satsuma Essential Selection', '34.00', '44.00', 4, '21', '/ASP_Project/images/products/9703744e5082a52d7ec445eb46af58f9.jpg,/ASP_Project/images/products/2628447e6f787a2a2535db70608941f3.jpg', 'Treat someone to the juicy and summery scent of Satsuma with this brilliant value bundle of goodies, beautifully boxed and ready to gift.', 1, 'NA:4:2', 0),
(61, 'Pink Grapefruit Essential Selection', '35.00', '47.00', 37, '21', '/ASP_Project/images/products/e2277689124dfae05ca05cb80563cda7.jpg,/ASP_Project/images/products/c6589733802c1108f2b77171f0480190.jpg', 'Treat someone to a zesty burst of sweetness with this brilliant value bundle of Pink Grapefruit goodies, beautifully boxed and ready to gift.', 1, 'NA:4:2', 0),
(62, 'Mediterranean Sea Salt Candle', '14.00', '16.00', 7, '20', '/ASP_Project/images/products/bb15fb0acf0f94c0f4bcda17ef1bdd0d.jpg,/ASP_Project/images/products/7f555dc5bc659bf4ebd68ac48d72b684.jpg', 'Inspired by an invigorating dive in the Dead Sea waters, this fresh-scented candle captures the pure and crisp scent of the sea. The salt flower and marine notes combine to awaken the mind. ', 1, 'NA:3:', 0),
(63, 'Aloe &amp; Soft Linen Candle', '24.00', '25.00', 3, '20', '/ASP_Project/images/products/a4a45159853abc4c58e7bc6957097ce3.jpg,/ASP_Project/images/products/bdd9724f17d2b4d65bf350ea19fa4b8a.jpg', 'This rich, creamy, aloe and soft linen scented candle is a luxurious fragrance for any occasion. This soothing candle is an essential addition to your home.', 1, 'NA:4:2', 0),
(64, 'Indian Night Jasmine Body Cream', '13.00', '16.00', 1, '15', '/ASP_Project/images/products/a920230617c675dd6f09c695ebd78c41.jpg,/ASP_Project/images/products/b4f6af719a3a4d192a29a831fe99f8f4.jpg', 'This rich moisturizer leaves your skin feeling silky-soft and scented with notes of fragrant violet leaf and warm jasmine, deepened by rich sandalwood', 1, 'NA:2:2', 0),
(65, 'Limited Edition Pi&ntilde;ita Colada Body Butter', '16.00', '17.00', 7, '15', '/ASP_Project/images/products/aa0118b748e6eac8e95eaedd03a05c57.jpg,/ASP_Project/images/products/80a1cd75cbbd5b19e01e949875bdf240.jpg', 'Smooth on sunshine with our Special Edition Pi&ntilde;ita Colada Body Butter. Infused with a deliciously tropical summer scent, this rich yet lightweight cream intensely hydrates skin for 24H making it the perfect post-beach body treat. ', 1, 'NA:4:2', 0),
(66, 'Coconut Body Butter', '20.00', '25.00', 1, '15', '/ASP_Project/images/products/c91cd1f7c1b0e769ebebac8928564d0d.jpg,/ASP_Project/images/products/2cbe23188ce6325e28d545f4fe0e498a.jpg', 'Give your skin a dose of ultra-rich hydration when you apply this nourishing coconut body butter. With 48hr moisturizing properties, your skin will stay softer for longer.', 1, 'NA:3:2', 0),
(67, 'Roots of Strength&trade; Firming Shaping Essence', '16.00', '22.00', 7, '14', '/ASP_Project/images/products/f9e36f87fbb4150ea1b9ae995977c022.jpg,/ASP_Project/images/products/b4982e5a0e14541790b5547d79b55e78.jpg', 'Infused with root extracts, this refreshing and lightweight daily essence lotion combines the lightweight freshness of water with the comfort of a moisturizing gel. Your skin is instantly replenished with moisture and comfort. ', 1, 'NA:5:2', 0),
(68, 'Oils Of Life&trade; Revitalizing Essence', '22.00', '28.00', 6, '14', '/ASP_Project/images/products/d339372a49e46098654300306d9a59c0.jpg,/ASP_Project/images/products/acb7d7012f08aa1063169325e311975d.jpg', 'By infusing 3 precious seed oils from around the world, known for their revitalizing and repairing properties on skin &ndash; Black Cumin seed oil from Egypt, Camellia seed oil from China and Rosehip seed oil from Chile &ndash; in to a unique bi-phase [oil + water] formula', 1, 'NA:6:2', 0),
(69, 'Zip-Front Bomber Jacket', '34.00', '36.00', 6, '10', '/ASP_Project/images/products/07561ca6952cfb5ef469eb44e2f39ea7.jpg,/ASP_Project/images/products/63694d4e259da72c403331c6f254d25c.jpg', 'A lightweight woven bomber jacket featuring ribbed trim, a zip-up front, long sleeves with a zip-up utility pocket, and front slant pockets.\r\nContent + Care\r\n- 100% polyester\r\n- Hand wash cold', 1, '8:3:,10:2:,12:3:,14:3:', 0),
(70, '  Lemon Graphic Coach Jacket', '35.00', '44.00', 37, '10', '/ASP_Project/images/products/f6c84de298273b683d116cb586e09ced.jpg', 'A woven coach jacket featuring an allover lemon graphic print, front snap-button closures, a basic collar, long sleeves, front slip pockets, and elasticized trim.\r\nContent + Care\r\n- Shell: 65% polyester, 35% cotton\r\n- Lining: 100% polyester\r\n- Hand wash cold', 1, '8:3:2,10:3:2,12:3:2', 0),
(71, 'Contrast Piping Floral Kimono', '29.00', '35.00', 4, '10', '/ASP_Project/images/products/4342e336ac528e49b533d9f13058e53c.jpg,/ASP_Project/images/products/fce2f0e41140926bc5e2eb3262bf642f.jpg', ' A woven kimono featuring an allover floral print, contrast piping, and open front, long kimono sleeves, and dropped shoulders.\r\nContent + Care\r\n- 100% viscose\r\n- Hand wash cold', 1, '8:3:2,10:3:2,12:4:2,14:0:2', 0),
(72, 'Distressed Denim Overalls', '50.00', '60.00', 6, '8', '/ASP_Project/images/products/0e9ee834972ce2d202de6cc65560f4d1.jpg,/ASP_Project/images/products/32ace6c944e8184989afd2b9ab2585b1.jpg,/ASP_Project/images/products/402b48dbec2ba10d0c34b64641cff780.jpg', 'A pair of stretch-denim overalls featuring an allover distressed design, adjustable buckle straps, a bib patch pocket, buttoned sides, a five-pocket construction, and cuffed hem.\r\nContent + Care\r\n- 68% cotton, 23% polyester, 7% rayon, 2% spandex\r\n- Machine wash cold', 1, '8:4:2,10:3:2,12:4:2', 0),
(73, 'Distressed Frayed Denim Shorts', '19.00', '25.00', 4, '8', '/ASP_Project/images/products/2275733ad16f83a09b40a7c726c2a0b3.jpg,/ASP_Project/images/products/44e6b646b12ff94e551d5660e5e404c0.jpg,/ASP_Project/images/products/196482f17957a78f07dca08ec5615a0c.jpg', 'A pair of denim shorts featuring a high-rise FIT, zippered fly, slight distressing, five-pocket construction, and a frayed hem.\r\nContent + Care\r\n- 70% cotton, 28% polyester, 1% spandex, 1% other fibers\r\n- Machine wash cold', 1, '8:4:2,10:3:2,12:3:2,14:3:2', 0),
(74, 'Red Floral Slit Dress', '23.00', '33.00', 37, '6', '/ASP_Project/images/products/b26194eaed5989ab3fceae27676b0293.jpg,/ASP_Project/images/products/d27c64caf98922a484d8cb155d563178.jpg,/ASP_Project/images/products/5ae8d2d2ab8738b5e90cec1ceab278dc.jpg', 'A woven chiffon dress featuring a floral motif, ruffle-trimmed surplice neckline with mock wrap construction, sheer long peasant sleeves, shirred armholes, removable self-tie sash at the waist, ruffle-trimmed high-low tulip hem, and a concealed side zip closure.', 1, '8:3:,10:2:,12:3:,14:3:', 0),
(75, 'BlackBlue Sheer Shift Dress', '35.00', '42.00', 6, '6', '/ASP_Project/images/products/f386af9505961dbcd5e852def3cc6a1a.jpg,/ASP_Project/images/products/d8085e0a5e4bf4825af5aacbc61b19b0.jpg,/ASP_Project/images/products/ece9b9449fbada034378752f5e1102c2.jpg', 'A sheer woven dress featuring a floral motif, mock neck, cutout back with dual loop-button closure, butterfly sleeves, removable self-tie sash at the waist, shift silhouette, and an attached cami dress underlayer.\r\nContent + Care\r\n- 100% polyester\r\n- Machine wash cold', 1, '8:3:2,10:3:2,12:3:2,14:3:2', 0),
(76, 'Black Body Knit Dress', '23.00', '34.00', 1, '6', '/ASP_Project/images/products/df512f7a6cfe0330c4e5a5608da695a2.jpg,/ASP_Project/images/products/19ffef2635a76b1f38f2daded1f60a96.jpg', 'A ribbed stretch-knit mini dress featuring an elasticized neckline, and a bodycon silhouette.\r\nContent + Care\r\n- 95% cotton, 5% spandex\r\n- Hand wash cold', 1, '8:3:2,10:3:2,12:3:2', 0),
(77, 'Pink Floyd Graphic Tee', '9.00', '15.00', 4, '7', '/ASP_Project/images/products/020191b1fdfb06eaa6e2beb7812f5c26.jpg,/ASP_Project/images/products/2d2cb327e2114c17c23720f8b993b5eb.jpg,/ASP_Project/images/products/9b1c7a657348dd0717f5718cdc09dacb.jpg,/ASP_Project/images/products/0a6a05cf112b62873861eba5a4519969.jpg', 'A cropped tee featuring a front &quot;Pink Floyd 1973 U.S. Tour&quot; and &quot;The Dark Side of The Moon&quot; graphic, a ribbed crew neck, short sleeves, and a boxy silhouette.\r\nContent + Care\r\n- 60% cotton, 40% polyester\r\n- Hand wash cold', 1, '6:2:2,8:4:2,10:3:2,12:3:2', 0),
(78, 'Plaid Flannel Shirt', '10.00', '20.00', 6, '7', '/ASP_Project/images/products/7d5c355068ac371bf116d9e6919ab005.jpg,/ASP_Project/images/products/4ac6e68c7d253015c0ca69fa1b52ca23.jpg,/ASP_Project/images/products/053f7c66fd11a59079d3108d4edba1d5.jpg,/ASP_Project/images/products/e51099696f7ed4316900f8d5f99c4ad3.jpg', 'A woven flannel shirt featuring an allover plaid pattern, a basic collar, button front, a chest patch pocket, long sleeves with button cuffs, a curved hem, and a boxy silhouette.\r\nContent + Care\r\n- 100% cotton\r\n- Machine wash cold', 1, '8:4:2,10:3:2,12:4:2,14:3:2', 0),
(79, 'Woven V-Neck Collar Top', '16.00', '22.00', 7, '7', '/ASP_Project/images/products/2e4bc97f9e43552e09d858d6042d79d6.jpg,/ASP_Project/images/products/decd17b810e43eec591974ab2e6f503d.jpg,/ASP_Project/images/products/eb88026647544850a007200a71269323.jpg', 'A woven top featuring a basic collar, plunging surplice neckline, front pleating, long sleeves with self-tie cuffs, back style lines, and a high-low hem.\r\nContent + Care\r\n- 100% rayon\r\n- Hand wash cold', 1, '8:3:2,10:4:2,12:3:2', 0),
(81, 'test', '0.00', '0.00', 37, '14', '/ASP_Project/images/products/217911636df9e2ba673cf4bfe7049721.jpeg,/ASP_Project/images/products/55fa1fb058edcc6f1676b7f37328dfcc.jpeg', 'asdsdasdasdasd', 0, '2:2:2,2:2:2,2:2:2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `charge_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cart_id` int(11) NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(175) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_total` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `txn_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `txn_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `charge_id`, `cart_id`, `full_name`, `email`, `street`, `street2`, `city`, `state`, `zip_code`, `country`, `sub_total`, `tax`, `grand_total`, `description`, `txn_type`, `txn_date`) VALUES
(1, 'ch_1CI06jJJHso11uivpjuVEwWC', 10, 'Shirin Bhagwat', 'av@v.com', '323 Franklin ave, Apt D4', '', 'Warrensburg', 'MO', '64093', 'US', '26.00', '2.26', '28.26', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:08:37'),
(2, 'ch_1CI0D1JJHso11uivvcoHu0VE', 11, 'Shirin Bhagwat', 'bhagwatshireen7@gmail.com', '2004 Woodlea Drive', '', 'Columbia', 'MO', '65201', 'US', '25.32', '2.20', '27.52', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:15:07'),
(3, 'ch_1CI0K5JJHso11uivWMc97xb4', 11, 'Ashutosh P', 'aspb3@mizzou.com', '2004 Woodlea Drive', '', 'Columbia', 'MO', '65201', 'US', '25.32', '2.20', '27.52', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:22:25'),
(4, 'ch_1CI0SEJJHso11uivulNPo1Se', 12, 'Samantha Brady', 'samyB@example.com', '2004 Woodlea Drive', '', 'Columbia', 'MO', '65201', 'US', '23.51', '2.05', '25.56', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:30:50'),
(5, 'ch_1CI0edJJHso11uivWTwJhHpy', 13, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', 'Little Whinging,', ' Surrey,', 'England', '65201', 'Great Britain', '26.00', '2.26', '28.26', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:43:39'),
(6, 'ch_1CI0jWJJHso11uivXtn3mIdk', 14, 'jamie morgan', 'jamie.m@example.com', 'A-31 Ashland Manor', '', 'Columbia', 'MO', '65201', 'US', '25.32', '2.20', '27.52', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:48:42'),
(7, 'ch_1CI0q4JJHso11uivZVs6ogsA', 15, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'Scotland', '25.32', '2.20', '27.52', '1 item from CartBugs Shoppe', 'charge', '2018-04-17 15:55:28'),
(8, 'ch_1CI1AyJJHso11uivC9RRxoLd', 16, 'Draco Malfoy', 'darco@hogwarts.com', '123 Slytherin Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'Scotland', '50.64', '4.41', '55.05', '2 items from CartBugs Shoppe', 'charge', '2018-04-17 16:17:04'),
(9, 'ch_1CI1PVJJHso11uivhmWABrAf', 17, 'Sirius Black', 'sirius.b@hogwarts.com', '123 Gryffindor Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'Scotland', '78.00', '6.79', '84.79', '3 items from CartBugs Shoppe', 'charge', '2018-04-17 16:32:05'),
(17, 'ch_1CJ4pmJJHso11uivDZ9HoQwQ', 31, 'Lalita Bhagwat', 'lxb38200@example.com', 'A-13 Parija CHS', '', 'Thane', 'Maharashtra', '400603', 'India', '84.00', '7.31', '91.31', '4 items from CartBugs Shoppe', 'charge', '2018-04-20 14:23:31'),
(18, 'ch_1CJ6gOJJHso11uiv6D6GPRHn', 32, 'Tom Patterson', 'txp@example.com', '2004 Woodlea Drive', '', 'Columbia', 'MO', '65201', 'US', '82.04', '7.14', '89.18', '4 items from CartBugs Shoppe', 'charge', '2018-04-20 16:21:57'),
(19, 'ch_1CJ6haJJHso11uiv3GMSSzMl', 33, 'Tim Patterson', 'tim@example.com', '123 Slytherin Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'UK', '43.00', '3.74', '46.74', '1 item from CartBugs Shoppe', 'charge', '2018-04-20 16:23:11'),
(20, 'ch_1CJ6iaJJHso11uivnQ22gKOC', 34, 'Julia Anderson', 'jxa@example.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'UK', '44.23', '3.85', '48.08', '1 item from CartBugs Shoppe', 'charge', '2018-04-20 16:24:14'),
(21, 'ch_1CJ6xNJJHso11uivHcCjMx3i', 35, 'James Potter', 'jxp@example.com', 'A-13 Parija CHS', '', 'Thane', 'Maharashtra', '400603', 'India', '15.00', '1.31', '16.31', '1 item from CartBugs Shoppe', 'charge', '2018-04-20 16:39:30'),
(22, 'ch_1CJ6yTJJHso11uivSd7ZEuhe', 36, 'Robert Johnson', 'rxj@example.com', '2004 Woodlea Drive', '', 'Columbia', 'MO', '65201', 'US', '30.00', '2.61', '32.61', '1 item from CartBugs Shoppe', 'charge', '2018-04-20 16:40:39'),
(23, 'ch_1CJ72cJJHso11uiv6hXPGamz', 37, 'Draco Malfoy', 'darco@hogwarts.com', '123 Slytherin Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'UK', '25.00', '2.18', '27.18', '1 item from CartBugs Shoppe', 'charge', '2018-04-20 16:44:55'),
(24, 'ch_1CJDFiJJHso11uivtLyC0reM', 38, 'Albus Dumbledore', 'albus@hogwarts.com', '123 Gryffindor Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'UK', '109.00', '9.48', '118.48', '4 items from CartBugs Shoppe', 'charge', '2018-04-20 23:22:51'),
(25, 'ch_1CJw5PJJHso11uiv9OOjSSy0', 40, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'UK', '14.00', '1.22', '15.22', '1 item from CartBugs Shoppe', 'charge', '2018-04-22 23:15:09'),
(26, 'ch_1CK5ytJJHso11uivdofceeO1', 41, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'UK', '23.00', '2.00', '25.00', '1 item from CartBugs Shoppe', 'charge', '2018-04-23 09:49:05'),
(27, 'ch_1CK6AjJJHso11uivkpAbyapt', 42, 'Draco Malfoy', 'darco@hogwarts.com', '123 Slytherin Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'UK', '34.00', '2.96', '36.96', '1 item from CartBugs Shoppe', 'charge', '2018-04-23 10:01:20'),
(28, 'ch_1CK6IAJJHso11uivS3JQ2W9x', 43, 'Shirin Bhagwat', 'sxb38200@ucmo.edu', 'A-13 Parija CHS', '', 'Thane', 'Maharashtra', '400603', 'UK', '21.55', '1.87', '23.42', '1 item from CartBugs Shoppe', 'charge', '2018-04-23 10:09:01'),
(29, 'ch_1CMg8tJJHso11uivqsptTfWZ', 45, 'Draco Malfoy', 'darco@hogwarts.com', '123 Slytherin Common Room', '', 'Hogsmeade Village', 'Hogsmeade', '65201', 'UK', '42.00', '3.65', '45.65', '1 item from CartBugs Shoppe', 'charge', '2018-04-30 12:50:00'),
(30, 'ch_1CNMPiJJHso11uivedwrmLK6', 47, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'UK', '16.00', '1.39', '17.39', '1 item from CartBugs Shoppe', 'charge', '2018-05-02 09:58:09'),
(31, 'ch_1CNOKYJJHso11uivsQBQgeME', 48, 'Harry Potter', 'harry.potter@hogwarts.com', '4 Privet Drive', '', 'Surrey,', 'England', '65201', 'uk', '220.00', '19.14', '239.14', '4 items from CartBugs Shoppe', 'charge', '2018-05-02 12:00:56'),
(32, 'ch_1CNmrVJJHso11uivkD9iuXZ2', 52, 'Shirin Shailesh Bhagwat', 'sxb@example.com', '323 Franklin Ave Apt D4', '', 'Warrensburg', 'MO', '64093', 'US', '30.00', '2.61', '32.61', '3 items from CartBugs Shoppe', 'charge', '2018-05-03 14:12:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
