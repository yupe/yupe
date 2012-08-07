--
-- Удаление внешних ключей таблиц
--

--
-- Удаление внешних ключей таблицы `blog`
--
ALTER TABLE `blog`
  DROP FOREIGN KEY `blog_ibfk_1`,
  DROP FOREIGN KEY `blog_ibfk_2`;

--
-- Удаление внешних ключей таблицы `dictionary_data`
--
ALTER TABLE `dictionary_data`
  DROP FOREIGN KEY `dictionary_data_ibfk_1`,
  DROP FOREIGN KEY `dictionary_data_ibfk_8`,
  DROP FOREIGN KEY `dictionary_data_ibfk_9`;

--
-- Удаление внешних ключей таблицы `dictionary_group`
--
ALTER TABLE `dictionary_group`
  DROP FOREIGN KEY `dictionary_group_ibfk_3`,
  DROP FOREIGN KEY `dictionary_group_ibfk_4`;

--
-- Удаление внешних ключей таблицы `feedback`
--
ALTER TABLE `feedback`
  DROP FOREIGN KEY `feedback_ibfk_1`;

--
-- Удаление внешних ключей таблицы `good`
--
ALTER TABLE `good`
  DROP FOREIGN KEY `good_ibfk_6`,
  DROP FOREIGN KEY `good_ibfk_7`,
  DROP FOREIGN KEY `good_ibfk_8`;

--
-- Удаление внешних ключей таблицы `image`
--
ALTER TABLE `image`
  DROP FOREIGN KEY `image_ibfk_1`;

--
-- Удаление внешних ключей таблицы `image_to_gallery`
--
ALTER TABLE `image_to_gallery`
  DROP FOREIGN KEY `image_to_gallery_ibfk_2`;

--
-- Удаление внешних ключей таблицы `login`
--
ALTER TABLE `login`
  DROP FOREIGN KEY `login_ibfk_1`;

--
-- Удаление внешних ключей таблицы `mail_template`
--
ALTER TABLE `mail_template`
  DROP FOREIGN KEY `mail_template_ibfk_1`;

--
-- Удаление внешних ключей таблицы `menu_item`
--
ALTER TABLE `menu_item`
  DROP FOREIGN KEY `menu_item_ibfk_1`;

--
-- Удаление внешних ключей таблицы `news`
--
ALTER TABLE `news`
  DROP FOREIGN KEY `news_ibfk_1`;

--
-- Удаление внешних ключей таблицы `page`
--
ALTER TABLE `page`
  DROP FOREIGN KEY `page_ibfk_5`,
  DROP FOREIGN KEY `page_ibfk_3`,
  DROP FOREIGN KEY `page_ibfk_4`;

--
-- Удаление внешних ключей таблицы `post`
--
ALTER TABLE `post`
  DROP FOREIGN KEY `post_ibfk_1`,
  DROP FOREIGN KEY `post_ibfk_2`,
  DROP FOREIGN KEY `post_ibfk_3`;

--
-- Удаление внешних ключей таблицы `post_to_tag`
--
ALTER TABLE `post_to_tag`
  DROP FOREIGN KEY `post_to_tag_ibfk_1`,
  DROP FOREIGN KEY `post_to_tag_ibfk_2`;

--
-- Удаление внешних ключей таблицы `recovery_password`
--
ALTER TABLE `recovery_password`
  DROP FOREIGN KEY `fk_RecoveryPassword_User1`;

--
-- Удаление внешних ключей таблицы `user_to_blog`
--
ALTER TABLE `user_to_blog`
  DROP FOREIGN KEY `user_to_blog_ibfk_1`,
  DROP FOREIGN KEY `user_to_blog_ibfk_2`;

--
-- Удаление внешних ключей таблицы `vote`
--
ALTER TABLE `vote`
  DROP FOREIGN KEY `vote_ibfk_1`;

--
-- Удаление внешних ключей таблицы `wiki_link`
--
ALTER TABLE `wiki_link`
  DROP FOREIGN KEY `wiki_fk_link_page_from`,
  DROP FOREIGN KEY `wiki_fk_link_page_to`;

--
-- Удаление внешних ключей таблицы `wiki_page_revision`
--
ALTER TABLE `wiki_page_revision`
  DROP FOREIGN KEY `wiki_fk_page_revision_page`;

--
-- Удаление таблиц БД
--
DROP TABLE IF EXISTS
    `blog`,
    `category`,
    `comment`,
    `content_block`,
    `contest`,
    `dictionary_data`,
    `dictionary_group`,
    `feedback`,
    `gallery`,
    `good`,
    `image`,
    `image_to_contest`,
    `image_to_gallery`,
    `login`,
    `mail_event`,
    `mail_template`,
    `menu`,
    `menu_item`,
    `news`,
    `page`,
    `post`,
    `post_to_tag`,
    `queue`,
    `recovery_password`,
    `settings`,
    `tag`,
    `user`,
    `user_to_blog`,
    `vote`,
    `wiki_link`,
    `wiki_page`,
    `wiki_page_revision`;