-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Okt 2026 pada 02.48
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saranasekolah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Staff Prasarana Sekolah','Guru','Kepala Sekolah') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `nama`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'admin', 'Admin Sekolah', '$2y$10$5U3ciVpZbpEnoIi0rW5gFuJLs9ymt0z.wHWmePjdx9WL0wCIS/85e', 'Staff Prasarana Sekolah', '2026-09-29 05:18:59', '2026-10-13 07:24:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasis`
--

CREATE TABLE `aspirasis` (
  `id_aspirasi` bigint(20) UNSIGNED NOT NULL,
  `nis` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Menunggu','Diproses','Selesai') NOT NULL DEFAULT 'Menunggu',
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `ket` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `anonim` tinyint(1) NOT NULL DEFAULT 0,
  `feedback` text DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `aspirasis`
--

INSERT INTO `aspirasis` (`id_aspirasi`, `nis`, `status`, `id_kategori`, `ket`, `foto`, `anonim`, `feedback`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 20251545, 'Diproses', 2, 'Atap bolong', '1789601549_20251545.png', 0, '', 2, '2026-09-16 23:32:34', '2026-10-13 23:50:05'),
(2, 20251545, 'Menunggu', 2, 'Atap bolong', '1789601554_20251545.png', 0, NULL, NULL, '2026-09-16 23:32:34', '2026-09-16 23:32:34'),
(3, 20251545, 'Selesai', 2, 'Pintu rusak', '1790127789_20251545.jpg', 1, '', 2, '2026-09-23 01:43:10', '2026-10-13 14:46:09'),
(7, 20000001, 'Diproses', 7, 'Layar komputer retak', '1790659457_20000001.jpg', 0, '🥲', 2, '2026-09-29 05:24:17', '2026-10-13 14:45:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategoris`
--

CREATE TABLE `kategoris` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `ket_kategori` varchar(50) NOT NULL,
  `jenis` enum('sarana_prasarana') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategoris`
--

INSERT INTO `kategoris` (`id_kategori`, `ket_kategori`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'Toilet & Kamar Mandi', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(2, 'Ruang Kelas', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(3, 'Elektronik/Listrik', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(4, 'Halaman Parkir', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(5, 'Lapangan Olahraga', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(6, 'Perpustakaan', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(7, 'Lab Praktik', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09'),
(8, 'Kantin', 'sarana_prasarana', '2026-09-02 19:01:09', '2026-09-02 19:01:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswas`
--

CREATE TABLE `siswas` (
  `nis` bigint(20) UNSIGNED NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `siswas`
--

INSERT INTO `siswas` (`nis`, `nama_siswa`, `kelas`, `password`, `created_at`, `updated_at`) VALUES
(10000000, 'Sifa Syafakillah', 'X MPLB 1', '$2y$10$h8R.rNfei1L8tnUSQEN/NOmKjADjRZZdWHCSZg3d6Ihb4WrdDBICq', '2026-09-28 17:35:31', '2026-09-28 17:35:31'),
(20000001, 'Mecca rahayu', 'X MPLB 2', '$2y$10$p36p/1G94CMWPcYOpfQAf.LMHr3jfeRsD1veOG8in9nejqUiZzik.', '2026-09-28 17:37:26', '2026-09-28 17:37:26'),
(20251545, 'Naya', 'X AKL 2', '$2y$10$6xuUjCnIpYWy9FoBW.Y99OETn1EGyM0fZ7/F1OFtaJg8a9Xk/vUuK', '2026-09-03 00:05:44', '2026-09-03 00:05:44'),
(20254838, 'Eka Gustiwana', 'XI RPL 3', '$2y$10$wninOGrrNkeQe47DuYvXxOYc.ISyXOBmv9rDCv1.W7J81fLlsMZFa', '2026-10-14 01:16:07', '2026-10-14 01:16:07'),
(30000001, 'Setia Anggara', 'X MPLB 3', '$2y$10$PoESGZTrXq92n8.ZaCEld.vXWjbXvNHGKAvGIH01nukFESkw/5BqS', '2026-09-28 17:38:57', '2026-09-28 17:38:57'),
(40000001, 'Mutia Kartika', 'X MPLB 4', '$2y$10$nRCcVdo8umEAsDHMbUZ8NuVW0iU/lYDefQQI6k3qxyVRHlbxUkZDa', '2026-09-28 17:40:04', '2026-09-28 17:40:04'),
(50000001, 'Dinda Kirana', 'X AKL 1', '$2y$10$.MJ83WWmWYiTvm0sA060Kuc84w5DBscHCfvXmuFDvcUrUL5u4TzpG', '2026-09-28 17:40:53', '2026-09-28 17:40:53'),
(60000001, 'Linda Anindya', 'X AKL 2', '$2y$10$ZhpDhRN71OjanjMlAOWapeU3T/cEF26SR6JSRS/zRnB95Pc5y4AFW', '2026-09-28 17:41:39', '2026-09-28 17:41:39'),
(70000001, 'Mahesa Handayani', 'X AKL 3', '$2y$10$9fcS6z2cIi1PWwCwBUnpL.Je/WdlDoW15A05k2pZrYs85zH5sDJNO', '2026-09-28 17:42:27', '2026-09-28 17:42:27'),
(80000001, 'Maharani Putri', 'X AKL 4', '$2y$10$Dhz/Jl857nmnVEC8ro4fUehzRGEhyK/b3FlBln.qIKXkA6sNVGVVC', '2026-09-28 17:43:43', '2026-09-28 17:43:43'),
(90000001, 'Kusuma wardani', 'X RPL 1', '$2y$10$ZwFdp8MPMNPofFp94acQF.lMJqnsGF4S6DT9uTosx5m2TFxdMyBcW', '2026-09-28 17:44:38', '2026-09-28 17:44:38');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `aspirasis`
--
ALTER TABLE `aspirasis`
  ADD PRIMARY KEY (`id_aspirasi`),
  ADD KEY `fk_aspirasi_kategori` (`id_kategori`),
  ADD KEY `fk_aspirasi_siswa` (`nis`),
  ADD KEY `fk_aspirasi_admin` (`admin_id`);

--
-- Indeks untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `siswas`
--
ALTER TABLE `siswas`
  ADD PRIMARY KEY (`nis`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `aspirasis`
--
ALTER TABLE `aspirasis`
  MODIFY `id_aspirasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kategoris`
--
ALTER TABLE `kategoris`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `aspirasis`
--
ALTER TABLE `aspirasis`
  ADD CONSTRAINT `fk_aspirasi_admin` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aspirasi_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategoris` (`id_kategori`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_aspirasi_siswa` FOREIGN KEY (`nis`) REFERENCES `siswas` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
