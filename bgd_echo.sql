-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2020 at 10:54 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bgd_echo`
--

-- --------------------------------------------------------

--
-- Table structure for table `anketa`
--

CREATE TABLE `anketa` (
  `anketa_id` int(11) NOT NULL,
  `pitanje` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `aktivna` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `anketa`
--

INSERT INTO `anketa` (`anketa_id`, `pitanje`, `aktivna`) VALUES
(15, 'Kako ste čuli za nas?', 1);

-- --------------------------------------------------------

--
-- Table structure for table `anketa_odgovori`
--

CREATE TABLE `anketa_odgovori` (
  `odgovor_id` int(11) NOT NULL,
  `anketa_id` int(11) NOT NULL,
  `odgovor` tinytext COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `anketa_odgovori`
--

INSERT INTO `anketa_odgovori` (`odgovor_id`, `anketa_id`, `odgovor`) VALUES
(13, 15, 'Facebook'),
(14, 15, 'Instagram'),
(15, 15, 'Reklame'),
(16, 15, 'Twitter'),
(17, 15, 'Novine');

-- --------------------------------------------------------

--
-- Table structure for table `kategorije_vesti`
--

CREATE TABLE `kategorije_vesti` (
  `kategorija_id` int(100) NOT NULL,
  `kategorija_naziv` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `roditelj_id` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kategorije_vesti`
--

INSERT INTO `kategorije_vesti` (`kategorija_id`, `kategorija_naziv`, `roditelj_id`) VALUES
(13, 'Društvo', NULL),
(16, 'Hronika', NULL),
(18, 'Biznis', NULL),
(19, 'Zabava', NULL),
(20, 'Sport', NULL),
(21, 'Fudbal', 20),
(23, 'Tenis', 20),
(25, 'Tehnologija', NULL),
(26, 'MMA', 20),
(27, 'IT', 25);

-- --------------------------------------------------------

--
-- Table structure for table `komentari`
--

