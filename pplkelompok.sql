-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Nov 2023 pada 17.58
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
-- Database: `pplkelompok`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `accounts`
--

CREATE TABLE `accounts` (
  `nim_nip` varchar(14) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `role` varchar(15) NOT NULL DEFAULT 'mahasiswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `accounts`
--

INSERT INTO `accounts` (`nim_nip`, `email`, `password`, `role`) VALUES
('00000000000000', 'departement@gmail.com', '123', 'departement'),
('1111111111111', 'bar@gmail.com', '123', 'dosen'),
('12121212121212', 'admin1@univ.ac.id', 'admin123', 'operator'),
('2055928291012', 'tempest@gmail.com', 'blackmarket12', 'mahasiswa'),
('2055928291013', 'akbar@gmail.com', '123', 'mahasiswa'),
('22222222222222', 'shid@gmail.com', '123', 'dosen'),
('2406012104005', 'rimuru7@gmail.com', '123', 'mahasiswa'),
('24060121120075', 'shid1@gmail.com', '12345', 'mahasiswa'),
('24060121130032', 'ivan123@gmail.com', '!M4n7bAStrf)', 'mahasiswa'),
('24060121130054', 'asd@gmail.com', '123', 'mahasiswa'),
('24060121130075', 'shidkigaming7@gmail.com', '&c10l5zlUhX!', 'mahasiswa'),
('24060121130076', 'ivan@gmail.com', 'K&FEeS$7P4xr', 'mahasiswa'),
('24060121140095', 'ardiyan@gmail.com', 'q0L@2Rj3x2k!', 'mahasiswa'),
('24060121140096', 'mahasiswa1@gmail.com', 'dP0azrTCm37u', 'mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `departements`
--

CREATE TABLE `departements` (
  `nip` varchar(14) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `departements`
--

INSERT INTO `departements` (`nip`, `nama`, `email`) VALUES
('00000000000000', 'Departement Informatika', 'departement@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosens`
--

CREATE TABLE `dosens` (
  `nip` varchar(14) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dosens`
--

INSERT INTO `dosens` (`nip`, `nama`, `email`) VALUES
('11111111111111', 'Akbar Maryan Bagaskara, S.Kom', 'bar@gmail.com'),
('22222222222222', 'Muhammad Ridwan Ash\'shidqi, M.Kom', 'shid@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `info_irs`
--

CREATE TABLE `info_irs` (
  `nim` varchar(20) NOT NULL,
  `smt` int(2) NOT NULL,
  `sks` int(2) NOT NULL,
  `scan_irs` text NOT NULL,
  `stat_cek` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `info_irs`
--

INSERT INTO `info_irs` (`nim`, `smt`, `sks`, `scan_irs`, `stat_cek`) VALUES
('2406012104005', 1, 24, 'FT20231112101509.pdf', 2),
('2406012104005', 2, 24, 'FT20231110082105.pdf', 2),
('2406012104005', 3, 24, 'FT20231112101522.pdf', 2),
('2406012104005', 4, 24, 'FT20231114115633.pdf', 2),
('2406012104005', 5, 24, 'FT20231114115642.pdf', 2),
('2406012104005', 6, 24, 'FT20231114115653.pdf', 2),
('2406012104005', 7, 24, 'FT20231114120214.pdf', 1),
('24060121120075', 1, 24, 'FT20231114044058.pdf', 1),
('24060121130032', 1, 23, 'FT20231111072433.pdf', 1),
('24060121130075', 1, 24, 'FT20231108064658.pdf', 1),
('24060121140096', 1, 24, 'FT20231114092329.pdf', 2),
('24060121140096', 2, 24, 'FT20231114092336.pdf', 2),
('24060121140096', 3, 24, 'FT20231114092344.pdf', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `info_khs`
--

CREATE TABLE `info_khs` (
  `nim` varchar(14) NOT NULL,
  `smt` int(2) NOT NULL,
  `sks` int(2) NOT NULL,
  `sks_kumulatif` int(2) NOT NULL,
  `ip_smt` float NOT NULL,
  `ipk` float NOT NULL,
  `scan_khs` text NOT NULL,
  `stat_cek` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `info_khs`
--

INSERT INTO `info_khs` (`nim`, `smt`, `sks`, `sks_kumulatif`, `ip_smt`, `ipk`, `scan_khs`, `stat_cek`) VALUES
('2406012104005', 1, 24, 24, 3.99, 3.92, 'FT20231108045846.pdf', 1),
('2406012104005', 2, 24, 24, 4, 4, 'FT20231114085402.pdf', 1),
('2406012104005', 3, 24, 24, 4, 4, 'FT20231114120000.pdf', 1),
('2406012104005', 4, 24, 24, 4, 4, 'FT20231114120015.pdf', 1),
('2406012104005', 5, 24, 24, 4, 4, 'FT20231114120026.pdf', 1),
('2406012104005', 6, 24, 24, 4, 4, 'FT20231114120042.pdf', 1),
('2406012104005', 7, 24, 24, 4, 4, 'FT20231114020825.pdf', 1),
('24060121120075', 1, 24, 24, 4, 4, 'FT20231114044145.pdf', 1),
('24060121140096', 1, 24, 24, 4, 4, 'FT20231114092424.pdf', 1),
('24060121140096', 2, 24, 24, 4, 4, 'FT20231114092447.pdf', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `info_pkls`
--

CREATE TABLE `info_pkls` (
  `nim` varchar(14) NOT NULL,
  `nilai_pkl` float NOT NULL,
  `scan_pkl` text NOT NULL,
  `semester` int(2) NOT NULL,
  `stat_cek` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `info_pkls`
--

INSERT INTO `info_pkls` (`nim`, `nilai_pkl`, `scan_pkl`, `semester`, `stat_cek`) VALUES
('2406012104005', 100, 'FT20231114120054.pdf', 6, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `info_skripsis`
--

CREATE TABLE `info_skripsis` (
  `nim` varchar(14) NOT NULL,
  `semester` int(2) NOT NULL,
  `nilai_skripsi` float NOT NULL,
  `tgl_lulus` date DEFAULT NULL,
  `lama_study` int(2) DEFAULT NULL,
  `scan_skripsi` text NOT NULL,
  `stat_cek` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `info_skripsis`
--

INSERT INTO `info_skripsis` (`nim`, `semester`, `nilai_skripsi`, `tgl_lulus`, `lama_study`, `scan_skripsi`, `stat_cek`) VALUES
('2406012104005', 7, 100, '2023-11-14', 1, 'FT20231114020622.pdf', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kab_kots`
--

CREATE TABLE `kab_kots` (
  `id_kab_kot` int(3) NOT NULL,
  `id_prov` int(2) NOT NULL,
  `kab_kot` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kab_kots`
--

INSERT INTO `kab_kots` (`id_kab_kot`, `id_prov`, `kab_kot`) VALUES
(1, 11, 'Kabupaten Aceh Selatan'),
(1, 12, 'Kabupaten Tapanuli Tengah'),
(1, 13, 'Kabupaten Pesisir Selatan'),
(1, 14, 'Kabupaten Kampar'),
(1, 15, 'Kabupaten Kerinci'),
(1, 16, 'Kabupaten Ogan Komering Ulu'),
(1, 17, 'Kabupaten Bengkulu Selatan'),
(1, 18, 'Kabupaten Lampung Selatan'),
(1, 19, 'Kabupaten Bangka'),
(1, 21, 'Kabupaten Bintan'),
(1, 31, 'Kabupaten Administrasi Kepulauan Seribu'),
(1, 32, 'Kabupaten Bogor'),
(1, 33, 'Kabupaten Cilacap'),
(1, 34, 'Kabupaten Kulon Progo'),
(1, 35, 'Kabupaten Pacitan'),
(1, 36, 'Kabupaten Pandeglang'),
(1, 51, 'Kabupaten Jembrana'),
(1, 52, 'Kabupaten Lombok Barat'),
(1, 53, 'Kabupaten Kupang'),
(1, 61, 'Kabupaten Sambas'),
(1, 62, 'Kabupaten Kotawaringin Barat'),
(1, 63, 'Kabupaten Tanah Laut'),
(1, 64, 'Kabupaten Paser'),
(1, 65, 'Kabupaten Bulungan'),
(1, 71, 'Kabupaten Bolaang Mongondow'),
(1, 72, 'Kabupaten Banggai'),
(1, 73, 'Kabupaten Kepulauan Selayar'),
(1, 74, 'Kabupaten Kolaka'),
(1, 75, 'Kabupaten Gorontalo'),
(1, 76, 'Kabupaten Pasangkayu'),
(1, 81, 'Kabupaten Maluku Tengah'),
(1, 82, 'Kabupaten Halmahera Barat'),
(1, 91, 'Kabupaten Merauke'),
(1, 92, 'Kabupaten Sorong'),
(2, 11, 'Kabupaten Aceh Tenggara'),
(2, 12, 'Kanupaten Tapanuli Utara'),
(2, 13, 'Kabupaten Solok'),
(2, 14, 'Kabupaten Indragiri Hulu'),
(2, 15, 'Kabupaten Merangin'),
(2, 16, 'Kabupaten Ogan Komering Ilir'),
(2, 17, 'Kabupaten Rejang Lebong'),
(2, 18, 'Kabupaten Lampung Tengah'),
(2, 19, 'Kabupaten Belitung'),
(2, 21, 'Kabupaten Karimun'),
(2, 32, 'Kabupaten Sukabumi'),
(2, 33, 'Kabupaten Banyumas'),
(2, 34, 'Kabupaten Bantul'),
(2, 35, 'Kabupaten Ponorogo'),
(2, 36, 'Kabupaten Lebak'),
(2, 51, 'Kabupaten Tabanan'),
(2, 52, 'Kabupaten Lombok Tengah'),
(2, 53, 'Kabupaten Timor Tengah Selatan'),
(2, 61, 'Kabupaten Mempawah'),
(2, 62, 'Kabupaten Kotawaringin Timur'),
(2, 63, 'Kabupaten Kotabaru'),
(2, 64, 'Kabupaten Kutai Kartanegara'),
(2, 65, 'Kabupaten Malinau'),
(2, 71, 'Kabupaten Minahasa'),
(2, 72, 'Kabupaten Poso'),
(2, 73, 'Kabupaten Bulukumba'),
(2, 74, 'Kabupaten Konawe'),
(2, 75, 'Kabupaten Boalemo'),
(2, 76, 'Kabupaten Mamuju'),
(2, 81, 'Kabupaten Maluku Tenggara'),
(2, 82, 'Kabupaten Halmahera Tengah'),
(2, 91, 'Kabupaten Jayawijaya'),
(2, 92, 'Kabupaten Manokwari'),
(3, 11, 'Kabupaten Aceh Timur'),
(3, 12, 'Kabupaten Tapanuli Selatan'),
(3, 13, 'Kabupaten Sijunjung'),
(3, 14, 'Kabupaten Bengkalis'),
(3, 15, 'Kabupaten Sarolangun'),
(3, 16, 'Kabupaten Muara Enim'),
(3, 17, 'Kabupaten Bengkulu Utara'),
(3, 18, 'Kabupaten Lampung Utara'),
(3, 19, 'Kabupaten Bangka Selatan'),
(3, 21, 'Kabupaten Natuna'),
(3, 32, 'Kabupaten Cianjur'),
(3, 33, 'Kabupaten Purbalingga'),
(3, 34, 'Kabupaten Gunungkidul'),
(3, 35, 'Kabupaten Trenggalek'),
(3, 36, 'Kabupaten Tangerang'),
(3, 51, 'Kabupaten Badung'),
(3, 52, 'Kabupaten Lombok Timur'),
(3, 53, 'Kabupaten Timor Tengah Utara'),
(3, 61, 'Kabupaten Sanggau'),
(3, 62, 'Kabupaten Kapuas'),
(3, 63, 'Kabupaten Banjar'),
(3, 64, 'Kabupaten Berau'),
(3, 65, 'Kabupaten Nunukan'),
(3, 71, 'Kabupaten Kepulauan Sangihe'),
(3, 72, 'Kabupaten Donggala'),
(3, 73, 'Kabupaten Bantaeng'),
(3, 74, 'Kabupaten Muna'),
(3, 75, 'Kabupaten Bone Bolango'),
(3, 76, 'Kabupaten Mamasa'),
(3, 81, 'Kabupaten Kepulauan Tanimbar'),
(3, 82, 'Kabupaten Halmahera Utara'),
(3, 91, 'Kabupaten Jayapura'),
(3, 92, 'Kabupaten Fak Fak'),
(4, 11, 'Kabupaten Aceh Tengah'),
(4, 12, 'Kabupaten Nias'),
(4, 13, 'Kabupaten Tanah Datar'),
(4, 14, 'Kabupaten Indragiri Hilir'),
(4, 15, 'Kabupaten Batanghari'),
(4, 16, 'Kabupaten Lahat'),
(4, 17, 'Kabupaten Kaur'),
(4, 18, 'Kabupaten Lampung Barat'),
(4, 19, 'Kabupaten Bangka Tengah'),
(4, 21, 'Kabupaten Lingga'),
(4, 32, 'Kabupaten Bandung'),
(4, 33, 'Kabupaten Banjarnegara'),
(4, 34, 'Kabupaten Sleman'),
(4, 35, 'Kabupaten Tulungagung'),
(4, 36, 'Kabupaten Serang'),
(4, 51, 'Kabupaten Gianyar'),
(4, 52, 'Kabupaten Sumbawa'),
(4, 53, 'Kabupaten Belu'),
(4, 61, 'Kabupaten Ketapang'),
(4, 62, 'Kabupaten Barito Selatan'),
(4, 63, 'Kabupaten Barito Kuala'),
(4, 65, 'Kabupaten Tana Tidung'),
(4, 71, 'Kabupaten Kepulauan Talaud'),
(4, 72, 'Kabupaten Toli Toli'),
(4, 73, 'Kabupaten Jeneponto'),
(4, 74, 'Kabupaten Buton'),
(4, 75, 'Kabupaten Pahuwato'),
(4, 76, 'Kabupaten Polewali Mandar'),
(4, 81, 'Kabupaten Buru'),
(4, 82, 'Kabupaten Halmahera Selatan'),
(4, 91, 'Kabupaten Nabire'),
(4, 92, 'Kabupaten Sorong Selatan'),
(5, 11, 'Kabupaten Aceh Barat'),
(5, 12, 'Kabupaten Langkat'),
(5, 13, 'Kabupaten Padang Pariaman'),
(5, 14, 'Kabupaten Pelalawan'),
(5, 15, 'Kabupaten Muaro Jambi'),
(5, 16, 'Kabupaten Musi Rawas'),
(5, 17, 'Kabupaten Seluma'),
(5, 18, 'Kabupaten Tulang Bawang'),
(5, 19, 'Kabupaten Bangka Barat'),
(5, 21, 'Kabupaten Kepulauan Anambas'),
(5, 32, 'Kabupaten Garut'),
(5, 33, 'Kabupaten Kebumen'),
(5, 35, 'Kabupaten Blitar'),
(5, 51, 'Kabupaten Klungkung'),
(5, 52, 'Kabupaten Dompu'),
(5, 53, 'Kabupaten Alor'),
(5, 61, 'Kabupaten Sintang'),
(5, 62, 'Kabupaten Barito Utara'),
(5, 63, 'Kabupaten Tapin'),
(5, 71, 'Kabupaten Minahasa Selatan'),
(5, 72, 'Kabupaten Buol'),
(5, 73, 'Kabupaten Takalar'),
(5, 74, 'Kabupaten Konawe Selatan'),
(5, 75, 'Kabupaten Gorontalo Utara'),
(5, 76, 'Kabupaten Majene'),
(5, 81, 'Kabupaten Seram Bagian Timur'),
(5, 82, 'Kabupaten Kepulauan Sula'),
(5, 91, 'Kabupaten Kepulauan Yapen'),
(5, 92, 'Kabupaten Raja Ampat'),
(6, 11, 'Kabupaten Aceh Besar'),
(6, 12, 'Kabupaten Karo'),
(6, 13, 'Kabupaten Agam'),
(6, 14, 'Kabupaten Rokan Hulu'),
(6, 15, 'Kabupaten Tanjung Jabung Barat'),
(6, 16, 'Kabupaten Musi Banyuasin'),
(6, 17, 'Kabupaten Muko Muko'),
(6, 18, 'Kabupaten Tanggamus'),
(6, 19, 'Kabupaten Belitung Timur'),
(6, 32, 'Kabupaten Tasikmalaya'),
(6, 33, 'Kabupaten Purworejo'),
(6, 35, 'Kabupaten Kediri'),
(6, 51, 'Kabupaten Bangli'),
(6, 52, 'Kabupaten Bima'),
(6, 53, 'Kabupaten Flores Timur'),
(6, 61, 'Kabupaten Kapuas Hulu'),
(6, 62, 'Kabupaten Katingan'),
(6, 63, 'Kabupaten Hulu Sungai Selatan'),
(6, 71, 'Kabupaten Minahasa Utara'),
(6, 72, 'Kabupaten Morowali'),
(6, 73, 'Kabupaten Gowa'),
(6, 74, 'Kabupaten Bombana'),
(6, 76, 'Kabupaten Mamuju Tengah'),
(6, 81, 'Kabupaten Seram Bagian Barat'),
(6, 82, 'Kabupaten Halmahera Timur'),
(6, 91, 'Kabupaten Biak Numfor'),
(6, 92, 'Kabupaten Teluk Bintuni'),
(7, 11, 'Kabupaten Pidie'),
(7, 12, 'Kabupaten Deli Serdang'),
(7, 13, 'Kabupaten Lima Puluh Kota'),
(7, 14, 'Kabupaten Rokan Hilir'),
(7, 15, 'Kabupaten Tanjung Jabung Timur'),
(7, 16, 'Kabupaten Banyuasin'),
(7, 17, 'Kabupaten Lebong'),
(7, 18, 'Kabupaten Lampung Timur'),
(7, 32, 'Kabupaten Ciamis'),
(7, 33, 'Kabupaten Wonosobo'),
(7, 35, 'Kabupaten Malang'),
(7, 51, 'Kabupaten Karangasem'),
(7, 52, 'Kabupaten Sumbawa Barat'),
(7, 53, 'Kabupaten Sikka'),
(7, 61, 'Kabupaten Bengkayang'),
(7, 62, 'Kabupaten Seruyan'),
(7, 63, 'Kabupaten Hulu Sungai Tengah'),
(7, 64, 'Kabupaten Kutai Barat'),
(7, 71, 'Kabupaten Minahasa Tenggara'),
(7, 72, 'Kabupaten Banggai Kepulauan'),
(7, 73, 'Kabupaten Sinjai'),
(7, 74, 'Kabupaten Wakatobi'),
(7, 81, 'Kabupaten Kepulauan Aru'),
(7, 82, 'Kabupaten Pulau Morotai'),
(7, 91, 'Kabupaten Puncak Jaya'),
(7, 92, 'Kabupaten Teluk Wondama'),
(8, 11, 'Kabupaten Aceh Utara'),
(8, 12, 'Kabupaten Simalungun'),
(8, 13, 'Kabupaten Pasaman'),
(8, 14, 'Kabupaten Siak'),
(8, 15, 'Kabupaten Bungo'),
(8, 16, 'Kabupaten Ogan Komering Ulutimur'),
(8, 17, 'Kabupaten Kepahiang'),
(8, 18, 'Kabupaten Way Kanan'),
(8, 32, 'Kabupaten Kuningan'),
(8, 33, 'Kabupaten Magelang'),
(8, 35, 'Kabupaten Lumajang'),
(8, 51, 'Kabupaten Buleleng'),
(8, 52, 'Kabupaten Lombok Utara'),
(8, 53, 'Kabupaten Ende'),
(8, 61, 'Kabupaten Landak'),
(8, 62, 'Kabupaten Sukamara'),
(8, 63, 'Kabupaten Hulu Sungai Utara'),
(8, 64, 'Kabupaten Kutai Timur'),
(8, 71, 'Kabupaten Bolaang Mongondowutara'),
(8, 72, 'Kabupaten Parigi Moutong'),
(8, 73, 'Kabupaten Bone'),
(8, 74, 'Kabupaten Kolaka Utara'),
(8, 81, 'Kabupaten Maluku Barat Daya'),
(8, 82, 'Kabupaten Pulau Taliabu'),
(8, 91, 'Kabupaten Paniai'),
(8, 92, 'Kabupaten Kaimana'),
(9, 11, 'Kabupaten Simeulue'),
(9, 12, 'Kabupaten Asahan'),
(9, 13, 'Kabupaten Kepulauan Mentawai'),
(9, 14, 'Kabupaten Kuantan Singingi'),
(9, 15, 'Kabupaten Tebo'),
(9, 16, 'Kabupaten Ogan Komering Uluselatan'),
(9, 17, 'Kabupaten Bengkulu Tengah'),
(9, 18, 'Kabupaten Pesawaran'),
(9, 32, 'Kabupaten Cirebon'),
(9, 33, 'Kabupaten Boyolali'),
(9, 35, 'Kabupaten Jember'),
(9, 53, 'Kabupaten Ngada'),
(9, 61, 'Kabupaten Sekadau'),
(9, 62, 'Kabupaten Lamandau'),
(9, 63, 'Kabupaten Tabalong'),
(9, 64, 'Kabupaten Penajam Paser Utara'),
(9, 71, 'Kabupaten Kepulauan Siau Tagulandangbiaro'),
(9, 72, 'Kabupaten Tojo Una Una'),
(9, 73, 'Kabupaten Maros'),
(9, 74, 'Kabupaten Konawe Utara'),
(9, 81, 'Kabupaten Buru Selatan'),
(9, 91, 'Kabupaten Mimika'),
(9, 92, 'Kabupaten Tambrauw'),
(10, 11, 'Kabupaten Aceh Singkil'),
(10, 12, 'Kabupaten Labuhan Batu'),
(10, 13, 'Kabupaten Dharmasraya'),
(10, 14, 'Kabupaten Kepulauan Meranti'),
(10, 16, 'Kabupaten Ogan Ilir'),
(10, 18, 'Kabupaten Pringsewu'),
(10, 32, 'Kabupaten Majalengka'),
(10, 33, 'Kabupaten Klaten'),
(10, 35, 'Kabupaten Banyuwangi'),
(10, 53, 'Kabupaten Manggarai'),
(10, 61, 'Kabupaten Melawi'),
(10, 62, 'Kabupaten Gunung Mas'),
(10, 63, 'Kabupaten Tanah Bumbu'),
(10, 71, 'Kabupaten Bolaang Mongondowtimur'),
(10, 72, 'Kabupaten Sigi'),
(10, 73, 'Kabupaten Pangkajene Kepulauan'),
(10, 74, 'Kabupaten Buton Utara'),
(10, 91, 'Kabupaten Sarmi'),
(10, 92, 'Kabupaten Maybrat'),
(11, 11, 'Kabupaten Bireuen'),
(11, 12, 'Kabupaten Dairi'),
(11, 13, 'Kabupaten Solok Selatan'),
(11, 16, 'Kabupaten Empat Lawang'),
(11, 18, 'Kabupaten Mesuji'),
(11, 32, 'Kabupaten Sumedang'),
(11, 33, 'Kabupaten Sukoharjo'),
(11, 35, 'Kabupaten Bondowoso'),
(11, 53, 'Kabupaten Sumba Timur'),
(11, 61, 'Kabupaten Kayong Utara'),
(11, 62, 'Kabupaten Pulang Pisau'),
(11, 63, 'Kabupaten Balangan'),
(11, 64, 'Kabupaten Mahakam Ulu'),
(11, 71, 'Kabupaten Bolaang Mongondowselatan'),
(11, 72, 'Kabupaten Banggai Laut'),
(11, 73, 'Kabupaten Barru'),
(11, 74, 'Kabupaten Kolaka Timur'),
(11, 91, 'Kabupaten Keerom'),
(11, 92, 'Kabupaten Manokwari Selatan'),
(12, 11, 'Kabupaten Aceh Barat Daya'),
(12, 12, 'Kabupaten Toba Samosir'),
(12, 13, 'Kabupaten Pasaman Barat'),
(12, 16, 'Kabupaten Penukal Abab Lematangilir'),
(12, 18, 'Kabupaten Tulang Bawang Barat'),
(12, 32, 'Kabupaten Indramayu'),
(12, 33, 'Kabupaten Wonogiri'),
(12, 35, 'Kabupaten Situbondo'),
(12, 53, 'Kabupaten Sumba Barat'),
(12, 61, 'Kabupaten Kubu Raya'),
(12, 62, 'Kabupaten Murung Raya'),
(12, 72, 'Kabupaten Morowali Utara'),
(12, 73, 'Kabupaten Soppeng'),
(12, 74, 'Kabupaten Konawe Kepulauan'),
(12, 91, 'Kabupaten Pegunungan Bintang'),
(12, 92, 'Kabupaten Pegunungan Arfak'),
(13, 11, 'Kabupaten Gayo Lues'),
(13, 12, 'Kabupaten Mandailing Natal'),
(13, 16, 'Kabupaten Musi Rawas Utara'),
(13, 18, 'Kabupaten Pesisir Barat'),
(13, 32, 'Kabupaten Subang'),
(13, 33, 'Kabupaten Karanganyar'),
(13, 35, 'Kabupaten Probolinggo'),
(13, 53, 'Kabupaten Lembata'),
(13, 62, 'Kabupaten Barito Timur'),
(13, 73, 'Kabupaten Wajo'),
(13, 74, 'Kabupaten Muna Barat'),
(13, 91, 'Kabupaten Yahukimo'),
(14, 11, 'Kabupaten Aceh Jaya'),
(14, 12, 'Kabupaten Nias Selatan'),
(14, 32, 'Kabupaten Purwakarta'),
(14, 33, 'Kabupaten Sragen'),
(14, 35, 'Kabupaten Pasuruan'),
(14, 53, 'Kabupaten Rote Ndao'),
(14, 73, 'Kabupaten Sidenreng Rappang'),
(14, 74, 'Kabupaten Buton Tengah'),
(14, 91, 'Kabupaten Tolikara'),
(15, 11, 'Kabupaten Nagan Raya'),
(15, 12, 'Kabupaten PakPak Bharat'),
(15, 32, 'Kabupaten Karawang'),
(15, 33, 'Kabupaten Grobogan'),
(15, 35, 'Kabupaten Sidoarjo'),
(15, 53, 'Kabupaten Manggarai Barat'),
(15, 73, 'Kabupaten Pinrang'),
(15, 74, 'Kabupaten Buton Selatan'),
(15, 91, 'Kabupaten Waropen'),
(16, 11, 'Kabupaten Aceh Tamiang'),
(16, 12, 'Kabupaten Humbang Hasundutan'),
(16, 32, 'Kabupaten Bekasi'),
(16, 33, 'Kabupaten Blora'),
(16, 35, 'Kabupaten Mojokerto'),
(16, 53, 'Kabupaten Nagekeo'),
(16, 73, 'Kabupaten Enrekang'),
(16, 91, 'Kabupaten Boven Digoel'),
(17, 11, 'Kabupaten Bener Meriah'),
(17, 12, 'Kabupaten Samosir'),
(17, 32, 'Kabupaten Bandung Barat'),
(17, 33, 'Kabupaten Rembang'),
(17, 35, 'Kabupaten Jombang'),
(17, 53, 'Kabupaten Sumba Tengah'),
(17, 73, 'Kabupaten Luwu'),
(17, 91, 'Kabupaten Mappi'),
(18, 11, 'Kabupaten Pidie Jaya'),
(18, 12, 'Kabupaten Serdang Bedagai'),
(18, 32, 'Kabupaten Pangandaran'),
(18, 33, 'Kabupaten Pati'),
(18, 35, 'Kabupaten Nganjuk'),
(18, 53, 'Kabupaten Sumba Barat Daya'),
(18, 73, 'Kabupaten Tana Toraja'),
(18, 91, 'Kabupaten Asmat'),
(19, 12, 'Kabupaten Batu Bara'),
(19, 33, 'Kabupaten Kudus'),
(19, 35, 'Kabupaten Madiun'),
(19, 53, 'Kabupaten Manggarai Timur'),
(19, 91, 'Kabupaten Supiori'),
(20, 12, 'Kabupaten Padang Lawas Utara'),
(20, 33, 'Kabupaten Jepara'),
(20, 35, 'Kabupaten Magetan'),
(20, 53, 'Kabupaten Sabu Raijua'),
(20, 91, 'Kabupaten Mamberamo Raya'),
(21, 12, 'Kabupaten Padang Lawas'),
(21, 33, 'Kabupaten Demak'),
(21, 35, 'Kabupaten Ngawi'),
(21, 53, 'Kabupaten Malaka'),
(21, 91, 'Kabupaten Mamberamo Tengah'),
(22, 12, 'Kabupaten Labuhanbatu Selatan'),
(22, 33, 'Kabupaten Semarang'),
(22, 35, 'Kabupaten Bojonegoro'),
(22, 73, 'Kabupaten Luwu Utara'),
(22, 91, 'Kabupaten Yalimo'),
(23, 12, 'Kabupaten Labuhanbatu Utara'),
(23, 33, 'Kabupaten Temanggung'),
(23, 35, 'Kabupaten Tuban'),
(23, 91, 'Kabupaten Lanny Jaya'),
(24, 12, 'Kabupaten Nias Utara'),
(24, 33, 'Kabupaten Kendal'),
(24, 35, 'Kabupaten Lamongan'),
(24, 73, 'Kabupaten Luwu Timur'),
(24, 91, 'Kabupaten Nduga'),
(25, 12, 'Kabupaten Nias Barat'),
(25, 33, 'Kabupaten Batang'),
(25, 35, 'Kabupaten Gresik'),
(25, 91, 'Kabupaten Puncak'),
(26, 33, 'Kabupaten Pekalongan'),
(26, 35, 'Kabupaten Bangkalan'),
(26, 73, 'Kabupaten Toraja Utara'),
(26, 91, 'Kabupaten Dogiyai'),
(27, 33, 'Kabupaten Pemalang'),
(27, 35, 'Kabupaten Sampang'),
(27, 91, 'Kabupaten Intan Jaya'),
(28, 33, 'Kabupaten Tegal'),
(28, 35, 'Kabupaten Pamekasan'),
(28, 91, 'Kabupaten Deiyai'),
(29, 33, 'Kabupaten Brebes'),
(29, 35, 'Kabupaten Sumenep'),
(71, 11, 'Kota Banda Aceh'),
(71, 12, 'Kota Medan'),
(71, 13, 'Kota Padang'),
(71, 14, 'Kota Pekanbaru'),
(71, 15, 'Kota Jambi'),
(71, 16, 'Kota Palembang'),
(71, 17, 'Kota Bengkulu'),
(71, 18, 'Kota Bandar Lampung'),
(71, 19, 'Kota Pangkal Pinang'),
(71, 21, 'Kota Batam'),
(71, 31, 'Kota Administrasi Jakarta Pusat'),
(71, 32, 'Kota Bogor'),
(71, 33, 'Kota Magelang'),
(71, 34, 'Kota Yogyakarta'),
(71, 35, 'Kota Kediri'),
(71, 36, 'Kota Tangerang'),
(71, 51, 'Kota Denpasar'),
(71, 52, 'Kota Mataram'),
(71, 53, 'Kota Kupang'),
(71, 61, 'Kota Pontianak'),
(71, 62, 'Kota Palangkaraya'),
(71, 63, 'Kota Banjarmasin'),
(71, 64, 'Kota Balikpapan'),
(71, 65, 'Kota Tarakan'),
(71, 71, 'Kota Manado'),
(71, 72, 'Kota Palu'),
(71, 73, 'Kota Makassar'),
(71, 74, 'Kota Kendari'),
(71, 75, 'Kota Gorontalo'),
(71, 81, 'Kota Ambon'),
(71, 82, 'Kota Ternate'),
(71, 91, 'Kota Jayapura'),
(71, 92, 'Kota Sorong'),
(72, 11, 'Kota Sabang'),
(72, 12, 'Kota Pematangsiantar'),
(72, 13, 'Kota Solok'),
(72, 14, 'Kota Dumai'),
(72, 15, 'Kota Sungai Penuh'),
(72, 16, 'Kota Pagar Alam'),
(72, 18, 'Kota Metro'),
(72, 21, 'Kota Tanjung Pinang'),
(72, 31, 'Kota Administrasi Jakarta Utara'),
(72, 32, 'Kota Sukabumi'),
(72, 33, 'Kota Surakarta'),
(72, 35, 'Kota Blitar'),
(72, 36, 'Kota Cilegon'),
(72, 52, 'Kota Bima'),
(72, 61, 'Kota Singkawang'),
(72, 63, 'Kota Banjarbaru'),
(72, 64, 'Kota Samarinda'),
(72, 71, 'Kota Bitung'),
(72, 73, 'Kota Pare Pare'),
(72, 74, 'Kota Bau Bau'),
(72, 81, 'Kota Tual'),
(72, 82, 'Kota Tidore Kepulauan'),
(73, 11, 'Kota Lhokseumawe'),
(73, 12, 'Kota Sibolga'),
(73, 13, 'Kota Sawahlunto'),
(73, 16, 'Kota Lubuk Linggau'),
(73, 31, 'Kota Administrasi Jakarta Barat'),
(73, 32, 'Kota Bandung'),
(73, 33, 'Kota Salatiga'),
(73, 35, 'Kota Malang'),
(73, 36, 'Kota Serang'),
(73, 71, 'Kota Tomohon'),
(73, 73, 'Kota Palopo'),
(74, 11, 'Kota Langsa'),
(74, 12, 'Kota Tanjung Balai'),
(74, 13, 'Kota Padang Panjang'),
(74, 16, 'Kota Prabumulih'),
(74, 31, 'Kota Administrasi Jakarta Selatan'),
(74, 32, 'Kota Cirebon'),
(74, 33, 'Kota Semarang'),
(74, 35, 'Kota Probolinggo'),
(74, 36, 'Kota Tangerang Selatan'),
(74, 64, 'Kota Bontang'),
(74, 71, 'Kota Kotamobagu'),
(75, 11, 'Kota Subulussalam'),
(75, 12, 'Kota Binjai'),
(75, 13, 'Kota Bukittinggi'),
(75, 31, 'Kota Administrasi Jakarta Timur'),
(75, 32, 'Kota Bekasi'),
(75, 33, 'Kota Pekalongan'),
(75, 35, 'Kota Pasuruan'),
(76, 12, 'Kota Tebing Tinggi'),
(76, 13, 'Kota Payakumbuh'),
(76, 32, 'Kota Depok'),
(76, 33, 'Kota Tegal'),
(76, 35, 'Kota Mojokerto'),
(77, 12, 'Kota Padang Sidempuan'),
(77, 13, 'Kota Pariaman'),
(77, 32, 'Kota Cimahi'),
(77, 35, 'Kota Madiun'),
(78, 12, 'Kota Gunungsitoli'),
(78, 32, 'Kota Tasikmalaya'),
(78, 35, 'Kota Surabaya'),
(79, 32, 'Kota Banjar'),
(79, 35, 'Kota Batu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `nim` varchar(14) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kab_kota` varchar(50) DEFAULT NULL,
  `provinsi` varchar(50) DEFAULT NULL,
  `angkatan` year(4) NOT NULL,
  `jalur_masuk` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `no_hp` bigint(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `kode_doswal` varchar(14) NOT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mahasiswas`
--

INSERT INTO `mahasiswas` (`nim`, `nama`, `alamat`, `kab_kota`, `provinsi`, `angkatan`, `jalur_masuk`, `email`, `no_hp`, `status`, `kode_doswal`, `foto`) VALUES
('2055928291012', 'rimuru', 'Pekalongan', 'Pekalongan', 'tensura', '2021', 'SNMPTN', 'tempest@gmail.com', 2311313, 1, '11111111111111', NULL),
('2055928291013', 'akbar maryan bagaskara', 'semarang', 'semarang', 'jawa tengah', '2021', 'SNMPTN', 'akbar@gmail.com', 12314, 1, '22222222222222', NULL),
('2406012104005', 'rimuru tempest', 'tempest', '75', '33', '2017', 'SNMPTN', 'rimuru7@gmail.com', 231131323, 1, '22222222222222', NULL),
('24060121120075', 'shidddd', 'pekalongan', '75', '33', '2021', 'SNMPTN', 'shid1@gmail.com', 32424242, 1, '22222222222222', NULL),
('24060121130032', 'ivannn', 'medan', '71', '12', '2021', 'SNMPTN', 'ivan123@gmail.com', 23113421313, 1, '22222222222222', NULL),
('24060121130054', 'adasdasda', 'aceh', '16', '11', '2021', 'SNMPTN', 'asd@gmail.com', 12312131, 1, '22222222222222', NULL),
('24060121130075', 'Muhamad ridwan ash\'shidqi', 'pekalongan', '26', '33', '2021', 'SNMPTN', 'shidkigaming7@gmail.com', 81325835578, 1, '11111111111111', NULL),
('24060121130076', 'ivan', 'medan', '74', '33', '2021', 'SNMPTN', 'ivan@gmail.com', 81325835575, 1, '22222222222222', NULL),
('24060121140095', 'Mursetyo Ardiyan Nugroho', 'klipang', '74', '33', '2021', 'SNMPTN', 'ardiyan@gmail.com', 81235177505, 1, '22222222222222', NULL),
('24060121140096', 'mahasiswa1', 'pekalongan', '75', '33', '2021', 'SNMPTN', 'mahasiswa1@gmail.com', 81325835236, 1, '22222222222222', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operators`
--

CREATE TABLE `operators` (
  `nip` varchar(14) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `operators`
--

INSERT INTO `operators` (`nip`, `nama`, `email`) VALUES
('12121212121212', 'admin', 'admin1@univ.ac.id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provs`
--

CREATE TABLE `provs` (
  `id_prov` int(2) NOT NULL,
  `provinsi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `provs`
--

INSERT INTO `provs` (`id_prov`, `provinsi`) VALUES
(11, 'Aceh'),
(12, 'Sumatera Utara'),
(13, 'Sumatera Barat'),
(14, 'Riau'),
(15, 'Jambi'),
(16, 'Sumatera Selatan'),
(17, 'Bengkulu'),
(18, 'Lampung'),
(19, 'Bangka Belitung'),
(21, 'Kepulauan Riau'),
(31, 'DKI Jakarta'),
(32, 'Jawa Barat'),
(33, 'Jawa Tengah'),
(34, 'DI Yogyakarta'),
(35, 'Jawa Timur'),
(36, 'Banten'),
(51, 'Bali'),
(52, 'Nusa Tenggara Barat'),
(53, 'Nusa Tenggara Timur'),
(61, 'Kalimantan Barat'),
(62, 'Kalimantan Tengah'),
(63, 'Kalimantan Selatan'),
(64, 'Kalimantan Timur'),
(65, 'Kalimantan Utara'),
(71, 'Sulawesi Utara'),
(72, 'Sulawesi Tengah'),
(73, 'Sulawesi Selatan'),
(74, 'Sulawesi Tenggara'),
(75, 'Gorontalo'),
(76, 'Sulawesi Barat'),
(81, 'Maluku'),
(82, 'Maluku Utara'),
(91, 'Papua'),
(92, 'Papua Barat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stat_akademik`
--

CREATE TABLE `stat_akademik` (
  `kode_status` int(1) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stat_akademik`
--

INSERT INTO `stat_akademik` (`kode_status`, `status`) VALUES
(1, 'Belum Ambll'),
(2, 'Sedang Ambil'),
(3, 'Lulus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stat_cek`
--

CREATE TABLE `stat_cek` (
  `kode_status` int(1) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stat_cek`
--

INSERT INTO `stat_cek` (`kode_status`, `status`) VALUES
(0, 'Belum Dicek'),
(1, 'Disetujui'),
(2, 'Disetujui');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stat_mahasiswa`
--

CREATE TABLE `stat_mahasiswa` (
  `kode_status` int(1) NOT NULL,
  `status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stat_mahasiswa`
--

INSERT INTO `stat_mahasiswa` (`kode_status`, `status`) VALUES
(1, 'Aktif'),
(2, 'Cuti'),
(3, 'Mangkir'),
(4, 'Drop Out'),
(5, 'Undur Diri'),
(6, 'Lulus'),
(7, 'Meninggal Dunia');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`nim_nip`) USING BTREE;

--
-- Indeks untuk tabel `departements`
--
ALTER TABLE `departements`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`nip`);

--
-- Indeks untuk tabel `info_irs`
--
ALTER TABLE `info_irs`
  ADD PRIMARY KEY (`nim`,`smt`);

--
-- Indeks untuk tabel `info_khs`
--
ALTER TABLE `info_khs`
  ADD PRIMARY KEY (`nim`,`smt`);

--
-- Indeks untuk tabel `info_pkls`
--
ALTER TABLE `info_pkls`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `info_skripsis`
--
ALTER TABLE `info_skripsis`
  ADD PRIMARY KEY (`nim`);

--
-- Indeks untuk tabel `kab_kots`
--
ALTER TABLE `kab_kots`
  ADD PRIMARY KEY (`id_kab_kot`,`id_prov`) USING BTREE;

--
-- Indeks untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `no_hp` (`no_hp`);

--
-- Indeks untuk tabel `operators`
--
ALTER TABLE `operators`
  ADD PRIMARY KEY (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `provs`
--
ALTER TABLE `provs`
  ADD PRIMARY KEY (`id_prov`);

--
-- Indeks untuk tabel `stat_akademik`
--
ALTER TABLE `stat_akademik`
  ADD PRIMARY KEY (`kode_status`);

--
-- Indeks untuk tabel `stat_cek`
--
ALTER TABLE `stat_cek`
  ADD PRIMARY KEY (`kode_status`);

--
-- Indeks untuk tabel `stat_mahasiswa`
--
ALTER TABLE `stat_mahasiswa`
  ADD PRIMARY KEY (`kode_status`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
