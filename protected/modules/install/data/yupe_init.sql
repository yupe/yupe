-- phpMyAdmin SQL Dump
-- version 3.5.0
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 13 2012 г., 13:08
-- Версия сервера: 5.5.11
-- Версия PHP: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `user` (`id`, `creation_date`, `change_date`, `first_name`, `last_name`, `nick_name`, `email`, `gender`, `birth_date`, `site`, `about`, `location`, `online_status`, `password`, `salt`, `status`, `access_level`, `last_visit`, `registration_date`, `registration_ip`, `activation_ip`, `avatar`, `use_gravatar`, `activate_key`, `email_confirm`) VALUES
(1, '2012-08-13 12:41:48', '2012-08-13 12:41:48', '', '', 'admin', 'admin@admin.ru', 0, NULL, '', '', '', '', 'c1f98dd950c917a214b66e98be53e52f', '4e802f29c47c20.49913008', 1, 1, '2012-08-13 12:58:17', '2012-08-13 12:41:48', '127.0.0.1', '127.0.0.1', NULL, 0, 'fd9c0644a49b2dc57ffbca0a97be8de7', 1);

INSERT INTO `settings` (`id`, `module_id`, `param_name`, `param_value`, `creation_date`, `change_date`, `user_id`) VALUES
(1, 'yupe', 'siteDescription', 'Юпи! - самый быстрый способ создать сайт на фреймворке Yii', '2012-08-13 12:41:50', '2012-08-13 12:41:50', 1),
(2, 'yupe', 'siteName', 'Юпи!', '2012-08-13 12:41:50', '2012-08-13 12:41:50', 1),
(3, 'yupe', 'siteKeyWords', 'Юпи!, yupe, yii, cms, цмс', '2012-08-13 12:41:50', '2012-08-13 12:41:50', 1);
(4, 'yupe', 'email', 'admin@admin.ru', '2012-08-13 12:41:50', '2012-08-13 12:41:50', 1);