CREATE TABLE `komentari` (
  `komentar_id` int(255) NOT NULL,
  `vest_id` int(255) NOT NULL,
  `komentar_tekst` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_id` int(255) NOT NULL,
  `komentar_napisan` int(255) NOT NULL,
  `komentar_rod` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `korisnik_id` int(255) NOT NULL,
  `korisnik_ime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_prezime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_korisnicko_ime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_lozinka` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_uloga_id` tinyint(4) NOT NULL DEFAULT 8,
  `korisnik_email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `korisnik_clan_od` int(255) NOT NULL,
  `korisnik_status_id` tinyint(4) NOT NULL DEFAULT 3,
  `aktivacioni_kod` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`korisnik_id`, `korisnik_ime`, `korisnik_prezime`, `korisnik_korisnicko_ime`, `korisnik_lozinka`, `korisnik_uloga_id`, `korisnik_email`, `korisnik_clan_od`, `korisnik_status_id`, `aktivacioni_kod`) VALUES
(7, 'Dusan', 'Vesic', 'vesicd8', '21232f297a57a5a743894a0e4a801fc3', 1, 'dusan.vesic8@gmail.com', 1585094583, 1, '3a367e154d69ddb3a8cf1f92ed0f62b8'),
(8, 'Autor', 'Autor', 'autor', '5fa08fa19656b633084cbedfa8f76edc', 5, 'urednik@gmail.com', 1585325926, 1, '3b42b59f69e9343a4cd7bed89cc8caaa'),
(9, 'Korisnik', 'Korisnik', 'korisnik12345', '716b64c0f6bad9ac405aab3f00958dd1', 8, 'korisnik15425@gmail.com', 1585360922, 1, 'b6ff6ffc56e73c253081a1ec5f6d41b6'),
(15, 'Korisnik', 'Korisnik', 'korisnik1', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik1@gmail.com', 1585743773, 3, '6f82fe937d363a8a97edc87d579c9e99'),
(16, 'Korisnik', 'Korisnik', 'korisnik2', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik2@gmail.com', 1585744020, 1, '6d19dca9a68bc4b03a301deb49d271c9'),
(17, 'Korisnik', 'Korisnik', 'korisnik3', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik3@gmail.com', 1585744138, 1, '796e77dbf73f5b1194fad7f0f778d6a6'),
(18, 'Korisnik', 'Korisnik', 'korisnik4', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik4@gmail.com', 1585744385, 1, 'fb1a6b1e047dd0f720ca9410809be355'),
(19, 'Korisnik', 'Korisnik', 'korisnik5', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik5@gmail.com', 1585744444, 1, '9f3055623527edc922b1f605d0781875'),
(20, 'Korisnik', 'Korisnik', 'korisnik6', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik6@gmail.com', 1585744509, 1, '40d8f87cbe8e3e1da435b2d30421205f'),
(21, 'Korisnik', 'Korisnik', 'korisnik7', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik7@gmail.com', 1585744588, 1, '59496ba43a6111a2b5d3787bef408932'),
(22, 'Korisnik', 'Korisnik', 'korisnik8', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik8@gmail.com', 1585747007, 1, 'fc093c0004fbb9ce0f4feed05fd8f5c5'),
(23, 'Korisnik', 'Korisnik', 'korisnik9', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik9@gmail.com', 1585747102, 1, '7d16adf52575e0c6967c5cd49cd4c12f'),
(24, 'Korisnik', 'Korisnik', 'korisnik10', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik10@gmail.com', 1585747165, 1, 'e3e3a24a0eb31d22e46a666622192fc0'),
(25, 'Korisnik', 'Korisnik', 'korisnik11', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik11@gmail.com', 1585747264, 1, 'e1c6940eae80655997e83f7e87d10beb'),
(26, 'Korisnik', 'Korisnik', 'korisnik12', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik12@gmail.com', 1585747317, 1, '01134320398b9f085cd7b27065dffd6a'),
(27, 'Korisnik', 'Korisnik', 'korisnik13', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik13@gmail.com', 1585747447, 1, 'c7912d90e2610230ccda3c5142401693'),
(28, 'Korisnik', 'Korisnik', 'korisnik14', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik14@gmail.com', 1585747541, 1, '88a2d330bbe64604d5dadb8227a12191'),
(29, 'Korisnik', 'Korisnik', 'korisnik15', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik15@gmail.com', 1585747589, 1, '208a09cd43f14b6ca8eaf95a2c9642b6'),
(30, 'Korisnik', 'Korisnik', 'korisnik16', '5116f16d3399fcb6571f571d79f35f41', 8, 'korisnik14@gmail.com', 1585747659, 3, '5084aaef0a63735418f7b6f736a24a57');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik_status`
--

CREATE TABLE `korisnik_status` (
  `status_id` tinyint(4) NOT NULL,
  `status_naziv` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik_status`
--

INSERT INTO `korisnik_status` (`status_id`, `status_naziv`) VALUES
(1, 'aktivan'),
(2, 'banovan'),
(3, 'neaktivan');

-- --------------------------------------------------------

--
-- Table structure for table `navigacija`
--

CREATE TABLE `navigacija` (
  `id` int(50) NOT NULL,
  `href` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `link_tekst` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `redosled` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `navigacija`
--

INSERT INTO `navigacija` (`id`, `href`, `link_tekst`, `title`, `redosled`) VALUES
(3, 'vesti.php', 'Vesti', 'Vesti', 10),
(4, 'kontakt.php', 'Kontakt', 'Kontakt', 15),
(5, 'autor.php', 'Autor', 'Autor', 20),
(7, 'index.php', 'Početna', 'Početna', 5);

-- --------------------------------------------------------

--
-- Table structure for table `odradjena_anketa`
--

CREATE TABLE `odradjena_anketa` (
  `id` int(11) NOT NULL,
  `anketa_id` int(11) NOT NULL,
  `odgovor_id` int(11) NOT NULL,
  `korisnik_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `odradjena_anketa`
--

INSERT INTO `odradjena_anketa` (`id`, `anketa_id`, `odgovor_id`, `korisnik_id`) VALUES
(22, 15, 14, 15),
(23, 15, 14, 16),
(24, 15, 14, 17),
(25, 15, 14, 18),
(26, 15, 17, 19),
(27, 15, 13, 20),
(28, 15, 15, 21),
(29, 15, 17, 22),
(30, 15, 13, 23),
(31, 15, 16, 24),
(32, 15, 15, 25),
(33, 15, 14, 26),
(34, 15, 13, 27),
(35, 15, 15, 28),
(36, 15, 17, 29);

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `slike_id` int(255) NOT NULL,
  `vest_id` int(255) NOT NULL,
  `slika_alt` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `slika_xl` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `slika_l` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `slika_sm` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`slike_id`, `vest_id`, `slika_alt`, `slika_xl`, `slika_l`, `slika_sm`) VALUES
(25, 52, 'Messi', 'xl-1585340940224191777ff50c41f8d130e3e79711341585340940.jpg', 'l-1585340940583bf622ba117f4c433575c355c124381585340940.jpg', 'sm-1585340940f71f69b70f1cdfcf7873feb18d4e175b1585340940.jpg'),
(27, 54, 'Evropsko prvenstvo', 'xl-1585341283a036f305e3ff8972dc080e77b98508271585341283.jpg', 'l-1585341283ed476e7f68d54465eed15d8091bbe2ec1585341283.jpg', 'sm-158534128355c22820de640d823565811b13f292ce1585341283.jpg'),
(28, 55, 'it', 'xl-1585342560f30c09f12795a80fc4d89401fdb36c841585342560.jpg', 'l-1585342560acc5f7697ec4d2ad9a43be991f2f7d491585342560.jpg', 'sm-1585342560c8d661ee323ef37acbd647ff92fa70fa1585342560.jpg'),
(29, 56, 'kurs', 'xl-1585343130f169288bdbed852d635a50b4fd70b4521585343130.jpg', 'l-1585343130cea31230dfcf6b12b18019ed5799bc3e1585343130.jpg', 'sm-1585343130cfb1c8ccaeca5761892f9cbd5b26be791585343130.jpg'),
(30, 57, 'ps5', 'xl-1585346423a71dab625f7ef569052939efcbcdf6c31585346423.jpg', 'l-1585346423f99bc5000cacf7ebafffaf7c4012cf411585346423.jpg', 'sm-158534642356f218ee13d09e3e8a72a7bba57f21ac1585346423.jpg'),
(31, 58, 'pucac', 'xl-1585348538f9de7c063baa1d1fc1516e48301bc9f71585348538.jpg', 'l-158534852126117447df88ba66c44d2d65bb2399bb1585348521.jpg', 'sm-1585348521d2ef5e377ed457a9a6c6cae27c5a5e8f1585348521.jpg'),
(32, 59, 'djokovic', 'xl-15853527401be7869f714b8ef3f5d806e1fe8845b21585352740.jpg', 'l-15853527405e550d73cf8bc72e0f0db1eed3fc246b1585352740.jpg', 'sm-1585352740bca9495a6ceef8900ef4dceaf01fd1891585352740.jpg'),
(33, 60, 'jon jones', 'xl-1585353488e5f76e7b8610de4af0c0296dd54a21b91585353488.jpg', 'l-15853534881a6673c655359a3733855deedd964a5c1585353488.jpg', 'sm-1585353488a3636a32f49c322a9fa37a5a96c307f71585353488.jpg'),
(34, 61, 'ufc', 'xl-158535418752706e460b09bbf9a8763711eacb4f471585354187.jpg', 'l-158535418714a4c97cc04f7c151e2bdc63c15d15f61585354187.jpg', 'sm-1585354187b3d5fef4fff73be3b2f988983bdf12191585354187.jpg'),
(37, 65, 'dubai', 'xl-158560639566f5ad88de726d1a9ccdd3ba976609561585606395.jpg', 'l-158560639529e01d2e8984d3ed7e2dcc60ba9202581585606395.jpg', 'sm-158560639509600c2a1fc599146970516efb02d8611585606395.jpg'),
(38, 66, 'sad', 'xl-1585606970bb3b3b3e03cdb679ce46ae08491a69ba1585606970.jpg', 'l-158560697000574ef9224a714467aabf8ceec63ef01585606970.jpg', 'sm-15856069707a2d74321f2862871655c49e7080cac41585606970.jpg'),
(39, 67, 'kockanje', 'xl-1585607681bd0bb15e7965838e801a13940d2f6caf1585607681.jpg', 'l-15856076813fbbe4b93e3244696c020b8d05c4c5c71585607681.jpg', 'sm-158560768137e37ab25fea1cdd0dd9702b38e8a6de1585607681.jpg'),
(40, 68, 'djokovic', 'xl-15856159870f88a41b567697e92efaee802a2322a41585615987.jpg', 'l-1585615987071971cf01275cd88cb7034a705ba67d1585615987.jpg', 'sm-15856159877fa16600f1e0a36ff029d00b44592ff51585615987.jpg'),
(41, 69, 'drama u zajecaru', 'xl-1585616596ceab1d8d6cf9ec34cc4ca2489403cc381585616596.jpg', 'l-158561659679f939b730c077c3063c192e876daff81585616596.jpg', 'sm-1585616596afa9dbf5817f1d1f1486893ec69c65a41585616596.png'),
(42, 70, 'indijanac', 'xl-1585617081934be1c45efa34e34fc7a04a13e5c16f1585617081.jpg', 'l-1585617081cf7388568c33320bd8b09afa5316fdde1585617081.jpg', 'sm-1585617081a4f703fe80ef791827ff5c3c0cc9b4741585617081.jpg'),
(43, 71, 'mesi nema za leba', 'xl-1585617607aa14ba6fe7277f46864f48724ef433f51585617607.jpg', 'l-15856176076f79d26620d0c6403b7bc758926abb811585617607.jpg', 'sm-1585617607a03d49f8ba0886d8b7351ef271beac9c1585617607.jpg'),
(44, 72, 'manijak', 'xl-1585618446253d1025a62690849fa85504d92c866d1585618446.jpg', 'l-1585618446eb278b24e23ca6eb951fb7fad439bfc21585618446.jpg', 'sm-15856184466445c79df4e2a248b25556d35f3b25691585618446.jpg'),
(45, 73, 'pala na glavu', 'xl-1585619059bf70b2f08e15234e5939f7df8ceb94501585619059.jpg', 'l-1585619059c267696727b7bfb852028ddea5e811ea1585619059.jpg', 'sm-1585619059a720c6dec3b60875ef9640842356ca261585619059.jpg'),
(46, 74, 'kim', 'xl-15856196423c2c9f0145a8033a683372a8574f5de51585619642.jpg', 'l-1585619642f10a9e861d7043cea4231b01ec5e40501585619642.jpg', 'sm-1585619642461c327fc97b3cc76c3e1a9d61d9047a1585619642.jpg'),
(47, 75, 'sat', 'xl-15856202464db56f14b94139fea32923b57423a44c1585620246.jpg', 'l-1585620246946ca112e762e7f2d16cbcfb38ece8861585620246.jpg', 'sm-1585620246dd1a705d90476875b454abaa8d5e54cd1585620246.jpg'),
(48, 76, 'mitrovic', 'xl-158575398294c6a9e6908b5de90ce979ed78414c021585753982.jpg', 'l-15857539823943c4ffe95f451c1adc5a995c636e9e1585753982.jpg', 'sm-1585753982256ad4884e3f4862122a08f4c14f2e081585753982.png'),
(49, 77, 'huawei-google', 'xl-15857543767a1e8bd0b53d288d6360a95dff84f4d71585754376.png', 'l-1585754376c41826b002073348c51ad0ad71b2e75d1585754376.png', 'sm-1585754376b17f67231e181b3848a7eec639f0edad1585754376.png'),
(50, 78, 'fb', 'xl-1585846181974fa6c5a009b7d4be329933451cfaa81585846181.jpg', 'l-1585846181d2d043810151ad244f1ea0fb04fe14581585846181.jpg', 'sm-15858461819643521000ff441dcfc90d356db64ca41585846181.png');

-- --------------------------------------------------------

--
-- Table structure for table `uloge`
--

CREATE TABLE `uloge` (
  `uloga_id` tinyint(4) NOT NULL,
  `uloga_naziv` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `uloge`
--

INSERT INTO `uloge` (`uloga_id`, `uloga_naziv`) VALUES
(1, 'admin'),
(5, 'autor'),
(8, 'regularan_korisnik');

-- --------------------------------------------------------

--
-- Table structure for table `vesti`
--

CREATE TABLE `vesti` (
  `vest_id` int(255) NOT NULL,
  `urednik_id` int(255) NOT NULL,
  `vest_naslov` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `vest_tekst` text COLLATE utf8_unicode_ci NOT NULL,
  `vest_kategorija_id` int(11) NOT NULL,
  `vest_datum_objave` int(255) NOT NULL,
  `broj_pregleda` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vesti`
--

INSERT INTO `vesti` (`vest_id`, `urednik_id`, `vest_naslov`, `vest_tekst`, `vest_kategorija_id`, `vest_datum_objave`, `broj_pregleda`) VALUES
(52, 8, 'OVO SU NAJSKUPLJI FUDBALERI SVETA! Mesi POTONUO', '<p>Za mnoge, Lionel Mesi je najbolji igrač na svetu, verovatno i najbolji svih vremena - ali on trenutno nije i najvredniji. Pošto je fudbal širom Evrope suspendovan, transfer „pijaca“ je ponovo u fokusu i mnoga velika imena pominju se kao potencijalne mete klubova, piše \"Marka\".</p>\r\n\r\n<p>Sudeći po „Transfermarketu“, Mesi se nalazi tek na osmom mestu njihove liste kada su u pitanju najskuplji fudbaleri planete. Na listi se nalaze mnoge zvezde iz Bundeslige, Premijer lige i Lige 1.</p>\r\n\r\n<p>10. Antoan Grizman (Barselona) - 120 miliona evra</p>\r\n\r\n<p>Francuz je procenjen na 120 miliona evra, što je ista količina novca za koju je i doveden iz Atletiko Madrida prethodnog leta.</p>\r\n\r\n<p>9. Džejdon Sančo (Borusija Dortmund) – 120 miliona evra</p>\r\n\r\n<p>Krilo Borusije jedan je od igrača koji najviše obećava, i iza sebe ima dve impresivne sezone otkad je napustio Mančester Siti. On će bez sumnje biti jedan od najtraženijih fudbalera tokom leta, i Borusija može da očekuje veliki novac od prodaje ovog mladog Engleza.</p>\r\n\r\n<p>8. Lionel Mesi (Barselona) – 140 miliona evra</p>\r\n\r\n<p>Mesi ima otkupnu klauzulu od 700 miliona evra, ali i pravo da ode kao slobodan igrač na leto. Njegova vrednost procenjena je na 140 miliona evra.</p>\r\n\r\n<p>7. Kevin De Brujne (Mančester Siti) – 150 miliona evra</p>\r\n\r\n<p>Jedan od najvažnijih igrača Pepa Gvardiole u Sitiju, i jedan od ključnih fudbalera zbog kojeg je Real poražen nedavno, zauzeo je sedmo mesto.</p>\r\n\r\n<p>6. Hari Kejn (Totenhem) – 150 miliona evra</p>\r\n\r\n<p>Simbol Totenhema i Engleske, bio je jedan od najubitačnijih napadača na svetu u poslednjih pet godina, što ga je plasiralo na deobu četvrtog mesta liste najskupljih fudbalera na svetu.</p>\r\n\r\n<p>5. Mohamed Salah (Liverpul) – 150 miliona evra</p>\r\n\r\n<p>Posle nekoliko dobrih sezona u Liverpulu, Salah je procenjen na 150 miliona evra, kao i rival iz Premijer lige Hari Kejn. Ostaje da se vidi da li će njegova vrednost opasti nakon ispadanja Liverpula iz Lige šampiona.</p>\r\n\r\n<p>4. Sadio Mane (Liverpul) – 150 miliona evra</p>\r\n\r\n<p>Još jedan igrač koji igra u izvanrednoj formi kod Jirgena Klopa, u ekipi koja je spremna da osvoji titulu u Engleskoj.</p>\r\n\r\n<p>3. Nejmar (Pari Sent Žermen) – 160 miliona evra</p>\r\n\r\n<p>Iako se našao na trećem mestu, vrednost Nejmara je opala u odnosu na vreme kada je napuštao Barselonu 2017. godine. Nekoliko klubova bi bilo i više nego voljno da ga ugrabi, i pored toga.</p>\r\n\r\n<p>2. Rahim Sterling (Mančester Siti) – 160 miliona evra</p>\r\n\r\n<p>Krilo engleske reprezentacije vredi isto koliko i Nejmar, a imajući u vidu potencijalnu suspenziju Sitija iz Evrope, napuštanje „Etihada“ ne deluje toliko nerealno, uprkos proceni vrednosti od čak 160 miliona evra.</p>\r\n\r\n<p>1. Kilijan Mbape (Pari Sent Žermen) – 200 miliona evra</p>\r\n\r\n<p>Lider „čopora“ je francuski zlatni dečak. Sa samo 21 godinom, ima osvojen Svetski Kup i postiže golove kao od šale u Ligi 1. A opet, sa druge strane, još mnogo toga ima da pruži.</p>', 20, 1585326967, 4),
(54, 8, 'ODLOŽENO EVROPSKO PRVENSTVO U FUDBALU!', '<p>Evropska kuća fudbala (UEFA) donela je odluku na video konferenciji sa predstavnicima nacionalnih saveza i sindikatom profesionalnih igrača, FIFPro, da se kontinentalni šampionat ne održi ove godine.</p>\r\n\r\n<p>Odluka je doneta zbog pandemije SARS-CoV19 korona virusa, usled kog su širom sveta prekinuta sportska takmičenja.</p>\r\n\r\n<p>Dok se UEFA još nije bila zvanično oglasila, odlaganje je potvrdio Fudbalski savez Norveške na svom Tviter nalogu:</p>\r\n\r\n<p>Odlaganje kontinentalnog šampionata (zakazanog prethodno za 12. jun ove godine) je \"oslobodilo\" jedan mesec za domaća prvenstva u evropskim državama, koja su takođe prekinuta, ali i za završnicu Lige šampiona i Lige Evropa, koje je UEFA obustavila zbog pomenute pandemije.</p>\r\n\r\n<p>Sat i po posle pomenutog tvita norveške kuće fudbala, novinar AP-a Rob Heris je na svom Tviteru prikazao saopštenje UEFA kojim se potvrđuje pomeranje šampionata Evrope u fudbalu sa 2020. na 2021. godinu.</p>', 21, 1585327841, 1),
(55, 8, 'EVROPSKA PREDUZEĆA SVE TEŽE DOLAZE DO IT STRUČNJAKA Evo gde se Srbija nalazi', '<p>Svako deseto preduzeće u Evropskoj uniji pokušalo je tokom 2018. godine da unajmi stručnjake za informacione i komunikacione tehnologije (ICT), a tačno 58 odsto tih kompanija imalo je poteškoće da nađe adekvatan kadar, navodi Eurostat u svojim najnovijim podacima.</p>\r\n\r\n<p>Kada je reč o Srbiji, ona je otprilike u rangu EU proseka, pa je tako 56 odsto firmi navelo kao značajan izazov popunjavanje radnih mesta IT stručnjaka.</p>\r\n\r\n<p>Među članicama EU, preduzeća u Rumuniji najteže dolaze do IKT specijalista. Iako je samo 3 odsto firmi u ovoj zemlji pokušalo da angažuje ovu vrstu radne snage, čak njih 90 odsto prijavilo je da su upražnjena radna mesta teško popunili.</p>\r\n\r\n<p>Velike probleme prilikom regrutacije ovog profila inženjera imale su i Češka (80 odsto), Austrija (74), Švedska (72), kao i Nemačka, Luksemburg i Holandija (u svakoj po 69 procenata).</p>\r\n\r\n<p>Stručnjake za IKT najlakše su pronalazila preduzeća iz Španije, gde je svega 27 odsto njih prijavilo da su naišli na poteškoće prilikom njihovog regrutovanja. Za njom slede Grčka (38 odsto), Bugarska (42) i Kipar (44).</p>', 18, 1585342560, 78),
(56, 8, 'Kurs dinara u ponedeljak 117,5790', '<p>Zvanični srednji kurs dinara prema evru iznosiće u ponedeljak, 24. februara, 117,5790 dinara za evro, što je neznatna promena u odnosu na danas, objavila je Narodna banka Srbije.</p>\r\n\r\n<p>Dinar će prema evru vredeti isto kao pre mesec dana a na godišnjem nivou će biti jači za 0,5 procenata.</p>\r\n\r\n<p>Indikativni kurs dinara prema dolaru je ojačao danas za 0,4 odsto na 108,4477 dinara za dolar.</p>\r\n\r\n<p>Dinar je prema dolaru slabiji za 1,9 procenata na mesečnom i za 3,9 posto na godišnjem nivou, a od početka ove godine je u padu za 3,3 odsto.</p>', 18, 1585343130, 0),
(57, 8, 'Fanovi besni: Pokažite nam kako izgeda Sony PlayStation 5', '<p>Gejmeri širom sveta priključili su se na prvi live stream posvećen Sony PlayStation 5, ali su ostali uskraćeni za ono najbitnije - da vide novu konzolu.</p>\r\n\r\n<p>Ono što su pak videli jesu neke od specifikacija, sve upakovano u tehnički zahtevnu prezentaciju koja je obećala brže učitavanje igre, 3-D audio i kompatibilnost sa igrama za postojeći PlayStation 4.</p>\r\n\r\n<p>PlayStation 5 će za početak imati impresivnu SSD od 825 gigabajta koja bi trebalo da omogući brži apejt a brzina prenosa je 5.5GB po sekundi što bi trebalo da omogući brzo učitavanje igri i brzinu \"skidanja\" koja je čak 100x veća od one koju ima PS4. Ovo je bitno i za proizvođače igara.</p>\r\n\r\n<p>Za razliku od Microsofta, Sony se odlučio za standardne eksterne USB drajvere ali i za M.2 SSD. Ali, tu je i caka - USB hardrajvovi se mogu koristiti samo za igranje PS4 igara na novoj PS5 konzoli ali ne i za nove igre napravljene za PS5. Razlog je to što će nove igre namenski biti napravljene za brži interni SSD.</p>\r\n\r\n<p>S druge strane, ono što su nazvali kompitabilnost unazad omogućiće da su igre za PS4 kompatibilne za PS5.</p>\r\n\r\n<p>Konzola bi trebalo da bude dostupna u novembru. Još nema reči o ceni, ali prema pisanju Bloomberga, trebalo bi da košza oko 450 dolara.</p>', 25, 1585346423, 9),
(58, 8, 'PUCAČA ODAO DNK SA FLAŠE Na škaljarca u \"mercedesu\" ispalio 27 hitaca, pa pobegao.', '<p>Podgoričanin Dragiša Bulatović uhapšen je u subotu zbog sumnje da je učestvovao u pokušaju ubistva pripadnika škaljarskog klana Igora Krstovića 29. januara ove godine u naselju Balijače.</p>\r\n\r\n<p>Kako prenose crnogorske \"Vijesti\", Bulatović je uhapšen u subotu, nakon čega mu je određen pritvor zbog bojazni da će ponoviti krivično delo ili ga dovršiti. Prema navodima crnogorskih \"Vijesti\", Bulatovićevi otisci navodno su pronađeni na flaši u kojoj je bio benzin korišćen za paljenje automobila kojim su napadači pobegli sa mesta zločina. Kome je Bulatović pomagao, kao i po čijem nalogu je pucano u Krstovića, zasad nije utvrđeno.</p>\r\n\r\n<p>Kako pišu \"Vijesti\" i dan nakon pucnjave u Zeti, nezvanično je potvrđeno su atentatori napravili brojne greške, te su ostavili brojne tragove koji vode do njih.</p>\r\n\r\n<p>- Oni koji su zapalili auto napravili su greške. Ostavili su neke tragove i nadamo se da će nam koristiti, ako ih kiša i vatrogasci gaseći požar nisu uništili pre izuzimanja. Odgovor na to, međutim, daće forenzičari nakon što završe započeta veštačenja - rekao je ranije jedan od sagovornika \"Vijesti\".</p>\r\n\r\n<p>U automobil Krstovića ispaljeno je 26 hitaca iz automatske puške, a prema nezvaničnim informacijama - sedam je završilo u njegovom telu.</p>\r\n\r\n<p>U \"mercedes\" kojim je upravljao Krstović napadači su ispalili 26 hitaca iz automatske puške, a sedam metaka je pogodilo metu. Odmah posle pucnjave istražitelji su na Kakaričkoj gori našli zapaljeni \"golf\", za koji, saopštili su, pretpostavljaju da je korišćen u pokušaju ubistva Krstovića. Tu je nađena i automatska puška \"M70\" iz koje je pucano na Krstovića.</p>\r\n\r\n<p>Posle pucnjave je operisan u Kliničkom centru u Podgorici, odakle je, zbog teških povreda, prošle nedelje prebačen na lečenje u Nemačku, što je izazvalo revolt tamošnje i policije i poreskih obveznika koje zanima ko plaća to dodatno angažovanje specijalaca.</p>', 16, 1585348521, 5),
(59, 8, '\"NEKA SE LJUTE FEDEREROVI NAVIJAČI, BRIGA ME!\"', '<p>Američka teniska legenda, Bred Gilbert, nije zadovoljan odlukom ATP-a da tokom prinudne pauze zbog korona virusa, Novaku Đokoviću ne uračuna nedelje provedene na prvom mestu.</p>\r\n\r\n<p>Gilbert veruje da su srpskom teniseru nepravedno oduzete nedelje na prvom mestu, kojima bi on već 5. oktobra postao najbojli igrač u istoriji kada je ova kategorija u pitanju.</p>\r\n\r\n<p>\"Federerovi navijači će se iznervirati zbog ovoga što ću reći, ali mislim da je Đoković zaslužio da sve te nedelje provede kao broj jedan. Zaslužio je svoj rang i da je sve normalno, sigurno bi zadržao prvo mesto duže vreme\", poručio je Gilbert.</p>\r\n\r\n<p>Poeni su zamrznuti, a time i čitava rang lista. To znači da će Novak Đoković znatno kasnije nego što je to projektovano moći da se izjednači sa Rodžerom Federerom.</p>\r\n\r\n<p>Naime, nedelje koje budu proticale do 7. juna, kada je planirano da se nastavi teniska sezona, neće se računati u ukupan zbir, pa je Federer miran barem do 2021. godine kada je u pitanju apsolutni rekord od 310 nedelja na prvom mestu ove liste.</p>\r\n\r\n<p>U ovom momentu, Švajcarac je jedini igrač koji je više od 300 nedelja proveo na vrhu, a Novak je trenutno stigao do 281. nedelje, pre nego što je rangiranje zamrznuto (ispred njega je i Pit Sampras, čiji je rekord trebalo da padne već u aprilu).</p>\r\n\r\n<p>Bred Gilbert je u igračkoj karijeri osvojio 20 titula i stigao do četvrtog mesta na ATP listi. Jedan je od najboljih amerikanaca u Istoriji tenisa.</p>', 23, 1585352740, 12),
(60, 8, 'UHAPŠEN DŽON DŽONS! Legendarni UFC šampion mrtav pijan za volanom VITLAO PIŠTOLJEM!', '<p>Prvak UFC u poluteškoj kategoriji Džon Džons uhapšen je u četvrtak pre podne po srednjeevropskom vremenu u Albukerkiju zbog neodgovornog rukovanja vatrenim oružjem i vožnje u pijanom stanju, navode američki mediji.</p>\r\n\r\n<p>Amerikanac je priveden u jedan čas noću po lokalnom vremenu, ali je ubrzo pušten na slobodu.</p>\r\n\r\n<p>Policajcima su prijavljeni pucnji i kada su stigli na lice mesta primetili su Džonsa za volanom jednih kola, a slavni borac je očigledno bio pod uticajem opojnih supstanci. Ubrzo je podvrgnut testovima i imao je nivo akohola u krvi koji je dvaput viši od dozvoljenog. Ispod njegovog sedišta pronađen je pištolj, a ispod suvozačevog sedišta nalazila se flaša alkoholnog pića.</p>\r\n\r\n<p>Još 2015. godine Džons je uhapšen zbog toga što je, takođe u pijanom stanju, izazvao sudar i pobegao sa lica mesta, a u udesu je bila povređena i trudnica. Pre toga, 2012. godine, takođe je uhapšen zbog vožnje u pijanom stanju.</p>\r\n\r\n<p>Džon Džons ima 32 godine, smatra se jednim od najvećih MMA boraca svih vremena, a i dalje je najmlađi prvak u istoriji UFC. Kada je 2011. godine osvojio pojas protiv Maurisija “Šoguna” Rue imao je tek 23 godine.</p>\r\n\r\n<p>U profesionalnoj karijeri ima skor od 28 pobeda, jednog poraza (diskvalifikacija zbog nedozvoljenih udaraca) i jedne poništene borbe protiv Danijela Kormijea. Džons je u tom meču slavio, ali je ona naknadno poništena jer je Džons bio pozitivan na nedozvoljenu supstancu turinabol.</p>\r\n\r\n<p>Veoma je poznato njegovo rivalstvo sa Danijelom Kormijeom, ali deluje sve manje izvesno da će njih dvojica imati meč u budućnosti.</p>', 26, 1585353488, 17),
(61, 8, 'DA, OVO JE ISTA OSOBA! Tuča godine u UFC, poznata borkinja potpuno IZDEFORMISANA', '<p>Uprkos očekivanjima, najatraktivniju borbu na UFC 246 u Las Vegasu priredile su dame - Vejli Ženg i Joana Jedžejčik.</p>\r\n\r\n<p>Simbolično, na 8. mart divovsku bitku vodile su Kineskinja i Poljakinja, u kojoj je prema odluci sudija bila bolja Ženg i kući odnela UFC pojas strovejt kategorije.</p>\r\n\r\n<p>Dame se nisu štedele od samog starta, veliki broj upućenih udaraca i brojka od njih čak 300 već u trećoj rundi. U proseku po stotinu međusobnih udaraca za jednu rundu, a dosta njih u predelu glave, donelo je i posledice po obe borkinje. Vizuelno, drastično veće po Joanu Jedžejčik čija je glava bila potpuno deformisana nakon borbe od podliva, masnica i ožiljaka.</p>\r\n\r\n<p>Vejli Ženg je odbranila pojas podeljenom odlukom sudija, u jednoj od najboljih ženskih borbi u UFC ikada. I Ženg i Jedžejčik su nakon borbe odvezene u bolnicu u Las Vegasu.</p>', 26, 1585354187, 45),
(65, 8, 'Expo 2020 u Dubaiju se odlaže za NAREDNU GODINU?', '<p>Sajamska manifestacija Expo 2020 u Dubaiju trebalo bi da bude odložena za godinu dana zbog globalne pandemije virusa korona.</p>\r\n\r\n<p>To se navodi u predlogu odluke u koju je uvid imala agencija Rojters i dva izvora upoznata sa situacijom. Na ovoj izložbi kulture, poslovnih i tehnoloških dostignuća, koja je trebalo da počne u oktobru, očekivalo se 11 miiona stranih posetilaca, kao izlagači iz 192 zemlje sveta.</p>\r\n\r\n<p>Očekuje se da će u Dubaju kasnije danas, posle sastanka zvaničnika iz Ujedinjenih Arapskih Emirata i predstavnika stranih zemalja koji su trebalo da učestvuju na sajmu, biti objavljeno da se događaj pomera za narednu godinu, dodaje britanska agencija.</p>\r\n\r\n<p>U informaciji se navodi da su učesnici manifestacije zatražili odlaganje, ukazujući na potrebu da se snage usredsrede na epidemiju koronavirusa. Portparol Expo-a odbio je komentar.</p>', 18, 1585606395, 2),
(66, 8, 'Predsednik FED: SAD su možda već u RECESIJI', '<p>Predsednik američkih Federalnih rezervi Džerom Pauel izjavio je, u jednom od retkih televizijskih intervjua, da su Sjedinjene Države možda već u recesiji, te da bi prvo morala situacija sa korona virusom da bude pod kontrolom pre nego što se krene sa restartovanjem privredne aktivnosti.</p>\r\n\r\n<p>\"Prvi zadatak vlasti je da se širenje virusa stavi pod kontrolu, a zatim nastavak ekonomske aktivnosti. U ovoj situaciji virus diktira prioritete, rekao je Pauel gostujući na televiziji NBC, prenosi Njujork Tajms.</p>\r\n\r\n<p>List dodaje da je izjava Pauela u suprotnosti sa stavom predsednika Donalda Trampa, koji je nagovestio da želi da se veliki broj Amerikanci vrati na posao čim prođe Uskrs, što znači za manje od tri sedmice.</p>\r\n\r\n<p>Tramp je takođe ocenio da napori da se uspori širenje virusa obustavljanjem aktivnosti u velikom delu ekonomija ne bi smeli da nanose više štete od same bolesti, dodaje Njujork Tajms.</p>', 18, 1585606970, 7),
(67, 8, 'KRADU I POZAJMLJUJU NOVAC DA BI SE KOCKALI Svaki treći tinejdžer u Srbiji NE MOŽE BEZ KLAĐENJA!', '<p>Svaki treći učenik prvog razreda srednje škole u Srbiji redovno se kocka, rezultati su istraživanja Instituta za javno zdravlje \"Dr Milan Jovanović Batut\".</p>\r\n\r\n<p>Tokom drugog polugodišta školske 2017/18. godine, \"Batut\" je u 101 osnovnoj i srednjoj školi u Srbiji realizovao istraživanje o zdravstvenom ponašanju dece školskog uzrasta, kao deo međunarodnog istraživanja. U pitanju je studija koja se svake četvrte godine realizuje u velikom broju zemalja evropskog regiona Svetske zdravstvene organizacije, kao i u Severnoj Americi.</p>\r\n\r\n<p>Zavisnost od kockanja kod mladih javlja se postepeno. Na prvi pogled \"bezazlen\" tiket, slot aparati, rulet, odigrani iz puke dosade, a zatim \"početnička sreća\" koja kasnije prerasta u želju za još većim dobitkom... Nakon nekoliko dobitaka, obično sleduju gubici - što mladi često povežu sa \"lošim danom, baksuznim društvom\", a onda kreće \"vađenje\". Ulažu sve više i više novca, što pozajmljenog, što ukradenog, i pre nego što se svi osveste, dete je izraslo u patološkog kockara.</p>\r\n\r\n<b>UPOZORENJA ZA RODITELJE</b>\r\n<ul>\r\n<li>nestanak novca ili dragocenosti iz kuće</li>\r\n<li>često odsustvo (škola, kuća)</li>\r\n<li>razdražljivost</li>\r\n<li>povlačenje u sebe</li>\r\n<li>smanjena efikasnost u školi</li>\r\n<li>zapuštanje fizičkog izgleda</li>\r\n<li>napetost</li>\r\n<li>sumnjivi izgovori</li>\r\n</ul>\r\n<p>Prim. dr Ivica Mladenović, načelnik Klinike za bolesti zavisnosti Instituta za mentalno zdravlje u Beogradu, za \"Blic\" kaže da su rezultati istraživanja, u najmanju ruku, poražavajući.</p>\r\n\r\n<p>- Sa pravnog aspekta imamo Zakon o igrama na sreću koji zabranjuje kockanje mlađima od 18 godina, što ukazuje da smo na polju sprovođenja zakona kao država doživeli totalni fijasko, i iskreno se nadam da će nadležni organi reagovati - kaže dr Mladenović.</p>\r\n\r\n<p>On dodaje da su igre na sreću jedna od omiljenih razonoda u Srbiji, pogotovo muške populacije, te je društvena tolerancija prema kockanju svakako jedan od razloga ovakve statistike.</p>\r\n\r\n<p>- Patološko kockanje spada u poremećaj kontrole nagona, to jest impulsa, te osoba ne može da odoli porivu da kocka, iako je svesna opasnosti po sebe i svoju okolinu. Imajući u vidu da je kockanje legalno, a moglo bi se reći čak i društveno prihvatljivo, ne čudi situacija u Srbiji gde je problem sa kockom više nego evidentan - ističe za \"Blic\" psiholog i psihoterapeut Jelena Manojlović, koordinator psihološkog tima SOS centra.</p>\r\n\r\n<b>POLOVINA PACIJENATA PATOLOŠKI KOCKARI</b>\r\n\r\n<p>Rezultati istraživanja su pokazali da se, bar jednom tokom života, kockalo 34,6 odsto učenika prvih razreda srednjih škola, a u prethodnih godinu dana 27,5 odsto njih, sa većom učestalošću među dečacima.</p>\r\n\r\n<p>- Do pre nekoliko godina naša dominantna klijentela bili su zavisnici od alkohola, a poslednjih nekoliko godina primarni pacijenti u Dnevnoj bolnici za bolesti zavisnosti su patološki kockari. U ovom trenutku oko 50 odsto naših pacijenata čine zavisnici od kockanja. Iako je po svim statistikama odnos muškaraca i žena patoloških kockara 3:1, muškarci čine 99 odsto lečenih patoloških kockara na klinici - priča dr Mladenović.</p>\r\n\r\n<p>Jedan od razloga je, podvlači, stigmatizacija, pa se žene zavisne od kockanja izuzetno retko javljaju na lečenje.</p>\r\n\r\n<b>MENJAJU SE PRIORITETI</b>\r\n\r\n<p>Školski psiholog Marina Nadejin Simić kaže za \"Blic\" da, kada su u pitanju adolescenti, ako kockanje postane patologija, menjaju se i prioriteti, ali i odnosi sa okolinom.</p>\r\n\r\n<p>- Toj deci prioritet više nije njihov hobi, sport, uspeh u školi, već kockanje. Oni tada postaju napeti, razdražljivi, a sve to se projektuje na odnos sa porodicom, nastavnicima, društvom - kaže Nadejin Simić.</p>', 18, 1585607681, 17),
(68, 8, 'Kejt i Vilijam prišli Novaku posle pobede, a ovo je PRVO PITANJE koje im je Đoković postavio', '<p>Novak Đoković juče je osvojio četvrti trofej na Vimbldonu, a finalni meč iz počasne lože posmatrali su i Kejt Midlton i princ Vilijam.</p>\r\n\r\n<p>Kejt i Vilijam nakon Noletove pobede susreli su se sa srpskim teniserom, a tom prilikom su mu čestitali i razmenili nekoliko rečenica. Jedan od Novakovih najbližih saradnika uoči njegove pobede izgovorio je nešto o čemu bruji svet, a o čemu je reč saznajte na OVOM LINKU.</p>\r\n\r\n<p>- On je prišao baš kada sam krenuo da odgovorim na pitanje u intervjuu, tako da je to bio zaista poseban momenat. Bio sam nervozan, nadao sam se da će on biti tamo, zaista je bilo prelepo. Kako su vaša deca? - upitao ih je Nole.</p>\r\n\r\n<p>- Veoma dobro, hvala. Pokušavaju da drže teniski reket u ruci, ali i da igraju fudbal - odgovorio je Vilijam, nakon čega su se svi nasmejali.</p>\r\n\r\n<p>- Bilo mi je drago da razgovaram sa vama - odgovorio je Nole, nakon čega mu je Kejt još jednom uputila čestitke: Čestitamo! Želimo vam prijatno leto!</p>\r\n\r\n<p>Novak i Jelena sinoć su prisustvovali gala večeri povodom završetka Vimbldona, gde su sve vreme razmenjivali zaljubljene poglede. Kako je bilo na slavlju pogledajte OVDE. Novak, inače, uveliko gradi novu porodičnu kuću u Srbiji, a fotografije možete ogledati OVDE.</p>', 23, 1585615987, 1),
(69, 8, 'DRAMA U ZAJEČARU Naoružani muškarac za vreme policijskog časa UPAO U KUĆU i pretio ljudima', '<p>Jedan muškarac u Zaječaru danas je, tokom policijskog časa, šetao naoružan puškom. Njega je videlo nekoliko osoba i pozvalo policiju. Za to vreme on je već upao u jednu kuću, gde je navodno pretio ukućanima.</p>\r\n\r\n<p>Još su nejasni motivi zbog čega je muškarac to činio. Pretpostavlja se da se ovaj incident dogodio verovatno zbog ranijih neraščišćenih računa, piše \"Pink\".</p>', 16, 1585616596, 0),
(70, 8, 'HAPŠENJE U BEOGRADU Muškarac (57) širio paniku i lažne vesti na Fejsbuku', '<p>Pripadnici Ministarstva unutrašnjih poslova, po nalogu Posebnog odeljenja za borbu protiv visokotehnološkog kriminala Višeg javnog tužilaštva u Beogradu, uhapsili su N. S. (57) zbog postojanja osnova sumnje da je počinio više krivičnih dela, saopštio je danas MUP.</p>\r\n\r\n<p>\"Postoje osnovi sumnje da je N. S. na društvenoj mreži \'\'Fejsbuk\'\' objavio snimak u kome iznosi lažne vesti, čime je uticao na sprovođenje odluka i mera u borbi protiv virusa korona, zatim pretnje kojima je ometao javnog tužioca u vršenju tužilačke funkcije, ali i pretnje da će upotrebiti silu prema policijskim službenicima koji su prema njemu preduzimali službene radnje u okviru svojih ovlašćenja\", navodi MUP.</p>\r\n\r\n<p>Sumnja se da je on izvršio krivična dela izazivanje panike i nereda, ometanje pravde i sprečavanje službenog lica u vršenju službene radnje.</p>\r\n\r\n<p>Osumnjičenom je određeno zadržavanje do 48 časova nakon čega će, uz krivičnu prijavu, biti priveden nadležnom tužilaštvu.</p>', 16, 1585617081, 1),
(71, 8, 'NEVOLJE U BARSELONI Klub pritiskom smanjio plate - Mesi pobesneo..', '<p>Fudbalski klub Barselona smanjio je plate fudbalerima zbog trenutnog stanja i manjka prihoda.</p>\r\n\r\n<p>Zajedničku odluku kluba i igrača da zarade u narednom periodu budu smanjene za čak 70 procenata, saopštenjem je potvrdio Leo Mesi koji je još pre nedelju dana bio spreman na manju platu.</p>\r\n\r\n<p>\"Mnogo je rečeno i napisano po pitanju plata u Barseloni u ovom teškom razdoblju. Želeli bismo da pojasnimo da smo se sve vreme zalagali za snižavanje plata u ovom periodu jer u potpunosti razumemo da je situacija izvan svakodnevnih okvira. Fudbaleri bi trebalo prvenstveno da pomagnu svom klubu kad to zatraži. To smo učinili više puta na ličnu inicijativu. Nismo pokrenuli temu plata jer je za nas najvažnije bilo da se pronađe pravi način da se pomogne Barseloni i onima koji bi mogli da budu ozbiljno pogođeni trenutnom situacijom.\"</p>\r\n\r\n<p>Sukob sa upravom kluba koji je počeo zbog otkaza koji je dobio bivši trener Ernesto Valverde još uvek traje. Argentinac je i ovog puta imao šta da zameri čelnim ljudima katalonskog kluba.</p>\r\n\r\n<p>\"Ne možemo da prestanemo da se čudimo ljudima iz kluba koji su pokušali da izvrše pritisak da učinimo ono za šta smo od prvog trenutka znali da ćemo uraditi. Za dogovor je trebalo više dana jer smo tražili najbolji model kako pomoći klubu i radnicima\".</p>\r\n\r\n<p>Mediji u Španiji su došli do računice da će klub od smanjenja zarada igrača uštedeti čak 100 miliona evra. Prethodno je javljno da Real Madrid svojim igračima neće smanjiti plate.</p>', 21, 1585617607, 5),
(72, 8, 'POLICIJA TRAGA ZA BAHATIM VOZAČEM Kolima jurio kroz pešačku zonu tokom policijskog časa?', '<p>Policija intenzivno radi na identifikaciji vozača koji je automobilom vozio kroz pešačku zonu u Obrenovićevoj ulici i proverava da li je snimak koji je objavljen na društvenim mrežama načinjen u vreme policijskog časa.</p>\r\n\r\n<p>Na \"jutjubu\" je danas objavljen video snimak pod nazivom \"Bahata vožnja automobila Obrenovićevom ulicom tokom policijskog časa u Nišu\" na kojem je u 17 sekundi vidi kako automobil juri noću centrom grada kroz pešačku zonu, od ugla sa Ulicom Svetozara Markovića, u pravcu Trga kralja Milana, dok se dvojica muškaraca glasno smeju uz muziku sa kasetofona koja trešti. Snimak je načinio suvozač mobilnim telefonom. U objašnjenju ispod ovog klipa na “jutjubu” navodi se da se radi o snimku koji kruži društvenim mrežama i da očevici koji su posmatrali bahatu vožnju sa balkona kažu da je nesavesni vozač rizikovao ne samo svoj, već i živote ljudi koji su se zbog prirode svog posla u to vreme našli na ulici a imali su pravo da se kreću u to doba.</p>\r\n\r\n\r\n<p>Ukoliko se ispostavi da je snimak načinjen u vreme policijskog časa, akterima lude vožnje prete krivične prijave zbog kršenja zabrane kretanja, ali, ako i se ispostavi da je načinjen ranije mogu da odgovaraju makar zbog saobraćajnog prekršaja, zbog vožnje pešačkom zonom.</p>\r\n\r\n\r\n\r\n<p>Budući da u Obrenovićevoj ulici ima dosta lokala koji imaju kamere, proveriće se snimci kako bi se utvrdilo o kojem se vozilu radi.</p>', 13, 1585618446, 3),
(73, 8, 'TEODORA DŽEHVEROVIĆ PALA NA GLAVU Pokušala da izvede vratolomiju, a onda se SRUŠILA', '<p>Pevačica Teodora Džehverović pokušala je da izvede hit vratolomiju sa društvenih mreža - da napravi stoj na rukama, te da se nogama odbije od zida i \"hodajući na rukama\" se okrene.</p>\r\n\r\n<p>Međutim, samo što je stopalima dohvatila plakar uz koji je hrabro rešila \"da se prevrne\", Teodora je pala na glavu i i leđa, pa i udarila nogama o vrata.</p>\r\n\r\n<p>Da se nije povredila svedoči to da što je odmah počela da se smeje, a ono što je usnimila podelila je sa svima uz poruku:</p>\r\n\r\n<p>- Ovaj klip je definitivno zaslužio da završi na mom feed-u! Sad imate priliku i da vidite šta sam uopšte pokušala.</p>\r\n\r\n<p>Kako je sve ovo izgledalo pogledajte u snimku u okviru teksta.</p>', 19, 1585619059, 0),
(74, 8, 'KAKAV HAOS Sestre Kardašijan napravile neviđen skandal i POTUKLE SE PRED KAMERAMA', '<p>Slavne sestre Kardašijan, posvađale su se \"na krv i nož\", što su zabeležile kamere koje ih godinama već prate 24 sata dnevno.</p>\r\n\r\n<p>U trejleru nove epizode rijalitija \"Keeping Up With The Kardashians\" vidimo Kim i Kortni Kardašijan dok se psuju, a onda i šutiraju, ali i Kloi, koja pokušava da ih razdvoji!</p>\r\n\r\n<p>Snimak pogledajte na sledećem <a href=\"https://youtu.be/9w2wokT9zj0\">linku</a>.</p>\r\n\r\n<p>Usledile su brojne sočne psovke i povici, a na objavu su se nizali komentari fanova koji su u šioku pisali da i pored svega nisu verovali da će do ovoga ikada doći.</p>\r\n\r\n<p>Inače, Kim je izazvala buru u medijima fotografijama na kojima se vidi da na jednoj nozi ima šest prstiju, a kako te slike izgledaju pogledajte OVDE.</p>', 19, 1585619642, 1),
(75, 8, 'Da li možete da nabrojite 100 različitih sportskih aktivnosti? Ovaj sat može', '<p>Watch GT 2e je nova, sportska verzija pametnog sata kompanije Huawei koji može da prepozna i prati vas tokom čak 100 različitih sportskih rutina uključujući penjanje po stenama, skejting ili parkur. A kako na sebi ima memoriju za do 500 pesama, ne treba vam ništa drugo osim njega kada krenete u teretanu.</p>\r\n\r\n<p>Huawei Watch GT 2e ima dosta sličnosti sa svojim prethodnikom od prošle godine modelom - Watch GT 2. Tu je 1.39-inčni OLED tačskrin rezolucije 454 x 454 sa 4GB memorije koji radi na Kirin A1 čipsetu sa baterijom koja sa jednim punjenjem traje do 14 dana. Međutim, ovaj sat ima i novih funkcija, a jedna od njih je merenje nivoa zasićenosti krvi kiseonikom (SpO2). U roku od jednog minuta, korisnici mogu lako da testiraju svoj nivo SpO2 i procene stanje tela u bilo kojem trenutku.</p>\r\n\r\n<p>Watch GT 2e je nova, sportska verzija pametnog sata kompanije Huawei koji može da prepozna i prati vas tokom čak 100 različitih sportskih rutina uključujući penjanje po stenama, skejting ili parkur. A kako na sebi ima memoriju za do 500 pesama, ne treba vam ništa drugo osim njega kada krenete u teretanu.</p>\r\n\r\n<p>Huawei Watch GT 2e ima dosta sličnosti sa svojim prethodnikom od prošle godine modelom - Watch GT 2. Tu je 1.39-inčni OLED tačskrin rezolucije 454 x 454 sa 4GB memorije koji radi na Kirin A1 čipsetu sa baterijom koja sa jednim punjenjem traje do 14 dana. Međutim, ovaj sat ima i novih funkcija, a jedna od njih je merenje nivoa zasićenosti krvi kiseonikom (SpO2). U roku od jednog minuta, korisnici mogu lako da testiraju svoj nivo SpO2 i procene stanje tela u bilo kojem trenutku.</p>\r\n\r\n<p>Ujedno Watch GT2e poseduje i 85 specijalno kreiranih opcija praćenja različitih sportskih aktivnosti podeljenih u šest kategorija: ekstremni sportovi, zabava, fitnes, vodeni sportovi, igre sa loptom i zimski sportovi. Ove kategorije pokrivaju aktivnosti od uličnog igranja, parkoura, penjanja na stene, do joge, baleta I boxa a sve vreme se beleže ključni podacikao što su trajanje, broj utrošenih kalorija, otkucaji srca, process vežbanja, vreme oporavka...</p>\r\n\r\n<p>Sportski momenat se vidi u dizajnu. Umesto da prati tradicionalne dizajne gde je lice sata odvojeno od kaiševa, on poseduje klasični okrugli brojčanik sa integrisanom trakom a kućište od nerđajućeg čelika dopunjuje skriveni, ravni dizajn krune koji se uklapa u zakrivljenu siluetu sata. Sat dolazi u četiri nove boje Graphite Black, Lava Red, Mint Green i Icy White, a kaiš je napravljen od mekane gume.</p>\r\n\r\n<p>U isto vreme, Huawei je predstavio i nove varijante modela Watch GT2 sa kućištem od 42mm koji sada dolaze sa novom varijantom Champagne Gold uz trake u dve nove boje, Frosty White i Chestnut Red.</p>\r\n\r\n<p>Sat je u prodaji od aprila po ceni od 199 evra, a model od 42mm koštaće 229 evra za Frosty White i 249 evra za Chestnut Red boju.</p>', 27, 1585620246, 30),
(76, 8, '\"DA NISAM FUDBALER, BIO BIH KRIMINALAC!\" Aleksandar Mitrović iskrenošću šokirao Ostrvo', '<p>Srpski fudbaler je i dalje strah i trepet za golmane.</p>\r\n\r\n<p>Aleksandar Mitrović je ove sezone postigao 23 pogotkana 34 mečeva. Impresivna forma! Prvi strelac Čempionšipa ove sezone i uskoro možda i reprezentacije svih vremena (Stjepan Bobek sa 38 datih sada ima samo sedam pogodaka prednosti) je dugo bio poznat kao loš momak. I upravo je o tome govorio engleskim medijima pre nekoliko godina.</p>\r\n\r\n<p>Protiv Litvanije je postigao dva pogotka i time stigao do 31. gola u dresu nacionalnog tima, ali i pokazao da se nalazi u fenomenalnoj formi (u dresu Fulama je ove sezone već postigao osam golova i prvi je strelac Čempionšipa).</p>\r\n\r\n<p>A da ga je trebalo istrepeti - trebalo je, jer tu je bilo svega. Koškanja, crvenih kartona, fantastičnih golova, ludih frizura i izlazaka do zore. Koktel svega što čini vrhunskog fudbalera i usijanu glavu. Ipak, kada su te mladalačke faze prošle ostao je samo napadač svetskog kalibra i potencijalno najbolji srpski golgeter 21. veka, pa i duže.</p>\r\n\r\n<p>On je otkrio kako je zbog temperamenta i karatera umalo završio sa druge strane zakona.</p>\r\n\r\n<p>- Van terena sam porodičan čovek, radim normalne stvari. Na terenu se jednostavno sve promeni. Čak i kada igram sa svojim bratom fudbalske simulacije, toliko se naljutim, da mi dođe da ga izudaram. Želim da pobedim. Oduvek sam takav - rekao je Mitrović za britanski \"Telegraf\" oktobra 2019. godine.</p>\r\n\r\n<p>A onda je usledila jedna rečenica koja je oduvek i uvek će vrištati da stane u naslov (naravno, verovatno je i vas privukla).</p>\r\n\r\n<p>- Otac mi je rekao da bih bio kriminalac ili kik-bokser. Možda bih radio nešto u čemu bih mogao da iskoristim svoj adrenalin. Možda nešto kao boks. Oduvek sam imao nenormalno energije. Bio sam problem svojim roditeljima, a sada sve to vidim u svom detetu. Lepo mi je govorila majka - rekao je Mitrović.</p>\r\n\r\n<p>Njukasl mu se dopadao iz jednog razloga - ljubav prema crno-belim bojama koje je nosio i u dresu Partizana:</p>\r\n\r\n<p>- Od samog starta sam srećan u Njukaslu. Bio mi je jedan od omiljenih klubova od malih nogu. Pratio sam Njukasl čitav život, imao sam i dva dresa ovog tima kao klinac. Sećam se i kada su igrali protiv Partizana. I u Partizanu sam igrao u istim bojama, Njukasl je za mene kao Partizan - potpuno je iskren Srbin.</p>', 21, 1585753982, 1),
(77, 8, 'Okreću li se stvari u korist kompanije Huawei? Google sada traži dozvolu da radi sa Kinezima', '<p>Google je podneo zahteva da bude izuzet iz odluka američke vlade po kojoj je tamošnjim kompanijama zabranjeno da sarađuju sa Huawei, prenose strani mediji. IT gigant zatražio je da im se izda licenca da opet mogu da ustupe svoje servise kompaniji Huawei.</p>\r\n\r\n<p>Kineski proizvođač je od maja prošle godine na listi firmi kojima je zabranjen pristup tehnologijama koje proizvode američke kompanije, što uključuje sve Google servise. Postoje izuzeci, poput Microsofta koji je nastavio saradnju sa Huawei a sada Google traži isto.</p>\r\n\r\n<p>Ukoliko im ovo bude odobrene Huawei će automatski moći da pdejtuje svoje uređaje na Google Mobile Services (GMS) što uključuje brojne aplikacije poput Play Store, Maps, Photos, YouTube i Gmail. Trenutno, Huawei koristi sopstveni Huawei Mobile Services kao alternativu, ali to znači da nema većine ovih aplikacija</p>', 27, 1585754376, 54),
(78, 8, 'Fejsbuk PONOVO prvi na listi najboljih poslova, a evo zašto je najbolje raditi za ovog giganta', '<p>Tehnološki gigant se treću godine zaredom našao na prvom mestu liste portala “Glasdor” sa 100 najboljih poslova u svetu, preneo je Cnet.</p>\r\n\r\n<p>Besplatni obroci, zdravstvena nega na licu mesta i olakšice za novopečene roditelje samo su neki faktori zbog kojih je najbolje raditi u “Fejsbuku” u 2018.</p>\r\n\r\n<p>Među 100 najboljih poslova u sledećoj godini našlo se i 40 novih biznisa, uključujući tvorca igrica “Blizard entertejnment (28. mesto) i “T-mobajl” (79). Tu su i tri “veterana”, koji su na listi najboljih poslova otkako je počela da se objavljuje pre 10 godina – “Bejn & Co.” (2. mesto), “Gugl” (5) i “Epl” (84).</p>\r\n\r\n<b>Evo koje su kompanije zauzele prvih 20 mesta na listi najboljih poslova u 2018:</b>\r\n<ul>\r\n<li>1.    Fejsbuk</li>\r\n\r\n<li>2.    Bejn & kompani</li>\r\n\r\n<li>3.    Boston konsalting grupa</li>\r\n\r\n<li>4.    In-N-aut burger</li>\r\n\r\n<li>5.    Gugl</li>\r\n\r\n<li>6.    Lululemon</li>\r\n\r\n<li>7.    HabSpot</li>\r\n\r\n<li>8.    Vorld Vajd tehnolodži</li>\r\n\r\n<li>9.    Dečja istraživačka bolnica St. Džud</li>\r\n\r\n<li>10.  Altimat softver</li>\r\n\r\n<li>11.  SAP</li>\r\n\r\n<li>12.  Mekinsi & kompani</li>\r\n\r\n<li>13.  Keler Vilijams</li>\r\n\r\n<li>14.  Vinarija E. & J. Galo</li>\r\n\r\n<li>15.  Sejlsfors</li>\r\n\r\n<li>16.  Pauer houm remodeling</li>\r\n\r\n<li>17.  Delta erlajns</li>\r\n\r\n<li>18.  Akademi morgidž</li>\r\n\r\n<li>19.  Crkva Isusa Hrista svetaca poslednjih dana</li>\r\n\r\n<li>20.  HEB</li>\r\n</ul>\r\n<p>Na daljim pozicijama na listi našli su se i „Linkedin“ (21. mesto), „Džonson & Džonson“ (38), „Majkrosoft“ (39), „Oškoš korporacija“ (48) i „SpejsX“ (50).</p>', 18, 1585846181, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anketa`
--
ALTER TABLE `anketa`
  ADD PRIMARY KEY (`anketa_id`);

--
-- Indexes for table `anketa_odgovori`
--
ALTER TABLE `anketa_odgovori`
  ADD PRIMARY KEY (`odgovor_id`),
  ADD KEY `anketa_id` (`anketa_id`);

--
-- Indexes for table `kategorije_vesti`
--
ALTER TABLE `kategorije_vesti`
  ADD PRIMARY KEY (`kategorija_id`),
  ADD UNIQUE KEY `kategorija_naziv` (`kategorija_naziv`);

--
-- Indexes for table `komentari`
--
ALTER TABLE `komentari`
  ADD PRIMARY KEY (`komentar_id`),
  ADD KEY `vest_id` (`vest_id`,`korisnik_id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`korisnik_id`),
  ADD UNIQUE KEY `korisnik_korisnicko_ime` (`korisnik_korisnicko_ime`),
  ADD UNIQUE KEY `korisnik_korisnicko_ime_2` (`korisnik_korisnicko_ime`),
  ADD UNIQUE KEY `aktivacioni_kod` (`aktivacioni_kod`),
  ADD KEY `korisnik_uloga_id` (`korisnik_uloga_id`),
  ADD KEY `korisnik_uloga_id_2` (`korisnik_uloga_id`),
  ADD KEY `korisnik_uloga_id_3` (`korisnik_uloga_id`),
  ADD KEY `korisnik_status_id` (`korisnik_status_id`);

--
-- Indexes for table `korisnik_status`
--
ALTER TABLE `korisnik_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `navigacija`
--
ALTER TABLE `navigacija`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `href` (`href`),
  ADD UNIQUE KEY `redosled` (`redosled`);

--
-- Indexes for table `odradjena_anketa`
--
ALTER TABLE `odradjena_anketa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anketa_id` (`anketa_id`),
  ADD KEY `korisnik_id` (`korisnik_id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`slike_id`),
  ADD KEY `vest_id` (`vest_id`);

--
-- Indexes for table `uloge`
--
ALTER TABLE `uloge`
  ADD PRIMARY KEY (`uloga_id`);

--
-- Indexes for table `vesti`
--
ALTER TABLE `vesti`
  ADD PRIMARY KEY (`vest_id`),
  ADD KEY `vest_kategorija_id` (`vest_kategorija_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anketa`
--
ALTER TABLE `anketa`
  MODIFY `anketa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `anketa_odgovori`
--
ALTER TABLE `anketa_odgovori`
  MODIFY `odgovor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `kategorije_vesti`
--
ALTER TABLE `kategorije_vesti`
  MODIFY `kategorija_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `komentari`
--
ALTER TABLE `komentari`
  MODIFY `komentar_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `korisnik_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `korisnik_status`
--
ALTER TABLE `korisnik_status`
  MODIFY `status_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navigacija`
--
ALTER TABLE `navigacija`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `odradjena_anketa`
--
ALTER TABLE `odradjena_anketa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `slike_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `uloge`
--
ALTER TABLE `uloge`
  MODIFY `uloga_id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vesti`
--
ALTER TABLE `vesti`
  MODIFY `vest_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anketa_odgovori`
--
ALTER TABLE `anketa_odgovori`
  ADD CONSTRAINT `anketa_odgovori_ibfk_1` FOREIGN KEY (`anketa_id`) REFERENCES `anketa` (`anketa_id`) ON DELETE CASCADE;

--
-- Constraints for table `komentari`
--
ALTER TABLE `komentari`
  ADD CONSTRAINT `komentari_ibfk_1` FOREIGN KEY (`vest_id`) REFERENCES `vesti` (`vest_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `komentari_ibfk_2` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD CONSTRAINT `korisnik_ibfk_1` FOREIGN KEY (`korisnik_uloga_id`) REFERENCES `uloge` (`uloga_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `korisnik_ibfk_2` FOREIGN KEY (`korisnik_status_id`) REFERENCES `korisnik_status` (`status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `odradjena_anketa`
--
ALTER TABLE `odradjena_anketa`
  ADD CONSTRAINT `odradjena_anketa_ibfk_1` FOREIGN KEY (`anketa_id`) REFERENCES `anketa` (`anketa_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `odradjena_anketa_ibfk_2` FOREIGN KEY (`korisnik_id`) REFERENCES `korisnik` (`korisnik_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `slike_ibfk_1` FOREIGN KEY (`vest_id`) REFERENCES `vesti` (`vest_id`) ON DELETE CASCADE;

--
-- Constraints for table `vesti`
--
ALTER TABLE `vesti`
  ADD CONSTRAINT `vesti_ibfk_1` FOREIGN KEY (`vest_kategorija_id`) REFERENCES `kategorije_vesti` (`kategorija_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
