-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2013 at 11:25 PM
-- Server version: 5.5.32-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yupetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `yupe_blog_blog`
--

CREATE TABLE IF NOT EXISTS `yupe_blog_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `icon` varchar(250) NOT NULL DEFAULT '',
  `slug` varchar(150) NOT NULL,
  `lang` char(2) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_blog_slug_lang` (`slug`,`lang`),
  KEY `ix_yupe_blog_blog_create_user` (`create_user_id`),
  KEY `ix_yupe_blog_blog_update_user` (`update_user_id`),
  KEY `ix_yupe_blog_blog_status` (`status`),
  KEY `ix_yupe_blog_blog_type` (`type`),
  KEY `ix_yupe_blog_blog_create_date` (`create_date`),
  KEY `ix_yupe_blog_blog_update_date` (`update_date`),
  KEY `ix_yupe_blog_blog_lang` (`lang`),
  KEY `ix_yupe_blog_blog_slug` (`slug`),
  KEY `ix_yupe_blog_blog_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_blog_post`
--

CREATE TABLE IF NOT EXISTS `yupe_blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `publish_date` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `lang` char(2) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `quote` varchar(250) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `link` varchar(250) NOT NULL DEFAULT '',
  `status` int(11) NOT NULL DEFAULT '0',
  `comment_status` int(11) NOT NULL DEFAULT '1',
  `create_user_ip` varchar(20) NOT NULL,
  `access_type` int(11) NOT NULL DEFAULT '1',
  `keywords` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL DEFAULT '',
  `image` varchar(300) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_post_lang_slug` (`slug`,`lang`),
  KEY `ix_yupe_blog_post_blog_id` (`blog_id`),
  KEY `ix_yupe_blog_post_create_user_id` (`create_user_id`),
  KEY `ix_yupe_blog_post_update_user_id` (`update_user_id`),
  KEY `ix_yupe_blog_post_status` (`status`),
  KEY `ix_yupe_blog_post_access_type` (`access_type`),
  KEY `ix_yupe_blog_post_comment_status` (`comment_status`),
  KEY `ix_yupe_blog_post_lang` (`lang`),
  KEY `ix_yupe_blog_post_slug` (`slug`),
  KEY `ix_yupe_blog_post_publish_date` (`publish_date`),
  KEY `ix_yupe_blog_post_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_blog_post_to_tag`
--

CREATE TABLE IF NOT EXISTS `yupe_blog_post_to_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `ix_yupe_blog_post_to_tag_post_id` (`post_id`),
  KEY `ix_yupe_blog_post_to_tag_tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_blog_tag`
--

CREATE TABLE IF NOT EXISTS `yupe_blog_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_tag_tag_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_blog_user_to_blog`
--

CREATE TABLE IF NOT EXISTS `yupe_blog_user_to_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `create_date` int(11) NOT NULL,
  `update_date` int(11) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `note` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_user_to_blog_blog_user_to_blog_u_b` (`user_id`,`blog_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_user_id` (`user_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_id` (`blog_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_status` (`status`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_catalog_good`
--

