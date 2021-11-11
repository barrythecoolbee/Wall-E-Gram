-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:33306
-- Tempo de geração: 30-Jun-2021 às 23:45
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `smi`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth-basic`
--

CREATE TABLE `auth-basic` (
  `idUser` int(11) NOT NULL,
  `name` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `profilePic` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1024) COLLATE utf8_unicode_ci DEFAULT 'You''re not a premium user, so you cannot edit the profile!'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth-basic`
--

INSERT INTO `auth-basic` (`idUser`, `name`, `password`, `email`, `active`, `profilePic`, `description`) VALUES
(0, 'guest', 'guest', 'guest@gmail.com', 1, NULL, ''),
(1, 'Eva', 'pass1', 'user1@isel.pt', 1, NULL, 'I’m Eva the robot and I love Wall-e. I’m very happy at my spaceship Axion but I also love the fresh air from earth even tho I can’t breath.'),
(2, 'user2', 'pass2', 'user2@isel.pt', 1, NULL, NULL),
(3, 'Alice123', 'Alice123', 'a46335@alunos.isel.pt', 1, 'NULL', NULL),
(4, 'rodri', 'Alice123', 'rodrigo.matela@gmail.com', 1, 'NULL', NULL),
(5, 'Alice1234', 'Alice123', 'alice@gmail.com', 0, 'NULL', NULL),
(6, 'Alice12345', 'Alice12345', 'alice2@gmail.com', 0, 'NULL', NULL),
(7, 'Alice1245', 'Alice1245', 'a46565@alunos.isel.pt', 1, 'NULL', NULL),
(8, 'Alice134', 'Alice134', 'a46316@alunos.isel.pt', 1, 'NULL', NULL),
(9, 'Teste123', 'Teste123', 'beatrizsa1906@gmail.com', 1, 'NULL', 'NULL');

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth-challenge`
--

CREATE TABLE `auth-challenge` (
  `idUser` int(11) NOT NULL,
  `challenge` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `registerDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth-permissions`
--

CREATE TABLE `auth-permissions` (
  `idRole` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth-permissions`
--

