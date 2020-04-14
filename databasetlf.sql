-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 25 Ara 2018, 20:30:56
-- Sunucu sürümü: 5.7.23
-- PHP Sürümü: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `instagram`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(1) NOT NULL,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(200) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`id`, `kadi`, `sifre`) VALUES
(1, 'admin', '123456');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `etkilesim`
--

DROP TABLE IF EXISTS `etkilesim`;
CREATE TABLE IF NOT EXISTS `etkilesim` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `toplam` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hesap_list`
--

DROP TABLE IF EXISTS `hesap_list`;
CREATE TABLE IF NOT EXISTS `hesap_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `sifre` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `ad` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `resim` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `max_id`
--

DROP TABLE IF EXISTS `max_id`;
CREATE TABLE IF NOT EXISTS `max_id` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `max` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `tur` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resim` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `durum` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `aciklama` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takip`
--

DROP TABLE IF EXISTS `takip`;
CREATE TABLE IF NOT EXISTS `takip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `karsi_kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `toplam_takip` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takip_list`
--

DROP TABLE IF EXISTS `takip_list`;
CREATE TABLE IF NOT EXISTS `takip_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `pk` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `resim` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `durum` int(150) NOT NULL,
  `istek_kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `unfollow`
--

DROP TABLE IF EXISTS `unfollow`;
CREATE TABLE IF NOT EXISTS `unfollow` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `toplam_unfollow` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `durum` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `unfollow_list`
--

DROP TABLE IF EXISTS `unfollow_list`;
CREATE TABLE IF NOT EXISTS `unfollow_list` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `pk` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `durum` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `istek_kadi` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorum`
--

DROP TABLE IF EXISTS `yorum`;
CREATE TABLE IF NOT EXISTS `yorum` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `kadi` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `yorum` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `islem` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `yapilan` varchar(150) COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
