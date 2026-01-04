-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2026 at 12:10 AM
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
-- Database: `watchlistnative`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`) VALUES
(1, 'Drama'),
(2, 'Film');

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `watchlist_id` int(11) NOT NULL,
  `status_progress` enum('watching','completed') NOT NULL,
  `rating` int(11) NOT NULL,
  `ulasan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `progress`
--

INSERT INTO `progress` (`progress_id`, `user_id`, `watchlist_id`, `status_progress`, `rating`, `ulasan`) VALUES
(46, 2, 69, 'completed', 5, 'Rasanya nano-nano waktu rewatch, keren banget editannya\r\n'),
(47, 2, 61, 'completed', 5, 'suka nontonnya karena walau ceritanya klise, pembawaan komedinya ngalir banget\r\n'),
(48, 2, 63, 'completed', 5, 'ternyata emang kalo nangis tuh ngga boleh ditahan ya.. kalo sedih ya nangis. kalo ditahan justru bikin tambah sakit. huee~'),
(49, 2, 55, 'completed', 5, 'ceritanya inspiratif. manuia emang ngga boeh mencampuri urusan tuhan. lah, siapa kita kan?'),
(50, 7, 69, 'completed', 5, 'bagus');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `pp` varchar(100) NOT NULL,
  `bio` varchar(100) NOT NULL,
  `tanggal_lahir` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `role`, `pp`, `bio`, `tanggal_lahir`) VALUES
