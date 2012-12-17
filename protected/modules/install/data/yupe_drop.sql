--
-- Выключаем проверку внешних ключей
--
SET foreign_key_checks = 0;

--
-- Удаление таблиц БД
--
DROP TABLE IF EXISTS
    `yupe_comment`,
    `yupe_content_block`,
    `yupe_dictionary_data`,
    `yupe_dictionary_group`,
    `yupe_feedback`,
    `yupe_good`,
    `yupe_image`,
    `yupe_image_to_gallery`,
    `yupe_login`,
    `yupe_mail_template`,
    `yupe_menu_item`,
    `yupe_news`,
    `yupe_page`,
    `yupe_post_to_tag`,
    `yupe_queue`,
    `yupe_recovery_password`,
    `yupe_settings`,
    `yupe_tag`,
    `yupe_user_to_blog`,
    `yupe_vote`,
    `yupe_wiki_link`,
    `yupe_wiki_page_revision`,

    `yupe_category`,
    `yupe_gallery`,
    `yupe_mail_event`,
    `yupe_menu`,
    `yupe_post`,
    `yupe_wiki_page`,

    `yupe_blog`,
    `yupe_user`;

--
-- Включаем проверку внешних ключей
--
SET foreign_key_checks = 1;