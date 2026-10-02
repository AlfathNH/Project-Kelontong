CREATE DATABASE IF NOT EXISTS `Pdb_tokokkelontong`;
USE `Pdb_tokokkelontong`;

CREATE TABLE IF NOT EXISTS `t_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `level` enum('pemilik','kasir','pelanggan') NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `t_produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(150) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `t_pesanan` (
  `id_pesanan` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_pelanggan` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  PRIMARY KEY (`id_pesanan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `t_user` (`id_user`, `nama_lengkap`, `username`, `password`, `level`) VALUES
(1, 'Haji Alfath (Pemilik)', 'pemilik', '$2y$12$e6wMx/Nn/7a/8D1C4qQ9o.7dcmfRnkcx.srcTN75k3s8ipMt0SOBC', 'pemilik'),
(2, 'Siti Rahma (Kasir 1)', 'kasir', '$2y$12$8qeoRxr53ohxsWYBy9ho.uysIYz4RVqXMf6JJF59y2e0KJJr9Dd6K', 'kasir'),
(3, 'Budi Santoso', 'budi', '$2y$12$xAM1Uk75VPh47AlGZxWTxOqpGdcIjkovDHtsj0RzjC8Mu1sAMcg0K', 'pelanggan');

INSERT IGNORE INTO `t_produk` (`id_produk`, `nama_produk`, `harga_jual`, `stok`) VALUES
(1, 'Beras Pandan Wangi Premium 5kg', 75000, 25),
(2, 'Minyak Goreng Sania Royale 2 Liter', 34500, 40),
(3, 'Telur Ayam Negeri Segar 1kg', 28000, 50),
(4, 'Gula Pasir Gulaku Tebu 1kg', 17500, 60),
(5, 'Tepung Terigu Segitiga Biru 1kg', 13000, 35),
(6, 'Indomie Goreng Original (Karton 40 pcs)', 118000, 15),
(7, 'Kopi Kapal Api Special Mix (10 sachet)', 15500, 80),
(8, 'Teh Celup Sariwangi Kotak (25 kantong)', 8500, 45),
(9, 'Kecap Manis Bango Botol 550ml', 24000, 30),
(10, 'Susu Kental Manis Frisian Flag 370g', 12500, 50);
