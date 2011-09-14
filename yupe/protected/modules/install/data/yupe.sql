-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 11 2011 г., 14:31
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
-- Структура таблицы `Category`
--

CREATE TABLE IF NOT EXISTS `Category` (
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
-- Структура таблицы `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ContentBlock`
--

CREATE TABLE IF NOT EXISTS `ContentBlock` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Contest`
--

CREATE TABLE IF NOT EXISTS `Contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `startAddImage` datetime NOT NULL,
  `stopAddImage` datetime NOT NULL,
  `startVote` datetime NOT NULL,
  `stopVote` datetime NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `FeedBack`
--

CREATE TABLE IF NOT EXISTS `FeedBack` (
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
  KEY `fk_FeedBack_User1` (`answerUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Gallery`
--

CREATE TABLE IF NOT EXISTS `Gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Image`
--

CREATE TABLE IF NOT EXISTS `Image` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Структура таблицы `ImageToContest`
--

CREATE TABLE IF NOT EXISTS `ImageToContest` (
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
-- Структура таблицы `ImageToGallery`
--

CREATE TABLE IF NOT EXISTS `ImageToGallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imageId` int(10) unsigned NOT NULL,
  `galleryId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_gallery_unique` (`imageId`,`galleryId`),
  KEY `imageId` (`imageId`),
  KEY `galleryId` (`galleryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Login`
--

CREATE TABLE IF NOT EXISTS `Login` (
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
-- Структура таблицы `News`
--

CREATE TABLE IF NOT EXISTS `News` (
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
  UNIQUE KEY `alias` (`alias`),
  UNIQUE KEY `userId` (`userId`),
  KEY `status` (`status`),
  KEY `isProtected` (`isProtected`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Page`
--

CREATE TABLE IF NOT EXISTS `Page` (
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
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  KEY `status` (`status`),
  KEY `isProtected` (`isProtected`),
  KEY `userId` (`userId`),
  KEY `changeUserId` (`changeUserId`),
  KEY `order` (`menuOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Profile`
--

CREATE TABLE IF NOT EXISTS `Profile` (
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
-- Структура таблицы `RecoveryPassword`
--

CREATE TABLE IF NOT EXISTS `RecoveryPassword` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_RecoveryPassword_User` (`userId`),
  KEY `index_recoverypassword_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Registration`
--

CREATE TABLE IF NOT EXISTS `Registration` (
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
-- Структура таблицы `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `moduleId` varchar(150) NOT NULL,
  `paramName` varchar(150) NOT NULL,
  `paramValue` varchar(150) NOT NULL,
  `creationDate` datetime NOT NULL,
  `changeDate` datetime NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `moduleId_2` (`moduleId`,`paramName`),
  KEY `moduleId` (`moduleId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=186 ;

-- --------------------------------------------------------

--
-- Структура таблицы `User`
--

CREATE TABLE IF NOT EXISTS `User` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

-- --------------------------------------------------------

--
-- Структура таблицы `Vote`
--

CREATE TABLE IF NOT EXISTS `Vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(50) CHARACTER SET ucs2 NOT NULL,
  `modelId` int(10) unsigned NOT NULL,
  `userId` int(10) unsigned NOT NULL,
  `creationDate` datetime NOT NULL,
  `value` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  KEY `model` (`model`,`modelId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Comment`
--
ALTER TABLE `Comment`
  ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `FeedBack`
--
ALTER TABLE `FeedBack`
  ADD CONSTRAINT `FeedBack_ibfk_1` FOREIGN KEY (`answerUser`) REFERENCES `User` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `Image`
--
ALTER TABLE `Image`
  ADD CONSTRAINT `Image_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `ImageToGallery`
--
ALTER TABLE `ImageToGallery`
  ADD CONSTRAINT `ImageToGallery_ibfk_1` FOREIGN KEY (`imageId`) REFERENCES `Image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `ImageToGallery_ibfk_2` FOREIGN KEY (`galleryId`) REFERENCES `Gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `Login`
--
ALTER TABLE `Login`
  ADD CONSTRAINT `Login_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `News`
--
ALTER TABLE `News`
  ADD CONSTRAINT `News_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `Page`
--
ALTER TABLE `Page`
  ADD CONSTRAINT `Page_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `Page_ibfk_2` FOREIGN KEY (`changeUserId`) REFERENCES `User` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `Profile`
--
ALTER TABLE `Profile`
  ADD CONSTRAINT `Profile_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `RecoveryPassword`
--
ALTER TABLE `RecoveryPassword`
  ADD CONSTRAINT `fk_RecoveryPassword_User1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `Vote`
--
ALTER TABLE `Vote`
  ADD CONSTRAINT `Vote_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;