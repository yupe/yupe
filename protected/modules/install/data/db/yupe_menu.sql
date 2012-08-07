-- Основное меню

INSERT INTO `menu` (`id`, `name`, `code`, `description`, `status`) VALUES
(1, 'Верхнее меню', 'top-menu', 'Основное меню сайта, расположенное сверху в блоке mainmenu.', 1);

-- Пункты основного меню

INSERT INTO `menu_item` (`id`, `parent_id`, `menu_id`, `title`, `href`, `condition_name`, `condition_denial`, `sort`, `status`) VALUES
(1, 0, 1, 'Главная', '/site', '', 0, 1, 1),
(2, 0, 1, 'Блоги', '/blog/blog/index/', '', 0, 2, 1),
(3, 0, 1, 'О проекте', '/site/page/view/about/', '', 0, 3, 1),
(4, 0, 1, 'Пользователи', '/user/people/index/', '', 0, 4, 1),
(5, 0, 1, 'Социальные виджеты', '/site/social/', '', 0, 5, 0),
(6, 0, 1, 'Помощь проекту', '/site/page/view/help/', '', 0, 6, 1),
(7, 0, 1, 'Контакты', '/feedback/contact/', '', 0, 7, 1),
(8, 0, 1, 'Wiki', '/wiki/default/index/', '', 0, 8, 0),
(9, 0, 1, 'Войти', '/login/', 'isAuthenticated', 1, 9, 1),
(10, 0, 1, 'Выйти', '/logout/', 'isAuthenticated', 0, 10, 1),
(11, 0, 1, 'Регистрация', '/registration/', 'isAuthenticated', 1, 11, 1),
(12, 0, 1, 'Панель управления', '/yupe/backend/', 'isSuperUser', 0, 12, 1),
(14, 0, 1, 'FAQ', '/feedback/contact/faq/', '', 0, 13, 1);