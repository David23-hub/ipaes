-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2024 at 02:33 PM
-- Server version: 10.6.17-MariaDB-cll-lve
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `intc3843_laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `po_id` varchar(50) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `item_category` varchar(20) DEFAULT NULL,
  `cart` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `management_order` tinyint(4) DEFAULT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `packing_at` timestamp NULL DEFAULT NULL,
  `packing_by` varchar(50) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `sent_by` varchar(50) DEFAULT NULL,
  `expedition_id` int(11) DEFAULT NULL,
  `shipping_cost` int(11) DEFAULT NULL,
  `recepient_number` varchar(100) DEFAULT NULL,
  `paid_at` varchar(100) DEFAULT NULL,
  `paid_by` varchar(50) DEFAULT NULL,
  `paid_bank_name` varchar(100) DEFAULT NULL,
  `paid_account_bank_name` varchar(100) DEFAULT NULL,
  `cancel_at` timestamp NULL DEFAULT NULL,
  `cancel_by` varchar(50) DEFAULT NULL,
  `cancel_reason` varchar(100) DEFAULT NULL,
  `nominal` varchar(100) DEFAULT NULL,
  `status_payment` int(11) DEFAULT NULL,
  `inv_no` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `po_id`, `doctor_id`, `item_category`, `cart`, `notes`, `management_order`, `due_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `status`, `packing_at`, `packing_by`, `sent_at`, `sent_by`, `expedition_id`, `shipping_cost`, `recepient_number`, `paid_at`, `paid_by`, `paid_bank_name`, `paid_account_bank_name`, `cancel_at`, `cancel_by`, `cancel_reason`, `nominal`, `status_payment`, `inv_no`) VALUES
