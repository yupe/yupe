-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 26 2011 г., 11:56
-- Версия сервера: 5.1.54
-- Версия PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


INSERT INTO `user` (`id`, `creation_date`, `change_date`, `first_name`, `last_name`, `nick_name`, `email`, `gender`, `password`, `salt`, `status`, `access_level`, `last_visit`, `registration_date`, `registration_ip`, `activation_ip`, `avatar`, `use_gravatar`,`email_confirm`) VALUES
(83, '2011-09-26 11:52:09', '2011-09-26 11:52:09', NULL, NULL, 'admin', 'admin@admin.ru', 0, 'c1f98dd950c917a214b66e98be53e52f', '4e802f29c47c20.49913008', 1, 1, '2011-09-26 11:55:03', '2011-09-26 11:52:09', '127.0.0.1', '127.0.0.1', NULL, 0, 1);



INSERT INTO `news` (`id`, `creation_date`, `change_date`, `date`, `title`, `alias`, `short_text`, `full_text`, `user_id`, `status`, `is_protected`, `keywords`, `description`) VALUES
(2, '2011-09-26 11:55:42', '2011-09-26 11:55:42', '2011-09-26', 'Очередной сайт на Юпи!', 'ocherednoy-sayt-na-yupi', 'Поздравляем! Ваш сайт на Юпи! успешно установлен и готов к работе!<br/>\r\n\r\nДля получения поддержки посетите <a href="http://yupe.ru/">http://yupe.ru/</a><br/>', 'Поздравляем! Ваш сайт на Юпи! успешно установлен и готов к работе!<br/>\r\n\r\nДля получения поддержки посетите <a href="http://yupe.ru/">http://yupe.ru/</a><br/>', 83, 1, 0, 'Юпи!,cms,Yii, ЦМС', 'Очередной сайт на ЦМС Юпи!');


INSERT INTO `settings` (`id`, `module_id`, `param_name`, `param_value`, `creation_date`, `change_date`, `user_id`) VALUES
(186, 'yupe', 'siteDescription', 'Юпи! - самый быстрый способ создать сайт на фреймворке Yii', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83),
(187, 'yupe', 'siteName', 'Юпи!', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83),
(188, 'yupe', 'siteKeyWords', 'Юпи!, yupe, yii, cms, цмс', '2011-09-26 11:52:25', '2011-09-26 11:52:25', 83);


