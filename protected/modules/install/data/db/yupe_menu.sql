-- Основное меню

INSERT INTO `yupe_menu` (`id`, `name`, `code`, `description`, `status`) VALUES
(1, 'Верхнее меню', 'top-menu', 'Основное меню сайта, расположенное сверху в блоке mainmenu.', 1);

-- Пункты основного меню
INSERT INTO `yupe_menu_item` (`id`, `parent_id`, `menu_id`, `title`, `href`, `class`, `title_attr`, `before_link`, `after_link`, `target`, `rel`, `condition_name`, `condition_denial`, `sort`, `status`) VALUES
(1, 0, 1, 'Главная', '/site/index', '', 'Главная страница сайта', '', '', '', '', '', 0, 1, 1),
(2, 0, 1, 'Блоги', '/blog/blog/index/', '', 'Блоги', '', '', '', '', '', 0, 2, 1),
(3, 0, 1, 'О проекте', '/site/page?view=about', '', 'О проекте', '', '', '', '', '', 0, 3, 1),
(4, 0, 1, 'Пользователи', '/user/people/index/', '', 'Пользователи', '', '', '', '', '', 0, 4, 1),
(5, 0, 1, 'Социальные виджеты', '/site/social/', '', 'Социальные виджеты', '', '', '', '', '', 0, 5, 0),
(6, 0, 1, 'Помощь проекту', '/site/page?view=help', '', 'Помощь проекту', '', '', '', '', '', 0, 6, 1),
(7, 0, 1, 'Контакты', '/feedback/contact/', '', 'Контакты', '', '', '', '', '', 0, 7, 1),
(8, 0, 1, 'Wiki', '/wiki/default/index/', '', 'Wiki', '', '', '', '', '', 0, 8, 0),
(9, 0, 1, 'Войти', '/user/account/login', '', 'Войти на сайт', '', '', '', '', 'isAuthenticated', 1, 9, 1),
(10, 0, 1, 'Выйти', '/user/account/logout', '', 'Выйти', '', '', '', '', 'isAuthenticated', 0, 10, 1),
(11, 0, 1, 'Регистрация', '/user/account/registration', '', 'Регистрация на сайте', '', '', '', '', 'isAuthenticated', 1, 11, 1),
(12, 0, 1, 'Панель управления', '/yupe/backend/', '', 'Панель управления сайтом', '', '', '', '', 'isSuperUser', 0, 12, 1),
(14, 0, 1, 'FAQ', '/feedback/contact/faq/', '', 'FAQ', '', '', '', '', '', 0, 13, 1);