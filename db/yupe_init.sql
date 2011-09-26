-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 26 2011 г., 11:56
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

--
-- Дамп данных таблицы `Category`
--


--
-- Дамп данных таблицы `Comment`
--


--
-- Дамп данных таблицы `ContentBlock`
--


--
-- Дамп данных таблицы `Contest`
--


--
-- Дамп данных таблицы `FeedBack`
--


--
-- Дамп данных таблицы `Gallery`
--


--
-- Дамп данных таблицы `Image`
--


--
-- Дамп данных таблицы `ImageToContest`
--


--
-- Дамп данных таблицы `ImageToGallery`
--


--
-- Дамп данных таблицы `Login`
--


--
-- Дамп данных таблицы `News`
--

INSERT INTO `News` (`id`, `creationDate`, `changeDate`, `date`, `title`, `alias`, `shortText`, `fullText`, `userId`, `status`, `isProtected`, `keywords`, `description`) VALUES
(2, '2011-09-26 11:55:42', '2011-09-26 11:55:42', '2011-09-26', 'Очередной сайт на Юпи!', 'ocherednoy-sayt-na-yupi', 'Поздравляем! Ваш сайт на Юпи! успешно установлен и готов к работе!<br/>\r\n\r\nДля получения поддержки посетите <a href="http://yupe.ru/">http://yupe.ru/</a><br/>', 'Поздравляем! Ваш сайт на Юпи! успешно установлен и готов к работе!<br/>\r\n\r\nДля получения поддержки посетите <a href="http://yupe.ru/">http://yupe.ru/</a><br/>', 83, 1, 0, 'Юпи!,cms,Yii, ЦМС', 'Очередной сайт на ЦМС Юпи!');

--
-- Дамп данных таблицы `Page`
--


--
-- Дамп данных таблицы `Profile`
--


--
-- Дамп данных таблицы `RecoveryPassword`
--


--
-- Дамп данных таблицы `Registration`
--


--
-- Дамп данных таблицы `Settings`
--

INSERT INTO `Settings` (`id`, `moduleId`, `paramName`, `paramValue`, `creationDate`, `changeDate`, `userId`) VALUES
(186, 'yupe', 'siteDescription', 'Юпи! - самый быстрый способ создать сайт на фреймворке Yii', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83),
(187, 'yupe', 'siteName', 'Юпи!', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83),
(188, 'yupe', 'siteKeyWords', 'Юпи!, yupe, yii, cms, цмс', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83);

--
-- Дамп данных таблицы `User`
--

INSERT INTO `User` (`id`, `creationDate`, `changeDate`, `firstName`, `lastName`, `nickName`, `email`, `gender`, `password`, `salt`, `status`, `accessLevel`, `lastVisit`, `registrationDate`, `registrationIp`, `activationIp`, `avatar`, `useGravatar`) VALUES
(83, '2011-09-26 11:52:09', '2011-09-26 11:52:09', NULL, NULL, 'admin', 'admin@admin.ru', 0, 'c1f98dd950c917a214b66e98be53e52f', '4e802f29c47c20.49913008', 1, 1, '2011-09-26 11:55:03', '2011-09-26 11:52:09', '127.0.0.1', '127.0.0.1', NULL, 0);

--
-- Дамп данных таблицы `Vote`
--

