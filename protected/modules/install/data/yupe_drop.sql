--
-- Отключение проверки внешних ключей
--
SET foreign_key_checks = 0;

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

--
-- Включение проверки внешних ключей
--
SET foreign_key_checks = 0;