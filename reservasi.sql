-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2022 at 04:27 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(5) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `username`, `password`) VALUES
(1, 'BSI Guest House', 'bsiguesthouse', 'd0970714757783e6cf17b26fb8e2298f');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(5) NOT NULL,
  `id_tipe` int(5) NOT NULL,
  `nama_kamar` varchar(50) NOT NULL,
  `no_kamar` int(5) NOT NULL,
  `tipe_kasur` enum('Single Bed','Twin Bed','Double Bed') NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `tgl_input` date NOT NULL,
  `harga_kamar` int(20) NOT NULL,
  `lokasi` enum('Lantai 1','Lantai2','Lantai 3') NOT NULL,
  `status_kamar` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `id_tipe`, `nama_kamar`, `no_kamar`, `tipe_kasur`, `gambar`, `tgl_input`, `harga_kamar`, `lokasi`, `status_kamar`) VALUES
(3, 3, 'Kamboja', 201, 'Double Bed', 'double.jpg', '2022-12-20', 500000, 'Lantai2', '0'),
(4, 1, 'Melati', 302, 'Twin Bed', 'twin.jpeg', '2022-11-01', 400000, 'Lantai 3', '0'),
(5, 1, 'Mawar', 103, 'Double Bed', 'double.jpg', '2022-12-20', 350000, 'Lantai 1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pengunjung`
--

CREATE TABLE `pengunjung` (
  `id_pengunjung` int(5) NOT NULL,
  `nama_pengunjung` varchar(50) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengunjung`
--

INSERT INTO `pengunjung` (`id_pengunjung`, `nama_pengunjung`, `jenis_kelamin`, `no_telp`, `alamat`, `email`, `password`) VALUES
(1, 'Fernando', 'Laki-laki', '085767895432', 'Purwokerto', 'fernando@gmail.com', '54321'),
(2, 'Julia', 'Perempuan', '088924327860', 'Purbalingga', 'julia@gmail.com', '01cfcd4f6b8770febfb40cb906715822'),
(4, 'Oci', 'Perempuan', '087865456789', 'Banyumas', 'oci@gmail.com', '54321');

-- --------------------------------------------------------

--
-- Table structure for table `penyewaan`
--

CREATE TABLE `penyewaan` (
  `id_sewa` int(10) NOT NULL,
  `tgl_sewa` datetime NOT NULL,
  `id_pengunjung` int(5) NOT NULL,
  `tgl_checkin` date NOT NULL,
  `tgl_checkout` date NOT NULL,
  `total_extend` double NOT NULL,
  `status_bayar` enum('Lunas','Belum Dibayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penyewaan`
--

INSERT INTO `penyewaan` (`id_sewa`, `tgl_sewa`, `id_pengunjung`, `tgl_checkin`, `tgl_checkout`, `total_extend`, `status_bayar`) VALUES
(1, '2022-12-19 11:59:53', 1, '2022-12-19', '2022-12-21', 700000, 'Lunas'),
(2, '2022-12-19 11:59:53', 3, '2022-12-18', '2022-12-21', 600000, 'Lunas'),
(3, '2022-12-19 11:59:53', 2, '2022-12-20', '2022-12-21', 400000, 'Belum Dibayar'),
(4, '2022-12-20 03:56:11', 4, '2022-12-19', '2022-12-20', 500000, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `tipekamar`
--

CREATE TABLE `tipekamar` (
  `id_tipe` int(5) NOT NULL,
  `tipe_kamar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipekamar`
--

INSERT INTO `tipekamar` (`id_tipe`, `tipe_kamar`) VALUES
(1, 'Standard'),
(2, 'Deluxe'),
(3, 'Premium Suite');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_sewa` int(10) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `id_pengunjung` int(5) NOT NULL,
  `id_kamar` int(5) NOT NULL,
  `tgl_checkin` date NOT NULL,
  `tgl_checkout` date NOT NULL,
  `extend` double NOT NULL,
  `total_extend` double NOT NULL,
  `status_sewa` enum('Berhasil','Gagal') NOT NULL,
  `status_bayar` enum('Lunas','Belum Dibayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_sewa`, `tgl_bayar`, `id_pengunjung`, `id_kamar`, `tgl_checkin`, `tgl_checkout`, `extend`, `total_extend`, `status_sewa`, `status_bayar`) VALUES
(1, '2022-12-19 11:55:46', 1, 2, '2022-12-19', '2022-12-21', 350000, 700000, 'Berhasil', 'Lunas'),
(2, '2022-12-19 11:55:46', 3, 1, '2022-12-18', '2022-12-21', 200000, 600000, 'Berhasil', 'Lunas'),
(4, '2022-12-20 03:59:08', 4, 3, '2022-12-19', '2022-12-20', 500000, 500000, 'Berhasil', 'Lunas'),
(5, '2022-12-20 04:12:13', 1, 5, '2022-12-20', '2022-12-21', 0, 0, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- Indexes for table `pengunjung`
--
ALTER TABLE `pengunjung`
  ADD PRIMARY KEY (`id_pengunjung`);

--
-- Indexes for table `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD PRIMARY KEY (`id_sewa`);

--
-- Indexes for table `tipekamar`
--
ALTER TABLE `tipekamar`
  ADD PRIMARY KEY (`id_tipe`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_sewa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pengunjung`
--
ALTER TABLE `pengunjung`
  MODIFY `id_pengunjung` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penyewaan`
--
ALTER TABLE `penyewaan`
  MODIFY `id_sewa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tipekamar`
--
ALTER TABLE `tipekamar`
  MODIFY `id_tipe` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_sewa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
