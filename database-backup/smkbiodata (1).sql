-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Jun 2024 pada 12.54
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smkbiodata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `ID` int(100) NOT NULL,
  `Username` varchar(60) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `Nama_Lengkap` varchar(100) NOT NULL,
  `Foto` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`ID`, `Username`, `Password`, `status`, `Nama_Lengkap`, `Foto`) VALUES
(1, 'Root', '', 'Admin', 'SMKN 1 SUMENEP', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `biodata_siswa`
--

CREATE TABLE `biodata_siswa` (
  `ID` int(255) NOT NULL,
  `username` varchar(60) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(30) NOT NULL,
  `Nama_Lengkap` varchar(80) NOT NULL,
  `Tempat_Lahir` varchar(30) NOT NULL,
  `Tanggal_Lahir` date NOT NULL,
  `Jenis_Kelamin` varchar(20) NOT NULL,
  `No_Induk_Siswa` int(255) NOT NULL,
  `NISN` int(70) NOT NULL,
  `NIK` int(16) NOT NULL,
  `No_Hp` int(13) NOT NULL,
  `Alamat` longtext NOT NULL,
  `Anak_Ke` int(1) NOT NULL,
  `Kelas` int(2) NOT NULL,
  `Kelas_Type` varchar(10) NOT NULL,
  `Jurusan` varchar(90) NOT NULL,
  `Tahun_Masuk` year(4) NOT NULL,
  `Tahun_Lulus` year(4) NOT NULL,
  `No_Seri_Ijazah` int(89) NOT NULL,
  `SMP` varchar(50) NOT NULL,
  `Nama_Ayah` varchar(50) NOT NULL,
  `Lulusan_Ayah` varchar(30) NOT NULL,
  `Pekerjaan_Ayah` varchar(40) NOT NULL,
  `Nama_Ibu` varchar(50) NOT NULL,
  `Lulusan_Ibu` varchar(30) NOT NULL,
  `Pekerjaan_Ibu` varchar(40) NOT NULL,
  `Foto` varchar(40) NOT NULL,
  `ID_Walikelas` int(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `biodata_siswa`
--

INSERT INTO `biodata_siswa` (`ID`, `username`, `password`, `status`, `Nama_Lengkap`, `Tempat_Lahir`, `Tanggal_Lahir`, `Jenis_Kelamin`, `No_Induk_Siswa`, `NISN`, `NIK`, `No_Hp`, `Alamat`, `Anak_Ke`, `Kelas`, `Kelas_Type`, `Jurusan`, `Tahun_Masuk`, `Tahun_Lulus`, `No_Seri_Ijazah`, `SMP`, `Nama_Ayah`, `Lulusan_Ayah`, `Pekerjaan_Ayah`, `Nama_Ibu`, `Lulusan_Ibu`, `Pekerjaan_Ibu`, `Foto`, `ID_Walikelas`) VALUES
(24, 'a', '123', 'Siswa', '123', '', '0000-00-00', '', 0, 12312, 0, 0, '', 0, 0, '2000', 'Teknik Komputer Dan Jaringan', '0000', '0000', 0, '', '', '', '', '', '', '', '', 18),
(26, 'Arjuna', '123', 'Siswa', 'Arjuna Lanang Adiwarsana', '', '0000-00-00', '', 0, 13123131, 0, 0, '', 0, 12, '473', 'Rekayasa Perangkat Lunak', '0000', '0000', 0, '', '', '', '', '', '', '', 'images.jpg', 19),
(29, 'user', 'user', 'Siswa', 'Arjuna Lanang Adiwarsana', '', '0000-00-00', '', 0, 123133, 0, 0, '', 0, 10, '473', 'Rekayasa Perangkat Lunak', '0000', '0000', 0, '', '', '', '', '', '', '', 'images.png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `Nama_Jurusan` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`Nama_Jurusan`) VALUES
('Akuntansi'),
('Bisnis Daring Dan Pemasaran'),
('Management Perkantoran'),
('Perhotelen'),
('Produksi Film'),
('Rekayasa Perangkat Lunak'),
('Tata Busana'),
('Teknik Komputer Dan Jaringan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelas`
--

CREATE TABLE `kelas` (
  `Nama_Tipe_Kelas` varchar(30) NOT NULL,
  `Tipe_Kelas` varchar(40) NOT NULL,
  `Kelas` int(2) NOT NULL,
  `Jurusan` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelas`
--

INSERT INTO `kelas` (`Nama_Tipe_Kelas`, `Tipe_Kelas`, `Kelas`, `Jurusan`) VALUES
('1', '134', 11, 'Teknik Komputer Dan Jaringan'),
('1', '2000', 12, 'Teknik Komputer Dan Jaringan'),
('RPL 1', '473', 12, 'Rekayasa Perangkat Lunak'),
('1', '849', 10, 'Teknik Komputer Dan Jaringan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelulusan_siswa`
--

CREATE TABLE `kelulusan_siswa` (
  `ID` int(255) NOT NULL,
  `ID_Biodata_Siswa` int(255) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Tahun` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kelulusan_siswa`
--

INSERT INTO `kelulusan_siswa` (`ID`, `ID_Biodata_Siswa`, `Username`, `Password`, `Tahun`) VALUES
(3, 24, 'a', '123', '2024');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status`
--

CREATE TABLE `status` (
  `Nama_Status` varchar(30) NOT NULL,
  `Level` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status`
--

INSERT INTO `status` (`Nama_Status`, `Level`) VALUES
('Admin', 1),
('None', 0),
('Siswa', 3),
('Walikelas', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tingkatan_kelas`
--

CREATE TABLE `tingkatan_kelas` (
  `Kelas` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tingkatan_kelas`
--

INSERT INTO `tingkatan_kelas` (`Kelas`) VALUES
(0),
(10),
(11),
(12),
(99);

-- --------------------------------------------------------

--
-- Struktur dari tabel `walikelas`
--

CREATE TABLE `walikelas` (
  `ID` int(11) NOT NULL,
  `Username` varchar(120) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `Nama_Lengkap` varchar(120) NOT NULL,
  `Jurusan` varchar(40) NOT NULL,
  `Kelas` int(2) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Tipe_Kelas` varchar(40) DEFAULT NULL,
  `Foto` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `walikelas`
--

INSERT INTO `walikelas` (`ID`, `Username`, `Password`, `Nama_Lengkap`, `Jurusan`, `Kelas`, `Status`, `Tipe_Kelas`, `Foto`) VALUES
(16, '1', '1a', '1', 'Teknik Komputer Dan Jaringan', 10, 'Walikelas', '849', ''),
(17, '2', '2', '2', 'Teknik Komputer Dan Jaringan', 11, 'Walikelas', '134', ''),
(18, '3', '3', '3', 'Teknik Komputer Dan Jaringan', 12, 'Walikelas', '2000', ''),
(19, 'Rully', '123', 'Rully Widiastutik', 'Rekayasa Perangkat Lunak', 12, 'Walikelas', '473', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `biodata_siswa`
--
ALTER TABLE `biodata_siswa`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `status` (`status`),
  ADD KEY `ID_Walikelas` (`ID_Walikelas`),
  ADD KEY `Jurusan` (`Jurusan`),
  ADD KEY `Kelas_Type` (`Kelas_Type`),
  ADD KEY `Kelas` (`Kelas`);

--
-- Indeks untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`Nama_Jurusan`);

--
-- Indeks untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`Tipe_Kelas`),
  ADD KEY `Kelas` (`Kelas`),
  ADD KEY `Jurusan` (`Jurusan`);

--
-- Indeks untuk tabel `kelulusan_siswa`
--
ALTER TABLE `kelulusan_siswa`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Biodata_Siswa` (`ID_Biodata_Siswa`);

--
-- Indeks untuk tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`Nama_Status`);

--
-- Indeks untuk tabel `tingkatan_kelas`
--
ALTER TABLE `tingkatan_kelas`
  ADD PRIMARY KEY (`Kelas`);

--
-- Indeks untuk tabel `walikelas`
--
ALTER TABLE `walikelas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Status` (`Status`),
  ADD KEY `Jurusan` (`Jurusan`),
  ADD KEY `Kelas` (`Kelas`),
  ADD KEY `Tipe_Kelas` (`Tipe_Kelas`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `biodata_siswa`
--
ALTER TABLE `biodata_siswa`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `kelulusan_siswa`
--
ALTER TABLE `kelulusan_siswa`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `walikelas`
--
ALTER TABLE `walikelas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`status`) REFERENCES `status` (`Nama_Status`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `biodata_siswa`
--
ALTER TABLE `biodata_siswa`
  ADD CONSTRAINT `biodata_siswa_ibfk_1` FOREIGN KEY (`Jurusan`) REFERENCES `jurusan` (`Nama_Jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biodata_siswa_ibfk_2` FOREIGN KEY (`status`) REFERENCES `status` (`Nama_Status`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biodata_siswa_ibfk_3` FOREIGN KEY (`ID_Walikelas`) REFERENCES `walikelas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biodata_siswa_ibfk_4` FOREIGN KEY (`Kelas_Type`) REFERENCES `kelas` (`Tipe_Kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `biodata_siswa_ibfk_5` FOREIGN KEY (`Kelas`) REFERENCES `tingkatan_kelas` (`Kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`Kelas`) REFERENCES `tingkatan_kelas` (`Kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`Jurusan`) REFERENCES `jurusan` (`Nama_Jurusan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kelulusan_siswa`
--
ALTER TABLE `kelulusan_siswa`
  ADD CONSTRAINT `kelulusan_siswa_ibfk_1` FOREIGN KEY (`ID_Biodata_Siswa`) REFERENCES `biodata_siswa` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `walikelas`
--
ALTER TABLE `walikelas`
  ADD CONSTRAINT `walikelas_ibfk_1` FOREIGN KEY (`Jurusan`) REFERENCES `jurusan` (`Nama_Jurusan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `walikelas_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `status` (`Nama_Status`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `walikelas_ibfk_3` FOREIGN KEY (`Kelas`) REFERENCES `tingkatan_kelas` (`Kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `walikelas_ibfk_4` FOREIGN KEY (`Tipe_Kelas`) REFERENCES `kelas` (`Tipe_Kelas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
