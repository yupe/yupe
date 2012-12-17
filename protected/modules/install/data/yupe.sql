-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 29 2012 г., 15:18
-- Версия сервера: 5.1.63
-- Версия PHP: 5.3.6-13ubuntu3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `yupe`
--

-- --------------------------------------------------------

--
-- Структура таблицы `blog`
--

CREATE TABLE IF NOT EXISTS `yupe_blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text NOT NULL,
  `icon` varchar(300) NOT NULL DEFAULT '',
  `slug` varchar(150) NOT NULL,
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `create_user_id` int(10) unsigned NOT NULL,
  `update_user_id` int(10) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `update_date` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `create_user_id` (`create_user_id`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `update_user_id` (`update_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE IF NOT EXISTS `yupe_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `alias` varchar(100) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  `lang` char(2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`,`lang`),
  KEY `status` (`status`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `comment`
--

CREATE TABLE IF NOT EXISTS `yupe_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `model` varchar(50) NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `text` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `model` (`model`,`model_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `content_block`
--

CREATE TABLE IF NOT EXISTS `yupe_content_block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_unique` (`code`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dictionary_data`
--

CREATE TABLE IF NOT EXISTS `yupe_dictionary_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `value` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_user_id` int(10) unsigned NOT NULL,
  `update_user_id` int(10) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `group_id` (`group_id`),
  KEY `create_user_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `dictionary_group`
--

CREATE TABLE IF NOT EXISTS `yupe_dictionary_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(300) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_user_id` int(10) unsigned NOT NULL,
  `update_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `create_user_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE IF NOT EXISTS `yupe_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answer_user` int(10) unsigned DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `theme` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `answer_date` datetime DEFAULT NULL,
  `is_faq` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`),
  KEY `isFaq` (`is_faq`),
  KEY `fk_feedback_user` (`answer_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE IF NOT EXISTS `yupe_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `good`
--

CREATE TABLE IF NOT EXISTS `yupe_good` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` double NOT NULL DEFAULT '0',
  `article` varchar(100) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `alias` varchar(100) NOT NULL,
  `data` text,
  `is_special` tinyint(1) NOT NULL DEFAULT '0',
  `status` smallint(1) unsigned NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `change_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `status` (`status`),
  KEY `category` (`category_id`),
  KEY `user_id` (`user_id`),
  KEY `change_user_id` (`change_user_id`),
  KEY `article` (`article`),
  KEY `price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image`
--

CREATE TABLE IF NOT EXISTS `yupe_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(300) NOT NULL,
  `description` text,
  `file` varchar(500) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `alt` varchar(150) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `image_to_gallery`
--

CREATE TABLE IF NOT EXISTS `yupe_image_to_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned NOT NULL,
  `galleryId` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_gallery_unique` (`image_id`,`galleryId`),
  KEY `image_id` (`image_id`),
  KEY `galleryId` (`galleryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `login`
--

CREATE TABLE IF NOT EXISTS `yupe_login` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `identity_id` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identityId` (`identity_id`,`type`),
  KEY `user_id` (`user_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_event`
--

CREATE TABLE IF NOT EXISTS `yupe_mail_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mail_template`
--

CREATE TABLE IF NOT EXISTS `yupe_mail_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `event_id` int(10) unsigned NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` text,
  `from` varchar(300) NOT NULL,
  `to` varchar(300) NOT NULL,
  `theme` tinytext NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `event_id` (`event_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE IF NOT EXISTS `yupe_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `menu_item`
--

CREATE TABLE IF NOT EXISTS `yupe_menu_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `href` varchar(255) NOT NULL,
  `class` varchar(50) NOT NULL,
  `title_attr` varchar(255) NOT NULL,
  `before_link` varchar(255) NOT NULL,
  `after_link` varchar(255) NOT NULL,
  `target` varchar(10) NOT NULL,
  `rel` varchar(10) NOT NULL,
  `condition_name` varchar(255) DEFAULT '0',
  `condition_denial` tinyint(4) DEFAULT '0',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `yupe_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `short_text` text,
  `full_text` text NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `link` varchar(300) DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias_unique` (`alias`,`lang`),
  KEY `status` (`status`),
  KEY `is_protected` (`is_protected`),
  KEY `user_id` (`user_id`),
  KEY `category` (`category_id`),
  KEY `date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE IF NOT EXISTS `yupe_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `parent_Id` int(10) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `change_user_id` int(10) unsigned NOT NULL,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `is_protected` int(11) NOT NULL,
  `menu_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`,`lang`),
  KEY `status` (`status`),
  KEY `is_protected` (`is_protected`),
  KEY `user_id` (`user_id`),
  KEY `change_user_id` (`change_user_id`),
  KEY `order` (`menu_order`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE IF NOT EXISTS `yupe_post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) unsigned NOT NULL,
  `create_user_id` int(10) unsigned NOT NULL,
  `update_user_id` int(10) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `update_date` int(11) unsigned NOT NULL,
  `publish_date` int(11) unsigned NOT NULL,
  `slug` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `quote` varchar(300) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `link` varchar(150) NOT NULL DEFAULT '',
  `status` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `comment_status` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `access_type` tinyint(4) unsigned NOT NULL DEFAULT '1',
  `keywords` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `status` (`status`),
  KEY `comment_status` (`comment_status`),
  KEY `access_type` (`access_type`),
  KEY `create_user_id` (`create_user_id`),
  KEY `update_user_id` (`update_user_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `post_to_tag`
--

CREATE TABLE IF NOT EXISTS `yupe_post_to_tag` (
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `queue`
--

CREATE TABLE IF NOT EXISTS `yupe_queue` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `worker` tinyint(3) unsigned NOT NULL,
  `create_time` datetime NOT NULL,
  `task` text NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `complete_time` datetime DEFAULT NULL,
  `priority` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `notice` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `recovery_password`
--

CREATE TABLE IF NOT EXISTS `yupe_recovery_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_recoverypassword_code` (`code`),
  KEY `fk_recoverypassword_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `yupe_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(150) NOT NULL,
  `param_name` varchar(150) NOT NULL,
  `param_value` varchar(150) NOT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleId` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `tag`
--

CREATE TABLE IF NOT EXISTS `yupe_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Tag_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE IF NOT EXISTS `yupe_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `middle_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `nick_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `birth_date` date DEFAULT NULL,
  `site` varchar(100) NOT NULL DEFAULT '',
  `about` varchar(300) NOT NULL DEFAULT '',
  `location` varchar(150) NOT NULL DEFAULT '',
  `online_status` varchar(150) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL,
  `salt` char(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '2',
  `access_level` tinyint(1) NOT NULL DEFAULT '0',
  `last_visit` datetime DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `registration_ip` varchar(20) NOT NULL,
  `activation_ip` varchar(20) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `use_gravatar` tinyint(4) NOT NULL DEFAULT '1',
  `activate_key` char(32) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_nickname_unique` (`nick_name`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_status_index` (`status`),
  KEY `email_confirm` (`email_confirm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_to_blog`
--

CREATE TABLE IF NOT EXISTS `yupe_user_to_blog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `blog_id` int(10) unsigned NOT NULL,
  `create_date` int(10) unsigned NOT NULL,
  `update_date` int(10) unsigned NOT NULL,
  `role` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` smallint(5) unsigned NOT NULL DEFAULT '1',
  `note` varchar(300) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_blog_unique` (`user_id`,`blog_id`),
  KEY `user_id` (`user_id`),
  KEY `blog_id` (`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `vote`
--

CREATE TABLE IF NOT EXISTS `yupe_vote` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(50) NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `value` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `model` (`model`,`model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `wiki_link`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_from_id` int(11) NOT NULL,
  `page_to_id` int(11) DEFAULT NULL,
  `wiki_uid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_fk_link_page_from` (`page_from_id`),
  KEY `wiki_fk_link_page_to` (`page_to_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `wiki_page`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_redirect` tinyint(1) DEFAULT '0',
  `page_uid` varchar(255) DEFAULT NULL,
  `namespace` varchar(255) DEFAULT NULL,
  `content` text,
  `revision_id` int(11) DEFAULT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wiki_idx_page_revision_id` (`revision_id`),
  UNIQUE KEY `wiki_idx_page_page_uid` (`page_uid`,`namespace`),
  KEY `wiki_idx_page_namespace` (`namespace`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `wiki_page_revision`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_page_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `is_minor` tinyint(1) DEFAULT NULL,
  `content` text,
  `user_id` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wiki_fk_page_revision_page` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `blog`
--
ALTER TABLE `yupe_blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `dictionary_data`
--
ALTER TABLE `yupe_dictionary_data`
  ADD CONSTRAINT `dictionary_data_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `yupe_dictionary_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_data_ibfk_8` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_data_ibfk_9` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `dictionary_group`
--
ALTER TABLE `yupe_dictionary_group`
  ADD CONSTRAINT `dictionary_group_ibfk_3` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_group_ibfk_4` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `feedback`
--
ALTER TABLE `yupe_feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`answer_user`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `good`
--
ALTER TABLE `yupe_good`
  ADD CONSTRAINT `good_ibfk_6` FOREIGN KEY (`category_id`) REFERENCES `yupe_category` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `good_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `good_ibfk_8` FOREIGN KEY (`change_user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image`
--
ALTER TABLE `yupe_image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `image_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `yupe_category` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `image_to_gallery`
--
ALTER TABLE `yupe_image_to_gallery`
  ADD CONSTRAINT `image_to_gallery_ibfk_2` FOREIGN KEY (`galleryId`) REFERENCES `yupe_gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `login`
--
ALTER TABLE `yupe_login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `mail_template`
--
ALTER TABLE `yupe_mail_template`
  ADD CONSTRAINT `mail_template_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `yupe_mail_event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `menu_item`
--
ALTER TABLE `yupe_menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `yupe_menu` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `yupe_news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `page`
--
ALTER TABLE `yupe_page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_ibfk_2` FOREIGN KEY (`change_user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `yupe_category` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `post`
--
ALTER TABLE `yupe_post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `post_to_tag`
--
ALTER TABLE `yupe_post_to_tag`
  ADD CONSTRAINT `post_to_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `yupe_post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_to_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `yupe_tag` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `recovery_password`
--
ALTER TABLE `yupe_recovery_password`
  ADD CONSTRAINT `fk_RecoveryPassword_User1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `user_to_blog`
--
ALTER TABLE `yupe_user_to_blog`
  ADD CONSTRAINT `user_to_blog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_to_blog_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `vote`
--
ALTER TABLE `yupe_vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `yupe_user` (`id`) ON UPDATE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `wiki_link`
--
ALTER TABLE `yupe_wiki_link`
  ADD CONSTRAINT `wiki_fk_link_page_from` FOREIGN KEY (`page_from_id`) REFERENCES `yupe_wiki_page` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wiki_fk_link_page_to` FOREIGN KEY (`page_to_id`) REFERENCES `yupe_wiki_page` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `wiki_page_revision`
--
ALTER TABLE `yupe_wiki_page_revision`
  ADD CONSTRAINT `wiki_fk_page_revision_page` FOREIGN KEY (`page_id`) REFERENCES `yupe_wiki_page` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;