(1, 'PO/2024/0522154229', 22, NULL, '7|paket|1|0|4800000', 'Dikirim dari pusat', 0, '2024-05-22 16:59:59', 'dennym.ipa@gmail.com', '2024-05-01 08:41:45', 'dennym.ipa@gmail.com', '2024-05-01 08:42:29', NULL, NULL, 1, '2024-05-02 02:49:40', 'Dedi Kadarisman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00001'),
(2, 'PO/2024/0501165552', 8, NULL, '31|product|1|100|880000,42|product|1|100|1800000,34|product|2|100|800000,36|product|2|100|800000,38|product|1|100|3500000,39|product|1|100|2520000,40|product|1|100|2420000', 'Elitox dan Exomide 15B pakai stok batam.\nUntuk produk lain tlg dikirim ke klinik dr. Lidyana.\nAkan dibawa ke pekanbaru oleh beliau.', 0, '2024-05-01 16:59:59', 'aditeka.ipa@gmail.com', '2024-05-01 09:52:12', 'Dedi Kadarisman', '2024-05-02 02:53:34', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 'INV/05/00002'),
(3, 'PO/2024/0522172711', 9, NULL, '31|product|2|30|880000', 'Tolong di bantu pengiriman sebelum jam 10.00 pengiriman by gojek instan dan ongkir di tanggung klinik', 0, '2024-05-22 16:59:59', 'teguhprakoso.ipa@gmail.com', '2024-05-01 10:26:14', 'teguhprakoso.ipa@gmail.com', '2024-05-01 10:27:11', NULL, NULL, 2, '2024-05-02 02:02:32', 'Dedi Kadarisman', '2024-05-02 02:08:31', 'Dedi Kadarisman', 1, 41000, 'gojek', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00003'),
(4, 'PO/2024/0501172758', 23, NULL, '38|product|5|30|3500000', 'Sudah lunas', 0, '2024-05-01 16:59:59', 'teguhprakoso.ipa@gmail.com', '2024-05-01 10:27:42', 'teguhprakoso.ipa@gmail.com', '2024-05-01 10:27:58', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00004'),
(5, 'PO/2024/0531185720', 26, NULL, '31|product|50|0|520000', 'Pakai stok bali , sisa 3 box', 0, '2024-05-31 16:59:59', 'yudhip.ipa@gmail.com', '2024-05-01 11:55:00', 'yudhip.ipa@gmail.com', '2024-05-01 11:57:20', NULL, NULL, 1, '2024-05-02 02:55:42', 'Dedi Kadarisman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00005'),
(7, 'PO/2024/0531202354', 10, NULL, '42|product|4|25|1800000', 'Dikirim pakai stock bandung, sisa 12 vial.', 0, '2024-05-31 16:59:59', 'riyan.ipa02@gmail.com', '2024-05-01 13:22:02', 'riyan.ipa02@gmail.com', '2024-05-01 13:23:54', NULL, NULL, 1, '2024-05-02 03:52:23', 'Dedi Kadarisman', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00006'),
(8, 'PO/2024/0509080438', 8, NULL, '31|product|5|0|880000,42|product|2|0|1800000,33|product|1|0|800000,34|product|1|0|800000,36|product|1|0|800000,38|product|1|0|3500000,39|product|1|0|2520000', 'Pembelanjaan dr. Rahmadhani.\nKirim ke alamat klinik, dokter sdh DP 8jt.', 0, '2024-05-09 16:59:59', 'aditeka.ipa@gmail.com', '2024-05-02 01:01:02', 'aditeka.ipa@gmail.com', '2024-05-02 01:04:38', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00007'),
(9, 'PO/2024/0601093729', 39, NULL, '42|product|2|25|1800000', '-pakai stok medan 2 vial exomide 15B\n-sisa stok medan 34 vial exomide 15B\n-diskon trial.', 0, '2024-06-01 16:59:59', 'latifahayu.ipa@gmail.com', '2024-05-02 02:34:23', 'latifahayu.ipa@gmail.com', '2024-05-02 02:37:29', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00008'),
(10, 'PO/2024/0601114411', 55, NULL, '42|product|5|0|1800000', 'no disc ....saving 25%', 0, '2024-06-01 16:59:59', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:42:42', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:44:11', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00009'),
(11, 'PO/2024/0523114709', 53, NULL, '42|product|4|25|1800000', 'mohon di kirim di alamat ini .... jl matraman salemba Gg.IX mangonsteen residence no 7F rt 4 rw 1 kebon mangis matraman', 0, '2024-05-23 16:59:59', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:44:29', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:47:09', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00010'),
(12, 'PO/2024/0523115423', 54, NULL, '42|product|1|25|1800000,49|product|1|30|950000', 'mohon di bantu di kirim alamat jl pemuda ,taman berdikari sentosa blok L16 jakarta timur 13220', 0, '2024-05-23 16:59:59', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:47:40', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:54:23', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INV/05/00011');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'paket', 1, 'david@gmail.com', '2024-02-20 07:30:52', 'david@gmail.com', '2024-02-20 07:35:36', NULL, NULL),
(2, 'product', 1, 'david@gmail.com', '2024-02-20 07:30:57', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `clinic` text DEFAULT NULL,
  `information` text DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `billing_no_hp` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `visible_lower` int(11) NOT NULL DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `name`, `address`, `clinic`, `information`, `dob`, `no_hp`, `billing_no_hp`, `status`, `visible_lower`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'dr david', 'jl alpukat jeruk salak no 123456 jakarta barat daya timur tenggara selatan barat daya barat barat laut utara timur laut', 'jl alpukat jeruk salak no 123456 jakarta barat daya timur tenggara selatan barat daya barat barat laut utara timur laut', 'information', '2000-04-05', '081270861076', '081270861076', 1, 1, 'davidb', '2024-03-17 00:20:18', 'superuser@gmail.com', '2024-05-01 09:40:19', 'superuser@gmail.com', '2024-05-01 09:43:00'),
(2, 'dr test', 'alamt dokter', 'clinic address', 'dsadas', '2024-04-07', '081270861076', '081270861076', 1, 1, 'davidb', '2024-04-07 10:18:22', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:43:19'),
(3, 'corent', 'jl. perkutut 11 no. 300', 'zz klinik', NULL, '2024-04-27', '08193948291', '08193948291', 1, 1, 'superuser', '2024-04-27 04:09:21', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:43:06'),
(4, 'q', 'q', 'q', NULL, '3133-02-23', '1', '123', 1, 0, 'manager', '2024-04-27 17:29:13', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:43:23'),
(5, 'qq', 'q', 'q', 'qwe13', '3211-03-21', '1', '123', 1, 0, 'marketing', '2024-04-27 17:29:46', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:43:10'),
(6, 'test markt', 'test markt', 'test markt', 'test markt', '2133-03-12', '123', '123', 1, 0, 't', '2024-04-27 17:58:28', 'superuser@gmail.com', '2024-05-01 09:41:00', 'superuser@gmail.com', '2024-05-01 09:43:14'),
(7, 'dok chris', 'alamat klinik', 'clinic chris', NULL, '2024-04-28', '08287472369134', '09828834729324', 1, 1, 'superuser', '2024-04-28 09:09:57', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:43:33'),
(8, 'Dr Rahmadhani', 'Jl. HR Soebrantas, No. 92, Kec Tampan, Pekanbaru 28294', 'MAYERD Clinic', NULL, '2024-05-01', '08117676686', '0895393229010', 1, 0, 'Adit', '2024-05-01 00:44:09', 'superuser@gmail.com', '2024-05-01 09:40:56', NULL, NULL),
(9, 'Dr lidyana', 'Jl. Baladewa No.30, RT.6/RW.5, Tanah Tinggi, Kec. Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10540', 'Dr lidyana', NULL, '1988-08-31', '082155604357', '082155604357', 1, 0, 'Teguh Prakoso', '2024-05-01 05:44:40', 'superuser@gmail.com', '2024-05-01 09:40:33', NULL, NULL),
(10, 'dr. Dina Utari Almi, M.Biomed (AAM),Dipl.CIBTAC', 'Jl. Pamagersari, No.2 ,Rt.02 Rw.13c, Majalaya, Kec.Majalaya, Kab.Bandung 40382', 'Ardami Aesthetic  Clinic', NULL, '1989-12-24', '081373352853', '081373352853', 1, 0, 'Riyan Septian', '2024-05-01 07:24:50', 'superuser@gmail.com', '2024-05-01 09:40:43', NULL, NULL),
(11, 'Dr. Arief Andri SpKK', 'Perum Dutamas, blok A5 No,8, Baloi Permai, Batam 29431', 'Pribadi', NULL, '2024-05-01', '0895614617303', '0895614617303', 1, 0, 'Adit', '2024-05-01 07:36:07', NULL, NULL, NULL, NULL),
(12, 'Dr. Aulia Dian A', 'Apt Devi Farma, Jl. A yani Sei Pasir, No.35, Meral, Kab Karimun 29664', 'Dev Skin', NULL, '2024-05-01', '085668888827', '085668888827', 1, 0, 'Adit', '2024-05-01 07:38:32', 'superuser@gmail.com', '2024-05-01 09:40:29', NULL, NULL),
(13, 'Dr T Rini Puspasari', 'Jl. Teratai Atas, No.234 DE, Sukajadi Pekanbaru 28121', 'The Rose Clinic', NULL, '2024-05-01', '08117525251', '08117525251', 1, 0, 'Adit', '2024-05-01 07:41:07', 'superuser@gmail.com', '2024-05-01 09:41:04', NULL, NULL),
(14, 'Dr Daicy Atmadji', 'Jl. Pembangunan Ruko Baloi Kusuma Indah, Blok A No.6, Batam 29444', 'DRDA', NULL, '2024-05-01', '08127076763', '08127076763', 1, 0, 'Adit', '2024-05-01 07:48:25', NULL, NULL, NULL, NULL),
(15, 'Dr. Herawati', 'Jl. Lintas Riau - Sumatera (RPS), Kel Banjar XII, Kec Tanah Putih, Kab Rokan Hilir, Riau 28985', 'Quenn Beauty Care', 'Pengiriman selalu pakai JNE, karena Tiki tdk ada cabang.', '2024-05-01', '081267500441', '081267500441', 1, 0, 'Adit', '2024-05-01 07:52:08', 'superuser@gmail.com', '2024-05-01 09:42:08', NULL, NULL),
(16, 'Dr Monica', 'Gang Pauh Air Lakon, Kec Bunguran Timur, Ranai Kota, Kab Natuna 29777. (Rumah yang ada taman bunga dan plang dr. Monica).', 'Pribadi', 'Pengiriman selalu pakai JNE atau Lion Air', '2024-05-01', '081266319831', '081266319831', 1, 0, 'Adit', '2024-05-01 07:56:02', 'superuser@gmail.com', '2024-05-01 09:41:55', NULL, NULL),
(17, 'Dr. Mungky Sukarnadi SpKK', 'Jl Raja Ali Haji No.6, Tj Ayun Sakti, Kec Bukit Bestari, Tj Pinang 29122, Apt QNATH', 'Lettice Clinic', NULL, '1984-07-13', '081281111713', '081281111713', 1, 0, 'Adit', '2024-05-01 08:01:03', NULL, NULL, NULL, NULL),
(18, 'Dr. Nurrahmah Kurniati', 'Komp Baloi Rantau Blok D No.6, Sukajadi, Batam 29444 (Masuk dari samping Polresta Batam)', 'Pribadi', NULL, '2024-05-01', '082392117243', '082392117243', 1, 0, 'Adit', '2024-05-01 08:03:34', 'superuser@gmail.com', '2024-05-01 09:41:32', NULL, NULL),
(19, 'Dr. Okta Siahaan', 'Jl. Darma Bakti No.28B, Labuh Baru Barat, Kec Payung Sekaki, Pekanbaru 28292', 'Djasur', NULL, '2024-05-01', '081273013160', '081273013160', 1, 0, 'Adit', '2024-05-01 08:04:58', 'superuser@gmail.com', '2024-05-01 09:41:18', NULL, NULL),
(20, 'Dr. Paola Hermawan', 'Jl. Riau, Komp Riau Bussines Center, Blok D-19, Pekanbaru 28292', 'Hera Beauty Clinic', NULL, '2024-05-01', '081362451992', '081362451992', 1, 0, 'Adit', '2024-05-01 08:06:26', 'superuser@gmail.com', '2024-05-01 09:40:52', NULL, NULL),
(21, 'Dr. Stella Verinda Dipl.AAAM', 'Jl. Gardenia, No.20 Harjosari, Kec Sukajadi. Pekanbaru 28122', 'Grasia Clinic', NULL, '2024-05-01', '081384892233', '081384892233', 1, 0, 'Adit', '2024-05-01 08:11:54', 'superuser@gmail.com', '2024-05-01 09:42:29', NULL, NULL),
(22, 'dr. Aisyah Luftia Pato', 'Jl. Brigjend H. Hasan Basri No.15, Semayap, Kec. Pulau Laut Utara, Kab. Kotabaru, Kalimantan Selatan 72113', 'Lutfiaskin Klinik', NULL, '1985-11-02', '081354889372', '081354889372', 1, 0, 'Muhammad Denny Murjaya', '2024-05-01 08:40:35', NULL, NULL, NULL, NULL),
(23, 'Dr bella louisa widjaja', 'Jl. Kelapa Cengkir Raya No.23 Blok CD1, RT.8/RW.12, Klp. Gading Tim., Kec. Klp. Gading, Jakarta, Daerah Khusus Ibukota Jakarta 14240', 'Bella derma', NULL, '1995-02-22', '08118287078', '08118287078', 1, 0, 'Teguh Prakoso', '2024-05-01 10:25:35', 'Intipersada.aes@gmail.com', '2024-05-01 11:28:20', NULL, NULL),
(26, 'Dr Maya Pramudhita', 'Jl. Palapa I no. 8A , Cilinaya , Cakranegara, mataram , NTB, 83238', 'The Clinic Mataram', NULL, '1983-02-01', '0818537101', '0818537101', 1, 0, 'Yohanes Eko Yudhi Pristianto', '2024-05-01 11:53:43', NULL, NULL, NULL, NULL),
(27, 'Dr. Theresia Merdeka Putri', 'Jl. Teratai No. 234, Pulau Karam, Kec Sukajadi, Pekanbaru 28156', 'Putri Merdeka', NULL, '2024-05-01', '081392715125', '081392715125', 1, 0, 'Adit', '2024-05-01 12:18:41', NULL, NULL, NULL, NULL),
(28, 'Dr Ummi Hani', 'Ruko Orchard Walk, Blok K-10, Agung Podomoro Land, Belian, Batam 29464', 'D\' Aesthetic', NULL, '2024-05-01', '082166133220', '082166133220', 1, 0, 'Adit', '2024-05-01 12:19:56', 'superuser@gmail.com', '2024-05-02 04:37:48', NULL, NULL),
(29, 'Dr Yosi Charly SpKK', 'Jl. R Oesman No.83, Batu Lipai, Tj Balai Karimun 29663', 'Fazskin Dermatology', NULL, '1980-04-22', '081277223366', '081277223366', 1, 0, 'Adit', '2024-05-01 12:22:07', 'superuser@gmail.com', '2024-05-02 04:30:51', NULL, NULL),
(30, 'Yosi Andra SpKK', 'Jl. Daeng Manambon No.17, Kel Tengah, Kec Mempawah Hilir. Mempawah Kal-Bar 78911', 'Pribadi', NULL, '2024-05-01', '082160304465', '082160304465', 1, 0, 'Adit', '2024-05-01 12:24:04', 'superuser@gmail.com', '2024-05-02 04:30:34', NULL, NULL),
(31, 'Dr Adrian Saleh M', 'Komp Botania 2, Blok B2 No.2A - 2B & 5, Batam 29433', 'Evoluskin', NULL, '1984-11-23', '087842032056', '087842032056', 0, 0, 'Adit', '2024-05-01 12:25:57', NULL, NULL, NULL, NULL),
(32, 'Dr Amelia Fenowati', 'One Mall Batam, Ground floor, Unit No.2, Teluk Tering, Batam Kota, Batam 29444', 'Ilucent', NULL, '2024-05-01', '081390001116', '081390001116', 1, 0, 'Adit', '2024-05-01 12:27:37', 'superuser@gmail.com', '2024-05-02 04:29:49', NULL, NULL),
(33, 'dr. Mira Shofiya', 'Jl. Sukamulus No.284/143C, RT.04 RW.01,Kel.Cicadas, Kec.Cibeunying kidul, Kota Bandung 40121', 'Apotek Dafa Farma', NULL, '1981-09-02', '081322019274', '081322019274', 1, 0, 'Riyan Septian', '2024-05-01 13:38:44', NULL, NULL, NULL, NULL),
(34, 'dr. Alisya Wijaya', 'Kav. Pondok Dustira no 15 Ds. Gadobangkong Kec. Ngamprah, Kabupaten. Bandung Barat, jawa barat 40552', 'Praktek dr. Alisya', NULL, '1993-01-06', '081122211177', '0811 2221 1177', 1, 0, 'Riyan Septian', '2024-05-01 13:42:46', NULL, NULL, NULL, NULL),
(35, 'dr. Aflah Hanifa', 'Jl. Raya Cikukulu no.205 rt/rw. 019/005 kel.Cisande, kec.Cicantayan, Kab. Sukabumi, Jawa Barat 43155', 'Klinik Honeyfa Aesthetic', NULL, '1991-03-12', '085720049848', '085720049848', 1, 0, 'Riyan Septian', '2024-05-01 13:45:58', 'superuser@gmail.com', '2024-05-02 04:30:14', NULL, NULL),
(36, 'dr. Dhea Nur Puspita', 'Kp.sibanteng no.8 rt.04 rw.03 kel.sibanteng, Kec.Leuwisadeng, Kabupaten Bogor, Jawa Barat 16640', 'Apotek sibanteng', NULL, '1996-09-10', '082123003263', '082123003263', 1, 0, 'Riyan Septian', '2024-05-01 13:52:33', 'superuser@gmail.com', '2024-05-02 04:30:01', NULL, NULL),
(37, 'test dokter', 'asdasdasd', 'adsadas', NULL, '2024-05-02', '123', '123', 1, 1, 'davidb', '2024-05-02 02:22:47', NULL, NULL, 'david@gmail.com', '2024-05-02 02:22:52'),
(38, 'Endika(pak Edo)', 'Jl. Andi tonton /perumahan griya pena mas blok B no 1,depan kantor pos/kota makassar', 'Rumah pribadi', 'Rumah paling sudut dekat taman', '1988-02-15', '081331923748', '081331923748', 1, 0, 'Endika', '2024-05-02 02:30:42', NULL, NULL, NULL, NULL),
(39, 'dr. Netty masliana', 'Jln. Tangguk bongkar III No.68, Kel: Tegal sari mandala II. Kec.Medan denai. Perumnas mandala.medan', 'Serena beauty clinic', NULL, '2024-05-02', '081310239599', '081310239599', 1, 0, 'Ayu', '2024-05-02 02:32:53', NULL, NULL, NULL, NULL),
(40, 'test dokter', 'test alamat', 'tesst clinic', NULL, '2024-05-02', '123213', '12321313', 1, 0, 'marketing', '2024-05-02 02:41:06', NULL, NULL, 'marketing@gmail.com', '2024-05-02 02:41:09'),
(41, 'Dr. Richard', 'Kuningan City', 'Berkah', NULL, '1998-01-18', '08111043518', '08111043518', 1, 0, 'marketing', '2024-05-02 02:42:49', NULL, NULL, NULL, NULL),
(42, 'Dr william', 'jalan kembangan', 'clinik sejahtera', NULL, '2001-06-02', '081638291130', '081274931234', 1, 0, 'marketing', '2024-05-02 02:46:47', NULL, NULL, NULL, NULL),
(43, 'Dr. dr. Kemas Abdurrohim Sp.Ak MARS M.Kes', 'Jl. Proklamasi bla bla bla bla bla', 'Divine Klinik', NULL, '1966-10-10', '0811869992', '0811869992', 1, 0, 'marketing', '2024-05-02 02:53:28', NULL, NULL, 'david@gmail.com', '2024-05-02 03:08:03'),
(44, 'dr. Devy Dipl. AAAM', 'Jl. Pangeran Hidayatullah, Benua Anyar, Kec. Banjarmasin Tim., Kota Banjarmasin, Kalimantan Selatan 70239', 'Devanka Aesthetic Clinic', NULL, '1990-07-08', '087885555882', '087885555882', 1, 0, 'Muhammad Denny Murjaya', '2024-05-02 03:03:30', NULL, NULL, NULL, NULL),
(45, 'dr. Adli Arhani', 'Jln. K.H. Zainul Arifin No.171 A-B, Madras hulu. Kec. Medan polonia. kota medan', 'Luminese Aesthetic clinic', NULL, '1985-10-03', '085275086114', '085361349977', 1, 0, 'Ayu', '2024-05-02 03:56:25', NULL, NULL, NULL, NULL),
(46, 'dr. Ayu Adila Nasution', 'Jln. Letda sujono No. 244 Medan', 'UK beauty clinic', NULL, '2024-04-16', '085270670279', '085270670279', 1, 0, 'Ayu', '2024-05-02 04:01:46', NULL, NULL, NULL, NULL),
(47, 'dr. Musda', 'Jln Pasar III Krakatau, No. 88 Medan. kel. glugur darat I,kecamatan medan timur.kode pos 20238.medan', 'Jinan Beauty', NULL, '2024-05-02', '08116113119', '08116113119', 1, 0, 'Ayu', '2024-05-02 04:05:39', NULL, NULL, NULL, NULL),
(48, 'Dr Testing', 'jalan sejahtera rajawali', 'sumber berkah', NULL, '1988-01-02', '081637261183', '081633821745', 1, 0, 'Teguh Prakoso', '2024-05-02 04:06:57', NULL, NULL, 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:12:25'),
(49, 'Dr testing 2', 'alamat testing 123', 'clinic testing 123', NULL, '1998-01-18', '08111043518', '08111043518', 1, 0, 'Teguh Prakoso', '2024-05-02 04:10:12', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:12:48', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:27:06'),
(50, 'dr. ika Lestari Siregar', 'Jln. Flamboyan baru no. 14 Kel. Tanjung Selamat.Kec. medan tuntungan', 'Prakter dr. Ika lestari siregar', NULL, '2024-05-02', '082273291895', '082273291895', 1, 0, 'Ayu', '2024-05-02 04:10:51', NULL, NULL, NULL, NULL),
(51, 'CV. Toga Mandiri Anugerah Perkasa', 'Jln K.H. wahid Hasyim No.60 A, babura kec: Medan baru kota medan.sumatera utara 20153', 'klinixxSlimThe Premiere Aesthetic Clinic', NULL, '2024-05-02', '08116045138', '08116045138', 1, 0, 'Ayu', '2024-05-02 04:14:51', NULL, NULL, NULL, NULL),
(52, 'dr. Kiki Rizki Dwiyanti', 'Jln. STM, Komplek Artha Vista', 'Ariana Audy Aesthetic', NULL, '1991-08-03', '082361449991', '082361449991', 1, 0, 'Ayu', '2024-05-02 04:19:07', NULL, NULL, NULL, NULL),
(53, 'Dr Kemas Abdurrohim Sp.Ak MARS M Kes', 'jl Proklamasi No 61A Menteng jakpus Rt 07 / Rw 03 pengangsaan jakarta,central city jakarta 10320', 'divine klinik', NULL, '1966-10-10', '0811869992', '0811869992', 1, 0, 'Teguh Prakoso', '2024-05-02 04:30:46', NULL, NULL, NULL, NULL),
(54, 'dr fika putri aesthetic', 'jl raya gading indah no8 blok A8 klp gading timur . kec klp gading jakarta utara 14240', 'Skinmats', NULL, '1985-09-19', '081296620002', '081296620002', 1, 0, 'Teguh Prakoso', '2024-05-02 04:37:22', 'superuser@gmail.com', '2024-05-02 04:39:36', NULL, NULL),
(55, 'dr chandra lohisto', 'jl batu ceper no2F kb klp kecamatan gambir kota jakarta pusat 10120', 'stay beauty', NULL, '1985-05-17', '0816910230', '082121081855', 1, 0, 'Teguh Prakoso', '2024-05-02 04:41:53', 'teguhprakoso.ipa@gmail.com', '2024-05-02 04:43:35', NULL, NULL),
(56, 'test dabun', 'test dabun', 'test dabun', NULL, '2024-05-23', '12345678', '123456789', 1, 1, 'davidb', '2024-05-02 04:53:52', NULL, NULL, 'david@gmail.com', '2024-05-02 04:54:07'),
(57, 'hsnsnsn', 'test dabun', 'test dabun', NULL, '2024-05-23', '12345678', '123456789', 0, 1, 'davidb', '2024-05-02 04:54:00', NULL, NULL, 'david@gmail.com', '2024-05-02 04:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ekspedisi`
--

INSERT INTO `ekspedisi` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'JNE', 0, 'david@gmail.com', '2024-03-17 00:22:41', NULL, NULL, NULL, NULL),
(2, 'dasd asd as', 0, 'david@gmail.com', '2024-03-17 07:18:15', NULL, NULL, 'david@gmail.com', '2024-03-17 07:19:45'),
(3, '321 1', 0, 'david@gmail.com', '2024-03-17 07:19:43', 'david@gmail.com', '2024-03-17 07:20:32', 'david@gmail.com', '2024-03-20 23:39:49'),
(4, 'TIKI', 1, 'superuser@gmail.com', '2024-04-16 13:51:51', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `extra_charge`
--

CREATE TABLE `extra_charge` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `dokter_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `extra_charge`
--

INSERT INTO `extra_charge` (`id`, `transaction_id`, `price`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `dokter_id`) VALUES
(1, 3, 20000, 'Gojek', '2024-05-02 02:01:30', 'dedi.ipa@gmail.com', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flights_user`
--

CREATE TABLE `flights_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_number`
--

CREATE TABLE `invoice_number` (
  `month` int(11) DEFAULT NULL,
  `counting` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice_number`
--

INSERT INTO `invoice_number` (`month`, `counting`) VALUES
(5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `unit` varchar(10) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `presentation` varchar(255) DEFAULT NULL,
  `mini_desc` varchar(255) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `commision_rate` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `qty_min` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `qty`, `unit`, `price`, `presentation`, `mini_desc`, `desc`, `commision_rate`, `status`, `img`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`, `qty_min`) VALUES
(1, 'batik1', -9, 'Box', 1000000, 'preksnlaas', 'mini desc1', 'desc1', 10, 1, '1710907683.jpg', 'david@gmail.com', '2024-03-19 21:08:03', 'david@gmail.com', '2024-04-04 06:53:06', 'superuser@gmail.com', '2024-05-01 09:44:33', 100),
(2, 'batik2', 130, 'Box', 200000, 'preksnlaas', 'mini desc2', 'desc2', 10, 1, '1710907701.png', 'david@gmail.com', '2024-03-19 21:08:21', 'david@gmail.com', '2024-03-19 21:13:53', 'superuser@gmail.com', '2024-05-01 09:44:37', 10),
(3, 'batik3', 287, 'Box', 300000, 'pdsmakdlas', 'mini desc3', 'desc3', 10, 1, '', 'david@gmail.com', '2024-03-19 21:08:42', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:44:41', 10),
(16, 'david', 10000, 'Box', 10000, 'presentation', 'mini desc', 'desc', 10, 1, '', 'david@gmail.com', '2024-03-20 00:13:47', NULL, NULL, 'david@gmail.com', '2024-03-20 23:36:22', 10),
(17, 'te', 121, 'Box', 12222, 'dsa', 'dea', 'ea', 12, 0, '1711002951.png', 'david@gmail.com', '2024-03-20 23:35:51', 'david@gmail.com', '2024-03-20 23:35:57', 'david@gmail.com', '2024-03-20 23:36:21', 10),
(18, 'asd', 123, 'Box', 123, '123', '13321', '1123123', 123, 0, '1711002977.png', 'david@gmail.com', '2024-03-20 23:36:17', NULL, NULL, 'david@gmail.com', '2024-03-20 23:36:25', 10),
(19, 'asdasd', 100, 'Box', 10000, 'asdn1', 'asdn,', 'asdnkasd', 2, 1, '', 'david@gmail.com', '2024-03-20 23:38:37', 'david@gmail.com', '2024-03-24 07:29:36', 'david@gmail.com', '2024-04-03 16:59:25', 10),
(20, 'test item', 20, 'Box', 1203, '1sad', '213sa', 'sad', 2.5, 1, '', 'david@gmail.com', '2024-03-24 07:30:38', NULL, NULL, 'david@gmail.com', '2024-04-03 16:59:27', 10),
(21, 'tes', 1111, 'Box', 1, '1', '1', '1', 1, 1, '', 'david@gmail.com', '2024-04-01 08:23:24', 'david@gmail.com', '2024-04-01 08:23:37', 'david@gmail.com', '2024-04-01 08:23:40', 111),
(22, 'test productt', 1, 'Box', 1, '1', '1', '1', 1, 1, '', 'david@gmail.com', '2024-04-06 05:37:34', NULL, NULL, 'david@gmail.com', '2024-04-06 05:38:20', 1),
(23, 'bando', 245, 'Box', 2000000, 'bando', 'bando', 'bando anak', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:53:41', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:44:45', 100),
(24, 'baju anak', 295, 'Box', 500000, 'baju anak', 'baju anak', 'baju anak', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:54:29', 'superuser@gmail.com', '2024-04-22 07:57:38', 'superuser@gmail.com', '2024-05-01 09:44:58', 100),
(25, 'celana kerja', 145, 'Box', 700000, 'celana kerja', 'celana kerja', 'celana kerja', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:55:11', 'superuser@gmail.com', '2024-04-22 07:57:46', 'superuser@gmail.com', '2024-05-01 09:45:03', 50),
(26, 'batik4', 494, 'Box', 1300000, 'batik', 'batik', 'batik', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:55:56', 'superuser@gmail.com', '2024-04-22 07:57:55', 'superuser@gmail.com', '2024-05-01 09:45:07', 100),
(27, 'batik5', 498, 'Box', 1000000, 'batik', 'batik', 'batik', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:56:40', 'superuser@gmail.com', '2024-04-22 07:57:26', 'superuser@gmail.com', '2024-05-01 09:45:10', 100),
(28, 'batik6', 498, 'Box', 1000000, 'batik', 'batik', 'batik', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:56:40', 'superuser@gmail.com', '2024-04-22 07:57:17', 'superuser@gmail.com', '2024-05-01 09:45:14', 100),
(29, 'mainan', 198, 'Box', 300000, 'mainan', 'mainan', 'mainan', 2, 1, '', 'superuser@gmail.com', '2024-04-22 07:58:27', NULL, NULL, 'superuser@gmail.com', '2024-05-01 09:45:17', 100),
(30, 'FA XL', 35, 'Box', 3350000, '2 VIALS (5 ML & 45 ML) / BOX', 'Fast and physiological fat reduction', 'Ascorbic acid dan Trivalent iron memicu apoptosis adiposit - proses biologis yang mengurangi jumlah sel tanpa pelepasan mediator inflamasi.', 3, 1, '', 'superuser@gmail.com', '2024-04-30 09:19:14', NULL, NULL, NULL, NULL, 100),
(31, 'Elitox 100iu', 1492, 'Box', 880000, 'Botulinum Toxin Type A', 'Botulinum toxin is a protein neurotoxin produced by the bacteria Clostridium botulinum', 'In cosmetology, botulinum toxin is used in anti-ageing procedures. The purpose of the injections is to eliminate age-related defects in the form of hyperkinetic wrinkles on the face and neck, which are caused by an increase in the tone of facial muscles. After injections of botulinum toxin, the transmission of nerve impulses to muscle fibres is blocked, muscle contraction becomes impossible, it relaxes, as a result wrinkles are smoothed.', 2, 1, '1714487424.jpeg', 'superuser@gmail.com', '2024-04-30 11:24:35', 'superuser@gmail.com', '2024-04-30 14:30:24', NULL, NULL, 1000),
(32, 'Elitox 200iu', 0, 'Box', 1600000, 'Botulinum Toxin Type A', 'Botulinum toxin is a protein neurotoxin produced by the bacteria Clostridium botulinum', 'In cosmetology, botulinum toxin is used in anti-ageing procedures. The purpose of the injections is to eliminate age-related defects in the form of hyperkinetic wrinkles on the face and neck, which are caused by an increase in the tone of facial muscles. After injections of botulinum toxin, the transmission of nerve impulses to muscle fibres is blocked, muscle contraction becomes impossible, it relaxes, as a result wrinkles are smoothed.', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:32:33', 'superuser@gmail.com', '2024-04-30 11:32:58', NULL, NULL, 10),
(33, 'Avalon Fine Plus', 58, 'Box', 800000, '-', 'AN OPTIMAL COMBINATION OF VISCOSITY AND ELASTICITY', 'Each product is a perfect combination of hyaluronic acid and cross-linking agent, which allows the practitioner to work with a wide range of patient requests and desires. AVALON™ Fillers are used for correction of wrinkles and lines of different depth, restoration of volume loss, lip augmentation, and correction of the face contours.', 2, 1, '1714487530.jpeg', 'superuser@gmail.com', '2024-04-30 11:34:31', 'superuser@gmail.com', '2024-04-30 14:32:10', NULL, NULL, 40),
(34, 'Avalon Vital Plus', 28, 'Box', 800000, '-', 'AN OPTIMAL COMBINATION OF VISCOSITY AND ELASTICITY', 'Each product is a perfect combination of hyaluronic acid and cross-linking agent, which allows the practitioner to work with a wide range of patient requests and desires. AVALON™ Fillers are used for correction of wrinkles and lines of different depth, restoration of volume loss, lip augmentation, and correction of the face contours.', 2, 1, '1714487516.jpeg', 'superuser@gmail.com', '2024-04-30 11:36:12', 'superuser@gmail.com', '2024-04-30 14:31:56', NULL, NULL, 40),
(35, 'Avalon Ultra Plus', 0, 'Box', 800000, '-', 'AN OPTIMAL COMBINATION OF VISCOSITY AND ELASTICITY', 'Each product is a perfect combination of hyaluronic acid and cross-linking agent, which allows the practitioner to work with a wide range of patient requests and desires. AVALON™ Fillers are used for correction of wrinkles and lines of different depth, restoration of volume loss, lip augmentation, and correction of the face contours.', 2, 1, '1714487501.jpeg', 'superuser@gmail.com', '2024-04-30 11:37:18', 'superuser@gmail.com', '2024-04-30 14:31:41', NULL, NULL, 40),
(36, 'Avalon Grand Plus', 234, 'Box', 800000, '-', 'AN OPTIMAL COMBINATION OF VISCOSITY AND ELASTICITY', 'Each product is a perfect combination of hyaluronic acid and cross-linking agent, which allows the practitioner to work with a wide range of patient requests and desires. AVALON™ Fillers are used for correction of wrinkles and lines of different depth, restoration of volume loss, lip augmentation, and correction of the face contours.', 2, 1, '1714487489.jpeg', 'superuser@gmail.com', '2024-04-30 11:38:40', 'superuser@gmail.com', '2024-04-30 14:31:29', NULL, NULL, 200),
(37, 'Crystal Hydro PDRN', 20, 'Box', 3200000, '2,2ml x 3 Syringe', 'Moisturising & Firming the skin', 'Combining the most effective revitalising ingredients - polynucleotides (PDRN), niacinamide and hyaluronic acid, - Crystal Hydro PDRN becomes a powerful anti-ageing solution that provides hydration to the skin, improving its tone and elasticity', 2, 1, '1714487475.jpeg', 'superuser@gmail.com', '2024-04-30 11:41:13', 'superuser@gmail.com', '2024-05-01 13:48:22', NULL, NULL, 50),
(38, 'Velancia PLACL Molding COG', 71, 'Box', 3500000, '19g/100mm PLACL', 'Velancia Molding COG threads are specially designed to eliminate medium depth wrinkles and provide a lifting effect on the face and body', 'Velancia Molding COG threads are specially designed to eliminate medium depth wrinkles and provide a lifting effect on the face and body.\r\n\r\nThe special cone-shaped barbs in Velancia Molding COG threads provide a strong fixation of the thread to tissue and a visible lifting effect.', 2, 1, '1714487438.jpeg', 'superuser@gmail.com', '2024-04-30 11:44:08', 'superuser@gmail.com', '2024-04-30 14:30:38', NULL, NULL, 30),
(39, 'PCL COG Mirako 1950', 29, 'Box', 2520000, '19g x 50mm', 'Velancia Mirako threads are designed for correcting the height and shape of the nose by inserting the thread into the nasal septum, which separates the left and right nostrills', 'Velancia Mirako threads are designed for correcting the height and shape of the nose by inserting the thread into the nasal septum, which separates the left and right nostrills.\r\n\r\nAfter the procedure,the subcutaneous tissue at the insertion site is supported and the nose can be reshaped in the desired way, as well as held at a positon higher than the original height. This also leads to the imporvement of the tip of the nose.\r\n\r\nVelancia Mirako threads are suitable for patients who desire to make some changes in the nose shape without rhipnoplasty surgery.', 2, 1, '1714487452.jpeg', 'superuser@gmail.com', '2024-04-30 11:46:02', 'superuser@gmail.com', '2024-04-30 14:30:52', NULL, NULL, 30),
(40, 'PCL COG Mirako 1938', 25, 'Box', 2420000, '19g x 38mm', 'Velancia Mirako threads are designed for correcting the height and shape of the nose by inserting the thread into the nasal septum, which separates the left and right nostrills', 'Velancia Mirako threads are designed for correcting the height and shape of the nose by inserting the thread into the nasal septum, which separates the left and right nostrills.\r\n\r\nAfter the procedure,the subcutaneous tissue at the insertion site is supported and the nose can be reshaped in the desired way, as well as held at a positon higher than the original height. This also leads to the imporvement of the tip of the nose.\r\n\r\nVelancia Mirako threads are suitable for patients who desire to make some changes in the nose shape without rhipnoplasty surgery.', 2, 1, '1714487570.jpeg', 'superuser@gmail.com', '2024-04-30 11:47:48', 'superuser@gmail.com', '2024-04-30 14:32:50', NULL, NULL, 30),
(41, 'PCL MeshBroom', 0, 'Box', 2700000, '21g x 60mm', 'Velancia Broom consists of 16PCL Mono threads in one Cannula', 'Velancia Broom consists of 16PCL Mono threads in one Cannula. Due to the unique composition of 16 threads, Broom threads can reach multiple areas on the face and body when inserted, which leads to a stronger boost of collagen compared to a nomal single thread.\r\n\r\nVelancia Broom threads can also be inserted into wide and flat areas to provide more elasticity to the skin.', 2, 1, '1714487552.jpeg', 'superuser@gmail.com', '2024-04-30 11:49:07', 'superuser@gmail.com', '2024-04-30 14:32:32', NULL, NULL, 30),
(42, 'Exomide Plus 15B', 483, 'Vial', 1800000, '5ml', 'Boosting effect of EXOMIDE ampoule that fills up from the deepest part of the skin', 'You can feel revitalizing & boosting effect that fills up from deep inside the skin. Amazing absorbing power of Mesenchymal Stem Cell Secretomes (EXOSOME) is the most important point in developing our skin & scalp full of vitality by taking care of the fundamental part of our skin & scalp.\r\n\r\nEXOMIDE AMPOULE\r\n\r\nGets absorbed deep into the skin and helps to deliver and absorb the nutrition needed for skin & scalp cells that make up the skin & scalp.', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:50:18', 'superuser@gmail.com', '2024-04-30 11:51:56', NULL, NULL, 120),
(43, 'Exomide Scalp', 85, 'Vial', 1300000, '5ml', 'Boosting effect of EXOMIDE ampoule that fills up from the deepest part of the skin', 'You can feel revitalizing & boosting effect that fills up from deep inside the skin. Amazing absorbing power of Mesenchymal Stem Cell Secretomes (EXOSOME) is the most important point in developing our skin & scalp full of vitality by taking care of the fundamental part of our skin & scalp.\r\n\r\nEXOMIDE AMPOULE\r\n\r\nGets absorbed deep into the skin and helps to deliver and absorb the nutrition needed for skin & scalp cells that make up the skin & scalp.', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:51:40', 'superuser@gmail.com', '2024-04-30 13:27:35', NULL, NULL, 30),
(44, 'Exomide 5B', 68, 'Vial', 1150000, '5ml', 'Boosting effect of EXOMIDE ampoule that fills up from the deepest part of the skin', 'You can feel revitalizing & boosting effect that fills up from deep inside the skin. Amazing absorbing power of Mesenchymal Stem Cell Secretomes (EXOSOME) is the most important point in developing our skin & scalp full of vitality by taking care of the fundamental part of our skin & scalp.\r\n\r\nEXOMIDE AMPOULE\r\n\r\nGets absorbed deep into the skin and helps to deliver and absorb the nutrition needed for skin & scalp cells that make up the skin & scalp.', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:53:12', 'superuser@gmail.com', '2024-04-30 13:28:05', NULL, NULL, 20),
(45, 'Leedfrost Cream', 7, 'Box', 900000, '-', '-', '-', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:54:08', 'superuser@gmail.com', '2024-04-30 13:27:54', NULL, NULL, 10),
(46, 'Stemide Over Facial Mask', 49, 'Box', 330000, '-', '-', '-', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:55:00', 'superuser@gmail.com', '2024-04-30 13:27:45', NULL, NULL, 10),
(47, 'Plagentic', 73, 'Box', 2100000, '10 vials', '-', '-', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:56:05', 'superuser@gmail.com', '2024-04-30 13:27:23', NULL, NULL, 10),
(48, 'Crystal Hydro PDRN/ 1 syringe', 7, 'Box', 1100000, '1 Syringe', '2,2ml x 1 Syringe', '-', 2, 1, '', 'superuser@gmail.com', '2024-04-30 11:57:10', 'superuser@gmail.com', '2024-04-30 13:27:12', NULL, NULL, 3),
(49, 'Crystal PN', 12, 'Box', 950000, 'Moisturising & Firming the skin', '1ml x 1 syringe', '-', 2, 1, '', 'superuser@gmail.com', '2024-05-02 04:51:49', NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_15_085852_create_flights_user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `id` int(11) NOT NULL,
  `msg` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_cost`
--

CREATE TABLE `other_cost` (
  `id` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `product` varchar(255) DEFAULT NULL,
  `commision_rate` float DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `name`, `price`, `desc`, `product`, `commision_rate`, `status`, `img`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 'bundlee', 1000000, 'bundle1', '1|1,2|2,3|3', 15, 1, '', 'david@gmail.com', '2024-03-19 21:14:51', NULL, NULL, 'david@gmail.com', '2024-03-31 10:54:42'),
(3, 'bundle 1', 100000, 'sadd', '1233|1,31212|3', 2, 0, '', 'david@gmail.com', '2024-03-20 23:46:47', NULL, NULL, 'david@gmail.com', '2024-04-03 16:59:17'),
(4, 'bundle 1', 1000000, 'desc', '1|1,1|2,1|3', 10, 1, '', 'david@gmail.com', '2024-04-03 16:59:57', NULL, NULL, NULL, NULL),
(5, 'Promo Mei 10 Elitox', 6300000, 'In cosmetology, botulinum toxin is used in anti-ageing procedures. The purpose of the injections is to eliminate age-related defects in the form of hyperkinetic wrinkles on the face and neck, which are caused by an increase in the tone of facial muscles. After injections of botulinum toxin, the transmission of nerve impulses to muscle fibres is blocked, muscle contraction becomes impossible, it relaxes, as a result wrinkles are smoothed.', '10|31', 2, 1, '', 'superuser@gmail.com', '2024-04-30 13:20:31', NULL, NULL, NULL, NULL),
(6, 'Promo Mei 15 Elitox', 9250000, 'In cosmetology, botulinum toxin is used in anti-ageing procedures. The purpose of the injections is to eliminate age-related defects in the form of hyperkinetic wrinkles on the face and neck, which are caused by an increase in the tone of facial muscles. After injections of botulinum toxin, the transmission of nerve impulses to muscle fibres is blocked, muscle contraction becomes impossible, it relaxes, as a result wrinkles are smoothed.', '15|31', 2, 1, '', 'superuser@gmail.com', '2024-04-30 13:21:24', NULL, NULL, NULL, NULL),
(7, 'Promo Mei 4 Elitox + 1 PDRN', 4800000, NULL, '4|31,1|37', 2, 1, '', 'superuser@gmail.com', '2024-04-30 13:22:37', NULL, NULL, NULL, NULL),
(8, 'Promo Mei 6 Elitox + 1 Exomide 15B', 5200000, NULL, '6|31,1|42', 2, 1, '', 'superuser@gmail.com', '2024-04-30 13:32:02', NULL, NULL, NULL, NULL),
(9, 'Promo Mei 3 Elitox + 1 Exomide 15B', 3250000, NULL, '3|31,1|42', 2, 1, '', 'superuser@gmail.com', '2024-04-30 13:32:53', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('david@gmail.com', '$2y$10$bYsfjDdK9kJdt1Ey.QkPtOj6GtckkV8ai4udkQKwZBmVslzl08sJq', '2024-03-02 05:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`id`, `date`, `price`, `note`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, '2024 August', 1000000, 'dsaknl', 'david@gmail.com', '2024-03-21 20:26:14', 'david@gmail.com', '2024-04-04 06:19:03', 'david@gmail.com', '2024-05-01 13:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT 0,
  `id_product` int(11) DEFAULT NULL,
  `stock_in` int(11) DEFAULT 0,
  `stock_out` int(11) DEFAULT 0,
  `desc` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `cart_id`, `id_product`, `stock_in`, `stock_out`, `desc`, `status`, `created_at`) VALUES
(1, 1, 31, 0, 4, 'Dari PAKET Promo Mei 4 Elitox + 1 PDRN Pesanan PO PO/2024/0522154229', 1, '2024-05-01 08:42:29'),
(2, 1, 37, 0, 1, 'Dari PAKET Promo Mei 4 Elitox + 1 PDRN Pesanan PO PO/2024/0522154229', 1, '2024-05-01 08:42:29'),
(3, 2, 31, 0, 1, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(4, 2, 42, 0, 1, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(5, 2, 34, 0, 2, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(6, 2, 36, 0, 2, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(7, 2, 38, 0, 1, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(8, 2, 39, 0, 1, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(9, 2, 40, 0, 1, 'Dari Pesanan PO PO/2024/0501165552', 1, '2024-05-01 09:55:52'),
(10, 3, 31, 0, 2, 'Dari Pesanan PO PO/2024/0522172711', 1, '2024-05-01 10:27:11'),
(11, 4, 38, 0, 5, 'Dari Pesanan PO PO/2024/0501172758', 1, '2024-05-01 10:27:58'),
(12, 5, 31, 0, 50, 'Dari Pesanan PO PO/2024/0531185720', 1, '2024-05-01 11:57:20'),
(13, 7, 42, 0, 4, 'Dari Pesanan PO PO/2024/0531202354', 1, '2024-05-01 13:23:54'),
(14, 0, 37, 16, 0, 'Penambahan Produk Saat Update StockCrystal Hydro PDRN', 1, '2024-05-01 13:48:22'),
(15, 8, 31, 0, 5, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(16, 8, 42, 0, 2, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(17, 8, 33, 0, 1, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(18, 8, 34, 0, 1, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(19, 8, 36, 0, 1, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(20, 8, 38, 0, 1, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(21, 8, 39, 0, 1, 'Dari Pesanan PO PO/2024/0509080438', 1, '2024-05-02 01:04:38'),
(22, 9, 42, 0, 2, 'Dari Pesanan PO PO/2024/0601093729', 1, '2024-05-02 02:37:29'),
(23, 10, 42, 0, 5, 'Dari Pesanan PO PO/2024/0601114411', 1, '2024-05-02 04:44:11'),
(24, 11, 42, 0, 4, 'Dari Pesanan PO PO/2024/0523114709', 1, '2024-05-02 04:47:09'),
(25, 0, 49, 13, 0, 'Penambahan Produk Saat Insert StockCrystal PN', 1, '2024-05-02 04:51:49'),
(26, 12, 42, 0, 1, 'Dari Pesanan PO PO/2024/0523115423', 1, '2024-05-02 04:54:23'),
(27, 12, 49, 0, 1, 'Dari Pesanan PO PO/2024/0523115423', 1, '2024-05-02 04:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `testingg`
--

CREATE TABLE `testingg` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testingg`
--

INSERT INTO `testingg` (`id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`, `img`, `no_hp`, `deleted_at`, `deleted_by`) VALUES
(2, 'davidb', 'david@gmail.com', NULL, '$2y$10$ZxxS45BaBop7zWKAmOOFrOBy71nE4zkZmug1QsU2/LUCKt2Ns8Wsa', 'superuser', 'Sc4pgP2IYnXODN8d8wFd5gglzpCnO2bZmKjZnlNGhTI9ajBR8GZQQTHByxPo', '2023-05-16 00:24:55', '2024-04-04 06:59:37', '1712239177.jpeg', '123', NULL, ''),
(11, 'marketing', 'marketing@gmail.com', NULL, '$2y$10$tyEIm9d.Laf3UexELmSnaOLpa6D/ulh1n8.24afjIXjOOkFsuhhuG', 'marketing', NULL, '2024-03-19 04:06:46', '2024-03-19 04:06:46', '', '', NULL, ''),
(12, 'sales', 'sales@gmail.com', NULL, '$2y$10$fft68furIYGGurWtfKZzi.agE7s7CzWPpb/6NCGYrXq7x8UHry66S', 'sales', NULL, '2024-03-19 04:07:00', '2024-03-19 04:07:00', '', '', NULL, ''),
(13, 'admin', 'admin@gmail.com', NULL, '$2y$10$3X9SOtp68xdiwjVDqGTYQOkhzlW.jRxtnXfE.YMVFlr2CCFbARJOO', 'admin', NULL, '2024-03-19 04:07:20', '2024-03-19 04:07:20', '', '', NULL, ''),
(14, 'finance', 'finance@gmail.com', NULL, '$2y$10$bPbkkPPPdMNIIdCIF/QUV.RGD1nUHG2PE9XzP03YiH01rwNUMTVsm', 'finance', NULL, '2024-03-19 04:08:58', '2024-03-19 04:08:58', '', '', NULL, ''),
(15, 'manager', 'manager@gmail.com', NULL, '$2y$10$taWGGIamMeBW8ivhHNzFDOMQgiJ1r/djLrl05CDMkHIUb/.khezY.', 'manager', NULL, '2024-03-19 04:12:57', '2024-03-19 04:12:57', '', '', NULL, ''),
(16, 'boo', 'boo@gmail.com', NULL, '$2y$10$NqyZ2IltFyD08Rdt8/n/V.14RuZ7ctDLF3b1ZA1S3qxKREbisxFpe', 'superuser', NULL, '2024-04-01 08:24:16', '2024-04-04 14:56:07', '1712242567.jpeg', '', NULL, ''),
(20, 'superuser', 'superuser@gmail.com', NULL, '$2y$10$9DJnUWVKm4a0F..DFzWO8edX1vueBR8rAkxSonWpGPcgFng/EmCRy', 'superuser', NULL, '2024-04-04 14:57:30', '2024-04-04 14:57:30', '', '1239120731', NULL, ''),
(21, 'marketing4', 'marketing4@gmail.com', NULL, '$2y$10$bKnJNTWjDEOS1sQLyDrVo.lGMomk/zjjYLNsEh6xme04gIb4fA3xG', 'marketing', NULL, '2024-04-04 15:15:00', '2024-04-04 15:19:36', '', '123', '2024-03-19 04:12:57', 'superuser s'),
(24, 'Marsi', 'marsi@gmail.com', NULL, '$2y$10$ER33rVNC0RU9uFDlp6khuOoNn8TBxeOYGVOee2CRmxZsTSx0Bphcy', 'manager', NULL, '2024-04-28 13:04:27', '2024-04-28 13:07:40', '', '085241020675', '2024-04-28 13:07:40', 'superuser'),
(25, 'Marsih', 'sun_m4r5@yahoo.com', NULL, '$2y$10$.QycWsxdV0NHX.m13AnjIOQQAaiOTdvNt0HOlq5XtTEsIGdouRV1q', 'manager', NULL, '2024-04-28 13:26:04', '2024-04-28 13:26:04', '', '085241020675', NULL, NULL),
(26, 'Teguh Prakoso', 'teguhprakoso.ipa@gmail.com', NULL, '$2y$10$ChtuZoGez.fWM6bMoJ7cW.mSIADCSgppKS4UprwGQp1vcWMfP6Y2i', 'marketing', '5t7130mBPcLjK7cGhZEWlDQB6Yja2ulZsr67QRSYcW0pb3zSazRYEGvXkcBJ', '2024-04-28 13:41:54', '2024-05-01 05:58:08', '1714543088.jpg', '085748289431', NULL, NULL),
(27, 'Yudiono', 'yudiono.ipa@gmail.com', NULL, '$2y$10$nQ7GVFb8v0H.DdrGUJWbnejcViiec.MOEwm7d1vFXD.JFjlx.LUrC', 'marketing', 'SAqs1hKPYMY5RwAxhdx68K9yT9IQ9lXp4gUWNDp2HnhbW4CVPSxxV4mH4v9K', '2024-04-28 13:47:06', '2024-04-28 13:47:06', '', '082174472915', NULL, NULL),
(28, 'Endika', 'endika.ipa@gmail.com', NULL, '$2y$10$FzHQ0uWteh1usrJTtUu1O.RYsvphTqTr2RurG2uav4trZ5NLLP.A2', 'marketing', NULL, '2024-04-28 13:48:48', '2024-04-28 13:48:48', '', '081331923748', NULL, NULL),
(29, 'Adit', 'aditeka.ipa@gmail.com', NULL, '$2y$10$h2w9avjCR2cfgsK849dq.u0TpADR6pm8Sx.yGvdF.KJ0JtfsyB9/e', 'marketing', 'qLClDimb519sPgXq0ACArQfwJd7ZMU9334ERcdUrp1wypfatigPL6sPkPB1J', '2024-04-28 13:50:05', '2024-05-01 00:33:46', '', '081910427991', NULL, NULL),
(30, 'Ayu', 'latifahayu.ipa@gmail.com', NULL, '$2y$10$SgqJfGn5YtimZ8jDseak3OzVzBWNLV.CoKFpL/LcePaYxLjP9zqn6', 'marketing', 'QfV1gH50m1XvxVjwhKhijktFBBjOA3HzSHYfMrV7Opep12YzYwPv7NQfuSvY', '2024-04-28 14:43:30', '2024-04-28 14:43:30', '', '085361349977', NULL, NULL),
(31, 'Ade Kartika Sari', 'adekartikasari.ipa@gmail.com', NULL, '$2y$10$pCFvyIuXKGIYONgzH/UFUO/lzOFL8.kYrFqRTRlOczmyXFrqUqm8u', 'manager', NULL, '2024-04-28 14:44:50', '2024-04-28 14:44:50', '', '081271360161', NULL, NULL),
(32, 'Merlyn', 'merlina.ipa@gmail.com', NULL, '$2y$10$URTZuawtYGskRLykUGAfduUa9s42MMG7vT3.xqwtYCdJPQbpfkvsW', 'marketing', NULL, '2024-04-28 14:48:24', '2024-04-28 14:48:24', '', '081230306567', NULL, NULL),
(33, 'Sumartini', 'tini.ipa77@gmail.com', NULL, '$2y$10$XhAdg2WQWJ4CeUIIK/KgjePFi/GN4y2W5eQi1iPhuRpaUVvXk2rUy', 'marketing', NULL, '2024-04-28 14:49:52', '2024-04-28 14:49:52', '', '085925174386', NULL, NULL),
(34, 'Hasyim Adnan', 'hasyimadnan.ipa@gmail.com', NULL, '$2y$10$IWIk9CN9YRq40Cxnw/fnK.Pm5Blnsqkvxn9bkTiBqoJQz3MYRYEXa', 'marketing', 'RjZ5PeY0iv8jSi9kIdcgVLwRSsHonjfuPXX8AZjv8opJ5lEkZ0I7WSLj1lrr', '2024-04-28 14:51:23', '2024-04-28 14:51:23', '', '081384754950', NULL, NULL),
(35, 'Novi Putri', 'noviputripriyantini.ipa@gmail.com', NULL, '$2y$10$5BaQPihIYSd6P8Gifz7xYOwrCW.OpLGE24BlaAR.Ejbmy5k9up59y', 'marketing', NULL, '2024-04-28 14:53:19', '2024-04-28 14:53:19', '', '081808045377', NULL, NULL),
(36, 'Riyan Septian', 'riyan.ipa02@gmail.com', NULL, '$2y$10$r9TnpapndijQA.NBS6Y6veqdfmJkfWBFFENPZx.viPXsPKKB2.cIG', 'marketing', NULL, '2024-04-28 14:55:46', '2024-04-28 14:55:46', '', '082127220286', NULL, NULL),
(37, 'Muhammad Denny Murjaya', 'dennym.ipa@gmail.com', NULL, '$2y$10$5XnyEgAOoUZe6qMkv3pqIuVYKa7etdfI7/2UwMbej.6lcoe6MCOK2', 'marketing', NULL, '2024-04-28 14:57:21', '2024-04-28 14:57:21', '', '0811553298', NULL, NULL),
(38, 'Ficky Hermawan', 'ficky.ipa@gmail.com', NULL, '$2y$10$71Jbr8bF4o1wRtbqKUIrDuz3unaZMjXaAx7VpG0sJ84xyytUGtk/K', 'marketing', NULL, '2024-04-28 14:58:32', '2024-04-28 14:58:32', '', '082231115097', NULL, NULL),
(39, 'Yohanes Eko Yudhi Pristianto', 'yudhip.ipa@gmail.com', NULL, '$2y$10$TDbJqj8hkv8C6Do9AGQs2.56EVUoFAVyzlJkGkG/L/felvLmixlmy', 'marketing', 'abLmvIeJ5u4p0vmeT04kI4wuGdTaFimAJk9DnWAmVIYUVTm3lzw8nJtBGGvR', '2024-04-28 15:00:02', '2024-05-01 07:46:57', '', '085159506711', NULL, NULL),
(40, 'Ayi Islamiah', 'ayi.ipa@gmail.com', NULL, '$2y$10$VeMXPIjlAgHCjQXJV74AruM43ufNkb/yFqOCqZGqeIx00sXFO0/m6', 'finance', NULL, '2024-04-28 15:01:48', '2024-04-28 15:01:48', '', '081212224079', NULL, NULL),
(41, 'Vinita', 'vinita.ipa@gmail.com', NULL, '$2y$10$Tb5sEzfSy.bpDueUvQPnUOSuQbIN6qgbyh/FDjNcaICFDjCQ0AilO', 'finance', NULL, '2024-04-28 15:02:48', '2024-04-28 15:02:48', '', '081994040297', NULL, NULL),
(42, 'Dedi Kadarisman', 'dedi.ipa@gmail.com', NULL, '$2y$10$hHqk75Pw3h/dATwyIA/y/.misKkkOy7GBY0rCd3f2PntFPi7kUZLy', 'admin', NULL, '2024-04-28 15:03:41', '2024-04-28 15:03:41', '', '087881047699', NULL, NULL),
(43, 'maggie chandra', 'Intipersada.aes@gmail.com', NULL, '$2y$10$9DJnUWVKm4a0F..DFzWO8edX1vueBR8rAkxSonWpGPcgFng/EmCRy', 'superuser', 'WH2byWqZZRHRJSqFdNw40QBSf5EUAF77O8FmY9hkxBXBdPlNVP5vet4bBhq8', '2024-04-04 14:57:30', '2024-05-02 02:55:08', '', '081285676688', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extra_charge`
--
ALTER TABLE `extra_charge`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `extra_charge_id_IDX` (`id`) USING BTREE,
  ADD KEY `extra_charge_FK` (`transaction_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `flights_user`
--
ALTER TABLE `flights_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notif` (`deleted_by`);

--
-- Indexes for table `other_cost`
--
ALTER TABLE `other_cost`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notif` (`deleted_by`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notif` (`deleted_by`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testingg`
--
ALTER TABLE `testingg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `ekspedisi`
--
ALTER TABLE `ekspedisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `extra_charge`
--
ALTER TABLE `extra_charge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flights_user`
--
ALTER TABLE `flights_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_cost`
--
ALTER TABLE `other_cost`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `testingg`
--
ALTER TABLE `testingg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `extra_charge`
--
ALTER TABLE `extra_charge`
  ADD CONSTRAINT `extra_charge_FK` FOREIGN KEY (`transaction_id`) REFERENCES `cart` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