CREATE TABLE IF NOT EXISTS `yupe_catalog_good` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `price` decimal(19,3) NOT NULL DEFAULT '0.000',
  `article` varchar(100) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `alias` varchar(150) NOT NULL,
  `data` text,
  `is_special` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `change_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_catalog_good_alias` (`alias`),
  KEY `ix_yupe_catalog_good_status` (`status`),
  KEY `ix_yupe_catalog_good_category` (`category_id`),
  KEY `ix_yupe_catalog_good_user` (`user_id`),
  KEY `ix_yupe_catalog_good_change_user` (`change_user_id`),
  KEY `ix_yupe_catalog_good_article` (`article`),
  KEY `ix_yupe_catalog_good_price` (`price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_category_category`
--

CREATE TABLE IF NOT EXISTS `yupe_category_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `alias` varchar(150) NOT NULL,
  `lang` char(2) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_category_category_alias_lang` (`alias`,`lang`),
  KEY `ix_yupe_category_category_parent_id` (`parent_id`),
  KEY `ix_yupe_category_category_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_comment_comment`
--

CREATE TABLE IF NOT EXISTS `yupe_comment_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_comment_comment_status` (`status`),
  KEY `ix_yupe_comment_comment_model_model_id` (`model`,`model_id`),
  KEY `ix_yupe_comment_comment_model` (`model`),
  KEY `ix_yupe_comment_comment_model_id` (`model_id`),
  KEY `ix_yupe_comment_comment_user_id` (`user_id`),
  KEY `ix_yupe_comment_comment_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_contentblock_content_block`
--

CREATE TABLE IF NOT EXISTS `yupe_contentblock_content_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_contentblock_content_block_code` (`code`),
  KEY `ix_yupe_contentblock_content_block_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_dictionary_dictionary_data`
--

CREATE TABLE IF NOT EXISTS `yupe_dictionary_dictionary_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_dictionary_dictionary_data_code_unique` (`code`),
  KEY `ix_yupe_dictionary_dictionary_data_group_id` (`group_id`),
  KEY `ix_yupe_dictionary_dictionary_data_create_user_id` (`create_user_id`),
  KEY `ix_yupe_dictionary_dictionary_data_update_user_id` (`update_user_id`),
  KEY `ix_yupe_dictionary_dictionary_data_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_dictionary_dictionary_group`
--

CREATE TABLE IF NOT EXISTS `yupe_dictionary_dictionary_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_dictionary_dictionary_group_code` (`code`),
  KEY `ix_yupe_dictionary_dictionary_group_create_user_id` (`create_user_id`),
  KEY `ix_yupe_dictionary_dictionary_group_update_user_id` (`update_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_feedback_feedback`
--

CREATE TABLE IF NOT EXISTS `yupe_feedback_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `answer_user` int(11) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `theme` varchar(250) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `answer_date` datetime DEFAULT NULL,
  `is_faq` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_feedback_feedback_category` (`category_id`),
  KEY `ix_yupe_feedback_feedback_type` (`type`),
  KEY `ix_yupe_feedback_feedback_status` (`status`),
  KEY `ix_yupe_feedback_feedback_isfaq` (`is_faq`),
  KEY `ix_yupe_feedback_feedback_answer_user` (`answer_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_gallery_gallery`
--

CREATE TABLE IF NOT EXISTS `yupe_gallery_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_gallery_gallery_status` (`status`),
  KEY `ix_yupe_gallery_gallery_owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_gallery_image_to_gallery`
--

CREATE TABLE IF NOT EXISTS `yupe_gallery_image_to_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_gallery_image_to_gallery_gallery_to_image` (`image_id`,`gallery_id`),
  KEY `ix_yupe_gallery_image_to_gallery_gallery_to_image_image` (`image_id`),
  KEY `ix_yupe_gallery_image_to_gallery_gallery_to_image_gallery` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_image_image`
--

CREATE TABLE IF NOT EXISTS `yupe_image_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `file` varchar(250) NOT NULL,
  `creation_date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alt` varchar(250) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_image_image_status` (`status`),
  KEY `ix_yupe_image_image_user` (`user_id`),
  KEY `ix_yupe_image_image_type` (`type`),
  KEY `ix_yupe_image_image_category_id` (`category_id`),
  KEY `fk_yupe_image_image_parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_mail_mail_event`
--

CREATE TABLE IF NOT EXISTS `yupe_mail_mail_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_mail_mail_event_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_mail_mail_template`
--

CREATE TABLE IF NOT EXISTS `yupe_mail_mail_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(150) NOT NULL,
  `event_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `from` varchar(150) NOT NULL,
  `to` varchar(150) NOT NULL,
  `theme` text NOT NULL,
  `body` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_mail_mail_template_code` (`code`),
  KEY `ix_yupe_mail_mail_template_status` (`status`),
  KEY `ix_yupe_mail_mail_template_event_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_menu_menu`
--

CREATE TABLE IF NOT EXISTS `yupe_menu_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_menu_menu_code` (`code`),
  KEY `ix_yupe_menu_menu_status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `yupe_menu_menu`
--

INSERT INTO `yupe_menu_menu` (`id`, `name`, `code`, `description`, `status`) VALUES
(1, 'Верхнее меню', 'top-menu', 'Main site menu. Located at top in "main menu" block.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yupe_menu_menu_item`
--

CREATE TABLE IF NOT EXISTS `yupe_menu_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `regular_link` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL,
  `href` varchar(150) NOT NULL,
  `class` varchar(150) NOT NULL,
  `title_attr` varchar(150) NOT NULL,
  `before_link` varchar(150) NOT NULL,
  `after_link` varchar(150) NOT NULL,
  `target` varchar(150) NOT NULL,
  `rel` varchar(150) NOT NULL,
  `condition_name` varchar(150) DEFAULT '0',
  `condition_denial` int(11) DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_menu_menu_item_menu_id` (`menu_id`),
  KEY `ix_yupe_menu_menu_item_sort` (`sort`),
  KEY `ix_yupe_menu_menu_item_status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `yupe_menu_menu_item`
--

INSERT INTO `yupe_menu_menu_item` (`id`, `parent_id`, `menu_id`, `regular_link`, `title`, `href`, `class`, `title_attr`, `before_link`, `after_link`, `target`, `rel`, `condition_name`, `condition_denial`, `sort`, `status`) VALUES
(1, 0, 1, 0, 'Главная', '/site/index', '', 'Главная страница сайта', '', '', '', '', '', 0, 1, 1),
(2, 0, 1, 0, 'Блоги', '/blog/blog/index', '', 'Блоги', '', '', '', '', '', 0, 2, 1),
(3, 2, 1, 0, 'Пользователи', '/user/people/index', '', 'Пользователи', '', '', '', '', '', 0, 3, 1),
(4, 3, 1, 0, 'Контакты', '/feedback/contact/index', '', 'Контакты', '', '', '', '', '', 0, 6, 1),
(5, 0, 1, 0, 'Wiki', '/wiki/default/index', '', 'Wiki', '', '', '', '', '', 0, 9, 0),
(6, 0, 1, 0, 'Войти', '/user/account/login', 'login-text', 'Войти на сайт', '', '', '', '', 'isAuthenticated', 1, 11, 1),
(7, 0, 1, 0, 'Выйти', '/user/account/logout', 'login-text', 'Выйти', '', '', '', '', 'isAuthenticated', 0, 12, 1),
(8, 0, 1, 0, 'Регистрация', '/user/account/registration', 'login-text', 'Регистрация на сайте', '', '', '', '', 'isAuthenticated', 1, 10, 1),
(9, 0, 1, 0, 'Панель управления', '/yupe/backend/index', 'login-text', 'Панель управления сайтом', '', '', '', '', 'isSuperUser', 0, 13, 1),
(10, 0, 1, 0, 'FAQ', '/feedback/contact/faq', '', 'FAQ', '', '', '', '', '', 0, 7, 1),
(11, 0, 1, 0, 'Контакты', '/feedback/index/', '', 'Контакты', '', '', '', '', '', 0, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `yupe_migrations`
--

CREATE TABLE IF NOT EXISTS `yupe_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_migrations_module` (`module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `yupe_migrations`
--

INSERT INTO `yupe_migrations` (`id`, `module`, `version`, `apply_time`) VALUES
(1, 'user', 'm000000_000000_user_base', 1379085241),
(2, 'yupe', 'm000000_000000_yupe_base', 1379085242),
(3, 'yupe', 'm130527_154455_yupe_change_unique_index', 1379085243),
(4, 'category', 'm000000_000000_category_base', 1379085244),
(5, 'comment', 'm000000_000000_comment_base', 1379085246),
(6, 'image', 'm000000_000000_image_base', 1379085248),
(7, 'gallery', 'm000000_000000_gallery_base', 1379085250),
(8, 'gallery', 'm130427_120500_gallery_creation_user', 1379085251),
(9, 'news', 'm000000_000000_news_base', 1379085253),
(10, 'catalog', 'm000000_000000_good_base', 1379085255),
(11, 'menu', 'm000000_000000_menu_base', 1379085257),
(12, 'menu', 'm121220_001126_menu_test_data', 1379085257),
(13, 'feedback', 'm000000_000000_feedback_base', 1379085259),
(14, 'queue', 'm000000_000000_queue_base', 1379085260),
(15, 'blog', 'm000000_000000_blog_base', 1379085269),
(16, 'blog', 'm130503_091124_BlogPostImage', 1379085269),
(17, 'blog', 'm130529_151602_add_post_category', 1379085270),
(18, 'dictionary', 'm000000_000000_dictionary_base', 1379085274),
(19, 'yeeki', 'm000000_000000_yeeki_base', 1379085278),
(20, 'contentblock', 'm000000_000000_contentblock_base', 1379085279),
(21, 'page', 'm000000_000000_page_base', 1379085282),
(22, 'page', 'm130115_155600_columns_rename', 1379085282),
(23, 'mail', 'm000000_000000_mail_base', 1379085285);

-- --------------------------------------------------------

--
-- Table structure for table `yupe_news_news`
--

CREATE TABLE IF NOT EXISTS `yupe_news_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `date` date NOT NULL,
  `title` varchar(250) NOT NULL,
  `alias` varchar(150) NOT NULL,
  `short_text` text,
  `full_text` text NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  `link` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `keywords` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_news_news_alias_lang` (`alias`,`lang`),
  KEY `ix_yupe_news_news_status` (`status`),
  KEY `ix_yupe_news_news_user_id` (`user_id`),
  KEY `ix_yupe_news_news_category_id` (`category_id`),
  KEY `ix_yupe_news_news_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `yupe_news_news` (`id`, `category_id`, `lang`, `creation_date`, `change_date`, `date`, `title`, `alias`, `short_text`, `full_text`, `image`, `link`, `user_id`, `status`, `is_protected`, `keywords`, `description`) VALUES
(1, NULL, 'ru', '2013-09-26 19:17:56', '2013-09-26 19:17:56', '2013-09-26', 'Первая опубликованная новость', 'pervaja-opublikovannaja-novost', '<p>\r\n	Первая опубликованная короткий новость\r\n</p>', '<p>\r\n	Первая опубликованная текст\r\n</p>', NULL, '', 1, 1, 0, 'Первая опубликованная новость', 'Первая опубликованная новость'),
(2, NULL, 'ru', '2013-09-26 19:18:45', '2013-09-26 19:18:45', '2013-09-26', 'Вторая не опубликованная новость', 'vtoraja-ne-opublikovannaja-novost', '<p>\r\n	Вторая не опубликованная новость короткий текст\r\n</p>', '<p>\r\n	Вторая не опубликованная новость текст\r\n</p>', NULL, '', 1, 0, 0, 'Вторая не опубликованная новость', 'Вторая не опубликованная новость'),
(3, NULL, 'ru', '2013-09-26 19:20:04', '2013-09-26 19:20:04', '2013-09-26', 'Третья новость только для авторизованных', 'tretja-novost-tolko-dlja-avtorizovannyh', '<p>\r\n	Третья новость только для авторизованных текст\r\n</p>', '<p>\r\n	Третья новость только для авторизованных текст\r\n</p>', NULL, '', 1, 1, 1, 'Третья новость только для авторизованных текст', 'Третья новость только для авторизованных текст');
-- --------------------------------------------------------

--
-- Table structure for table `yupe_page_page`
--

CREATE TABLE IF NOT EXISTS `yupe_page_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `change_user_id` int(11) DEFAULT NULL,
  `title_short` varchar(150) NOT NULL,
  `title` varchar(250) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `body` text NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_page_page_slug_lang` (`slug`,`lang`),
  KEY `ix_yupe_page_page_status` (`status`),
  KEY `ix_yupe_page_page_is_protected` (`is_protected`),
  KEY `ix_yupe_page_page_user_id` (`user_id`),
  KEY `ix_yupe_page_page_change_user_id` (`change_user_id`),
  KEY `ix_yupe_page_page_menu_order` (`order`),
  KEY `ix_yupe_page_page_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


INSERT INTO `yupe_page_page` (`id`, `category_id`, `lang`, `parent_id`, `creation_date`, `change_date`, `user_id`, `change_user_id`, `title_short`, `title`, `slug`, `body`, `keywords`, `description`, `status`, `is_protected`, `order`) VALUES
(1, NULL, 'ru', NULL, '2013-09-19 19:38:33', '2013-09-19 19:38:33', 1, 1, 'Опубликованная страница', 'Опубликованная страница', 'opublikovannaja-starnica', '<p>\r\n	Опубликованная страница текст\r\n</p>', 'сео слова', 'сео описание', 1, 0, 0);

INSERT INTO `yupe_page_page` (`id`, `category_id`, `lang`, `parent_id`, `creation_date`, `change_date`, `user_id`, `change_user_id`, `title_short`, `title`, `slug`, `body`, `keywords`, `description`, `status`, `is_protected`, `order`) VALUES
(2, NULL, 'ru', NULL, '2013-09-19 19:47:43', '2013-09-19 19:47:43', 1, 1, 'Скрытая страница', 'Скрытая страница', 'skrytaja-stranica', '<p>\r\n	Скрытая страница текст\r\n</p>', '', '', 0, 0, 0);

INSERT INTO `yupe_page_page` (`id`, `category_id`, `lang`, `parent_id`, `creation_date`, `change_date`, `user_id`, `change_user_id`, `title_short`, `title`, `slug`, `body`, `keywords`, `description`, `status`, `is_protected`, `order`) VALUES
(3, NULL, 'ru', NULL, '2013-09-19 19:55:47', '2013-09-19 19:55:47', 1, 1, 'Защищенная страница', 'Защищенная страница', 'zaschischennaja-stranica', '<p>\r\n	Защищенная страница текст\r\n</p>', '', '', 1, 1, 0);


-- --------------------------------------------------------

--
-- Table structure for table `yupe_queue_queue`
--

CREATE TABLE IF NOT EXISTS `yupe_queue_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `worker` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `task` text NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `complete_time` datetime DEFAULT NULL,
  `priority` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '0',
  `notice` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_queue_queue_worker` (`worker`),
  UNIQUE KEY `ux_yupe_queue_queue_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_user_recovery_password`
--

CREATE TABLE IF NOT EXISTS `yupe_user_recovery_password` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `code` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_user_recovery_password_code` (`code`),
  KEY `ix_yupe_user_recovery_password_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `yupe_user_recovery_password`
--
--
-- Table structure for table `yupe_user_user`
--

CREATE TABLE IF NOT EXISTS `yupe_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `first_name` varchar(250) DEFAULT NULL,
  `middle_name` varchar(250) DEFAULT NULL,
  `last_name` varchar(250) DEFAULT NULL,
  `nick_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0',
  `birth_date` date DEFAULT NULL,
  `site` varchar(250) NOT NULL DEFAULT '',
  `about` varchar(250) NOT NULL DEFAULT '',
  `location` varchar(250) NOT NULL DEFAULT '',
  `online_status` varchar(250) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL,
  `salt` char(32) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2',
  `access_level` int(11) NOT NULL DEFAULT '0',
  `last_visit` datetime DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `registration_ip` varchar(50) NOT NULL,
  `activation_ip` varchar(50) NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `use_gravatar` tinyint(1) NOT NULL DEFAULT '1',
  `activate_key` char(32) NOT NULL,
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_user_user_nick_name` (`nick_name`),
  UNIQUE KEY `ux_yupe_user_user_email` (`email`),
  KEY `ix_yupe_user_user_status` (`status`),
  KEY `ix_yupe_user_user_email_confirm` (`email_confirm`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `yupe_user_user`
--

INSERT INTO `yupe_user_user` (`id`, `creation_date`, `change_date`, `first_name`, `middle_name`, `last_name`, `nick_name`, `email`, `gender`, `birth_date`, `site`, `about`, `location`, `online_status`, `password`, `salt`, `status`, `access_level`, `last_visit`, `registration_date`, `registration_ip`, `activation_ip`, `avatar`, `use_gravatar`, `activate_key`, `email_confirm`) VALUES
(1, '2013-09-13 19:15:31', '2013-09-16 20:05:48', '', '', '', 'yupe', 'yupe@yupe.local', 0, NULL, '', '', '', '', '1973499f220139c96759089de6f77519', '72bf7380c2ad86266bb53e75bd2b26cf', 1, 1, '2013-09-16 20:05:45', '2013-09-13 19:15:31', '127.0.0.1', '127.0.0.1', NULL, 1, 'da4fb4f42e1bac61271d924386e8c706', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yupe_wiki_wiki_link`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_wiki_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_from_id` int(11) NOT NULL,
  `page_to_id` int(11) DEFAULT NULL,
  `wiki_uid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_wiki_wiki_link_code_unique` (`page_from_id`),
  KEY `ix_yupe_wiki_wiki_link_status` (`page_to_id`),
  KEY `ix_yupe_wiki_wiki_link_uid` (`wiki_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_wiki_wiki_page`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_wiki_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_redirect` tinyint(1) DEFAULT '0',
  `page_uid` varchar(250) DEFAULT NULL,
  `namespace` varchar(250) DEFAULT NULL,
  `content` text,
  `revision_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_wiki_wiki_page_revision_id` (`revision_id`),
  KEY `ix_yupe_wiki_wiki_page_user_id` (`user_id`),
  KEY `ix_yupe_wiki_wiki_page_namespace` (`namespace`),
  KEY `ix_yupe_wiki_wiki_page_created_at` (`created_at`),
  KEY `ix_yupe_wiki_wiki_page_updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_wiki_wiki_page_revision`
--

CREATE TABLE IF NOT EXISTS `yupe_wiki_wiki_page_revision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `is_minor` tinyint(1) DEFAULT NULL,
  `content` text,
  `user_id` varchar(250) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_wiki_wiki_page_revision_pageid` (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `yupe_yupe_settings`
--

CREATE TABLE IF NOT EXISTS `yupe_yupe_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(100) NOT NULL,
  `param_name` varchar(100) NOT NULL,
  `param_value` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_yupe_settings_module_id_param_name_user_id` (`module_id`,`param_name`,`user_id`),
  KEY `ix_yupe_yupe_settings_module_id` (`module_id`),
  KEY `ix_yupe_yupe_settings_param_name` (`param_name`),
  KEY `fk_yupe_yupe_settings_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `yupe_yupe_settings`
--

INSERT INTO `yupe_yupe_settings` (`id`, `module_id`, `param_name`, `param_value`, `creation_date`, `change_date`, `user_id`, `type`) VALUES
(1, 'yupe', 'siteDescription', 'Юпи! - самый быстрый способ создать сайт на Yii', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1),
(2, 'yupe', 'siteName', 'Юпи!', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1),
(3, 'yupe', 'siteKeyWords', 'Юпи!, yupe, yii, cms, цмс', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1),
(4, 'yupe', 'email', 'yupe@yupetest.ru', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1),
(5, 'yupe', 'theme', 'default', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1),
(6, 'yupe', 'backendTheme', '', '2013-09-13 19:15:35', '2013-09-13 19:15:35', 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `yupe_blog_blog`
--
ALTER TABLE `yupe_blog_blog`
  ADD CONSTRAINT `fk_yupe_blog_blog_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_blog_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_blog_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_blog_post`
--
ALTER TABLE `yupe_blog_post`
  ADD CONSTRAINT `fk_yupe_blog_post_blog` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_post_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_post_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_post_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_blog_post_to_tag`
--
ALTER TABLE `yupe_blog_post_to_tag`
  ADD CONSTRAINT `fk_yupe_blog_post_to_tag_post_id` FOREIGN KEY (`post_id`) REFERENCES `yupe_blog_post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_post_to_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `yupe_blog_tag` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_blog_user_to_blog`
--
ALTER TABLE `yupe_blog_user_to_blog`
  ADD CONSTRAINT `fk_yupe_blog_user_to_blog_blog_user_to_blog_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_blog_user_to_blog_blog_user_to_blog_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_catalog_good`
--
ALTER TABLE `yupe_catalog_good`
  ADD CONSTRAINT `fk_yupe_catalog_good_category` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_catalog_good_change_user` FOREIGN KEY (`change_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_catalog_good_user` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_category_category`
--
ALTER TABLE `yupe_category_category`
  ADD CONSTRAINT `fk_yupe_category_category_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_comment_comment`
--
ALTER TABLE `yupe_comment_comment`
  ADD CONSTRAINT `fk_yupe_comment_comment_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_comment_comment` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_comment_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_dictionary_dictionary_data`
--
ALTER TABLE `yupe_dictionary_dictionary_data`
  ADD CONSTRAINT `fk_yupe_dictionary_dictionary_data_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_dictionary_dictionary_data_data_group_id` FOREIGN KEY (`group_id`) REFERENCES `yupe_dictionary_dictionary_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_dictionary_dictionary_data_update_user_id` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_dictionary_dictionary_group`
--
ALTER TABLE `yupe_dictionary_dictionary_group`
  ADD CONSTRAINT `fk_yupe_dictionary_dictionary_group_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_dictionary_dictionary_group_update_user_id` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_feedback_feedback`
--
ALTER TABLE `yupe_feedback_feedback`
  ADD CONSTRAINT `fk_yupe_feedback_feedback_answer_user` FOREIGN KEY (`answer_user`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_feedback_feedback_category` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_gallery_gallery`
--
ALTER TABLE `yupe_gallery_gallery`
  ADD CONSTRAINT `fk_yupe_gallery_gallery_owner` FOREIGN KEY (`owner`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_gallery_image_to_gallery`
--
ALTER TABLE `yupe_gallery_image_to_gallery`
  ADD CONSTRAINT `fk_yupe_gallery_image_to_gallery_gallery_to_image_gallery` FOREIGN KEY (`gallery_id`) REFERENCES `yupe_gallery_gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_gallery_image_to_gallery_gallery_to_image_image` FOREIGN KEY (`image_id`) REFERENCES `yupe_image_image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_image_image`
--
ALTER TABLE `yupe_image_image`
  ADD CONSTRAINT `fk_yupe_image_image_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_image_image_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_image_image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_image_image_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_mail_mail_template`
--
ALTER TABLE `yupe_mail_mail_template`
  ADD CONSTRAINT `fk_yupe_mail_mail_template_event_id` FOREIGN KEY (`event_id`) REFERENCES `yupe_mail_mail_event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_menu_menu_item`
--
ALTER TABLE `yupe_menu_menu_item`
  ADD CONSTRAINT `fk_yupe_menu_menu_item_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `yupe_menu_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `yupe_news_news`
--
ALTER TABLE `yupe_news_news`
  ADD CONSTRAINT `fk_yupe_news_news_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_news_news_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_page_page`
--
ALTER TABLE `yupe_page_page`
  ADD CONSTRAINT `fk_yupe_page_page_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_page_page_change_user_id` FOREIGN KEY (`change_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_yupe_page_page_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `yupe_wiki_wiki_link`
--
ALTER TABLE `yupe_wiki_wiki_link`
  ADD CONSTRAINT `fk_yupe_wiki_wiki_link_page_from_fk` FOREIGN KEY (`page_from_id`) REFERENCES `yupe_wiki_wiki_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yupe_wiki_wiki_link_page_to_fk` FOREIGN KEY (`page_to_id`) REFERENCES `yupe_wiki_wiki_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `yupe_wiki_wiki_page`
--
ALTER TABLE `yupe_wiki_wiki_page`
  ADD CONSTRAINT `fk_yupe_wiki_wiki_page_revision_id` FOREIGN KEY (`revision_id`) REFERENCES `yupe_wiki_wiki_page_revision` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_yupe_wiki_wiki_page_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `yupe_wiki_wiki_page_revision`
--
ALTER TABLE `yupe_wiki_wiki_page_revision`
  ADD CONSTRAINT `fk_yupe_wiki_wiki_page_revision_page` FOREIGN KEY (`page_id`) REFERENCES `yupe_wiki_wiki_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `yupe_yupe_settings`
--
ALTER TABLE `yupe_yupe_settings`
  ADD CONSTRAINT `fk_yupe_yupe_settings_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
