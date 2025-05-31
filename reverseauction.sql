-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 06:16 PM
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
-- Database: `reverseauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `adres`
--

CREATE TABLE `adres` (
  `adres_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `adres_ad` varchar(50) NOT NULL,
  `adres_soyad` varchar(50) NOT NULL,
  `adres_gsm` varchar(50) NOT NULL,
  `adres_il` varchar(50) NOT NULL,
  `adres_ilce` varchar(50) NOT NULL,
  `adres_mahalle` varchar(50) NOT NULL,
  `adres_adres` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `adres`
--

INSERT INTO `adres` (`adres_id`, `kullanici_id`, `adres_ad`, `adres_soyad`, `adres_gsm`, `adres_il`, `adres_ilce`, `adres_mahalle`, `adres_adres`) VALUES
(15, 213, 'Mehmet', 'Ekiz', '0539 931 55 50', 'İstanbul', 'Eyüpsultan', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `ayar`
--

CREATE TABLE `ayar` (
  `ayar_id` int(11) NOT NULL,
  `ayar_logo` varchar(250) NOT NULL,
  `ayar_url` varchar(50) NOT NULL,
  `ayar_title` varchar(250) NOT NULL,
  `ayar_description` varchar(250) NOT NULL,
  `ayar_keywords` varchar(100) NOT NULL,
  `ayar_author` varchar(150) NOT NULL,
  `ayar_tel` varchar(50) NOT NULL,
  `ayar_gsm` varchar(50) NOT NULL,
  `ayar_faks` varchar(50) NOT NULL,
  `ayar_mail` varchar(50) NOT NULL,
  `ayar_ilce` varchar(50) NOT NULL,
  `ayar_il` varchar(50) NOT NULL,
  `ayar_adres` varchar(250) NOT NULL,
  `ayar_mesai` varchar(250) NOT NULL,
  `ayar_maps` varchar(250) NOT NULL,
  `ayar_analystic` varchar(50) NOT NULL,
  `ayar_zopim` varchar(250) NOT NULL,
  `ayar_facebook` varchar(50) NOT NULL,
  `ayar_twitter` varchar(50) NOT NULL,
  `ayar_instagram` varchar(50) NOT NULL,
  `ayar_youtube` varchar(50) NOT NULL,
  `ayar_linkedin` varchar(50) NOT NULL,
  `ayar_smtphost` varchar(50) NOT NULL,
  `ayar_smtpuser` varchar(50) NOT NULL,
  `ayar_smtppassword` varchar(50) NOT NULL,
  `ayar_smtpport` varchar(50) NOT NULL,
  `ayar_bakim` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `ayar`
--

INSERT INTO `ayar` (`ayar_id`, `ayar_logo`, `ayar_url`, `ayar_title`, `ayar_description`, `ayar_keywords`, `ayar_author`, `ayar_tel`, `ayar_gsm`, `ayar_faks`, `ayar_mail`, `ayar_ilce`, `ayar_il`, `ayar_adres`, `ayar_mesai`, `ayar_maps`, `ayar_analystic`, `ayar_zopim`, `ayar_facebook`, `ayar_twitter`, `ayar_instagram`, `ayar_youtube`, `ayar_linkedin`, `ayar_smtphost`, `ayar_smtpuser`, `ayar_smtppassword`, `ayar_smtpport`, `ayar_bakim`) VALUES
(0, 'images/30097 logo.png', 'http://www.reverseauction.com', 'Türkiye\'nin İlk Talep Tabanlı Online İlan ve Alışveriş Sitesi', 'Arz yerine talebin ön planda olduğu, talep edilen ürünler için tersine açık artırma sistemi ile fiyat belirlenebileceği bir e-ticaret platformu', 'eticaret, shopping, reverse, talep, arz, auction, açık, artırma, tersine', ' Copyright © 2024-2025  Reverse Auction. Bir ekonomik istikrar projesi.', '0212 555 12 12', '0539 931 55 50', '02125551212@fax.tc', 'info.reverseauction@gmail.com', 'Kadıköy', 'İstanbul', 'İstanbul Medeniyet Üniversitesi', '7 x 24 açık eticaret sitesi', 'AIzaSyCiaioI2CRwNL3klHmv1C10qDgYJmpDsn4', 'ayar_analystic', 'ayar_zopim', 'https://www.facebook.com', 'https://www.twitter.com', 'https://www.instagram.com', 'https://www.youtube.com', 'https://www.linkedin.com', 'smtp.gmail.com', 'info.reverseauction@gmail.com', 'gtctxdqmisvfzaif', '465', '0');

-- --------------------------------------------------------

--
-- Table structure for table `banka`
--

CREATE TABLE `banka` (
  `banka_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `banka_ad` varchar(50) NOT NULL,
  `banka_iban` varchar(50) NOT NULL,
  `banka_hesapadsoyad` varchar(50) NOT NULL,
  `banka_durum` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `banka`
--

INSERT INTO `banka` (`banka_id`, `kullanici_id`, `banka_ad`, `banka_iban`, `banka_hesapadsoyad`, `banka_durum`) VALUES
(23, 213, 'ziraat', 'TR12 3456 7890 1234 5678 9012 34', 'Yasin Akın', '0'),
(28, 253, 'ziraat', 'TR65 4654 6548 9645 4684 5465 46', 'mehmet eren ekiz', '0');

-- --------------------------------------------------------

--
-- Table structure for table `favori`
--

CREATE TABLE `favori` (
  `favori_id` int(11) NOT NULL,
  `talep_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firma`
--

CREATE TABLE `firma` (
  `firma_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `firma_ad` varchar(100) NOT NULL,
  `firma_vdaire` varchar(100) NOT NULL,
  `firma_vno` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hakkimizda`
--

CREATE TABLE `hakkimizda` (
  `hakkimizda_id` int(11) NOT NULL,
  `hakkimizda_baslik` varchar(250) NOT NULL,
  `hakkimizda_icerik_baslik` text NOT NULL,
  `hakkimizda_icerik` text NOT NULL,
  `hakkimizda_video_baslik` text NOT NULL,
  `hakkimizda_video` varchar(50) NOT NULL,
  `hakkimizda_vizyon_baslik` varchar(50) NOT NULL,
  `hakkimizda_vizyon` varchar(500) NOT NULL,
  `hakkimizda_misyon_baslik` text NOT NULL,
  `hakkimizda_misyon` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `hakkimizda`
--

INSERT INTO `hakkimizda` (`hakkimizda_id`, `hakkimizda_baslik`, `hakkimizda_icerik_baslik`, `hakkimizda_icerik`, `hakkimizda_video_baslik`, `hakkimizda_video`, `hakkimizda_vizyon_baslik`, `hakkimizda_vizyon`, `hakkimizda_misyon_baslik`, `hakkimizda_misyon`) VALUES
(0, 'Biz Kimiz', 'Ne Yapıyoruz', '<p>deneme</p>', 'tanıtım videosu', '39wrD-Xz6cw', 'Vizyonumuz', '<p>denemee</p>', 'Misyonuzmuz', '<p>deenmee</p>');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_ad` varchar(100) NOT NULL,
  `kategori_seourl` varchar(250) NOT NULL,
  `kategori_sira` int(2) NOT NULL,
  `kategori_durum` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_ad`, `kategori_seourl`, `kategori_sira`, `kategori_durum`) VALUES
(14, 'Vasıta', 'otomobil', 1, '1'),
(15, 'Gayrimenkul', 'gayrimenkul', 2, '1');

-- --------------------------------------------------------

--
-- Table structure for table `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `subMerchantKey` varchar(500) NOT NULL,
  `kullanici_teklif_alma_verme` enum('0','1','2') NOT NULL DEFAULT '0',
  `kullanici_teklif_foto` varchar(500) NOT NULL DEFAULT 'dimg/magaza-fotoyok.png',
  `kullanici_zaman` datetime NOT NULL DEFAULT current_timestamp(),
  `kullanici_resim` varchar(250) NOT NULL,
  `kullanici_ad` varchar(50) NOT NULL,
  `kullanici_soyad` varchar(50) NOT NULL,
  `kullanici_mail` varchar(100) NOT NULL,
  `kullanici_gsm` varchar(50) NOT NULL,
  `kullanici_il` varchar(50) NOT NULL,
  `kullanici_dogum_tarihi` date NOT NULL,
  `kullanici_password` varchar(50) NOT NULL,
  `dogrulama_kodu` varchar(255) NOT NULL,
  `dogrulama_durumu` enum('0','1') NOT NULL DEFAULT '0',
  `kullanici_tip` enum('PERSONAL','PRIVATE_COMPANY','LIMITED_OR_JOINT_STOCK_COMPANY','') NOT NULL DEFAULT 'PERSONAL',
  `kullanici_yetki` enum('1','2','3','4','5') NOT NULL,
  `kullanici_durum` enum('0','1') NOT NULL DEFAULT '1',
  `kullanici_son_ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `subMerchantKey`, `kullanici_teklif_alma_verme`, `kullanici_teklif_foto`, `kullanici_zaman`, `kullanici_resim`, `kullanici_ad`, `kullanici_soyad`, `kullanici_mail`, `kullanici_gsm`, `kullanici_il`, `kullanici_dogum_tarihi`, `kullanici_password`, `dogrulama_kodu`, `dogrulama_durumu`, `kullanici_tip`, `kullanici_yetki`, `kullanici_durum`, `kullanici_son_ip`) VALUES
(213, '', '2', 'dimg/magaza-fotoyok.png', '2025-05-19 16:17:39', '', 'Yasin', 'Akın', 'yasinakin@gmail.com', '0539 931 55 50', 'Istanbul', '0000-00-00', 'bc14b57eff1244213bcfebd5db263c50', '', '1', 'PERSONAL', '1', '1', '::1'),
(248, '', '0', 'dimg/magaza-fotoyok.png', '2025-05-26 20:26:27', '', 'Mehmet Eren', 'Ekiz', 'info@reverseauction.com', '08508408078', 'istanbul', '2001-07-09', '202cb962ac59075b964b07152d234b70', '', '0', 'PERSONAL', '5', '1', ''),
(253, '', '2', 'dimg/magaza-fotoyok.png', '2025-05-28 14:11:18', '', 'Emre', 'Ekiz', 'emreekiz@gmail.com', '0539 931 55 50', 'Istanbul', '0000-00-00', 'bc14b57eff1244213bcfebd5db263c50', '', '1', 'PERSONAL', '1', '1', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `kullaniciiplog`
--

CREATE TABLE `kullaniciiplog` (
  `id` int(11) NOT NULL,
  `kullanici_mail` varchar(100) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `log_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `kullaniciiplog`
--

INSERT INTO `kullaniciiplog` (`id`, `kullanici_mail`, `ip_address`, `user_agent`, `log_time`) VALUES
(7, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:18:50'),
(8, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-19 16:34:41'),
(9, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-20 13:52:58'),
(10, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:00:00'),
(11, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:12:59'),
(12, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:33:48'),
(13, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:40:47'),
(14, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:45:39'),
(15, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:50:33'),
(16, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 21:51:02'),
(17, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 22:01:54'),
(18, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 22:13:26'),
(19, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 22:17:23'),
(20, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-21 22:19:08'),
(21, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-22 14:47:18'),
(27, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-24 19:21:39'),
(50, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 15:32:53'),
(85, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 22:41:07'),
(87, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-26 22:45:52'),
(91, 'yasinakin@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-27 18:46:13'),
(95, 'emreekiz@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 14:28:49'),
(96, 'emreekiz@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-28 14:31:28'),
(97, 'emreekiz@gmail.com', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', '2025-05-28 14:34:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `menu_ust` varchar(50) NOT NULL,
  `menu_ad` varchar(100) NOT NULL,
  `menu_detay` text NOT NULL,
  `menu_url` varchar(250) NOT NULL,
  `menu_sira` int(2) NOT NULL,
  `menu_durum` enum('0','1') NOT NULL,
  `menu_seourl` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_ust`, `menu_ad`, `menu_detay`, `menu_url`, `menu_sira`, `menu_durum`, `menu_seourl`) VALUES
(19, '', 'İletişim', '', '', 1, '0', 'iletisim'),
(20, '', 'Hakkımızda', '', 'hakkimizda', 2, '1', 'hakkimizda'),
(21, '', 'Talep Oluştur', '', 'talep-olustur.php', 3, '1', 'talep-olustur');

-- --------------------------------------------------------

--
-- Table structure for table `mesaj`
--

CREATE TABLE `mesaj` (
  `mesaj_id` int(11) NOT NULL,
  `mesaj_zaman` datetime NOT NULL DEFAULT current_timestamp(),
  `talep_id` int(11) NOT NULL,
  `kimden` int(11) NOT NULL,
  `kime` int(11) NOT NULL,
  `mesaj_detay` text NOT NULL,
  `mesaj_okunma` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `talep`
--

CREATE TABLE `talep` (
  `talep_id` int(11) NOT NULL,
  `kullanici_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `talep_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `talep_ad` varchar(250) NOT NULL,
  `talep_marka` int(11) NOT NULL,
  `talep_min_yil` varchar(50) NOT NULL,
  `talep_max_yil` varchar(50) NOT NULL,
  `talep_yakit_tipi` varchar(100) NOT NULL,
  `talep_kasa_tipi` varchar(100) NOT NULL,
  `talep_kapi_sayisi` varchar(100) NOT NULL,
  `talep_vites_tipi` varchar(100) NOT NULL,
  `talep_min_km` varchar(50) NOT NULL,
  `talep_max_km` varchar(50) NOT NULL,
  `talep_fiyat` varchar(50) NOT NULL,
  `talep_uzeri_teklif` enum('0','1') NOT NULL DEFAULT '0',
  `talep_sehir` varchar(50) NOT NULL,
  `talep_cember_yaricap` varchar(100) NOT NULL,
  `talep_konum_enlem` double NOT NULL,
  `talep_konum_boylam` double NOT NULL,
  `talep_detay` text NOT NULL,
  `talep_seourl` varchar(250) NOT NULL,
  `talep_keyword` varchar(250) NOT NULL,
  `talep_durum` enum('0','1','2','3') NOT NULL,
  `talep_one_cikar` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `talep`
--

INSERT INTO `talep` (`talep_id`, `kullanici_id`, `kategori_id`, `talep_zaman`, `talep_ad`, `talep_marka`, `talep_min_yil`, `talep_max_yil`, `talep_yakit_tipi`, `talep_kasa_tipi`, `talep_kapi_sayisi`, `talep_vites_tipi`, `talep_min_km`, `talep_max_km`, `talep_fiyat`, `talep_uzeri_teklif`, `talep_sehir`, `talep_cember_yaricap`, `talep_konum_enlem`, `talep_konum_boylam`, `talep_detay`, `talep_seourl`, `talep_keyword`, `talep_durum`, `talep_one_cikar`) VALUES
(134, 213, 14, '2025-05-19 13:19:39', 'temiz araç arıyorum', 24, '2019', '2022', 'Benzin&amp;LPG, Dizel', 'Hatchback, Sedan', '5', 'Manuel, Otomatik', '80.000', '130.000', '1.000.000', '0', 'istanbul', '340600', 41.008238, 28.978359, '<p>Temiz kazasız ara&ccedil; arıyorum.</p>', 'temiz-arac-ariyorum', '', '1', '0'),
(136, 213, 15, '2025-05-19 13:51:15', 'temiz depreme dayanıklı ev', 1, '2010', '2020', '', '', '', '', '0', '10000000', '3.000.000', '0', 'sinop', '159700', 42.027974, 35.151725, '<p>depreme dayanıklı bir ev olsun ve ciddi teklifler l&uuml;tfen</p>', 'temiz-depreme-dayanikli-ev', '', '1', '0'),
(137, 213, 15, '2025-05-19 13:56:17', 'genç ev olsun lütfen', 1, '2018', '2025', '', '', '', '', '0', '10000000', '6.000.000', '0', 'mersin', '162800', 36.812104, 34.641481, '<p>ciddi teklifler l&uuml;tfen.</p>', 'genc-ev-olsun-lutfen', '', '1', '0'),
(138, 213, 14, '2025-05-19 14:32:43', 'ikinci el temiz araç', 2, '2019', '2025', 'Benzin, Dizel', 'Hatchback, Sedan, SUV', '5', 'Manuel, Otomatik', '60.000', '110.000', '2.500.000', '0', 'ankara', '613600', 39.933363, 32.859742, '<p>teklifleri bekliyorum.</p>', 'ikinci-el-temiz-arac', '', '1', '0'),
(139, 213, 14, '2025-05-19 14:36:35', 'lütfen ciddi teklif verenlerr', 2, '2010', '2025', 'Benzin, Dizel, Elektrik', 'Hatchback, Sedan', '5', 'Otomatik', '20.000', '160.000', '2.000.000', '0', 'adana', '335400', 36.991419, 35.330829, '<p>teklifleri bekliyorum.</p>', 'lutfen-ciddi-teklif-verenlerr', '', '1', '0'),
(140, 213, 14, '2025-05-21 19:19:31', 'temiz araç arıyorum', 16, '2019', '2025', 'Hybrid', 'Sedan', '5', 'Otomatik', '80.000', '130.000', '1.000.000', '0', 'ankara', '276800', 39.9333635, 32.8597419, '', 'temiz-arac-ariyorum', '', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `teklif`
--

CREATE TABLE `teklif` (
  `teklif_id` int(11) NOT NULL,
  `talep_id` int(11) NOT NULL,
  `teklif_veren_kullanici_id` int(11) NOT NULL,
  `teklif_zaman` timestamp NOT NULL DEFAULT current_timestamp(),
  `teklif_fiyat` varchar(100) NOT NULL,
  `teklif_aciklama` varchar(250) NOT NULL,
  `teklif_sehir_ilce` varchar(50) NOT NULL,
  `teklif_cember_yaricap` varchar(100) NOT NULL,
  `teklif_konum_enlem` double NOT NULL,
  `teklif_konum_boylam` double NOT NULL,
  `teklif_onay_durum` enum('0','1','2','3','4') NOT NULL,
  `teklif_durum` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vasitamarka`
--

CREATE TABLE `vasitamarka` (
  `marka_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `marka_ad` varchar(100) NOT NULL,
  `marka_seourl` varchar(250) NOT NULL,
  `marka_sira` int(2) NOT NULL,
  `marka_durum` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `vasitamarka`
--

INSERT INTO `vasitamarka` (`marka_id`, `kategori_id`, `marka_ad`, `marka_seourl`, `marka_sira`, `marka_durum`) VALUES
(1, 14, 'Aion', '', 0, '1'),
(2, 14, 'Alfa Romeo', '', 0, '1'),
(3, 14, 'Anadol', '', 0, '1'),
(4, 14, 'Arora', '', 0, '1'),
(5, 14, 'Aston Martin', '', 0, '1'),
(6, 14, 'Audi', '', 0, '1'),
(7, 14, 'Bentley', '', 0, '1'),
(8, 14, 'BMW', '', 0, '1'),
(9, 14, 'Buick', '', 0, '1'),
(10, 14, 'BYD', '', 0, '1'),
(11, 14, 'Cadillac', '', 0, '1'),
(12, 14, 'Chery', '', 0, '1'),
(13, 14, 'Chevrolet', '', 0, '1'),
(14, 14, 'Chrysler', '', 0, '1'),
(15, 14, 'Citroen', '', 0, '1'),
(16, 14, 'Cupra', '', 0, '1'),
(17, 14, 'Dacia', '', 0, '1'),
(18, 14, 'Daewoo', '', 0, '1'),
(19, 14, 'Daihatsu', '', 0, '1'),
(20, 14, 'Dodge', '', 0, '1'),
(21, 14, 'DS Automobiles', '', 0, '1'),
(22, 14, 'Ferrari', '', 0, '1'),
(23, 14, 'Fiat', '', 0, '1'),
(24, 14, 'Ford', '', 0, '1'),
(25, 14, 'Geely', '', 0, '1'),
(26, 14, 'Honda', '', 0, '1'),
(27, 14, 'Hyundai', '', 0, '1'),
(28, 14, 'I-GO', '', 0, '1'),
(29, 14, 'Ikco', '', 0, '1'),
(30, 14, 'Infiniti', '', 0, '1'),
(31, 14, 'Jaguar', '', 0, '1'),
(32, 14, 'Jiayuan', '', 0, '1'),
(33, 14, 'Joyce', '', 0, '1'),
(34, 14, 'Katren', '', 0, '1'),
(35, 14, 'Kia', '', 0, '1'),
(36, 14, 'Kral', '', 0, '1'),
(37, 14, 'Kuba', '', 0, '1'),
(38, 14, 'Lada', '', 0, '1'),
(39, 14, 'Lamborghini', '', 0, '1'),
(40, 14, 'Lancia', '', 0, '1'),
(41, 14, 'Leapmotor', '', 0, '1'),
(42, 14, 'Lexus', '', 0, '1'),
(43, 14, 'Lincoln', '', 0, '1'),
(44, 14, 'Lotus', '', 0, '1'),
(45, 14, 'Luqi', '', 0, '1'),
(46, 14, 'Marcos', '', 0, '1'),
(47, 14, 'Maserati', '', 0, '1'),
(48, 14, 'Mazda', '', 0, '1'),
(49, 14, 'McLaren', '', 0, '1'),
(50, 14, 'Mercedes-Benz', '', 0, '1'),
(51, 14, 'MG', '', 0, '1'),
(52, 14, 'Micro', '', 0, '1'),
(53, 14, 'Mini', '', 0, '1'),
(54, 14, 'Mitsubishi', '', 0, '1'),
(55, 14, 'Moskwitsch', '', 0, '1'),
(56, 14, 'Nieve', '', 0, '1'),
(57, 14, 'Nissan', '', 0, '1'),
(58, 14, 'Oldsmobile', '', 0, '1'),
(59, 14, 'Opel', '', 0, '1'),
(60, 14, 'Peugeot', '', 0, '1'),
(61, 14, 'Plymouth', '', 0, '1'),
(62, 14, 'Polestar', '', 0, '1'),
(63, 14, 'Pontiac', '', 0, '1'),
(64, 14, 'Porsche', '', 0, '1'),
(65, 14, 'Proton', '', 0, '1'),
(66, 14, 'Rainwoll', '', 0, '1'),
(67, 14, 'Reeder', '', 0, '1'),
(68, 14, 'Regal Raptor', '', 0, '1'),
(69, 14, 'Relive', '', 0, '1'),
(70, 14, 'Renault', '', 0, '1'),
(71, 14, 'RKS', '', 0, '1'),
(72, 14, 'Rolls-Royce', '', 0, '1'),
(73, 14, 'Rover', '', 0, '1'),
(74, 14, 'Saab', '', 0, '1'),
(75, 14, 'Saturn', '', 0, '1'),
(76, 14, 'Seat', '', 0, '1'),
(77, 14, 'Skoda', '', 0, '1'),
(78, 14, 'Smart', '', 0, '1'),
(79, 14, 'Subaru', '', 0, '1'),
(80, 14, 'Suzuki', '', 0, '1'),
(81, 14, 'Tata', '', 0, '1'),
(82, 14, 'Tesla', '', 0, '1'),
(83, 14, 'The London Taxi', '', 0, '1'),
(84, 14, 'Tofaş', '', 0, '1'),
(85, 14, 'Toyota', '', 0, '1'),
(86, 14, 'Vanderhall', '', 0, '1'),
(87, 14, 'Volkswagen', '', 0, '1'),
(88, 14, 'Volta', '', 0, '1'),
(89, 14, 'Volvo', '', 0, '1'),
(90, 14, 'XEV', '', 0, '1'),
(91, 14, 'Yuki', '', 0, '1'),
(92, 14, 'Zeekr', '', 0, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adres`
--
ALTER TABLE `adres`
  ADD PRIMARY KEY (`adres_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `ayar`
--
ALTER TABLE `ayar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Indexes for table `banka`
--
ALTER TABLE `banka`
  ADD PRIMARY KEY (`banka_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `favori`
--
ALTER TABLE `favori`
  ADD PRIMARY KEY (`favori_id`),
  ADD KEY `talep_id` (`talep_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `firma`
--
ALTER TABLE `firma`
  ADD PRIMARY KEY (`firma_id`),
  ADD KEY `kullanici_id` (`kullanici_id`);

--
-- Indexes for table `hakkimizda`
--
ALTER TABLE `hakkimizda`
  ADD PRIMARY KEY (`hakkimizda_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`),
  ADD UNIQUE KEY `kullanici_mail` (`kullanici_mail`);

--
-- Indexes for table `kullaniciiplog`
--
ALTER TABLE `kullaniciiplog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kullanici_mail` (`kullanici_mail`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `mesaj`
--
ALTER TABLE `mesaj`
  ADD PRIMARY KEY (`mesaj_id`),
  ADD KEY `talep_id` (`talep_id`),
  ADD KEY `kimden` (`kimden`),
  ADD KEY `kime` (`kime`);

--
-- Indexes for table `talep`
--
ALTER TABLE `talep`
  ADD PRIMARY KEY (`talep_id`),
  ADD KEY `kategori_id` (`kategori_id`) USING BTREE,
  ADD KEY `talep_marka` (`talep_marka`),
  ADD KEY `kullanici_id` (`kullanici_id`) USING BTREE;

--
-- Indexes for table `teklif`
--
ALTER TABLE `teklif`
  ADD PRIMARY KEY (`teklif_id`),
  ADD KEY `talep_id` (`talep_id`,`teklif_veren_kullanici_id`),
  ADD KEY `teklif_veren_kullanici_id` (`teklif_veren_kullanici_id`);

--
-- Indexes for table `vasitamarka`
--
ALTER TABLE `vasitamarka`
  ADD PRIMARY KEY (`marka_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adres`
--
ALTER TABLE `adres`
  MODIFY `adres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `banka`
--
ALTER TABLE `banka`
  MODIFY `banka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `favori`
--
ALTER TABLE `favori`
  MODIFY `favori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `firma`
--
ALTER TABLE `firma`
  MODIFY `firma_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=254;

--
-- AUTO_INCREMENT for table `kullaniciiplog`
--
ALTER TABLE `kullaniciiplog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `mesaj`
--
ALTER TABLE `mesaj`
  MODIFY `mesaj_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `talep`
--
ALTER TABLE `talep`
  MODIFY `talep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `teklif`
--
ALTER TABLE `teklif`
  MODIFY `teklif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `vasitamarka`
--
ALTER TABLE `vasitamarka`
  MODIFY `marka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adres`
--
ALTER TABLE `adres`
  ADD CONSTRAINT `adres_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `banka`
--
ALTER TABLE `banka`
  ADD CONSTRAINT `banka_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favori`
--
ALTER TABLE `favori`
  ADD CONSTRAINT `favori_ibfk_1` FOREIGN KEY (`talep_id`) REFERENCES `talep` (`talep_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favori_ibfk_2` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `firma`
--
ALTER TABLE `firma`
  ADD CONSTRAINT `firma_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kullaniciiplog`
--
ALTER TABLE `kullaniciiplog`
  ADD CONSTRAINT `kullaniciiplog_ibfk_1` FOREIGN KEY (`kullanici_mail`) REFERENCES `kullanici` (`kullanici_mail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mesaj`
--
ALTER TABLE `mesaj`
  ADD CONSTRAINT `mesaj_ibfk_1` FOREIGN KEY (`talep_id`) REFERENCES `talep` (`talep_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mesaj_ibfk_2` FOREIGN KEY (`kimden`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mesaj_ibfk_3` FOREIGN KEY (`kime`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `talep`
--
ALTER TABLE `talep`
  ADD CONSTRAINT `talep_ibfk_1` FOREIGN KEY (`kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `talep_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `talep_ibfk_3` FOREIGN KEY (`talep_marka`) REFERENCES `vasitamarka` (`marka_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teklif`
--
ALTER TABLE `teklif`
  ADD CONSTRAINT `teklif_ibfk_1` FOREIGN KEY (`talep_id`) REFERENCES `talep` (`talep_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teklif_ibfk_2` FOREIGN KEY (`teklif_veren_kullanici_id`) REFERENCES `kullanici` (`kullanici_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vasitamarka`
--
ALTER TABLE `vasitamarka`
  ADD CONSTRAINT `vasitamarka_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