(1, 'Kiki', 'kiki@gmail.com', '$2y$10$vE9.LQZ7VctFY3YOlS.SMupOOoWAc.P9ZT5IZpYYfy0TAjvDwLFc.', 'admin', '_Kiki_Amanullah_69586737cfd23.jpg', 'Anak tengah dari 3 bersaudara', '2006-09-16'),
(2, 'Naya', 'naya@gmail.com', '$2y$10$1Oo54MIV9A8xcFXdrT6.M.taUcTMTiOzy1039myr/CxpD8xMi0dKW', 'user', '_Nayyara_Zidni_6958938422072.jpeg', 'adalah pokoknya', '2019-02-19'),
(4, 'Baru', 'baru@gmail.com', '$2y$10$36xKig0zx5e1ACmFmNjwqulCjk8rA4ujyHruC6flpg/SuSlo13n86', 'user', '', '', ''),
(5, 'Juwol', 'juwol@gmail.com', '$2y$10$tn2w3QYCAqvq7OUJg9Dh..Av1UcjWvrTQ/DS/vsg1zrvYULo3DFvm', 'user', '', '', ''),
(6, 'Najwa Rizki Amanullah', 'lala@gmail.com', '$2y$10$NxdF/j2Qx9z/DYjCuW/0Ke4OPmq37OBegRn3Ei7DpRjlN3WSY1dUu', 'admin', '', '', ''),
(7, 'Sakha', 'sakha@gmail.com', '$2y$10$lTj/Slr7PE6FPmuH0fwIvuM1vrPDbGhA0U.dwhb.Ddl6u9GAztz6.', 'user', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `watchlist_id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `aktor` varchar(100) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `tahun_rilis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `watchlist`
--

INSERT INTO `watchlist` (`watchlist_id`, `kategori_id`, `judul`, `genre`, `aktor`, `deskripsi`, `poster`, `tahun_rilis`) VALUES
(53, 1, 'A Hundreed Memories', 'slice of life, melo drama', 'Kim Dami, shin Ye-eun, Heo Namjoon', 'Kisah perjalanan hidup seorang gadis bernama Ko Yongrye yang menjadi kondektur bus di usia muda, tentang persahabatan, cinta, harapan, dan takdir yang membuat hidupnya lebih bermakna', '_A_Hundreed_Memories_6954a57baaa96.jpg', '2025'),
(54, 1, 'No Gain No Love', 'comedy, romance', 'Shin Min-ah, Kim Youngdae', 'Seorang kepala tim perusahaan harus menikah demi promosi jabatan. Pilihannya hanya pemuda minimarket yang ternyata adalah salah satu anak asuh ibunya.', '_No_Gain_No_Love_6954a6a889a91.jpg', '2024'),
(55, 1, 'Tomorrow', 'comedy, action, sci-fic, drama', 'Rowon, Lee Soohyuk, Kim Hyesun', 'Joonwoong yag selalu gagal dapat pekerjaan harus menjalani koma selama enam bulan karena menyelamatkan tuna wisma yang hampir bunuh diri. Sebagai gantinya dia diminta untuk bekerja sebagai malaikaat maut yang mencegah orang untuk bunuh diri.', '_Tomorrow_6954a7ac7ea30.jpg', '2022'),
(56, 1, 'Thypoon Family', 'drama, history, comedy', 'Lee Junho, Kim Minha', 'Kisah Kang Taepoong menghadapi krisis ekonomi tahun 1997 setelah ayahnya meninggal dunia.', '_Thypoon_Family_6954a878f288f.jpg', '2023'),
(57, 2, 'The Shadow Edge', 'action, crime', 'Jacky Chan, Tony Leung, Junhui', 'Seorang detektif pensiunan terpaksa turun tangan untuk menangkap sindikat pencuri berteknologi tinggi yang mencuri sejumlah besar bitcoin dari pengusaha ternama', '_The_Shadow_Edge_6954aae034519.jpg', '2025'),
(58, 1, 'Dynamite Kiss', 'comedy, romance', 'Jang Kiyong, Ahn Eunjin', 'Seorang wanita lajang memalsukan statusnya sebagai seorang ibu untuk mendapatkan pekerjaan di perusahaan perlengkapan bayi', '_Dynamite_Kiss_6955bf3a502d8.jpg', '2025'),
(59, 1, 'When The Phone Ring', 'mistery, romance, crime', 'Chae Soobin, Yoo Yeonseok', 'Juru bicara kenegaraan menikah dengan gadis bisu yang ternyata menyimpan banyak rahasia, termasuk fakta bahwa dia bisa bicara', '_When_The_Phone_Ring_6955bfe6bf6b4.jpg', '2024'),
(60, 1, 'Whould You Merry Me', 'comedy, romance', 'Jung somin, Choi Woosik', 'Pernikahan kontrak 90 hari antara pewaris toko roti dan seorang desainer dilakukan demi mendapatkan hadiah undian rumah mewah untuk pasangan pengantin baru', '_Whould_You_Merry_Me_69598b3a3b5da.jpg', '2025'),
(61, 1, 'Hometown Cha Cha Cha', 'comedy, romance', 'Shin Minah, Kim Seonho', 'Dokter gigi dari Seoul memutuskan pindah ke pedesaan dan membuka kliniknya sendiri, keputusan yang membuatnya bertemu dengan pria serba bisa yang menyembunyikan masa lalu kelam ', '_Hometown_Cha_Cha_Cha_6955c13596b47.jpg', '2021'),
(62, 1, 'King The Land', 'comedy, romance', 'Lee Junho, Im Yoona', 'Pewaris hotel ternama yang tidak suka tersenyum karena trauma masa kecil dibuat jatuh cinta dengan salah satu pegawainya yang punya senyuman manis', '_King_The_Land_6955c1f2cb7aa.jpg', '2023'),
(63, 1, 'Doom At Your Service', 'melo drama, fantasy, comedy', 'Park Boyoung, Seo Inguk', 'Kebiasaan Tak Dong Kyung yang selalu menahan tangisan membuatnya didiagnosis kanker otak dan hanya punya sisa 100 hari untuk hidup', '_Doom_At_Your_Service_6955c32a53939.jpg', '2021'),
(64, 1, 'Bussines Proposal', 'comedy, romance', 'Kim Sejeong, Ahn Hyoseop', 'Karyawan paling rajin di perusahaan makanan mengalami kisah cinta bertepuk sebelah tangan yang tragis ', '_Bussines_Proposal_6955c477c068e.jpg', '2022'),
(65, 1, 'Genie, Make a Wish', 'fantasy, comedy, romance', 'Kim Woobin, Bae Suzy', 'Wanita yang terlahir tanpa bisa merasakan rasa kemanusiaan melakukan trip ke dubai dan menemukan teko ajaib berisi jin yang bisa mengabulkan tiga permintaan', '_Genie,_Make_a_Wish_69598b1d2108a.jpg', '2025'),
(66, 1, 'Head Over Heels', 'horror, romace, youth', 'Cho Youngwoo, Cho Yihyun, Cha Kangyoon', 'Kisah dukun muda yang menyelamatkan laki-laki yang dia sukai dari kutukan jahat yang dikirim oleh keluarganya sendiri', '_Head_Over_Heels_6955c5eb6f33c.jpg', '2025'),
(67, 1, 'Undercover High School', 'action, mistery', 'Seo Kangjoon, Jin Kijoo', 'Seorang agen BIN rela menyamar menjadi ssiswa SMA untuk mencari uang seludupan di gudang terbengkalai di sebuah sekolah', '_Undercover_High_School_6955c6629bff7.jpg', '2025'),
(68, 2, 'How to Train Your Dragon', 'action, adventure, fantasy', 'Mason Thames, Nico Parker', 'Putra seorang pemimpin Viking berteman dengan naga yang seharusnya dia bunuh', '_How_to_Train_Your_Dragon_6955c70c624c2.jpg', '2025'),
(69, 2, 'Ashfall', 'action, disaster, comedy', 'Ha Jungwoo, Lee Byunghun, Ma Dongseok', 'Letusan gunung Baekdu menyebabkan bencana yang membuat Korea hampir lenyap, tidak sebelum seorang tentara mencuri nuklir dari Korea Utara untuk meledakkan bagian bawah gunung', '_Ashfall_6955c845174b4.jpg', '2019');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`),
  ADD UNIQUE KEY `Drama` (`kategori_id`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `fk_user_review` (`user_id`),
  ADD KEY `fk_watchlist_review` (`watchlist_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`watchlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `watchlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `fk_user_review` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `fk_watchlist_review` FOREIGN KEY (`watchlist_id`) REFERENCES `watchlist` (`watchlist_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
