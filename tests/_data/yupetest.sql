SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `yupe_blog_blog`;
CREATE TABLE `yupe_blog_blog` (
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
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `member_status` int(11) NOT NULL DEFAULT '1',
  `post_status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_blog_slug_lang` (`slug`,`lang`),
  KEY `ix_yupe_blog_blog_create_user` (`create_user_id`),
  KEY `ix_yupe_blog_blog_update_user` (`update_user_id`),
  KEY `ix_yupe_blog_blog_status` (`status`),
  KEY `ix_yupe_blog_blog_type` (`type`),
  KEY `ix_yupe_blog_blog_create_date` (`create_time`),
  KEY `ix_yupe_blog_blog_update_date` (`update_time`),
  KEY `ix_yupe_blog_blog_lang` (`lang`),
  KEY `ix_yupe_blog_blog_slug` (`slug`),
  KEY `ix_yupe_blog_blog_category_id` (`category_id`),
  CONSTRAINT `fk_yupe_blog_blog_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_blog_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_blog_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_blog_blog` (`id`, `category_id`, `name`, `description`, `icon`, `slug`, `lang`, `type`, `status`, `create_user_id`, `update_user_id`, `create_time`, `update_time`, `member_status`, `post_status`) VALUES
  (1,	NULL,	'Опубликованный блог',	'<p>\n	Опубликованный блог описание\n</p>',	'',	'public-blog',	NULL,	1,	1,	1,	1,	1381246593,	1381246593,	1,	1),
  (2,	NULL,	'Удаленный блог',	'<p>\n	Удаленный блог\n</p>',	'',	'deleted-blog',	NULL,	1,	2,	1,	1,	1381246629,	1381246629,	1,	1);

DROP TABLE IF EXISTS `yupe_blog_post`;
CREATE TABLE `yupe_blog_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `publish_time` int(11) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `lang` char(2) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `quote` text,
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
  KEY `ix_yupe_blog_post_publish_date` (`publish_time`),
  KEY `ix_yupe_blog_post_category_id` (`category_id`),
  CONSTRAINT `fk_yupe_blog_post_blog` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_post_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_post_create_user` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_post_update_user` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_blog_post` (`id`, `blog_id`, `create_user_id`, `update_user_id`, `create_time`, `update_time`, `publish_time`, `slug`, `lang`, `title`, `quote`, `content`, `link`, `status`, `comment_status`, `create_user_ip`, `access_type`, `keywords`, `description`, `image`, `category_id`) VALUES
  (1,	1,	1,	1,	1381419017,	1381419017,	1381375680,	'pervaja-publichnaja-zapis-v-opublikovannom-bloge',	NULL,	'Первая публичная запись в опубликованном блоге',	'<p>\r\n	Первая публичная запись в опубликованном блоге цитата\r\n</p>',	'<p style=\"margin-left: 40px;\">\r\n	Первая публичная запись в опубликованном блоге контент\r\n</p>',	'',	1,	1,	'127.0.0.1',	1,	'первый, пост',	'Первый пост',	NULL,	NULL),
  (2,	1,	1,	1,	1381419119,	1381419119,	1381375800,	'chernovik-v-opublikovannom-bloge',	NULL,	'Черновик в опубликованном блоге',	'<p style=\"margin-left: 20px;\">\r\n	Черновик в опубликованном блоге цитата\r\n</p>',	'<p style=\"margin-left: 20px;\">\r\n	Черновик в опубликованном блоге контент\r\n</p>',	'',	0,	1,	'127.0.0.1',	1,	'второй, пост',	'Второй пост',	NULL,	NULL);

DROP TABLE IF EXISTS `yupe_blog_post_to_tag`;
CREATE TABLE `yupe_blog_post_to_tag` (
  `post_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `ix_yupe_blog_post_to_tag_post_id` (`post_id`),
  KEY `ix_yupe_blog_post_to_tag_tag_id` (`tag_id`),
  CONSTRAINT `fk_yupe_blog_post_to_tag_post_id` FOREIGN KEY (`post_id`) REFERENCES `yupe_blog_post` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_post_to_tag_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `yupe_blog_tag` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_blog_post_to_tag` (`post_id`, `tag_id`) VALUES
  (1,	1),
  (1,	2),
  (1,	3);

DROP TABLE IF EXISTS `yupe_blog_tag`;
CREATE TABLE `yupe_blog_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_tag_tag_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_blog_tag` (`id`, `name`) VALUES
  (1,	'тег'),
  (2,	'тег2'),
  (3,	'тег3');

DROP TABLE IF EXISTS `yupe_blog_user_to_blog`;
CREATE TABLE `yupe_blog_user_to_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `blog_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '1',
  `status` int(11) NOT NULL DEFAULT '1',
  `note` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_blog_user_to_blog_blog_user_to_blog_u_b` (`user_id`,`blog_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_user_id` (`user_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_id` (`blog_id`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_status` (`status`),
  KEY `ix_yupe_blog_user_to_blog_blog_user_to_blog_role` (`role`),
  CONSTRAINT `fk_yupe_blog_user_to_blog_blog_user_to_blog_blog_id` FOREIGN KEY (`blog_id`) REFERENCES `yupe_blog_blog` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_blog_user_to_blog_blog_user_to_blog_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_callback`;
CREATE TABLE `yupe_callback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_category_category`;
CREATE TABLE `yupe_category_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(150) NOT NULL,
  `lang` char(2) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `short_description` text,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_category_category_alias_lang` (`slug`,`lang`),
  KEY `ix_yupe_category_category_parent_id` (`parent_id`),
  KEY `ix_yupe_category_category_status` (`status`),
  CONSTRAINT `fk_yupe_category_category_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_comment_comment`;
CREATE TABLE `yupe_comment_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `model` varchar(100) NOT NULL,
  `model_id` int(11) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `text` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) DEFAULT NULL,
  `level` int(11) DEFAULT '0',
  `root` int(11) DEFAULT '0',
  `lft` int(11) DEFAULT '0',
  `rgt` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_comment_comment_status` (`status`),
  KEY `ix_yupe_comment_comment_model_model_id` (`model`,`model_id`),
  KEY `ix_yupe_comment_comment_model` (`model`),
  KEY `ix_yupe_comment_comment_model_id` (`model_id`),
  KEY `ix_yupe_comment_comment_user_id` (`user_id`),
  KEY `ix_yupe_comment_comment_parent_id` (`parent_id`),
  KEY `ix_yupe_comment_comment_level` (`level`),
  KEY `ix_yupe_comment_comment_root` (`root`),
  KEY `ix_yupe_comment_comment_lft` (`lft`),
  KEY `ix_yupe_comment_comment_rgt` (`rgt`),
  CONSTRAINT `fk_yupe_comment_comment_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_comment_comment` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_comment_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_contentblock_content_block`;
CREATE TABLE `yupe_contentblock_content_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `code` varchar(100) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `content` text NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_contentblock_content_block_code` (`code`),
  KEY `ix_yupe_contentblock_content_block_type` (`type`),
  KEY `ix_yupe_contentblock_content_block_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_dictionary_dictionary_data`;
CREATE TABLE `yupe_dictionary_dictionary_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_dictionary_dictionary_data_code_unique` (`code`),
  KEY `ix_yupe_dictionary_dictionary_data_group_id` (`group_id`),
  KEY `ix_yupe_dictionary_dictionary_data_create_user_id` (`create_user_id`),
  KEY `ix_yupe_dictionary_dictionary_data_update_user_id` (`update_user_id`),
  KEY `ix_yupe_dictionary_dictionary_data_status` (`status`),
  CONSTRAINT `fk_yupe_dictionary_dictionary_data_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_dictionary_dictionary_data_data_group_id` FOREIGN KEY (`group_id`) REFERENCES `yupe_dictionary_dictionary_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_dictionary_dictionary_data_update_user_id` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_dictionary_dictionary_group`;
CREATE TABLE `yupe_dictionary_dictionary_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL DEFAULT '',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_dictionary_dictionary_group_code` (`code`),
  KEY `ix_yupe_dictionary_dictionary_group_create_user_id` (`create_user_id`),
  KEY `ix_yupe_dictionary_dictionary_group_update_user_id` (`update_user_id`),
  CONSTRAINT `fk_yupe_dictionary_dictionary_group_create_user_id` FOREIGN KEY (`create_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_dictionary_dictionary_group_update_user_id` FOREIGN KEY (`update_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_feedback_feedback`;
CREATE TABLE `yupe_feedback_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `answer_user` int(11) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `theme` varchar(250) NOT NULL,
  `text` text NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `answer` text NOT NULL,
  `answer_time` datetime DEFAULT NULL,
  `is_faq` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_feedback_feedback_category` (`category_id`),
  KEY `ix_yupe_feedback_feedback_type` (`type`),
  KEY `ix_yupe_feedback_feedback_status` (`status`),
  KEY `ix_yupe_feedback_feedback_isfaq` (`is_faq`),
  KEY `ix_yupe_feedback_feedback_answer_user` (`answer_user`),
  CONSTRAINT `fk_yupe_feedback_feedback_answer_user` FOREIGN KEY (`answer_user`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_feedback_feedback_category` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_gallery_gallery`;
CREATE TABLE `yupe_gallery_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `owner` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_gallery_gallery_status` (`status`),
  KEY `ix_yupe_gallery_gallery_owner` (`owner`),
  CONSTRAINT `fk_yupe_gallery_gallery_owner` FOREIGN KEY (`owner`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_gallery_gallery` (`id`, `name`, `description`, `status`, `owner`) VALUES
  (1,	'Первая галерея',	'<p>\r\n  Первая галерея\r\n</p>',	1,	1);

DROP TABLE IF EXISTS `yupe_gallery_image_to_gallery`;
CREATE TABLE `yupe_gallery_image_to_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_gallery_image_to_gallery_gallery_to_image` (`image_id`,`gallery_id`),
  KEY `ix_yupe_gallery_image_to_gallery_gallery_to_image_image` (`image_id`),
  KEY `ix_yupe_gallery_image_to_gallery_gallery_to_image_gallery` (`gallery_id`),
  CONSTRAINT `fk_yupe_gallery_image_to_gallery_gallery_to_image_gallery` FOREIGN KEY (`gallery_id`) REFERENCES `yupe_gallery_gallery` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_gallery_image_to_gallery_gallery_to_image_image` FOREIGN KEY (`image_id`) REFERENCES `yupe_image_image` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_gallery_image_to_gallery` (`id`, `image_id`, `gallery_id`, `create_time`) VALUES
  (1,	1,	1,	'2013-11-08 13:21:15');

DROP TABLE IF EXISTS `yupe_image_image`;
CREATE TABLE `yupe_image_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `description` text,
  `file` varchar(250) NOT NULL,
  `create_time` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `alt` varchar(250) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_image_image_status` (`status`),
  KEY `ix_yupe_image_image_user` (`user_id`),
  KEY `ix_yupe_image_image_type` (`type`),
  KEY `ix_yupe_image_image_category_id` (`category_id`),
  KEY `fk_yupe_image_image_parent_id` (`parent_id`),
  CONSTRAINT `fk_yupe_image_image_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_image_image_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `yupe_image_image` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_image_image_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_image_image` (`id`, `category_id`, `parent_id`, `name`, `description`, `file`, `create_time`, `user_id`, `alt`, `type`, `status`, `sort`) VALUES
  (1,	NULL,	NULL,	'2013-10-22 22.33.28.jpg',	'',	'636b1da2749984e81de4adf1dd3d529f.jpg',	'2013-11-08 13:21:15',	1,	'2013-10-22 22.33.28.jpg',	0,	1,	1);

DROP TABLE IF EXISTS `yupe_mail_mail_event`;
CREATE TABLE `yupe_mail_mail_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(150) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_mail_mail_event_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_mail_mail_template`;
CREATE TABLE `yupe_mail_mail_template` (
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
  KEY `ix_yupe_mail_mail_template_event_id` (`event_id`),
  CONSTRAINT `fk_yupe_mail_mail_template_event_id` FOREIGN KEY (`event_id`) REFERENCES `yupe_mail_mail_event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_menu_menu`;
CREATE TABLE `yupe_menu_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_menu_menu_code` (`code`),
  KEY `ix_yupe_menu_menu_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_menu_menu` (`id`, `name`, `code`, `description`, `status`) VALUES
  (1,	'Верхнее меню',	'top-menu',	'Main site menu. Located at top in \"main menu\" block.',	1);

DROP TABLE IF EXISTS `yupe_menu_menu_item`;
CREATE TABLE `yupe_menu_menu_item` (
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
  KEY `ix_yupe_menu_menu_item_status` (`status`),
  CONSTRAINT `fk_yupe_menu_menu_item_menu_id` FOREIGN KEY (`menu_id`) REFERENCES `yupe_menu_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_menu_menu_item` (`id`, `parent_id`, `menu_id`, `regular_link`, `title`, `href`, `class`, `title_attr`, `before_link`, `after_link`, `target`, `rel`, `condition_name`, `condition_denial`, `sort`, `status`) VALUES
  (1,	0,	1,	0,	'Главная',	'/site/index',	'',	'Главная страница сайта',	'',	'',	'',	'',	'',	0,	1,	1),
  (2,	0,	1,	0,	'Блоги',	'/blog/blog/index',	'',	'Блоги',	'',	'',	'',	'',	'',	0,	2,	1),
  (3,	2,	1,	0,	'Пользователи',	'/user/people/index',	'',	'Пользователи',	'',	'',	'',	'',	'',	0,	3,	1),
  (5,	0,	1,	0,	'Wiki',	'/wiki/default/index',	'',	'Wiki',	'',	'',	'',	'',	'',	0,	9,	0),
  (6,	0,	1,	0,	'Войти',	'/user/account/login',	'login-text',	'Войти на сайт',	'',	'',	'',	'',	'isAuthenticated',	1,	11,	1),
  (7,	0,	1,	0,	'Выйти',	'/user/account/logout',	'login-text',	'Выйти',	'',	'',	'',	'',	'isAuthenticated',	0,	12,	1),
  (8,	0,	1,	0,	'Регистрация',	'/user/account/registration',	'login-text',	'Регистрация на сайте',	'',	'',	'',	'',	'isAuthenticated',	1,	10,	1),
  (9,	0,	1,	0,	'Панель управления',	'/yupe/backend/index',	'login-text',	'Панель управления сайтом',	'',	'',	'',	'',	'isSuperUser',	0,	13,	1),
  (10,	0,	1,	0,	'FAQ',	'/feedback/contact/faq',	'',	'FAQ',	'',	'',	'',	'',	'',	0,	7,	1),
  (11,	0,	1,	0,	'Контакты',	'/feedback/contact/index',	'',	'Контакты',	'',	'',	'',	'',	'',	0,	7,	1);

DROP TABLE IF EXISTS `yupe_migrations`;
CREATE TABLE `yupe_migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_migrations_module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_migrations` (`id`, `module`, `version`, `apply_time`) VALUES
  (1,	'user',	'm000000_000000_user_base',	1449572900),
  (2,	'user',	'm131019_212911_user_tokens',	1449572901),
  (3,	'user',	'm131025_152911_clean_user_table',	1449572909),
  (4,	'user',	'm131026_002234_prepare_hash_user_password',	1449572913),
  (5,	'user',	'm131106_111552_user_restore_fields',	1449572914),
  (6,	'user',	'm131121_190850_modify_tokes_table',	1449572916),
  (7,	'user',	'm140812_100348_add_expire_to_token_table',	1449572918),
  (8,	'user',	'm150416_113652_rename_fields',	1449572919),
  (9,	'user',	'm151006_000000_user_add_phone',	1449572921),
  (10,	'yupe',	'm000000_000000_yupe_base',	1449572925),
  (11,	'yupe',	'm130527_154455_yupe_change_unique_index',	1449572926),
  (12,	'yupe',	'm150416_125517_rename_fields',	1449572927),
  (13,	'category',	'm000000_000000_category_base',	1449572932),
  (14,	'category',	'm150415_150436_rename_fields',	1449572932),
  (15,	'store',	'm140812_160000_store_attribute_group_base',	1449572933),
  (16,	'store',	'm140812_170000_store_attribute_base',	1449572936),
  (17,	'store',	'm140812_180000_store_attribute_option_base',	1449572940),
  (18,	'store',	'm140813_200000_store_category_base',	1449572943),
  (19,	'store',	'm140813_210000_store_type_base',	1449572944),
  (20,	'store',	'm140813_220000_store_type_attribute_base',	1449572946),
  (21,	'store',	'm140813_230000_store_producer_base',	1449572947),
  (22,	'store',	'm140814_000000_store_product_base',	1449572957),
  (23,	'store',	'm140814_000010_store_product_category_base',	1449572960),
  (24,	'store',	'm140814_000013_store_product_attribute_eav_base',	1449572964),
  (25,	'store',	'm140814_000018_store_product_image_base',	1449572965),
  (26,	'store',	'm140814_000020_store_product_variant_base',	1449572969),
  (27,	'store',	'm141014_210000_store_product_category_column',	1449572972),
  (28,	'store',	'm141015_170000_store_product_image_column',	1449572974),
  (29,	'store',	'm141218_091834_default_null',	1449572975),
  (30,	'store',	'm150210_063409_add_store_menu_item',	1449572975),
  (31,	'store',	'm150210_105811_add_price_column',	1449572978),
  (32,	'store',	'm150210_131238_order_category',	1449572979),
  (33,	'store',	'm150211_105453_add_position_for_product_variant',	1449572981),
  (34,	'store',	'm150226_065935_add_product_position',	1449572983),
  (35,	'store',	'm150416_112008_rename_fields',	1449572983),
  (36,	'store',	'm150417_180000_store_product_link_base',	1449572987),
  (37,	'store',	'm150825_184407_change_store_url',	1449572988),
  (38,	'store',	'm150907_084604_new_attributes',	1449572991),
  (39,	'mail',	'm000000_000000_mail_base',	1449572995),
  (40,	'payment',	'm140815_170000_store_payment_base',	1449572996),
  (41,	'image',	'm000000_000000_image_base',	1449573002),
  (42,	'image',	'm150226_121100_image_order',	1449573003),
  (43,	'image',	'm150416_080008_rename_fields',	1449573003),
  (44,	'comment',	'm000000_000000_comment_base',	1449573008),
  (45,	'comment',	'm130704_095200_comment_nestedsets',	1449573014),
  (46,	'comment',	'm150415_151804_rename_fields',	1449573014),
  (47,	'blog',	'm000000_000000_blog_base',	1449573038),
  (48,	'blog',	'm130503_091124_BlogPostImage',	1449573039),
  (49,	'blog',	'm130529_151602_add_post_category',	1449573042),
  (50,	'blog',	'm140226_052326_add_community_fields',	1449573045),
  (51,	'blog',	'm140714_110238_blog_post_quote_type',	1449573046),
  (52,	'blog',	'm150406_094809_blog_post_quote_type',	1449573048),
  (53,	'blog',	'm150414_180119_rename_date_fields',	1449573048),
  (54,	'delivery',	'm140815_190000_store_delivery_base',	1449573049),
  (55,	'delivery',	'm140815_200000_store_delivery_payment_base',	1449573052),
  (56,	'order',	'm140814_200000_store_order_base',	1449573060),
  (57,	'order',	'm150324_105949_order_status_table',	1449573063),
  (58,	'order',	'm150416_100212_rename_fields',	1449573063),
  (59,	'order',	'm150514_065554_change_order_price',	1449573063),
  (60,	'coupon',	'm140816_200000_store_coupon_base',	1449573064),
  (61,	'coupon',	'm150414_124659_add_order_coupon_table',	1449573067),
  (62,	'coupon',	'm150415_153218_rename_fields',	1449573067),
  (63,	'page',	'm000000_000000_page_base',	1449573073),
  (64,	'page',	'm130115_155600_columns_rename',	1449573074),
  (65,	'page',	'm140115_083618_add_layout',	1449573075),
  (66,	'page',	'm140620_072543_add_view',	1449573076),
  (67,	'page',	'm150312_151049_change_body_type',	1449573077),
  (68,	'page',	'm150416_101038_rename_fields',	1449573078),
  (69,	'dictionary',	'm000000_000000_dictionary_base',	1449573086),
  (70,	'dictionary',	'm150415_183050_rename_fields',	1449573087),
  (71,	'callback',	'm150926_083350_callback_base',	1449573091),
  (72,	'queue',	'm000000_000000_queue_base',	1449573092),
  (73,	'queue',	'm131007_031000_queue_fix_index',	1449573093),
  (74,	'rbac',	'm140115_131455_auth_item',	1449573095),
  (75,	'rbac',	'm140115_132045_auth_item_child',	1449573097),
  (76,	'rbac',	'm140115_132319_auth_item_assign',	1449573100),
  (77,	'rbac',	'm140702_230000_initial_role_data',	1449573100),
  (78,	'menu',	'm000000_000000_menu_base',	1449573104),
  (79,	'menu',	'm121220_001126_menu_test_data',	1449573104),
  (80,	'contentblock',	'm000000_000000_contentblock_base',	1449573106),
  (81,	'contentblock',	'm140715_130737_add_category_id',	1449573107),
  (82,	'contentblock',	'm150127_130425_add_status_column',	1449573108),
  (83,	'notify',	'm141031_091039_add_notify_table',	1449573110),
  (84,	'social',	'm000000_000000_social_profile',	1449573112),
  (85,	'feedback',	'm000000_000000_feedback_base',	1449573116),
  (86,	'feedback',	'm150415_184108_rename_fields',	1449573117),
  (87,	'yandexmarket',	'm141110_090000_yandex_market_export_base',	1449573117),
  (88,	'gallery',	'm000000_000000_gallery_base',	1449573121),
  (89,	'gallery',	'm130427_120500_gallery_creation_user',	1449573123),
  (90,	'gallery',	'm150416_074146_rename_fields',	1449573123),
  (91,	'news',	'm000000_000000_news_base',	1449573127),
  (92,	'news',	'm150416_081251_rename_fields',	1449573128),
  (93,	'sitemap',	'm141004_130000_sitemap_page',	1449573129),
  (94,	'sitemap',	'm141004_140000_sitemap_page_data',	1449573129),
  (100,	'store',	'm151218_081635_add_external_id_fields',	1450702133),
  (101,	'store',	'm151218_082939_add_external_id_ix',	1450702133),
  (102,	'store',	'm151218_142113_add_product_index',	1450702133),
  (103,	'store',	'm151223_140722_drop_product_type_categories',	1450943031),
  (104,	'order',	'm000000_000000_base_order',	1450950290),
  (105,	'order',	'm151209_185124_split_address',	1450950291),
  (106,	'order',	'm151211_115447_add_appartment_field',	1450950291);

DROP TABLE IF EXISTS `yupe_news_news`;
CREATE TABLE `yupe_news_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `date` date NOT NULL,
  `title` varchar(250) NOT NULL,
  `slug` varchar(150) NOT NULL,
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
  UNIQUE KEY `ux_yupe_news_news_alias_lang` (`slug`,`lang`),
  KEY `ix_yupe_news_news_status` (`status`),
  KEY `ix_yupe_news_news_user_id` (`user_id`),
  KEY `ix_yupe_news_news_category_id` (`category_id`),
  KEY `ix_yupe_news_news_date` (`date`),
  CONSTRAINT `fk_yupe_news_news_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_news_news_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_news_news` (`id`, `category_id`, `lang`, `create_time`, `update_time`, `date`, `title`, `slug`, `short_text`, `full_text`, `image`, `link`, `user_id`, `status`, `is_protected`, `keywords`, `description`) VALUES
  (1,	NULL,	'ru',	'2013-09-26 19:17:56',	'2013-09-26 19:17:56',	'2013-09-26',	'Первая опубликованная новость',	'pervaja-opublikovannaja-novost',	'<p>\r\n	Первая опубликованная короткий новость\r\n</p>',	'<p>\r\n	Первая опубликованная текст\r\n</p>',	NULL,	'',	1,	1,	0,	'Первая опубликованная новость',	'Первая опубликованная новость'),
  (2,	NULL,	'ru',	'2013-09-26 19:18:45',	'2013-09-26 19:18:45',	'2013-09-26',	'Вторая не опубликованная новость',	'vtoraja-ne-opublikovannaja-novost',	'<p>\r\n	Вторая не опубликованная новость короткий текст\r\n</p>',	'<p>\r\n	Вторая не опубликованная новость текст\r\n</p>',	NULL,	'',	1,	0,	0,	'Вторая не опубликованная новость',	'Вторая не опубликованная новость'),
  (3,	NULL,	'ru',	'2013-09-26 19:20:04',	'2013-09-26 19:20:04',	'2013-09-26',	'Третья новость только для авторизованных',	'tretja-novost-tolko-dlja-avtorizovannyh',	'<p>\r\n	Третья новость только для авторизованных текст\r\n</p>',	'<p>\r\n	Третья новость только для авторизованных текст\r\n</p>',	NULL,	'',	1,	1,	1,	'Третья новость только для авторизованных текст',	'Третья новость только для авторизованных текст');

DROP TABLE IF EXISTS `yupe_notify_settings`;
CREATE TABLE `yupe_notify_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `my_post` tinyint(1) NOT NULL DEFAULT '1',
  `my_comment` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_notify_settings_user_id` (`user_id`),
  CONSTRAINT `fk_yupe_notify_settings_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_page_page`;
CREATE TABLE `yupe_page_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `lang` char(2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `change_user_id` int(11) DEFAULT NULL,
  `title_short` varchar(150) NOT NULL,
  `title` varchar(250) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `body` mediumtext NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `status` int(11) NOT NULL,
  `is_protected` tinyint(1) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0',
  `layout` varchar(250) DEFAULT NULL,
  `view` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_page_page_slug_lang` (`slug`,`lang`),
  KEY `ix_yupe_page_page_status` (`status`),
  KEY `ix_yupe_page_page_is_protected` (`is_protected`),
  KEY `ix_yupe_page_page_user_id` (`user_id`),
  KEY `ix_yupe_page_page_change_user_id` (`change_user_id`),
  KEY `ix_yupe_page_page_menu_order` (`order`),
  KEY `ix_yupe_page_page_category_id` (`category_id`),
  CONSTRAINT `fk_yupe_page_page_category_id` FOREIGN KEY (`category_id`) REFERENCES `yupe_category_category` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_page_page_change_user_id` FOREIGN KEY (`change_user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  CONSTRAINT `fk_yupe_page_page_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_page_page` (`id`, `category_id`, `lang`, `parent_id`, `create_time`, `update_time`, `user_id`, `change_user_id`, `title_short`, `title`, `slug`, `body`, `keywords`, `description`, `status`, `is_protected`, `order`, `layout`, `view`) VALUES
  (1,	NULL,	'ru',	NULL,	'2013-09-19 19:38:33',	'2013-09-19 19:38:33',	1,	1,	'Опубликованная страница',	'Опубликованная страница',	'opublikovannaja-starnica',	'<p>\r\n	Опубликованная страница текст\r\n</p>',	'сео слова',	'сео описание',	1,	0,	0,	NULL,	NULL),
  (2,	NULL,	'ru',	NULL,	'2013-09-19 19:47:43',	'2013-09-19 19:47:43',	1,	1,	'Скрытая страница',	'Скрытая страница',	'skrytaja-stranica',	'<p>\r\n	Скрытая страница текст\r\n</p>',	'',	'',	0,	0,	0,	NULL,	NULL),
  (3,	NULL,	'ru',	NULL,	'2013-09-19 19:55:47',	'2013-09-19 19:55:47',	1,	1,	'Защищенная страница',	'Защищенная страница',	'zaschischennaja-stranica',	'<p>\r\n	Защищенная страница текст\r\n</p>',	'',	'',	1,	1,	0,	NULL,	NULL);

DROP TABLE IF EXISTS `yupe_queue_queue`;
CREATE TABLE `yupe_queue_queue` (
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
  KEY `ux_yupe_queue_queue_worker` (`worker`),
  KEY `ux_yupe_queue_queue_priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_sitemap_page`;
CREATE TABLE `yupe_sitemap_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(250) NOT NULL,
  `changefreq` varchar(20) NOT NULL,
  `priority` float NOT NULL DEFAULT '0.5',
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_sitemap_page_url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_social_user`;
CREATE TABLE `yupe_social_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `provider` varchar(250) NOT NULL,
  `uid` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_social_user_uid` (`uid`),
  KEY `ix_yupe_social_user_provider` (`provider`),
  KEY `fk_yupe_social_user_user_id` (`user_id`),
  CONSTRAINT `fk_yupe_social_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_attribute`;
CREATE TABLE `yupe_store_attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_attribute_name_group` (`name`,`group_id`),
  KEY `ix_yupe_store_attribute_title` (`title`),
  KEY `fk_yupe_store_attribute_group` (`group_id`),
  CONSTRAINT `fk_yupe_store_attribute_group` FOREIGN KEY (`group_id`) REFERENCES `yupe_store_attribute_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_attribute_group`;
CREATE TABLE `yupe_store_attribute_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_attribute_option`;
CREATE TABLE `yupe_store_attribute_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `position` tinyint(4) DEFAULT NULL,
  `value` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_store_attribute_option_attribute_id` (`attribute_id`),
  KEY `ix_yupe_store_attribute_option_position` (`position`),
  CONSTRAINT `fk_yupe_store_attribute_option_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `yupe_store_attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_category`;
CREATE TABLE `yupe_store_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(150) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `short_description` text,
  `description` text,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '1',
  `external_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_category_alias` (`slug`),
  KEY `ix_yupe_store_category_parent_id` (`parent_id`),
  KEY `ix_yupe_store_category_status` (`status`),
  KEY `yupe_store_category_external_id_ix` (`external_id`),
  CONSTRAINT `fk_yupe_store_category_parent` FOREIGN KEY (`parent_id`) REFERENCES `yupe_store_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_coupon`;
CREATE TABLE `yupe_store_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(255) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `value` decimal(10,2) NOT NULL DEFAULT '0.00',
  `min_order_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `registered_user` tinyint(4) NOT NULL DEFAULT '0',
  `free_shipping` tinyint(4) NOT NULL DEFAULT '0',
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `quantity_per_user` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_delivery`;
CREATE TABLE `yupe_store_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `free_from` float(10,2) DEFAULT NULL,
  `available_from` float(10,2) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `separate_payment` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_yupe_store_delivery_position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_delivery_payment`;
CREATE TABLE `yupe_store_delivery_payment` (
  `delivery_id` int(11) NOT NULL,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`delivery_id`,`payment_id`),
  KEY `fk_yupe_store_delivery_payment_payment` (`payment_id`),
  CONSTRAINT `fk_yupe_store_delivery_payment_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `yupe_store_delivery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_delivery_payment_payment` FOREIGN KEY (`payment_id`) REFERENCES `yupe_store_payment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_order`;
CREATE TABLE `yupe_store_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) DEFAULT NULL,
  `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method_id` int(11) DEFAULT NULL,
  `paid` tinyint(4) DEFAULT '0',
  `payment_time` datetime DEFAULT NULL,
  `payment_details` text,
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `separate_delivery` tinyint(4) DEFAULT '0',
  `status_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `comment` varchar(1024) NOT NULL DEFAULT '',
  `ip` varchar(15) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `note` varchar(1024) NOT NULL DEFAULT '',
  `modified` datetime DEFAULT NULL,
  `zipcode` varchar(30) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `house` varchar(50) DEFAULT NULL,
  `apartment` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `udx_yupe_store_order_url` (`url`),
  KEY `idx_yupe_store_order_user_id` (`user_id`),
  KEY `idx_yupe_store_order_date` (`date`),
  KEY `idx_yupe_store_order_status` (`status_id`),
  KEY `idx_yupe_store_order_paid` (`paid`),
  KEY `fk_yupe_store_order_delivery` (`delivery_id`),
  KEY `fk_yupe_store_order_payment` (`payment_method_id`),
  CONSTRAINT `fk_yupe_store_order_delivery` FOREIGN KEY (`delivery_id`) REFERENCES `yupe_store_delivery` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_order_payment` FOREIGN KEY (`payment_method_id`) REFERENCES `yupe_store_payment` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_order_status` FOREIGN KEY (`status_id`) REFERENCES `yupe_store_order_status` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_order_user` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_order_coupon`;
CREATE TABLE `yupe_store_order_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_yupe_store_order_coupon_order` (`order_id`),
  KEY `fk_yupe_store_order_coupon_coupon` (`coupon_id`),
  CONSTRAINT `fk_yupe_store_order_coupon_coupon` FOREIGN KEY (`coupon_id`) REFERENCES `yupe_store_coupon` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_yupe_store_order_coupon_order` FOREIGN KEY (`order_id`) REFERENCES `yupe_store_order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_order_product`;
CREATE TABLE `yupe_store_order_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `variants` text,
  `variants_text` varchar(1024) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `sku` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_yupe_store_order_product_order_id` (`order_id`),
  KEY `idx_yupe_store_order_product_product_id` (`product_id`),
  CONSTRAINT `fk_yupe_store_order_product_order` FOREIGN KEY (`order_id`) REFERENCES `yupe_store_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_order_product_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_order_status`;
CREATE TABLE `yupe_store_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_payment`;
CREATE TABLE `yupe_store_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `settings` text,
  `currency_id` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_yupe_store_payment_position` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_producer`;
CREATE TABLE `yupe_store_producer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_short` varchar(150) NOT NULL,
  `name` varchar(250) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `image` varchar(250) DEFAULT NULL,
  `short_description` text,
  `description` text,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `ix_yupe_store_producer_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product`;
CREATE TABLE `yupe_store_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `price` decimal(19,3) NOT NULL DEFAULT '0.000',
  `discount_price` decimal(19,3) DEFAULT NULL,
  `discount` decimal(19,3) DEFAULT NULL,
  `description` text,
  `short_description` text,
  `data` text,
  `is_special` tinyint(1) NOT NULL DEFAULT '0',
  `length` decimal(19,3) DEFAULT NULL,
  `width` decimal(19,3) DEFAULT NULL,
  `height` decimal(19,3) DEFAULT NULL,
  `weight` decimal(19,3) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `in_stock` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `meta_title` varchar(250) DEFAULT NULL,
  `meta_keywords` varchar(250) DEFAULT NULL,
  `meta_description` varchar(250) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `average_price` decimal(19,3) DEFAULT NULL,
  `purchase_price` decimal(19,3) DEFAULT NULL,
  `recommended_price` decimal(19,3) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  `external_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_product_alias` (`slug`),
  KEY `ix_yupe_store_product_status` (`status`),
  KEY `ix_yupe_store_product_type_id` (`type_id`),
  KEY `ix_yupe_store_product_producer_id` (`producer_id`),
  KEY `ix_yupe_store_product_price` (`price`),
  KEY `ix_yupe_store_product_discount_price` (`discount_price`),
  KEY `ix_yupe_store_product_create_time` (`create_time`),
  KEY `ix_yupe_store_product_update_time` (`update_time`),
  KEY `fk_yupe_store_product_category` (`category_id`),
  KEY `yupe_store_product_external_id_ix` (`external_id`),
  KEY `ix_yupe_store_product_sku` (`sku`),
  KEY `ix_yupe_store_product_name` (`name`),
  CONSTRAINT `fk_yupe_store_product_category` FOREIGN KEY (`category_id`) REFERENCES `yupe_store_category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_producer` FOREIGN KEY (`producer_id`) REFERENCES `yupe_store_producer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_type` FOREIGN KEY (`type_id`) REFERENCES `yupe_store_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_attribute_value`;
CREATE TABLE `yupe_store_product_attribute_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `number_value` double DEFAULT NULL,
  `string_value` varchar(250) DEFAULT NULL,
  `text_value` text,
  `option_value` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `yupe_fk_product_attribute_product` (`product_id`),
  KEY `yupe_fk_product_attribute_attribute` (`attribute_id`),
  KEY `yupe_fk_product_attribute_option` (`option_value`),
  KEY `yupe_ix_product_attribute_number_value` (`number_value`),
  KEY `yupe_ix_product_attribute_string_value` (`string_value`),
  CONSTRAINT `yupe_fk_product_attribute_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `yupe_store_attribute` (`id`) ON DELETE CASCADE,
  CONSTRAINT `yupe_fk_product_attribute_option` FOREIGN KEY (`option_value`) REFERENCES `yupe_store_attribute_option` (`id`) ON DELETE CASCADE,
  CONSTRAINT `yupe_fk_product_attribute_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_category`;
CREATE TABLE `yupe_store_product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_store_product_category_product_id` (`product_id`),
  KEY `ix_yupe_store_product_category_category_id` (`category_id`),
  CONSTRAINT `fk_yupe_store_product_category_category` FOREIGN KEY (`category_id`) REFERENCES `yupe_store_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_category_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_image`;
CREATE TABLE `yupe_store_product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_yupe_store_product_image_product` (`product_id`),
  CONSTRAINT `fk_yupe_store_product_image_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_link`;
CREATE TABLE `yupe_store_product_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `linked_product_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_product_link_product` (`product_id`,`linked_product_id`),
  KEY `fk_yupe_store_product_link_linked_product` (`linked_product_id`),
  KEY `fk_yupe_store_product_link_type` (`type_id`),
  CONSTRAINT `fk_yupe_store_product_link_linked_product` FOREIGN KEY (`linked_product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_link_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_link_type` FOREIGN KEY (`type_id`) REFERENCES `yupe_store_product_link_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_link_type`;
CREATE TABLE `yupe_store_product_link_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_product_link_type_code` (`code`),
  UNIQUE KEY `ux_yupe_store_product_link_type_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_product_variant`;
CREATE TABLE `yupe_store_product_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `attribute_value` varchar(255) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `type` tinyint(4) NOT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_yupe_store_product_variant_product` (`product_id`),
  KEY `idx_yupe_store_product_variant_attribute` (`attribute_id`),
  KEY `idx_yupe_store_product_variant_value` (`attribute_value`),
  CONSTRAINT `fk_yupe_store_product_variant_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `yupe_store_attribute` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_store_product_variant_product` FOREIGN KEY (`product_id`) REFERENCES `yupe_store_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_type`;
CREATE TABLE `yupe_store_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_store_type_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_store_type_attribute`;
CREATE TABLE `yupe_store_type_attribute` (
  `type_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  PRIMARY KEY (`type_id`,`attribute_id`),
  CONSTRAINT `fk_yupe_store_type_attribute_type` FOREIGN KEY (`type_id`) REFERENCES `yupe_store_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_user_tokens`;
CREATE TABLE `yupe_user_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `expire_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ix_yupe_user_tokens_user_id` (`user_id`),
  CONSTRAINT `fk_yupe_user_tokens_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_user_tokens` (`id`, `user_id`, `token`, `type`, `status`, `create_time`, `update_time`, `ip`, `expire_time`) VALUES
  (1,	1,	'ef5145bedaca7f17957350d817fd9807',	1,	1,	'2013-11-05 20:02:30',	'2013-11-05 20:02:31',	'127.0.0.1',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `yupe_user_user`;
CREATE TABLE `yupe_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `update_time` datetime NOT NULL,
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
  `status` int(11) NOT NULL DEFAULT '2',
  `access_level` int(11) NOT NULL DEFAULT '0',
  `visit_time` datetime DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `hash` varchar(255) NOT NULL DEFAULT '476f7eefe7a02b04c12ed886d3c98a6c0.66696900 1449572909',
  `email_confirm` tinyint(1) NOT NULL DEFAULT '0',
  `phone` char(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_user_user_nick_name` (`nick_name`),
  UNIQUE KEY `ux_yupe_user_user_email` (`email`),
  KEY `ix_yupe_user_user_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_user_user` (`id`, `update_time`, `first_name`, `middle_name`, `last_name`, `nick_name`, `email`, `gender`, `birth_date`, `site`, `about`, `location`, `status`, `access_level`, `visit_time`, `create_time`, `avatar`, `hash`, `email_confirm`, `phone`) VALUES
  (1,	'2013-11-05 20:02:30',	'',	'',	'',	'yupe',	'yupe@yupe.local',	0,	NULL,	'',	'',	'',	1,	1,	'2015-12-27 10:36:10',	'2013-11-05 20:02:30',	NULL,	'$2a$13$kV7qdBBM3MPYW.6LAKeiv.iIAMDa4BZFhwzjMWhCm78UmDT8wDH7G',	1,	NULL);

DROP TABLE IF EXISTS `yupe_user_user_auth_assignment`;
CREATE TABLE `yupe_user_user_auth_assignment` (
  `itemname` char(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `fk_yupe_user_user_auth_assignment_user` (`userid`),
  CONSTRAINT `fk_yupe_user_user_auth_assignment_item` FOREIGN KEY (`itemname`) REFERENCES `yupe_user_user_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_user_user_auth_assignment_user` FOREIGN KEY (`userid`) REFERENCES `yupe_user_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_user_user_auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
  ('admin',	1,	NULL,	NULL);

DROP TABLE IF EXISTS `yupe_user_user_auth_item`;
CREATE TABLE `yupe_user_user_auth_item` (
  `name` char(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`),
  KEY `ix_yupe_user_user_auth_item_type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_user_user_auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
  ('admin',	2,	'Администратор',	NULL,	NULL);

DROP TABLE IF EXISTS `yupe_user_user_auth_item_child`;
CREATE TABLE `yupe_user_user_auth_item_child` (
  `parent` char(64) NOT NULL,
  `child` char(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `fk_yupe_user_user_auth_item_child_child` (`child`),
  CONSTRAINT `fk_yupe_user_user_auth_item_child_child` FOREIGN KEY (`child`) REFERENCES `yupe_user_user_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_yupe_user_user_auth_itemchild_parent` FOREIGN KEY (`parent`) REFERENCES `yupe_user_user_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_yandex_market_export`;
CREATE TABLE `yupe_yandex_market_export` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `settings` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `yupe_yupe_settings`;
CREATE TABLE `yupe_yupe_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` varchar(100) NOT NULL,
  `param_name` varchar(100) NOT NULL,
  `param_value` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_yupe_yupe_settings_module_id_param_name_user_id` (`module_id`,`param_name`,`user_id`),
  KEY `ix_yupe_yupe_settings_module_id` (`module_id`),
  KEY `ix_yupe_yupe_settings_param_name` (`param_name`),
  KEY `fk_yupe_yupe_settings_user_id` (`user_id`),
  CONSTRAINT `fk_yupe_yupe_settings_user_id` FOREIGN KEY (`user_id`) REFERENCES `yupe_user_user` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `yupe_yupe_settings` (`id`, `module_id`, `param_name`, `param_value`, `create_time`, `update_time`, `user_id`, `type`) VALUES
  (1,	'yupe',	'siteDescription',	'Юпи! - самый простой способ создать сайт на Yii!',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (2,	'yupe',	'siteName',	'Юпи! Магазин бытовой техники',	'2015-12-08 14:12:28',	'2015-12-13 11:26:44',	1,	1),
  (3,	'yupe',	'siteKeyWords',	'Юпи!, yupe, цмс, yii',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (4,	'yupe',	'email',	'root@mail.ru',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (5,	'yupe',	'theme',	'default',	'2015-12-08 14:12:28',	'2015-12-23 13:16:17',	1,	1),
  (6,	'yupe',	'backendTheme',	'',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (7,	'yupe',	'defaultLanguage',	'ru',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (8,	'yupe',	'defaultBackendLanguage',	'ru',	'2015-12-08 14:12:28',	'2015-12-08 14:12:28',	1,	1),
  (9,	'yupe',	'coreCacheTime',	'3600',	'2015-12-13 11:26:44',	'2015-12-13 11:26:44',	1,	1),
  (10,	'yupe',	'uploadPath',	'uploads',	'2015-12-13 11:26:44',	'2015-12-13 11:26:44',	1,	1),
  (11,	'yupe',	'editor',	'redactor',	'2015-12-13 11:26:44',	'2015-12-13 11:26:44',	1,	1),
  (12,	'yupe',	'availableLanguages',	'ru,en,zh_cn',	'2015-12-13 11:26:44',	'2015-12-13 11:26:44',	1,	1),
  (13,	'yupe',	'allowedIp',	'',	'2015-12-13 11:26:44',	'2015-12-13 11:26:44',	1,	1),
  (14,	'yupe',	'hidePanelUrls',	'0',	'2015-12-13 11:26:45',	'2015-12-13 11:26:45',	1,	1),
  (15,	'yupe',	'logo',	'images/logo.png',	'2015-12-13 11:26:45',	'2015-12-13 11:26:45',	1,	1),
  (16,	'yupe',	'allowedExtensions',	'gif, jpeg, png, jpg, zip, rar',	'2015-12-13 11:26:45',	'2015-12-13 11:26:45',	1,	1),
  (17,	'yupe',	'mimeTypes',	'image/gif, image/jpeg, image/png, application/zip, application/rar',	'2015-12-13 11:26:45',	'2015-12-13 11:26:45',	1,	1),
  (18,	'yupe',	'maxSize',	'5242880',	'2015-12-13 11:26:45',	'2015-12-13 11:26:45',	1,	1),
  (19,	'store',	'uploadPath',	'store',	'2015-12-13 11:34:51',	'2015-12-13 11:34:51',	1,	1),
  (20,	'store',	'editor',	'redactor',	'2015-12-13 11:34:51',	'2015-12-13 11:34:51',	1,	1),
  (21,	'store',	'itemsPerPage',	'21',	'2015-12-13 11:34:51',	'2015-12-18 16:39:22',	1,	1),
  (22,	'store',	'phone',	'02',	'2015-12-13 11:34:51',	'2015-12-13 11:34:51',	1,	1),
  (23,	'store',	'email',	'02@02.ru',	'2015-12-13 11:34:51',	'2015-12-13 11:34:51',	1,	1),
  (24,	'homepage',	'mode',	'3',	'2015-12-13 11:38:42',	'2015-12-13 11:38:42',	1,	1),
  (25,	'homepage',	'target',	'',	'2015-12-13 11:38:43',	'2015-12-13 11:38:43',	1,	1),
  (26,	'homepage',	'limit',	'',	'2015-12-13 11:38:43',	'2015-12-13 11:38:43',	1,	1),
  (27,	'store',	'currency',	'RUB',	'2015-12-13 12:36:42',	'2015-12-20 16:01:25',	1,	1),
  (28,	'product',	'pageSize',	'15',	'2015-12-18 10:54:51',	'2015-12-18 10:54:51',	1,	2),
  (29,	'producer',	'pageSize',	'20',	'2015-12-18 14:10:21',	'2015-12-18 14:10:21',	1,	2),
  (30,	'user',	'avatarMaxSize',	'5242880',	'2015-12-22 11:59:43',	'2015-12-22 11:59:43',	1,	1),
  (31,	'user',	'avatarExtensions',	'jpg,png,gif,jpeg',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (32,	'user',	'defaultAvatarPath',	'images/avatar.png',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (33,	'user',	'avatarsDir',	'avatars',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (34,	'user',	'showCaptcha',	'0',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (35,	'user',	'minCaptchaLength',	'3',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (36,	'user',	'maxCaptchaLength',	'6',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (37,	'user',	'minPasswordLength',	'8',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (38,	'user',	'autoRecoveryPassword',	'0',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (39,	'user',	'recoveryDisabled',	'0',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (40,	'user',	'registrationDisabled',	'0',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (41,	'user',	'notifyEmailFrom',	'test@test.ru',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (42,	'user',	'logoutSuccess',	'/',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (43,	'user',	'loginSuccess',	'/',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (44,	'user',	'accountActivationSuccess',	'/user/account/login',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (45,	'user',	'accountActivationFailure',	'/user/account/registration',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (46,	'user',	'loginAdminSuccess',	'/yupe/backend/index',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (47,	'user',	'registrationSuccess',	'/user/account/login',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (48,	'user',	'sessionLifeTime',	'7',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (49,	'user',	'usersPerPage',	'20',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (50,	'user',	'emailAccountVerification',	'1',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (51,	'user',	'badLoginCount',	'3',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (52,	'user',	'phoneMask',	'+7-999-999-9999',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (53,	'user',	'phonePattern',	'/^((\\+?7)(-?\\d{3})-?)?(\\d{3})(-?\\d{4})$/',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (54,	'user',	'generateNickName',	'0',	'2015-12-22 11:59:44',	'2015-12-22 11:59:44',	1,	1),
  (55, 'comment', 'allowGuestComment', '0', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (56, 'comment', 'defaultCommentStatus', '0', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (57, 'comment', 'autoApprove', '1', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (58, 'comment', 'notify', '1', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (59, 'comment', 'email', 'root@mail.ru', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (60, 'comment', 'showCaptcha', '1', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (61, 'comment', 'minCaptchaLength', '3', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (62, 'comment', 'maxCaptchaLength', '6', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (63, 'comment', 'rssCount', '10', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (64, 'comment', 'allowedTags', 'p,br,strong,img[src|style],a[href]', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (65, 'comment', 'antiSpamInterval', '10', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (66, 'comment', 'stripTags', '1', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (67, 'comment', 'editor', 'textarea', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1),
  (68, 'comment', 'modelsAvailableForRss', '', '2015-12-28 21:00:49', '2015-12-28 21:00:49', 1, 1);

