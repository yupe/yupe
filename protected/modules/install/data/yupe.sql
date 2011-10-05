-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 05 2011 г., 21:21
-- Версия сервера: 5.1.54
-- Версия PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yupe`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(11) NOT NULL DEFAULT '0',
  `name` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `alias` varchar(50) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned DEFAULT NULL,
  `model` varchar(50) NOT NULL,
  `modelId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `text` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `model` (`model`,`modelId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_block`
--

CREATE TABLE IF NOT EXISTS `content_block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_unique` (`code`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `startAddImage` datetime NOT NULL,
  `stopAddImage` datetime NOT NULL,
  `startVote` datetime NOT NULL,
  `stopVote` datetime NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answerUser` int(10) unsigned DEFAULT NULL,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `theme` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `answerDate` datetime NOT NULL,
  `isFaq` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `isFaq` (`isFaq`),
  KEY `fk_feedback_user` (`answerUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `file` varchar(500) NOT NULL,
  `creationDate` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `alt` varchar(150) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image_to_contest`
--

CREATE TABLE IF NOT EXISTS `image_to_contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imageId` int(10) unsigned NOT NULL,
  `contestId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_contest_unique` (`imageId`,`contestId`),
  KEY `imageId` (`imageId`),
  KEY `contestId` (`contestId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image_to_gallery`
--

CREATE TABLE IF NOT EXISTS `image_to_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imageId` int(10) unsigned NOT NULL,
  `galleryId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_gallery_unique` (`imageId`,`galleryId`),
  KEY `imageId` (`imageId`),
  KEY `galleryId` (`galleryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `identityId` int(10) unsigned NOT NULL,
  `type` varchar(50) NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identityId` (`identityId`,`type`),
  KEY `userId` (`userId`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `shortText` varchar(400) NOT NULL,
  `fullText` text NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `isProtected` tinyint(1) NOT NULL DEFAULT '0',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias_unique` (`alias`),
  KEY `status` (`status`),
  KEY `isProtected` (`isProtected`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentId` int(10) DEFAULT NULL,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `changeUserId` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `isProtected` int(11) NOT NULL,
  `menuOrder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`),
  KEY `status` (`status`),
  KEY `isProtected` (`isProtected`),
  KEY `userId` (`userId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `order` (`menuOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `userId` int(10) unsigned NOT NULL,
  `twitter` varchar(100) DEFAULT NULL,
  `livejournal` varchar(100) DEFAULT NULL,
  `vkontakte` varchar(100) DEFAULT NULL,
  `odnoklassniki` varchar(100) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `yandex` varchar(100) DEFAULT NULL,
  `google` varchar(100) DEFAULT NULL,
  `blog` varchar(100) DEFAULT NULL,
  `site` varchar(100) DEFAULT NULL,
  `about` text,
  `location` varchar(100) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  UNIQUE KEY `userIid_UNIQUE` (`userId`),
  KEY `fk_Profile_User1` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `recovery_password`
--

CREATE TABLE IF NOT EXISTS `recovery_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_recoverypassword_code` (`code`),
  KEY `fk_recoverypassword_user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL,
  `nickName` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `salt` char(32) NOT NULL,
  `password` char(32) NOT NULL,
  `code` char(32) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registration_nickname_unique` (`nickName`),
  UNIQUE KEY `registration_email_unique` (`email`),
  UNIQUE KEY `registration_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleId` varchar(150) NOT NULL,
  `paramName` varchar(150) NOT NULL,
  `paramValue` varchar(150) NOT NULL,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleId` (`moduleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=197 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `firstName` varchar(150) DEFAULT NULL,
  `lastName` varchar(150) DEFAULT NULL,
  `nickName` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `password` char(32) NOT NULL,
  `salt` char(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `accessLevel` tinyint(1) NOT NULL DEFAULT '0',
  `lastVisit` datetime NOT NULL,
  `registrationDate` datetime NOT NULL,
  `registrationIp` varchar(20) NOT NULL,
  `activationIp` varchar(20) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `useGravatar` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_nickname_unique` (`nickName`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_status_index` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `modelId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  `value` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `model` (`model`,`modelId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`answerUser`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image_to_contest`
--
ALTER TABLE `image_to_contest`
  ADD CONSTRAINT `image_to_contest_ibfk_2` FOREIGN KEY (`contestId`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `image_to_contest_ibfk_1` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image_to_gallery`
--
ALTER TABLE `image_to_gallery`
  ADD CONSTRAINT `image_to_gallery_ibfk_1` FOREIGN KEY (`imageId`) REFERENCES `image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `image_to_gallery_ibfk_2` FOREIGN KEY (`galleryId`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `recovery_password`
--
ALTER TABLE `recovery_password`
  ADD CONSTRAINT `fk_RecoveryPassword_User1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;