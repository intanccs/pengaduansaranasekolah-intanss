-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Sep 2026 pada 01.16
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
(1, 'doe', 'Doe supriyadi', '7654321', 'Guru', '2026-09-02 20:47:43', '2026-09-02 20:47:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `aspirasis`
--

CREATE TABLE `aspirasis` (
  `id_aspirasi` bigint(20) UNSIGNED NOT NULL,
  `nis` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Menunggu','Proses','Selesai') NOT NULL DEFAULT 'Menunggu',
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
(1, 20251545, 'Menunggu', 2, 'Atap bolong', '1789601549_20251545.png', 0, NULL, NULL, '2026-09-16 23:32:34', '2026-09-16 23:32:34'),
(2, 20251545, 'Menunggu', 2, 'Atap bolong', '1789601554_20251545.png', 0, NULL, NULL, '2026-09-16 23:32:34', '2026-09-16 23:32:34'),
(3, 20251545, 'Menunggu', 2, 'Pintu rusak', '1790127789_20251545.jpg', 1, NULL, NULL, '2026-09-23 01:43:10', '2026-09-23 01:43:10'),
(4, 202808061, 'Menunggu', 8, 'Kaki meja patah', '1790198772_202808061.jpg', 0, NULL, NULL, '2026-09-23 21:26:12', '2026-09-23 21:26:12'),
(5, 202808061, 'Menunggu', 1, 'Pengunci pintu rusak', '1790205390_202808061.jpg', 0, NULL, NULL, '2026-09-23 23:16:30', '2026-09-23 23:16:30'),
(6, 202808061, 'Menunggu', 4, 'Tanda penjaga hilang', '1790205721_202808061.jpg', 1, NULL, NULL, '2026-09-23 23:22:01', '2026-09-23 23:22:01');

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
(20200000, 'Sifa Syafakillah', 'XII RPL 3', '$2y$10$LSpX9EGhRqfEsfhWoAu6DOj2Ixb4W0qOhoRtVTxon1t2jNLxKBc/e', '2026-09-02 23:11:25', '2026-09-02 23:11:25'),
(20211111, 'Mecca rahayu', 'XII RPL 3', '$2y$10$dcNITTNzkubT6DeZKmJH9O7xjz027so8p8aBuObRTDLE97715D8AC', '2026-09-02 21:00:01', '2026-09-02 21:00:01'),
(20215151, 'Setia Anggara', 'XII RPL 2', '$2y$10$dj02Sw3hKU0NlAGIpj986etKD1ie84NWMnKvlL8LvocP02pkKqz32', '2026-09-02 23:25:17', '2026-09-02 23:25:17'),
(20215415, 'Mutia Kartika', 'X MPLB 4', '$2y$10$vi2Ay.JkuRIAlKufFOtZJuFxC99DOlsnAFdYgwo5ZkCgGUfmgmZQS', '2026-09-02 23:40:36', '2026-09-02 23:40:36'),
(20222222, 'Dinda Kirana', 'XII RPL 3', '$2y$10$Q9JJpK9YfTuZee9ZBntgM.QVoBIT4iOwHBDV7YnvYPEzuF5cwat0O', '2026-09-02 23:08:58', '2026-09-02 23:08:58'),
(20230045, 'Linda Anindya', 'XII RPL 3', '$2y$10$SI4/ywKNfyuFF0q6y.PQx.Oxq7HM8z1/.4WPtC902VEk.kCL5S3Zy', '2026-09-02 20:32:33', '2026-09-02 20:32:33'),
(20236036, 'Mahesa Handayani', 'XII RPL 3', '$2y$10$s7HKn/vkxP5Chg68BXC1Z.OwLjPWFyrmtSiwcK74/hnuV9YhhZUhi', '2026-09-02 23:19:35', '2026-09-02 23:19:35'),
(20243434, 'Maharani Putri', 'XII RPL 3', '$2y$10$DoWX3h8HdfzXj0H7bjmnvuy67oUYdnWeAy20EKGdhb6.XZrzkf0mm', '2026-09-02 23:14:01', '2026-09-02 23:14:01'),
(20245454, 'Kusuma Wardani', 'XII RPL 3', '$2y$10$JFcX8M0gf3XumgqbZ9pT0uIh9M2L1M55eTJ76.JfE3xRUPZVoOd1e', '2026-09-02 23:21:51', '2026-09-02 23:21:51'),
(20245678, 'Panji sakti', 'XI RPL 4', '$2y$10$JUCQpvEnGemmREtpjC1owO..llJwmhfQHeDHl/d5D16U3XswulrI2', '2026-09-02 23:36:21', '2026-09-02 23:36:21'),
(20250505, 'Gea satya', 'XI AKL 2', '$2y$10$oToNiLzSpublUOOOhk3mGOzem5arogolp3O0L6y18NtXBGoackLo2', '2026-09-02 23:28:07', '2026-09-02 23:28:07'),
(20251545, 'Naya', 'X AKL 2', '$2y$10$6xuUjCnIpYWy9FoBW.Y99OETn1EGyM0fZ7/F1OFtaJg8a9Xk/vUuK', '2026-09-03 00:05:44', '2026-09-03 00:05:44'),
(20253289, 'Kertana dewi', 'XI MPLB 3', '$2y$10$0nWlGVAFoYu5sVkzeZgY6OJOOX58z4zdX4DdHJP/oePoKjOqFwFey', '2026-09-02 23:34:23', '2026-09-02 23:34:23'),
(20254813, 'Salwa Rinjani', 'X MPLB 1', '$2y$10$EyaujGoRyalg.pL0/MFfIOXcB.IaHNfI3ZMFLsLpYsDKV8tW6Suha', '2026-09-02 23:38:02', '2026-09-02 23:38:02'),
(20255555, 'Naya Revina', 'XII RPL 3', '$2y$10$bG/hhgsz4/jEqG4Ey937u.ivG9J0tstZ2X73ounCe5inua/HTfszi', '2026-09-02 20:58:07', '2026-09-02 20:58:07'),
(20258936, 'Rahaya Mustika', 'X MPLB 1', '$2y$10$Pynbx1Zv8Zyy8Y6zrlolS.dRLbppifnC6L1fEn5QrUhYYNHc3aG3W', '2026-09-02 23:35:24', '2026-09-02 23:35:24'),
(20266333, 'Irma Suryani', 'XII RPL 3', '$2y$10$SONzEFOZT2K4CE8P1Vrix.0TTOWbz7F6Wk3TCkn0BrxEHm5MjkIeK', '2026-09-02 23:20:58', '2026-09-02 23:20:58'),
(20266666, 'Dinda Kirana', 'XII RPL 3', '$2y$10$mpBYcGbnbqSxQF3xu47D3OGFqqiqhX6dPKWCaJ.RH64ul3CcUdp6m', '2026-09-02 23:10:04', '2026-09-02 23:10:04'),
(20270685, 'Siska Raya', 'XII AKL 2', '$2y$10$W8AHYnUERqszSoJzf7rUOu5m5.i892HW6ZMbw8Cm4NNbtcZv2fo7e', '2026-09-02 23:30:51', '2026-09-02 23:30:51'),
(20283835, 'Rian Permana', 'X RPL 4', '$2y$10$CK2fKV1kpQINuAkC694nfOeA1U0/nxznUKI3aZwET4DnKArcKioLa', '2026-09-02 23:31:44', '2026-09-02 23:31:44'),
(20288888, 'Sintia Ayu', 'XII RPL 3', '$2y$10$125H/V2fJeTOoqBodI6IKuRildkSbpVBffQaV07v.Vfg9I29EXRja', '2026-09-02 23:12:44', '2026-09-02 23:12:44'),
(202000004, 'Reina putri', 'XII RPL 2', '$2y$10$/U0v2/9qKy6K/Gs3QhPTTea/rc.fPDGhVqiwT205K7cUqHAcAM.PK', '2026-09-23 01:59:00', '2026-09-23 01:59:00'),
(202808061, 'Reina putri', 'XII RPL 3', '$2y$10$ImiTX7YUmmvwHkwEn.ydYOuslfJ.AHWADTnnEbkaWl6FQqZUx09ey', '2026-09-23 02:00:28', '2026-09-23 02:00:28');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `aspirasis`
--
ALTER TABLE `aspirasis`
  MODIFY `id_aspirasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
