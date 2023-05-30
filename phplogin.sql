-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2023. Máj 30. 12:44
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
-- Tábla szerkezet ehhez a táblához `likes`
--

CREATE TABLE `likes` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `likes`
--

INSERT INTO `likes` (`post_id`, `user_id`) VALUES
(29, 29),
(30, 48),
(29, 48),
(28, 48),
(28, 29);

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
(27, 'szia borsószem', '', 'bupa', '2023-05-29 14:18:24', 0),
(28, 'Kedves Naplóm!', 'A mai napon láttam egy kacsát. Megettem. Finom volt. :)\r\nÜdvözlettel: Cunk', 'hatizsak2', '2023-05-29 14:19:17', 0),
(29, 'Szia Pite kapitány', 'én jobban', 'hatizsak2', '2023-05-29 14:20:13', 0),
(30, '', 'én sokkal jobban 😡😡😡', 'bupa', '2023-05-29 14:22:17', 0);

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
(29, 'bupa', '$2y$10$0V7R.0zLdvBxCMe2PaN.keCAdtZS1yn4vntQ07bEqfbTvo/fWFuh.', 'admin'),
(37, 'user2', 'asd', 'user'),
(39, 'user12', '$2y$10$E.jHdNDbM5fh9vMvcVfmduYHcGfZW6UjA3I1FiYxMqBBf7UIx/Ft6', 'user'),
(42, 'deleted', '$2y$10$PCosSvHITRnrKjN.8zfm8uAzDdPba4AnOWEmva8hgKtoEOp1S0b/e', 'user'),
(44, 'checkdb', '$2y$10$mrfIZ0HmpYZkKciynPa6veonS5jIJjrq1fUgvt0HB7.SMlZ3/0rKa', 'user'),
(45, 'tuncike', '$2y$10$XHuOha7oVVBtkO5/Z9DcCunYNv4cFBnBSvlUL8t16l1M4VtnLEFEC', 'user'),
(46, 'hatizsak2', '$2y$10$SAoDtqRqmjhf4hY9cWcVM.ARg3jjU.BWRxhyPw2vlng1fIWWjT3TO', 'user'),
(47, 'asdasdddd2', '$2y$10$/2du60V1hp63F79xbegFLucwG9TzRe7UEO6azx3YlQSNcWXssytPu', 'user'),
(48, 'asd', '$2y$10$1AJC6Jt5vjBnbPbEku5od.va4Dw4GCWY.umtZw1L9mifPzfkR909u', 'user');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT a táblához `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
