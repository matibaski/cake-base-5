-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 14. Mrz 2020 um 07:15
-- Server-Version: 5.7.26
-- PHP-Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `aaatmpcake`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `body` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `articles`
--

INSERT INTO `articles` (`id`, `user_id`, `title`, `body`, `created`, `modified`) VALUES
(1, 2, 'Whats up New York?', '<h3>Whats up New York?</h3>\r\n<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. <span style=\"text-decoration: line-through;\">Lorem ipsum dolor sit amet</span>, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>', '2020-03-10 13:37:47', '2020-03-10 17:15:28');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `message` text,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `messages`
--

INSERT INTO `messages` (`id`, `to_user_id`, `from_user_id`, `message`, `seen`, `created`) VALUES
(1, 1, 2, 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.', 1, '2020-03-12 18:41:02');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `navigations`
--

DROP TABLE IF EXISTS `navigations`;
CREATE TABLE `navigations` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Daten für Tabelle `navigations`
--

INSERT INTO `navigations` (`id`, `icon`, `title`, `link`) VALUES
(2, NULL, 'Main', NULL),
(3, 'fas fa-tachometer-alt', 'Dashboard', 'a:4:{s:10:\"controller\";s:5:\"pages\";s:6:\"action\";s:7:\"display\";s:5:\"pass0\";s:4:\"home\";s:5:\"pass1\";s:0:\"\";}'),
(8, NULL, 'System', NULL),
(10, 'fas fa-list', 'Navigation', 'a:4:{s:10:\"controller\";s:8:\"navigations\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}'),
(11, 'fas fa-user', 'Users', 'a:4:{s:10:\"controller\";s:8:\"users\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}'),
(15, NULL, 'My App', NULL),
(16, 'far fa-file-alt', 'Articles', 'a:4:{s:10:\"controller\";s:8:\"articles\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}'),
(17, 'far fa-envelope', 'Messages', 'a:4:{s:10:\"controller\";s:8:\"messages\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}'),
(23, 'far fa-bell', 'Notifications', 'a:4:{s:10:\"controller\";s:13:\"notifications\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}'),
(26, NULL, 'Errorpages', NULL),
(27, 'fas fa-exclamation-triangle', 'Error 404', 'a:4:{s:10:\"controller\";s:6:\"groups\";s:6:\"action\";s:5:\"index\";s:5:\"pass0\";s:0:\"\";s:5:\"pass1\";s:0:\"\";}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `cta` text COLLATE utf8_unicode_ci,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `image_file` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `zip` varchar(6) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(2555) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `image_file`, `cover_image`, `street`, `zip`, `city`, `region`, `country`, `phone`, `mobile`, `website`, `facebook`, `instagram`, `linkedin`, `created`, `modified`) VALUES
(1, 1, 'Admin', 'User', NULL, NULL, 'Bahnhofstrasse 1', '8000', 'Zürich', 'Zürich', 'Switzerland', '+41441234567', '+41791234567', 'https://google.com', 'https://www.facebook.com/Google/', 'https://www.instagram.com/Google/', 'https://www.linkedin.com/company/google', '2020-03-14 01:54:51', '2020-03-14 03:31:01'),
(2, 2, 'Standard', 'User', NULL, NULL, 'Poststrasse 108', '3000', 'Bern', 'Bern', 'Switzerland', '+41581234567', '+41761234567', 'https://bing.com', 'https://www.facebook.com/Microsoft/', 'https://www.instagram.com/microsoft/', 'https://www.linkedin.com/company/microsoft', '2020-03-14 01:49:52', '2020-03-14 01:53:37');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `activation_hash` varchar(255) DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `active`, `activation_hash`, `disabled`, `created`, `modified`) VALUES
(1, 'admin@cakebase.com', '$2y$10$pc2tjOrKYBbglesEdIttouBVH.lJ/dFNTJgJ6g3KN4ceU0whQrueG', 'admin', 1, NULL, 0, '2020-03-14 01:54:51', '2020-03-14 03:31:01'),
(2, 'user@cakebase.com', '$2y$10$T1bIf8MtDHitMgFXeKw.N.gdJL3Hx91Sl/NEKoFcOe0SnEBdtkhVu', 'user', 1, NULL, 0, '2020-03-14 01:49:52', '2020-03-14 03:17:08');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `navigations`
--
ALTER TABLE `navigations`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `activation_hash` (`activation_hash`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `navigations`
--
ALTER TABLE `navigations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT für Tabelle `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
