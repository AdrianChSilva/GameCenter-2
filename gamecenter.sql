-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2019 at 02:13 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamecenter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(6) NOT NULL,
  `adminDNI` varchar(9) COLLATE utf8_bin NOT NULL,
  `adminNombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `adminApellido` varchar(60) COLLATE utf8_bin NOT NULL,
  `adminTlfn` varchar(9) COLLATE utf8_bin NOT NULL,
  `adminDir` varchar(255) COLLATE utf8_bin NOT NULL,
  `cuentaCodigo` varchar(70) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminDNI`, `adminNombre`, `adminApellido`, `adminTlfn`, `adminDir`, `cuentaCodigo`) VALUES
(13, '00000000', 'Administrador', 'Principal', '777777777', 'Administrador Principal 29011', 'Adm08984-11'),
(29, '1111111', 'AdminUno', 'AdminUno', '111111111', 'AdminUno', 'Adm07534-2'),
(30, '222222222', 'admindos', 'admindos', '2222222', 'admindos', 'Adm11587-3'),
(31, '33333333', 'admintres', 'admintres', '333333333', 'admintres', 'Adm01051-4');

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE `cuenta` (
  `id` int(6) NOT NULL,
  `cuentaCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `cuentaPrivg` int(1) NOT NULL,
  `cuentaAlias` varchar(25) COLLATE utf8_bin NOT NULL,
  `cuentaPass` varchar(500) COLLATE utf8_bin NOT NULL,
  `cuentaEmail` varchar(80) COLLATE utf8_bin NOT NULL,
  `cuentaEstado` varchar(20) COLLATE utf8_bin NOT NULL,
  `cuentaTipo` varchar(25) COLLATE utf8_bin NOT NULL,
  `cuentaGenero` varchar(10) COLLATE utf8_bin NOT NULL,
  `cuentaFoto` varchar(700) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `cuenta`
--

INSERT INTO `cuenta` (`id`, `cuentaCodigo`, `cuentaPrivg`, `cuentaAlias`, `cuentaPass`, `cuentaEmail`, `cuentaEstado`, `cuentaTipo`, `cuentaGenero`, `cuentaFoto`) VALUES
(13, 'Adm08984-11', 1, 'adminP', 'VVhSNWxVVzRMZkU4a09wZTJyQlNJQT09', 'AdministradorPrincipal@gmail.com', 'Activo', 'Administrador', 'Masculino', '../archivos/logo.png'),
(84, 'Adm07534-2', 1, 'adminuno', 'VW9UZ2pINk9Vcy9EeTIzOE9sdHloUT09', 'adminuno@gmail.com', 'Activo', 'Administrador', 'Masculino', 'https://images.dog.ceo/breeds/schipperke/n02104365_6575.jpg'),
(85, 'Adm11587-3', 2, 'admindos', 'cSswZTZZemtLRXQ0ZWpDdnR1N1RxZz09', 'admindos@gmail.com', 'Activo', 'Administrador', 'Indefinido', 'https://cdn4.iconfinder.com/data/icons/twitter-ui-set/128/Egg_Proffile_And_Settings_Twitter-512.png'),
(86, 'Adm01051-4', 3, 'admintres', 'OUxZSmZKM0hTVlRYak85M3Q3bUJBZz09', 'admintres@admintres.es', 'Activo', 'Administrador', 'Masculino', 'https://images.dog.ceo/breeds/elkhound-norwegian/n02091467_73.jpg'),
(87, 'Usr2061882-5', 4, 'adrichs', 'SFIza2Vkbzl3Z0RzajE5MHFQVCtjUT09', 'adri@gmail.com', 'Activo', 'Cliente', 'Masculino', 'https://images.dog.ceo/breeds/hound-blood/n02088466_3448.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `desarrolladora`
--

CREATE TABLE `desarrolladora` (
  `id` int(6) NOT NULL,
  `desarrCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `desarrNombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `desarrTlfn` varchar(20) COLLATE utf8_bin NOT NULL,
  `desarrEmail` varchar(90) COLLATE utf8_bin NOT NULL,
  `desarrDir` varchar(255) COLLATE utf8_bin NOT NULL,
  `desarrCEO` varchar(90) COLLATE utf8_bin NOT NULL,
  `desarrAno` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `desarrolladora`
--

INSERT INTO `desarrolladora` (`id`, `desarrCodigo`, `desarrNombre`, `desarrTlfn`, `desarrEmail`, `desarrDir`, `desarrCEO`, `desarrAno`) VALUES
(9, '00000001', 'Microsoft Studios', '11111111', 'mcstudio@gmail.com', 'america nÂ°1', 'BillGates', 1950),
(10, '00000002', 'Electronic Arts', '2222222222', 'electronicarts@gmail.com', 'caller america 1', 'TripHawkins', 1978),
(11, '00000003', 'Nintendo', '33333333', 'nintengo@nintendo.com', 'Calle JapÃ³n nÂ°1', 'Fusajiro Yamauchi', 1889),
(12, '00000004', 'Activision', '44444444', 'Activision@Activision.com', 'AmÃ©rica', 'Larry Kaplan', 1978),
(13, '00000005', 'Sony Interactive Entertainment', '55555555', 'Sony@desarrolladora.com', 'Japon', 'Ken Kutaragi', 1993),
(14, '0000006', 'Take Two Interactive', '66666666', 't2@taketwo.com', 'Nueva York', 'Strauss Zelnick', 1993),
(15, '00000007', 'Xbox Game Studios', '777777777', 'xbox@desarrolladora.com', 'America', 'Phil Spencer', 2001),
(16, '0000008', 'From Software', '88888888', 'fromsftwr@gmail.com', 'Japon', 'Hidetaka Miyazaki', 2010);

-- --------------------------------------------------------

--
-- Table structure for table `genero`
--

CREATE TABLE `genero` (
  `id` int(6) NOT NULL,
  `generoCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `generoNombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `genero`
--

INSERT INTO `genero` (`id`, `generoCodigo`, `generoNombre`) VALUES
(16, '1', 'Sandbox'),
(19, '02', 'AcciÃ³n'),
(20, '03', 'RPG'),
(21, '04', 'JRPG'),
(22, '05', 'Aventuras-puzzle'),
(23, '06', 'AcciÃ³n-Aventura'),
(24, '07', 'Aventuras'),
(25, '08', 'Plataforma'),
(26, '09', 'Souls');

-- --------------------------------------------------------

--
-- Table structure for table `historico`
--

CREATE TABLE `historico` (
  `id` int(6) NOT NULL,
  `histCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `histFecha` date NOT NULL,
  `histHoraInicio` varchar(20) COLLATE utf8_bin NOT NULL,
  `histHoraFinal` varchar(20) COLLATE utf8_bin NOT NULL,
  `histTipo` varchar(20) COLLATE utf8_bin NOT NULL,
  `histAnno` int(4) NOT NULL,
  `cuentaCodigo` varchar(70) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `historico`
--

INSERT INTO `historico` (`id`, `histCodigo`, `histFecha`, `histHoraInicio`, `histHoraFinal`, `histTipo`, `histAnno`, `cuentaCodigo`) VALUES
(323, 'CodH57151075-1', '2019-05-23', '04:01:47 pm', '04:03:15 pm', 'Administrador', 2019, 'Adm08984-11'),
(324, 'CodH61912668-2', '2019-05-23', '04:03:20 pm', '04:03:41 pm', 'Administrador', 2019, 'Adm07534-2'),
(325, 'CodH35592786-3', '2019-05-23', '04:03:47 pm', '04:07:55 pm', 'Administrador', 2019, 'Adm08984-11'),
(326, 'CodH01712525-4', '2019-05-23', '04:08:04 pm', '04:26:27 pm', 'Administrador', 2019, 'Adm07534-2'),
(327, 'CodH06237299-5', '2019-05-24', '10:03:58 am', '11:22:53 am', 'Administrador', 2019, 'Adm07534-2'),
(328, 'CodH67161176-6', '2019-05-24', '11:22:58 am', '11:26:04 am', 'Administrador', 2019, 'Adm11587-3'),
(329, 'CodH65906031-7', '2019-05-24', '11:26:09 am', 'NO DATA', 'Administrador', 2019, 'Adm01051-4'),
(330, 'CodH06885220-8', '2019-05-24', '11:26:23 am', '11:28:45 am', 'Administrador', 2019, 'Adm01051-4'),
(331, 'CodH86933801-9', '2019-05-24', '11:29:09 am', '11:34:39 am', 'Administrador', 2019, 'Adm01051-4'),
(332, 'CodH27913430-10', '2019-05-24', '11:34:51 am', '11:35:23 am', 'Administrador', 2019, 'Adm11587-3'),
(333, 'CodH00816413-11', '2019-05-24', '11:35:33 am', '11:35:39 am', 'Administrador', 2019, 'Adm01051-4'),
(334, 'CodH80925290-12', '2019-05-24', '11:35:45 am', '11:41:54 am', 'Administrador', 2019, 'Adm07534-2'),
(335, 'CodH36551686-13', '2019-05-24', '11:42:00 am', '11:42:22 am', 'Administrador', 2019, 'Adm11587-3'),
(336, 'CodH14198551-14', '2019-05-24', '11:42:27 am', '11:44:26 am', 'Administrador', 2019, 'Adm08984-11'),
(337, 'CodH17000787-15', '2019-05-24', '11:45:37 am', '11:47:12 am', 'Cliente', 2019, 'Usr2061882-5'),
(338, 'CodH46046730-16', '2019-05-24', '11:47:18 am', '11:50:43 am', 'Administrador', 2019, 'Adm07534-2'),
(339, 'CodH21747534-17', '2019-05-24', '03:44:24 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(340, 'CodH98280176-18', '2019-05-26', '01:21:46 pm', '01:21:54 pm', 'Administrador', 2019, 'Adm08984-11'),
(341, 'CodH83866306-19', '2019-05-26', '01:31:55 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(342, 'CodH47110442-20', '2019-05-26', '01:32:02 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(343, 'CodH60241331-21', '2019-05-26', '01:32:13 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(344, 'CodH78418458-22', '2019-05-26', '01:33:30 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(345, 'CodH00837591-23', '2019-05-26', '01:34:32 pm', '01:34:41 pm', 'Administrador', 2019, 'Adm08984-11'),
(346, 'CodH33194531-24', '2019-05-26', '01:36:01 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(347, 'CodH09966967-25', '2019-05-26', '01:36:10 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(348, 'CodH08049484-26', '2019-05-26', '01:38:00 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(349, 'CodH24081792-27', '2019-05-26', '01:38:40 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(350, 'CodH74557897-28', '2019-05-26', '01:39:40 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(351, 'CodH17653429-29', '2019-05-26', '01:40:35 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(352, 'CodH47275146-30', '2019-05-26', '01:41:57 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(353, 'CodH90336912-31', '2019-05-26', '01:42:18 pm', '01:42:24 pm', 'Administrador', 2019, 'Adm08984-11'),
(354, 'CodH68780332-32', '2019-05-26', '01:44:20 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(355, 'CodH70692480-33', '2019-05-26', '01:52:30 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(356, 'CodH76307217-34', '2019-05-26', '01:53:35 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(357, 'CodH37009866-35', '2019-05-26', '01:53:56 pm', '01:54:18 pm', 'Administrador', 2019, 'Adm08984-11'),
(358, 'CodH69384802-36', '2019-05-26', '01:54:25 pm', '01:54:40 pm', 'Administrador', 2019, 'Adm07534-2'),
(359, 'CodH05348861-37', '2019-05-26', '01:54:46 pm', '01:55:12 pm', 'Administrador', 2019, 'Adm11587-3'),
(360, 'CodH23881685-38', '2019-05-26', '01:57:28 pm', '02:00:21 pm', 'Administrador', 2019, 'Adm07534-2'),
(361, 'CodH30575937-39', '2019-05-26', '02:00:27 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(362, 'CodH79175297-40', '2019-05-26', '02:04:51 pm', '02:05:01 pm', 'Administrador', 2019, 'Adm08984-11'),
(363, 'CodH99072240-41', '2019-05-26', '02:05:06 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(364, 'CodH95058997-42', '2019-05-26', '02:07:00 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(365, 'CodH44206166-43', '2019-05-26', '02:13:19 pm', '02:16:45 pm', 'Administrador', 2019, 'Adm08984-11'),
(366, 'CodH94453780-44', '2019-05-26', '02:16:17 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(367, 'CodH23674396-45', '2019-05-26', '02:17:27 pm', '02:17:35 pm', 'Administrador', 2019, 'Adm08984-11'),
(368, 'CodH70274233-46', '2019-05-26', '02:30:35 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(369, 'CodH46336199-47', '2019-05-26', '02:33:07 pm', '02:33:14 pm', 'Administrador', 2019, 'Adm08984-11'),
(370, 'CodH06148017-48', '2019-05-26', '02:33:20 pm', 'NO DATA', 'Cliente', 2019, 'Usr2061882-5'),
(371, 'CodH59818940-49', '2019-05-26', '02:35:24 pm', '02:36:44 pm', 'Administrador', 2019, 'Adm08984-11'),
(372, 'CodH13877232-50', '2019-05-26', '02:36:55 pm', '02:37:43 pm', 'Administrador', 2019, 'Adm08984-11'),
(373, 'CodH89302743-51', '2019-05-26', '02:37:48 pm', '02:39:12 pm', 'Administrador', 2019, 'Adm08984-11'),
(374, 'CodH70128839-52', '2019-05-26', '02:45:24 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(375, 'CodH30223900-53', '2019-05-26', '02:45:34 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(376, 'CodH38968879-54', '2019-05-26', '02:45:45 pm', '02:45:59 pm', 'Administrador', 2019, 'Adm08984-11'),
(377, 'CodH39849641-55', '2019-05-26', '02:48:04 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(378, 'CodH22114654-56', '2019-05-26', '02:52:27 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(379, 'CodH21454369-57', '2019-05-26', '02:53:47 pm', '02:54:38 pm', 'Administrador', 2019, 'Adm08984-11'),
(380, 'CodH96298055-58', '2019-05-26', '02:54:45 pm', '02:55:07 pm', 'Administrador', 2019, 'Adm08984-11'),
(381, 'CodH70285369-59', '2019-05-26', '02:55:18 pm', '02:57:11 pm', 'Cliente', 2019, 'Usr2061882-5'),
(382, 'CodH05141484-60', '2019-05-26', '02:57:41 pm', '02:57:58 pm', 'Administrador', 2019, 'Adm08984-11'),
(384, 'CodH08812118-62', '2019-05-27', '11:21:31 am', '11:25:59 am', 'Administrador', 2019, 'Adm08984-11'),
(385, 'CodH38946507-63', '2019-05-27', '11:27:27 am', '11:30:38 am', 'Cliente', 2019, 'Usr2061882-5'),
(386, 'CodH75794430-64', '2019-05-27', '11:30:43 am', '01:26:33 pm', 'Administrador', 2019, 'Adm08984-11'),
(387, 'CodH10096198-65', '2019-05-27', '01:26:49 pm', '01:26:58 pm', 'Cliente', 2019, 'Usr2061882-5'),
(388, 'CodH91103750-66', '2019-05-27', '01:27:02 pm', '01:27:31 pm', 'Administrador', 2019, 'Adm08984-11'),
(389, 'CodH55805879-67', '2019-05-27', '01:27:45 pm', '01:28:15 pm', 'Administrador', 2019, 'Adm08984-11'),
(390, 'CodH50458016-68', '2019-05-27', '01:28:20 pm', '01:28:28 pm', 'Cliente', 2019, 'Usr2061882-5'),
(391, 'CodH85814711-69', '2019-05-27', '01:28:32 pm', '01:50:12 pm', 'Administrador', 2019, 'Adm08984-11'),
(392, 'CodH21798098-70', '2019-05-27', '01:51:10 pm', '01:53:21 pm', 'Cliente', 2019, 'Usr2061882-5'),
(393, 'CodH54068823-71', '2019-05-27', '01:53:26 pm', '05:00:12 pm', 'Administrador', 2019, 'Adm08984-11'),
(394, 'CodH35844720-72', '2019-05-27', '05:00:20 pm', '10:11:07 pm', 'Administrador', 2019, 'Adm08984-11'),
(395, 'CodH47814993-73', '2019-05-27', '10:43:25 pm', 'NO DATA', 'Administrador', 2019, 'Adm08984-11'),
(396, 'CodH67520247-74', '2019-05-28', '11:07:50 am', '02:02:39 pm', 'Administrador', 2019, 'Adm08984-11'),
(397, 'CodH54781526-74', '2019-05-28', '02:02:45 pm', '02:04:30 pm', 'Cliente', 2019, 'Usr2061882-5'),
(398, 'CodH05744773-75', '2019-05-28', '02:04:34 pm', '02:04:49 pm', 'Administrador', 2019, 'Adm08984-11'),
(399, 'CodH97336017-76', '2019-05-28', '02:04:56 pm', 'NO DATA', 'Administrador', 2019, 'Adm11587-3');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `id` int(6) NOT NULL,
  `publisherCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `publisherNombre` varchar(90) COLLATE utf8_bin NOT NULL,
  `publisherEncargado` varchar(90) COLLATE utf8_bin NOT NULL,
  `publisherTlfn` varchar(20) COLLATE utf8_bin NOT NULL,
  `publisherEmail` varchar(90) COLLATE utf8_bin NOT NULL,
  `publisherDir` varchar(10) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `publisherCodigo`, `publisherNombre`, `publisherEncargado`, `publisherTlfn`, `publisherEmail`, `publisherDir`) VALUES
(8, 'Pub05752-1', 'Microsoft', 'Bill Gates', '1111111110', 'microsoftpublisher@gmail.com', 'america'),
(9, 'Pub80180-2', 'Activision Blizzard', 'Phil Spencer', '22222222', 'activisionblizzard@publisher.com', 'America'),
(10, 'Pub54721-3', 'Nintendo', 'Shuntaro Furukawa', '33333333', 'nintendo@publisher.com', 'JapÃ³n'),
(11, 'Pub60564-4', 'Electronic Arts', 'James Jhonson', '44444444', 'EA@publisher.com', 'America'),
(12, 'Pub17569-5', 'Square Enix', 'Soichi Nakamura', '555555555', 'squaresoft@antesmolabanlosFF.com', 'Japon Feud'),
(13, 'Pub92508-6', 'Sony Play Station', 'Rob Zernick', '666666666', 'sony@publisher.com', 'America-Ja');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(6) NOT NULL,
  `userDNI` varchar(9) COLLATE utf8_bin NOT NULL,
  `userNombre` varchar(50) COLLATE utf8_bin NOT NULL,
  `userApellido` varchar(60) COLLATE utf8_bin NOT NULL,
  `userTlfn` varchar(9) COLLATE utf8_bin NOT NULL,
  `userOcup` varchar(50) COLLATE utf8_bin NOT NULL,
  `userDir` varchar(255) COLLATE utf8_bin NOT NULL,
  `cuentaCodigo` varchar(70) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `userDNI`, `userNombre`, `userApellido`, `userTlfn`, `userOcup`, `userDir`, `cuentaCodigo`) VALUES
(34, '771876442', 'AdriÃ¡n', 'Chamorro Silva', '650000499', 'PC', 'Alejandro Puskin', 'Usr2061882-5');

-- --------------------------------------------------------

--
-- Table structure for table `videojuego`
--

CREATE TABLE `videojuego` (
  `id` int(15) NOT NULL,
  `vidCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `vidTitulo` varchar(90) COLLATE utf8_bin NOT NULL,
  `vidPais` varchar(50) COLLATE utf8_bin NOT NULL,
  `vidAnno` int(4) NOT NULL,
  `vidPrecio` decimal(30,2) NOT NULL,
  `vidPlataforma` varchar(100) COLLATE utf8_bin NOT NULL,
  `vidAnalisis` text COLLATE utf8_bin NOT NULL,
  `vidImagen` varchar(700) COLLATE utf8_bin NOT NULL,
  `vidGuiaPDF` varchar(700) COLLATE utf8_bin NOT NULL,
  `generoCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `publisherCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `desarrCodigo` varchar(70) COLLATE utf8_bin NOT NULL,
  `vidVideo` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `videojuego`
--

INSERT INTO `videojuego` (`id`, `vidCodigo`, `vidTitulo`, `vidPais`, `vidAnno`, `vidPrecio`, `vidPlataforma`, `vidAnalisis`, `vidImagen`, `vidGuiaPDF`, `generoCodigo`, `publisherCodigo`, `desarrCodigo`, `vidVideo`) VALUES
(43, '1', 'Minecraft Windows 10', 'AmÃ©rica', 2016, '30.00', 'Windows10', 'Minecraft es un videojuego de construcciÃ³n, de tipo Â«mundo abiertoÂ» o sandbox creado originalmente por el sueco Markus Persson (conocido comÃºnmente como \"Notch\"),10â€‹ y posteriormente desarrollado por su empresa, Mojang AB. Fue lanzado pÃºblicamente el 17 de mayo de 2009, despuÃ©s de diversos cambios fue lanzada su versiÃ³n completa el 18 de noviembre de 2011.\r\n\r\n\r\nMarkus Persson, el creador de Minecraft.\r\nUn mes antes del lanzamiento de su versiÃ³n completa, el 18 de octubre de 2011, fue estrenada una versiÃ³n para Android, y el 17 de noviembre del mismo aÃ±o fue lanzada la versiÃ³n para iOS. El 9 de mayo de 2012 fue lanzada la versiÃ³n del juego para Xbox 360 y PS3. Todas las versiones de Minecraft reciben actualizaciones constantes desde su lanzamiento. El 11 de noviembre de 2014, Minecraft lanzÃ³ su ediciÃ³n para el apartado de PlayStation Vita, desarrollada por Mojang y 4J Studios, esta versiÃ³n presenta las mismas actualizaciones y similares caracterÃ­sticas que las otras versiones de consola; ademÃ¡s, cuenta con el sistema de venta cruzada, es decir que al comprar la versiÃ³n de PlayStation 3 se adquiere tambiÃ©n la de PlayStation Vita. A septiembre de 2014 se habÃ­an vendido mÃ¡s de 54 millones de copias.11â€‹\r\n\r\nEl 15 de septiembre del 2014, fue adquirido por la empresa Microsoft por un valor de 2500 millones USD. Este suceso provocÃ³ el alejamiento de Markus Persson de la compaÃ±Ã­a.11â€‹ El 1 de noviembre de 2016 Microsoft anunciÃ³ el lanzamiento de la versiÃ³n completa de Minecraft Education Edition.', '../archivos/1200px-Windows_10_Edition.png', '../archivos/guia-trucoteca-minecraft-pc.pdf', '1', 'Pub05752-1', '00000001', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/Nq_Q77bJ3H0\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(44, '02', 'Sekiro: Shadows Die twice', 'Japon', 2019, '70.00', 'Multi', 'En un reinventado perÃ­odo Sengoku de finales del siglo XVI en JapÃ³n, el seÃ±or de la guerra Isshin Ashina organizÃ³ un golpe sangriento y tomÃ³ el control de la tierra de Ashina del Ministerio del Interior. Durante este tiempo, un shinobi errante llamado Ukonzaemon Usui adoptÃ³ a un huÃ©rfano sin nombre, conocido por muchos como Owl, quien nombrÃ³ al niÃ±o Lobo y lo entrenÃ³ en los caminos del shinobi. Dos dÃ©cadas mÃ¡s tarde, el clan Ashina estÃ¡ al borde del colapso debido a una combinaciÃ³n del ahora anciano Isshin que se enfermÃ³ y los enemigos del clan se fueron acercando constantemente por todos lados. Desesperado por salvar a su clan, el nieto de Isshin, Genichiro, buscÃ³ al Divino Heredero Kuro para que pueda usar la \"Herencia del DragÃ³n\" del niÃ±o para crear un ejÃ©rcito inmortal. Wolf, ahora un shinobi de pleno derecho y el guardaespaldas personal de Kuro, pierde su brazo izquierdo al no poder detener a Genichiro. Cuando recibiÃ³ la sangre del dragÃ³n de Kuro tres aÃ±os antes, Wolf sobreviviÃ³ a sus heridas y se despertÃ³ en un templo abandonado. En el templo, se encuentra con el Escultor, un antiguo shinobi llamado Sekijo que ahora esculpe estatuas de Buda, y Wolf encuentra que su brazo perdido ha sido reemplazado por la PrÃ³tesis Shinobi, un brazo artificial sofisticado que puede empuÃ±ar una gran variedad de artilugios y armas. Con la PrÃ³tesis Shinobi, Wolf asalta el Castillo Ashina y se enfrenta a Genichiro nuevamente, derrotÃ¡ndolo, aunque este Ãºltimo es capaz de escapar bebiendo las aguas Rejuvenecedoras, que es una rÃ©plica hecha por el hombre de la sangre del dragÃ³n. A pesar de tener la oportunidad de huir de Ashina para siempre, Kuro decide quedarse y realizar el ritual de \"Inmortal SeparaciÃ³n\", que eliminarÃ­a su herencia de dragÃ³n y evitarÃ­a que alguien mÃ¡s se peleara por Ã©l para obtener la inmortalidad. Lobo acepta a regaÃ±adientes ayudar a Kuro y se dirige a las Ã¡reas que rodean el castillo para recopilar todos los componentes necesarios del ritual, incluida una espada especial que puede cortar inmortales conocida como la Hoja mortal. Cuando Wolf regresa, se encuentra con Owl, quien se creÃ­a que habÃ­a sido asesinado hace tres aÃ±os. Owl revela que tambiÃ©n busca la Herencia del DragÃ³n de Kuro, y le ordena a Wolf que renuncie a su lealtad a Kuro. A Wolf se le presenta la opciÃ³n de seguir a Owl y traicionar a Kuro o permanecer leal a Kuro. Si Wolf se pone del lado de Owl, se verÃ¡ obligado a pelear con Emma,un mÃ©dico al servicio de Isshin y con Isshin. Al derrotarlos, Wolf luego apuÃ±ala a Owl en la espalda mientras Kuro con horror se da cuenta de que Wolf ha sido corrompido por la sed de sangre y ha caÃ­do en el camino de Shura. Luego se afirma que un demonio vagÃ³ por las tierras durante muchos aÃ±os matando a muchas personas. Si Kuro es elegido, Wolf pelea y mata a Owl. A continuaciÃ³n, utiliza los elementos que ha reunido para entrar en Fountainhead Palace. Luego, Wolf entra en el Reino Divino, donde lucha contra el DragÃ³n Divino para obtener sus lÃ¡grimas para la SeparaciÃ³n inmortal. Al regresar a Ashina, Castle Wolf descubre que ha sido atacado por el Ministerio del Interior y Emma le informa que Kuro ha huido por un pasaje de escape secreto. Wolf encuentra a Kuro y Genichiro heridos, empuÃ±ando una segunda Hoja Mortal. Genichiro luego desafÃ­a a Wolf por Ãºltima vez. Tras su derrota, se sacrifica para traer a Isshin, quien recientemente muriÃ³ de su enfermedad, a la vida en el apogeo de su poder. Aunque Isshin estÃ¡ del lado de Wolf y Kuro, honra el sacrificio de Genichiro y elige luchar contra Wolf. DespuÃ©s de derrotar a Isshin, el jugador puede obtener tres finales dependiendo de lo que se le dÃ© a Kuro. El final estÃ¡ndar es \"separaciÃ³n inmortal\". Lobo le da a Kuro las lÃ¡grimas de dragÃ³n y corta sus lazos con el DragÃ³n Divino. Este proceso termina matando a Kuro, mientras que Wolf se convierte en el prÃ³ximo escultor y termina su vida como shinobi. En el final de \"PurificaciÃ³n\", Wolf consigue salvar a Kuro a costa de su propia vida. El final final, \"Retorno\", se obtiene al ayudar al NiÃ±o Divino de las Aguas Rejuvenecedoras a completar un ritual para devolver el poder del DragÃ³n Divino a su lugar de nacimiento en el Oeste. El cuerpo de Kuro muere pero su espÃ­ritu se transfiere al corazÃ³n del NiÃ±o Divino. Wolf sigue siendo un shinobi y elige viajar con el NiÃ±o Divino en su viaje hacia el oeste.', '../archivos/sekiro-shadows-die-twice.jpg', '../archivos/mpdf.pdf', '09', 'Pub80180-2', '00000004', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/e8iGRmFCRQk\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(45, '03', 'Dark Souls 3', 'JapÃ³n', 2017, '70.00', 'Multi', 'Dark souls 3 es el final de la saga y presenta un mundo, el Reino de Lothric, al borde del Apocalipsis por culpa de \"la maldiciÃ³n de los no muertos\", y la razÃ³n por la que el mundo aÃºn no se ha sumido en la oscuridad totalmente es el sacrificio que muchos hÃ©roes e incluso dioses hicieron al reavivar la llama original, la cual se encarga de mantener la \"Era del fuego\", dejando que esta consumiera sus respectivas almas y cuerpos.\r\n\r\nEl protagonista, el personaje al que damos vida en este tÃ­tulo, es uno de los que llaman \"Latentes\"; estas personas son humanos que consiguieron llegar al horno de la Primera Llama, trataron de enlazarla, pero fueron consumidos y hechos ceniza sin conseguir su objetivo. Estos humanos son despertados cuando los SeÃ±ores de la Ceniza (aquellos que sÃ­ que fueron suficientemente poderosos como para enlazar la Primera Llama) son despertados pero no cumplen su deber: quedarse en sus tronos (en el Santuario de Enlace del Fuego) hasta que se les vuelva a sacrificar para enlazar la Primera Llama. Es decir, cuando los SeÃ±ores de la Ceniza no quieren volver a prolongar la Era de los Dioses (la era del fuego) y abandonan sus tronos, los Latentes deben ir a por ellos para matarlos y devolver sus cenizas a los Tronos, y el Latente que lo consiga, deberÃ¡, como Ãºltima parte del plan, inmolarse Ã©l mismo, y convertirse de esta forma, en un SeÃ±or de la Ceniza.', '../archivos/ds3.png', '../archivos/GameRantDarkSouls3Guide.pdf', '09', 'Pub80180-2', '0000008', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/_zDZYrIUgKE\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(46, '04', 'Dark Souls 2', 'JapÃ³n', 1994, '70.00', 'Multi', 'Dark Souls II (ãƒ€ãƒ¼ã‚¯ã‚½ã‚¦ãƒ«ãƒ„ãƒ¼ DÄku Souru TsÅ«?) es un videojuego de rol de acciÃ³n que tiene lugar en un mundo abierto, desarrollado para Microsoft Windows, PlayStation 3 y Xbox 360 por From Software. From Software tambiÃ©n distribuye el juego en JapÃ³n, mientras que Namco Bandai Games lo hace para otras regiones.\r\n\r\nDark Souls II fue anunciado como la secuela de Dark Souls en los Spike Video Game Awards el 7 de diciembre de 2012.2â€‹3â€‹ Hidetaka Miyazaki, quien fue el director de Demon\'s Souls y Dark Souls, no regresÃ³ para cumplir ese rol en Dark Souls II.4â€‹ En lugar de eso actuÃ³ como el supervisor, y el juego fue dirigido por Tomohiro Shibuya y Yui Tanimura.4â€‹ Miyazaki indicÃ³ que no habrÃ­a ninguna conexiÃ³n entre las historias de Dark Souls y Dark Souls II, aunque contendrÃ­a referencias a su predecesor vistas al conversar con los NPC, en almas nuevas en el modo NG+,y objetos del juego anterior, etc., aparte de tener lugar en el mismo mundo fantÃ¡stico.5â€‹ El juego utiliza servidores multijugador dedicados.5â€‹', '../archivos/dark-souls-ii-img-4.jpg', '../archivos/guc3ada-completa-dark-souls-ii.pdf', '09', 'Pub80180-2', '0000008', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuentaCodigo` (`cuentaCodigo`);

--
-- Indexes for table `cuenta`
--
ALTER TABLE `cuenta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cuentaCodigo` (`cuentaCodigo`);

--
-- Indexes for table `desarrolladora`
--
ALTER TABLE `desarrolladora`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `desarrCodigo` (`desarrCodigo`);

--
-- Indexes for table `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `generoCodigo` (`generoCodigo`);

--
-- Indexes for table `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuentaCodigo` (`cuentaCodigo`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `publisherCodigo` (`publisherCodigo`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cuentaCodigo` (`cuentaCodigo`);

--
-- Indexes for table `videojuego`
--
ALTER TABLE `videojuego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vidCodigo` (`vidCodigo`),
  ADD KEY `desarrCodigo` (`desarrCodigo`),
  ADD KEY `generoCodigo` (`generoCodigo`),
  ADD KEY `publisherCodigo` (`publisherCodigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `cuenta`
--
ALTER TABLE `cuenta`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `desarrolladora`
--
ALTER TABLE `desarrolladora`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `genero`
--
ALTER TABLE `genero`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=400;

--
-- AUTO_INCREMENT for table `publisher`
--
ALTER TABLE `publisher`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `videojuego`
--
ALTER TABLE `videojuego`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`cuentaCodigo`) REFERENCES `cuenta` (`cuentaCodigo`);

--
-- Constraints for table `historico`
--
ALTER TABLE `historico`
  ADD CONSTRAINT `historico_ibfk_1` FOREIGN KEY (`cuentaCodigo`) REFERENCES `cuenta` (`cuentaCodigo`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`cuentaCodigo`) REFERENCES `cuenta` (`cuentaCodigo`);

--
-- Constraints for table `videojuego`
--
ALTER TABLE `videojuego`
  ADD CONSTRAINT `videojuego_ibfk_1` FOREIGN KEY (`desarrCodigo`) REFERENCES `desarrolladora` (`desarrCodigo`),
  ADD CONSTRAINT `videojuego_ibfk_2` FOREIGN KEY (`generoCodigo`) REFERENCES `genero` (`generoCodigo`),
  ADD CONSTRAINT `videojuego_ibfk_3` FOREIGN KEY (`publisherCodigo`) REFERENCES `publisher` (`publisherCodigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
