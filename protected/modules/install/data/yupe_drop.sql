--
-- Удаление внешних ключей таблиц
--

--
-- Удаление внешних ключей таблицы `blog`
--
ALTER TABLE `yupe_blog`
  DROP FOREIGN KEY `blog_ibfk_1`,
  DROP FOREIGN KEY `blog_ibfk_2`;

--
-- Удаление внешних ключей таблицы `dictionary_data`
--
ALTER TABLE `yupe_dictionary_data`
  DROP FOREIGN KEY `dictionary_data_ibfk_1`,
  DROP FOREIGN KEY `dictionary_data_ibfk_8`,
  DROP FOREIGN KEY `dictionary_data_ibfk_9`;

--
-- Удаление внешних ключей таблицы `dictionary_group`
--
ALTER TABLE `yupe_dictionary_group`
  DROP FOREIGN KEY `dictionary_group_ibfk_3`,
  DROP FOREIGN KEY `dictionary_group_ibfk_4`;

--
-- Удаление внешних ключей таблицы `feedback`
--
ALTER TABLE `yupe_feedback`
  DROP FOREIGN KEY `feedback_ibfk_1`;

--
-- Удаление внешних ключей таблицы `good`
--
ALTER TABLE `yupe_good`
  DROP FOREIGN KEY `good_ibfk_6`,
  DROP FOREIGN KEY `good_ibfk_7`,
  DROP FOREIGN KEY `good_ibfk_8`;

--
-- Удаление внешних ключей таблицы `image`
--
ALTER TABLE `yupe_image`
  DROP FOREIGN KEY `image_ibfk_2`,
  DROP FOREIGN KEY `image_ibfk_1`;

--
-- Удаление внешних ключей таблицы `image_to_gallery`
--
ALTER TABLE `yupe_image_to_gallery`
  DROP FOREIGN KEY `image_to_gallery_ibfk_2`;

--
-- Удаление внешних ключей таблицы `login`
--
ALTER TABLE `yupe_login`
  DROP FOREIGN KEY `login_ibfk_1`;

--
-- Удаление внешних ключей таблицы `mail_template`
--
ALTER TABLE `yupe_mail_template`
  DROP FOREIGN KEY `mail_template_ibfk_1`;

--
-- Удаление внешних ключей таблицы `menu_item`
--
ALTER TABLE `yupe_menu_item`
  DROP FOREIGN KEY `menu_item_ibfk_1`;

--
-- Удаление внешних ключей таблицы `news`
--
ALTER TABLE `yupe_news`
  DROP FOREIGN KEY `news_ibfk_1`;

--
-- Удаление внешних ключей таблицы `page`
--
ALTER TABLE `yupe_page`
  DROP FOREIGN KEY `page_ibfk_3`,
  DROP FOREIGN KEY `page_ibfk_1`,
  DROP FOREIGN KEY `page_ibfk_2`;

--
-- Удаление внешних ключей таблицы `post`
--
ALTER TABLE `yupe_post`
  DROP FOREIGN KEY `post_ibfk_1`,
  DROP FOREIGN KEY `post_ibfk_2`,
  DROP FOREIGN KEY `post_ibfk_3`;

--
-- Удаление внешних ключей таблицы `post_to_tag`
--
ALTER TABLE `yupe_post_to_tag`
  DROP FOREIGN KEY `post_to_tag_ibfk_1`,
  DROP FOREIGN KEY `post_to_tag_ibfk_2`;

--
-- Удаление внешних ключей таблицы `recovery_password`
--
ALTER TABLE `yupe_recovery_password`
  DROP FOREIGN KEY `fk_RecoveryPassword_User1`;

--
-- Удаление внешних ключей таблицы `user_to_blog`
--
ALTER TABLE `yupe_user_to_blog`
  DROP FOREIGN KEY `user_to_blog_ibfk_1`,
  DROP FOREIGN KEY `user_to_blog_ibfk_2`;

--
-- Удаление внешних ключей таблицы `vote`
--
ALTER TABLE `yupe_vote`
  DROP FOREIGN KEY `vote_ibfk_1`;

--
-- Удаление внешних ключей таблицы `wiki_link`
--
ALTER TABLE `yupe_wiki_link`
  DROP FOREIGN KEY `wiki_fk_link_page_from`,
  DROP FOREIGN KEY `wiki_fk_link_page_to`;

--
-- Удаление внешних ключей таблицы `wiki_page_revision`
--
ALTER TABLE `yupe_wiki_page_revision`
  DROP FOREIGN KEY `wiki_fk_page_revision_page`;

--
-- Удаление таблиц БД
--
DROP TABLE IF EXISTS
    `yupe_blog`,
    `yupe_category`,
    `yupe_comment`,
    `yupe_content_block`,
    `yupe_contest`,
    `yupe_dictionary_data`,
    `yupe_dictionary_group`,
    `yupe_feedback`,
    `yupe_gallery`,
    `yupe_good`,
    `yupe_image`,
    `yupe_image_to_contest`,
    `yupe_image_to_gallery`,
    `yupe_login`,
    `yupe_mail_event`,
    `yupe_mail_template`,
    `yupe_menu`,
    `yupe_menu_item`,
    `yupe_news`,
    `yupe_page`,
    `yupe_post`,
    `yupe_post_to_tag`,
    `yupe_queue`,
    `yupe_recovery_password`,
    `yupe_settings`,
    `yupe_tag`,
    `yupe_user`,
    `yupe_user_to_blog`,
    `yupe_vote`,
    `yupe_wiki_link`,
    `yupe_wiki_page`,
    `yupe_wiki_page_revision`;