-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2012 at 06:55 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yupe`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `alias` varchar(100) NOT NULL,
  `status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `status` (`status`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `content_block`
--

CREATE TABLE IF NOT EXISTS `content_block` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `code` varchar(50) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_unique` (`code`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  `start_add_image` datetime NOT NULL,
  `stop_add_image` datetime NOT NULL,
  `start_vote` datetime NOT NULL,
  `stop_vote` datetime NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_data`
--

CREATE TABLE IF NOT EXISTS `dictionary_data` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `dictionary_group`
--

CREATE TABLE IF NOT EXISTS `dictionary_group` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `answer_user` int(10) unsigned DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `description` text,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `good`
--

CREATE TABLE IF NOT EXISTS `good` (
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
  KEY `price` (`price`),
  KEY `is_special` (`is_special`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `image_to_contest`
--

CREATE TABLE IF NOT EXISTS `image_to_contest` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_contest_unique` (`image_id`,`contest_id`),
  KEY `image_id` (`image_id`),
  KEY `contestId` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `image_to_gallery`
--

CREATE TABLE IF NOT EXISTS `image_to_gallery` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned NOT NULL,
  `galleryId` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `image_gallery_unique` (`image_id`,`galleryId`),
  KEY `image_id` (`image_id`),
  KEY `galleryId` (`galleryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
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
-- Table structure for table `mail_event`
--

CREATE TABLE IF NOT EXISTS `mail_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` varchar(300) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `mail_template`
--

CREATE TABLE IF NOT EXISTS `mail_template` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `code` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `menu_item`
--

CREATE TABLE IF NOT EXISTS `menu_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `href` varchar(255) NOT NULL,
  `condition_name` varchar(255) DEFAULT NULL,
  `condition_denial` tinyint(4) DEFAULT NULL,
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`),
  KEY `sort` (`sort`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `date` date NOT NULL,
  `title` varchar(150) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `short_text` varchar(400) NOT NULL,
  `full_text` text NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `keywords` varchar(150) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias_unique` (`alias`),
  KEY `status` (`status`),
  KEY `is_protected` (`is_protected`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
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
  UNIQUE KEY `slug_unique` (`slug`),
  KEY `status` (`status`),
  KEY `is_protected` (`is_protected`),
  KEY `user_id` (`user_id`),
  KEY `change_user_id` (`change_user_id`),
  KEY `order` (`menu_order`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) unsigned NOT NULL,
  `create_user_id` int(10) unsigned NOT NULL,
  `update_user_id` int(10) unsigned NOT NULL,
  `create_date` int(11) unsigned NOT NULL,
  `update_date` int(11) unsigned NOT NULL,
  `slug` varchar(150) NOT NULL,
  `publish_date` datetime NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `post_to_tag`
--

CREATE TABLE IF NOT EXISTS `post_to_tag` (
  `post_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `recovery_password`
--

CREATE TABLE IF NOT EXISTS `recovery_password` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `creation_date` datetime NOT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index_recoverypassword_code` (`code`),
  KEY `fk_recoverypassword_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(150) NOT NULL,
  `param_name` varchar(150) NOT NULL,
  `param_value` varchar(150) NOT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `moduleId` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=534 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Tag_name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `first_name` varchar(150) DEFAULT NULL,
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
  `use_gravatar` tinyint(4) NOT NULL DEFAULT '0',
  `activate_key` char(32) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_nickname_unique` (`nick_name`),
  UNIQUE KEY `user_email_unique` (`email`),
  KEY `user_status_index` (`status`),
  KEY `email_confirm` (`email_confirm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=86 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_to_blog`
--

CREATE TABLE IF NOT EXISTS `user_to_blog` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
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
-- Table structure for table `wiki_link`
--

CREATE TABLE IF NOT EXISTS `wiki_link` (
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
-- Table structure for table `wiki_page`
--

CREATE TABLE IF NOT EXISTS `wiki_page` (
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
-- Table structure for table `wiki_page_revision`
--

CREATE TABLE IF NOT EXISTS `wiki_page_revision` (
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
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `dictionary_data`
--
ALTER TABLE `dictionary_data`
  ADD CONSTRAINT `dictionary_data_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `dictionary_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_data_ibfk_8` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_data_ibfk_9` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `dictionary_group`
--
ALTER TABLE `dictionary_group`
  ADD CONSTRAINT `dictionary_group_ibfk_3` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `dictionary_group_ibfk_4` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`answer_user`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `good`
--
ALTER TABLE `good`
  ADD CONSTRAINT `good_ibfk_6` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `good_ibfk_7` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `good_ibfk_8` FOREIGN KEY (`change_user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `image_to_gallery`
--
ALTER TABLE `image_to_gallery`
  ADD CONSTRAINT `image_to_gallery_ibfk_2` FOREIGN KEY (`galleryId`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `mail_template`
--
ALTER TABLE `mail_template`
  ADD CONSTRAINT `mail_template_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `mail_event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `menu_item`
--
ALTER TABLE `menu_item`
  ADD CONSTRAINT `menu_item_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `page_ibfk_2` FOREIGN KEY (`change_user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`update_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_ibfk_3` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `post_to_tag`
--
ALTER TABLE `post_to_tag`
  ADD CONSTRAINT `post_to_tag_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `post_to_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `recovery_password`
--
ALTER TABLE `recovery_password`
  ADD CONSTRAINT `fk_RecoveryPassword_User1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user_to_blog`
--
ALTER TABLE `user_to_blog`
  ADD CONSTRAINT `user_to_blog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_to_blog_ibfk_2` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `wiki_link`
--
ALTER TABLE `wiki_link`
  ADD CONSTRAINT `wiki_fk_link_page_from` FOREIGN KEY (`page_from_id`) REFERENCES `wiki_page` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wiki_fk_link_page_to` FOREIGN KEY (`page_to_id`) REFERENCES `wiki_page` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `wiki_page_revision`
--
ALTER TABLE `wiki_page_revision`
  ADD CONSTRAINT `wiki_fk_page_revision_page` FOREIGN KEY (`page_id`) REFERENCES `wiki_page` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