INSERT INTO `auth-permissions` (`idRole`, `idUser`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 7),
(1, 8),
(4, 0),
(2, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `auth-roles`
--

CREATE TABLE `auth-roles` (
  `idRole` int(11) NOT NULL,
  `friendlyName` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `auth-roles`
--

INSERT INTO `auth-roles` (`idRole`, `friendlyName`) VALUES
(1, 'manager'),
(2, 'sympathizer'),
(3, 'user'),
(4, 'guest');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `idCat` int(11) NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`idCat`, `name`) VALUES
(1, 'categoria'),
(2, 'hashtag'),
(3, 'nada'),
(4, 'NADAAAAA'),
(5, 'adeus'),
(7, 'TESTE'),
(8, 'TESTEEEEE'),
(9, 'ganda'),
(10, 'bola'),
(11, 'Carnaval'),
(12, 'Elvas'),
(13, 'FOX');

-- --------------------------------------------------------

--
-- Estrutura da tabela `configs`
--

CREATE TABLE `configs` (
  `userType` enum('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `maxSize` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `configs`
--

INSERT INTO `configs` (`userType`, `maxSize`) VALUES
('0', 65536),
('1', 32768),
('2', 98304),
('3', 131072);

-- --------------------------------------------------------

--
-- Estrutura da tabela `email-accounts`
--

CREATE TABLE `email-accounts` (
  `id` int(11) NOT NULL,
  `accountName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `smtpServer` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(11) NOT NULL,
  `useSSL` tinyint(4) NOT NULL,
  `timeout` int(11) NOT NULL,
  `loginName` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `email-accounts`
--

INSERT INTO `email-accounts` (`id`, `accountName`, `smtpServer`, `port`, `useSSL`, `timeout`, `loginName`, `password`, `email`, `displayName`) VALUES
(1, 'Gmail - Wall-e', 'smtp.gmail.com', 465, 1, 30, 'grupomaisfixesmi@gmail.com', 'wall-e2021', 'grupomaisfixesmi@gmail.com', 'Mail do Wall-e'),
(2, 'Gmail - SMI', 'smtp.gmail.com', 465, 1, 30, 'smi.isel.1516@gmail.com', 'somoscampeoes', 'smi.isel.1516@gmail.com', 'Sistemas Multimédia para a Internet');

-- --------------------------------------------------------

--
-- Estrutura da tabela `email-contacts`
--

CREATE TABLE `email-contacts` (
  `id` int(11) NOT NULL,
  `displayName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `email-contacts`
--

INSERT INTO `email-contacts` (`id`, `displayName`, `email`) VALUES
(1, 'Carlos Gonçalves - IPL', 'cgoncalves@deetc.isel.ipl.pt'),
(2, 'Carlos Gonçalves - ISEL', 'carlos.goncalves@isel.pt');

-- --------------------------------------------------------

--
-- Estrutura da tabela `followers`
--

CREATE TABLE `followers` (
  `idFollower` int(11) NOT NULL,
  `idIsFollowed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `forms-counties`
--

CREATE TABLE `forms-counties` (
  `idDistrict` int(11) NOT NULL,
  `idCounty` int(11) NOT NULL,
  `nameCounty` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `forms-counties`
--

INSERT INTO `forms-counties` (`idDistrict`, `idCounty`, `nameCounty`) VALUES
(1, 1, 'Águeda'),
(1, 2, 'Albergaria-a-Velha'),
(1, 3, 'Anadia'),
(1, 4, 'Arouca'),
(1, 5, 'Aveiro'),
(1, 6, 'Castelo de Paiva'),
(1, 7, 'Espinho'),
(1, 8, 'Estarreja'),
(1, 9, 'Santa Maria da Feira'),
(1, 10, 'Ílhavo'),
(1, 11, 'Mealhada'),
(1, 12, 'Murtosa'),
(1, 13, 'Oliveira de Azeméis'),
(1, 14, 'Oliveira do Bairro'),
(1, 15, 'Santa Maria da Feira'),
(1, 16, 'Ovar'),
(1, 17, 'Sever do Vouga'),
(1, 18, 'Vagos'),
(1, 19, 'Vale de Cambra'),
(11, 1, 'Alenquer'),
(11, 2, 'Arruda dos Vinhos'),
(11, 3, 'Azambuja'),
(11, 4, 'Cadaval'),
(11, 5, 'Cascais'),
(11, 6, 'Lisboa'),
(11, 7, 'Loures'),
(11, 8, 'Lourinhã'),
(11, 9, 'Mafra'),
(11, 10, 'Oeiras'),
(11, 11, 'Sintra'),
(11, 12, 'Sobral de Monte Agraço'),
(11, 13, 'Torres Vedras'),
(11, 14, 'Vila Franca de Xira'),
(11, 15, 'Amadora'),
(11, 16, 'Odivelas'),
(4, 6, 'Miranda do Douro'),
(12, 7, 'Elvas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `forms-districts`
--

CREATE TABLE `forms-districts` (
  `idDistrict` int(11) NOT NULL,
  `nameDistrict` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `forms-districts`
--

INSERT INTO `forms-districts` (`idDistrict`, `nameDistrict`) VALUES
(1, 'Aveiro'),
(2, 'Beja'),
(3, 'Braga'),
(4, 'Bragança'),
(5, 'Castelo Branco'),
(6, 'Coimbra'),
(7, 'Évora'),
(8, 'Faro'),
(9, 'Guarda'),
(10, 'Leiria'),
(11, 'Lisboa'),
(12, 'Portalegre'),
(13, 'Porto'),
(14, 'Santarém'),
(15, 'Setubal'),
(16, 'Viana do Castelo'),
(17, 'Vila Real'),
(18, 'Viseu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `forms-zips`
--

CREATE TABLE `forms-zips` (
  `idDistrict` int(11) NOT NULL,
  `idCounty` int(11) NOT NULL,
  `idLocation` int(11) NOT NULL,
  `nameLocation` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `postalCode` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `postalCodeExtension` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `postalCodeName` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `forms-zips`
--

INSERT INTO `forms-zips` (`idDistrict`, `idCounty`, `idLocation`, `nameLocation`, `postalCode`, `postalCodeExtension`, `postalCodeName`) VALUES
(11, 11, 28801111, 'Assafora', '2705', '454', 'Rua do Poço da Barreiroa, São João das Lampas'),
(4, 6, 390604, 'Miranda do Douro', '5210', '214', 'Rua do Pinhal, Mirando do Douro'),
(12, 7, 479880000, 'Elvas', '7350', '312', 'Rua Celeste Paço, Elvas');

-- --------------------------------------------------------

--
-- Estrutura da tabela `images-config`
--

CREATE TABLE `images-config` (
  `id` int(11) NOT NULL,
  `destination` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `maxFileSize` int(11) NOT NULL,
  `thumbType` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `thumbWidth` int(11) NOT NULL,
  `thumbHeight` int(11) NOT NULL,
  `numColls` int(11) NOT NULL,
  `cellspacing` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `images-config`
--

INSERT INTO `images-config` (`id`, `destination`, `maxFileSize`, `thumbType`, `thumbWidth`, `thumbHeight`, `numColls`, `cellspacing`) VALUES
(1, 'C:\\Temp\\upload\\contents', 52428800, 'png', 80, 80, 3, 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `images-counters`
--

CREATE TABLE `images-counters` (
  `id` int(11) NOT NULL,
  `counterValue` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `images-counters`
--

INSERT INTO `images-counters` (`id`, `counterValue`) VALUES
(1, 19);

-- --------------------------------------------------------

--
-- Estrutura da tabela `images-details`
--

CREATE TABLE `images-details` (
  `id` int(11) NOT NULL,
  `fileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `mimeFileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `typeFileName` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `imageFileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `imageMimeFileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `imageTypeFileName` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `thumbFileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `thumbMimeFileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `thumbTypeFileName` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `longitude` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(512) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `images-details`
--

INSERT INTO `images-details` (`id`, `fileName`, `mimeFileName`, `typeFileName`, `imageFileName`, `imageMimeFileName`, `imageTypeFileName`, `thumbFileName`, `thumbMimeFileName`, `thumbTypeFileName`, `latitude`, `longitude`, `title`, `description`) VALUES
(1, 'C:\\Temp\\upload\\contents\\mapa.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\mapa.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\thumbs\\mapa.jpeg', 'image', 'jpeg', '', '', 'Teste', 'No description available'),
(2, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\thumbs\\layout.jpeg', 'image', 'jpeg', '', '', 'Teste2', 'TESSSSSSTE'),
(3, 'C:\\Temp\\upload\\contents\\Logic - Like Me (feat. Casey Veggies).mp3', 'audio', 'mpeg', 'C:\\Temp\\upload\\contents\\thumbs\\Logic - Like Me (feat. Casey Veggies)-Large.jpeg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\thumbs\\Logic - Like Me (feat. Casey Veggies).jpeg', 'image', 'jpeg', '', '', 'sfdfss', 'sfs');

-- --------------------------------------------------------

--
-- Estrutura da tabela `post-categories`
--

CREATE TABLE `post-categories` (
  `idCat` int(11) NOT NULL,
  `idPost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `post-categories`
--

INSERT INTO `post-categories` (`idCat`, `idPost`) VALUES
(1, 14),
(2, 14),
(3, 14),
(4, 14),
(1, 15),
(5, 15),
(1, 16),
(5, 16),
(7, 20),
(8, 21),
(9, 22),
(10, 22),
(11, 23),
(12, 23),
(13, 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `post-comments`
--

CREATE TABLE `post-comments` (
  `pubDate` date NOT NULL,
  `content` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `idPost` int(11) NOT NULL,
  `idComment` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `post-comments`
--

INSERT INTO `post-comments` (`pubDate`, `content`, `idPost`, `idComment`, `idUser`) VALUES
('2021-06-23', 'time travelling :)', 14, 2, 2),
('2021-06-22', 'testeteste123', 15, 3, 1),
('2021-06-22', 'TESTEEEEEEEEEEEEEEEEEEEEEEE', 15, 4, 1),
('2021-06-22', 'another test by Alice', 15, 5, 3),
('2021-06-24', 'Comentei aqui', 22, 6, 1),
('2021-06-24', 'Ora cá vai mais um', 15, 7, 1),
('2021-06-24', 'YOOOOO', 16, 8, 1),
('2021-06-26', 'example', 14, 9, 1),
('2021-06-27', 'Eu sou o teste123', 14, 10, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `post-images`
--

CREATE TABLE `post-images` (
  `id` int(11) NOT NULL,
  `fileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `mimeFileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `typeFileName` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `imageFileName` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `imageMimeFileName` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `imageTypeFileName` varchar(16) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `post-images`
--

INSERT INTO `post-images` (`id`, `fileName`, `mimeFileName`, `typeFileName`, `imageFileName`, `imageMimeFileName`, `imageTypeFileName`) VALUES
(15, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(16, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(17, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(19, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(20, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(21, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(22, 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\layout.jpg', 'image', 'jpeg'),
(23, 'C:\\Temp\\upload\\contents\\liganos_ball.png', 'image', 'png', 'C:\\Temp\\upload\\contents\\liganos_ball.png', 'image', 'png'),
(24, 'C:\\Temp\\upload\\contents\\FB_IMG_15829191786087185.jpg', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\FB_IMG_15829191786087185.jpg', 'image', 'jpeg'),
(25, 'C:\\Temp\\upload\\contents\\Fox 3.JPG', 'image', 'jpeg', 'C:\\Temp\\upload\\contents\\Fox 3.JPG', 'image', 'jpeg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rss-comments`
--

CREATE TABLE `rss-comments` (
  `pubDate` date NOT NULL,
  `contents` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `idNew` int(11) NOT NULL,
  `idComment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `rss-comments`
--

INSERT INTO `rss-comments` (`pubDate`, `contents`, `idNew`, `idComment`) VALUES
('2021-06-22', 'comentario', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rss-news`
--

CREATE TABLE `rss-news` (
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pubDate` date NOT NULL,
  `contents` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `idNew` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `rss-news`
--

INSERT INTO `rss-news` (`title`, `author`, `description`, `pubDate`, `contents`, `idNew`) VALUES
('Title', 'Carlos Conçalves', 'This is the description', '2021-06-22', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Haec para/doca illi, nos admirabilia dicamus. Omnia peccata paria dicitis. Haeret in salebra. Inde igitur, inquit, ordiendum est. \r\n\r\n', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rss-posts`
--

CREATE TABLE `rss-posts` (
  `idUser` int(11) NOT NULL,
  `idPost` int(11) NOT NULL,
  `description` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `pubDate` date NOT NULL,
  `idImage` int(11) NOT NULL,
  `visibility` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `rss-posts`
--

INSERT INTO `rss-posts` (`idUser`, `idPost`, `description`, `pubDate`, `idImage`, `visibility`) VALUES
(1, 14, 'TESTE18 E DEFINITIVO', '2021-06-21', 15, b'1'),
(1, 15, 'XPTO', '2021-06-21', 16, b'1'),
(1, 16, 'XPTOOOOOOO', '2021-06-21', 17, b'1'),
(1, 19, 'zsdasda', '2021-06-21', 20, b'1'),
(1, 20, 'sdasdad', '2021-06-21', 21, b'1'),
(1, 21, 'post muito bonito', '2021-06-21', 22, b'0'),
(1, 22, 'bola', '2021-06-21', 23, b'0'),
(9, 23, 'Like', '2021-06-27', 24, b'0'),
(9, 24, 'FOX', '2021-06-27', 25, b'1');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `auth-basic`
--
ALTER TABLE `auth-basic`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `auth-challenge`
--
ALTER TABLE `auth-challenge`
  ADD KEY `idUser` (`idUser`);

--
-- Índices para tabela `auth-permissions`
--
ALTER TABLE `auth-permissions`
  ADD KEY `idRole` (`idRole`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices para tabela `auth-roles`
--
ALTER TABLE `auth-roles`
  ADD PRIMARY KEY (`idRole`);

--
-- Índices para tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`idCat`);

--
-- Índices para tabela `email-accounts`
--
ALTER TABLE `email-accounts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `email-contacts`
--
ALTER TABLE `email-contacts`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `followers`
--
ALTER TABLE `followers`
  ADD KEY `idFollower` (`idFollower`),
  ADD KEY `idIsFollowed` (`idIsFollowed`);

--
-- Índices para tabela `images-config`
--
ALTER TABLE `images-config`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `images-counters`
--
ALTER TABLE `images-counters`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `images-details`
--
ALTER TABLE `images-details`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `post-categories`
--
ALTER TABLE `post-categories`
  ADD KEY `idCat` (`idCat`),
  ADD KEY `idPost` (`idPost`);

--
-- Índices para tabela `post-comments`
--
ALTER TABLE `post-comments`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `idPost` (`idPost`),
  ADD KEY `idUser` (`idUser`);

--
-- Índices para tabela `post-images`
--
ALTER TABLE `post-images`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rss-comments`
--
ALTER TABLE `rss-comments`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `idNew` (`idNew`);

--
-- Índices para tabela `rss-news`
--
ALTER TABLE `rss-news`
  ADD PRIMARY KEY (`idNew`);

--
-- Índices para tabela `rss-posts`
--
ALTER TABLE `rss-posts`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `idUser` (`idUser`),
  ADD KEY `idImage` (`idImage`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auth-basic`
--
ALTER TABLE `auth-basic`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `idCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `email-accounts`
--
ALTER TABLE `email-accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `email-contacts`
--
ALTER TABLE `email-contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `images-config`
--
ALTER TABLE `images-config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `images-counters`
--
ALTER TABLE `images-counters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `images-details`
--
ALTER TABLE `images-details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `post-comments`
--
ALTER TABLE `post-comments`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `post-images`
--
ALTER TABLE `post-images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de tabela `rss-comments`
--
ALTER TABLE `rss-comments`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `rss-news`
--
ALTER TABLE `rss-news`
  MODIFY `idNew` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `rss-posts`
--
ALTER TABLE `rss-posts`
  MODIFY `idPost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `auth-challenge`
--
ALTER TABLE `auth-challenge`
  ADD CONSTRAINT `auth-challenge_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `auth-basic` (`idUser`);

--
-- Limitadores para a tabela `auth-permissions`
--
ALTER TABLE `auth-permissions`
  ADD CONSTRAINT `auth-permissions_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `auth-roles` (`idRole`),
  ADD CONSTRAINT `auth-permissions_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `auth-basic` (`idUser`);

--
-- Limitadores para a tabela `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_ibfk_1` FOREIGN KEY (`idFollower`) REFERENCES `auth-basic` (`idUser`),
  ADD CONSTRAINT `followers_ibfk_2` FOREIGN KEY (`idIsFollowed`) REFERENCES `auth-basic` (`idUser`);

--
-- Limitadores para a tabela `post-categories`
--
ALTER TABLE `post-categories`
  ADD CONSTRAINT `post-categories_ibfk_1` FOREIGN KEY (`idCat`) REFERENCES `categories` (`idCat`),
  ADD CONSTRAINT `post-categories_ibfk_2` FOREIGN KEY (`idPost`) REFERENCES `rss-posts` (`idPost`);

--
-- Limitadores para a tabela `post-comments`
--
ALTER TABLE `post-comments`
  ADD CONSTRAINT `post-comments_ibfk_1` FOREIGN KEY (`idPost`) REFERENCES `rss-posts` (`idPost`),
  ADD CONSTRAINT `post-comments_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `auth-basic` (`idUser`);

--
-- Limitadores para a tabela `rss-comments`
--
ALTER TABLE `rss-comments`
  ADD CONSTRAINT `rss-comments_ibfk_1` FOREIGN KEY (`idNew`) REFERENCES `rss-news` (`idNew`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `rss-posts`
--
ALTER TABLE `rss-posts`
  ADD CONSTRAINT `rss-posts_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `auth-basic` (`idUser`),
  ADD CONSTRAINT `rss-posts_ibfk_2` FOREIGN KEY (`idImage`) REFERENCES `post-images` (`id`);

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `cleanAccounts` ON SCHEDULE AT '2021-06-29 17:56:48' ON COMPLETION PRESERVE DISABLE DO DELETE `smi`.`auth-challenge`, `smi`.`auth-basic` FROM `smi`.`auth-basic` INNER JOIN `smi`.`auth-challenge` ON `smi`.`auth-basic`.`idUser` = `smi`.`auth-challenge`.`idUser` WHERE `smi`.`auth-basic`.`active`=0 AND DATE_ADD( `smi`.`auth-challenge`.`registerDate`, INTERVAL 10 MINUTE) < NOW()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
