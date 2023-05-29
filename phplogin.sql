-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Máj 28. 14:51
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `phplogin`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` text NOT NULL,
  `author` text NOT NULL,
  `created_at` text NOT NULL,
  `edited` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `post`
--

INSERT INTO `post` (`id`, `title`, `body`, `author`, `created_at`, `edited`) VALUES
(15, 'asd', 'asd', 'user', '2023-05-25 17:15:59', 0),
(16, 'dsadsasadd', 'sasda', 'user2', '2023-05-25 17:20:39', 0),
(17, 'Something', 'in my ass stfu\r\nMMMMMMMMMMMMmdsmmm sdad a\r\na', 'bupa', '2023-05-25 17:43:14', 1),
(18, 'dsadsa', 'asasd  dsdas asdassadas dasd', 'bupa', '2023-05-25 18:03:26', 1),
(19, 'asd', ' asdasdasdsa', 'bupa', '2023-05-25 18:26:30', 0),
(20, 'asdasddsad', 'dsadsddssddsdsds', 'bupa', '2023-05-25 20:06:35', 0),
(22, 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', 'bupa', '2023-05-25 23:45:43', 0),
(23, 'asdds', 'dsd', 'bupa', '2023-05-25 23:47:11', 0),
(24, 'deleted author', 'deleted author', 'user', '2023-05-26 17:47:28', 0),
(25, 'deldeldeldelde', 'dedelldeldeldeldeled', 'deleted', '2023-05-26 18:15:12', 0),
(26, 'delete', 'deletethis', 'deleted', '2023-05-26 18:15:20', 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `permission` varchar(10) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `permission`) VALUES
(29, 'bupa', '$2y$10$xBVhk80Hq.j8njW2i8VO4uXHioukfbX0Gkykem7j.A1zPReNK6ylO', 'admin'),
(37, 'user2', 'asd', 'user'),
(39, 'user12', '$2y$10$E.jHdNDbM5fh9vMvcVfmduYHcGfZW6UjA3I1FiYxMqBBf7UIx/Ft6', 'user'),
(42, 'deleted', '$2y$10$PCosSvHITRnrKjN.8zfm8uAzDdPba4AnOWEmva8hgKtoEOp1S0b/e', 'user'),
(44, 'checkdb', '$2y$10$mrfIZ0HmpYZkKciynPa6veonS5jIJjrq1fUgvt0HB7.SMlZ3/0rKa', 'user');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
