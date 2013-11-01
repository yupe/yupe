<?php
/**
 * File Doc Comment
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  yupe.modules.menu.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m121220_001126_menu_test_data extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->insert(
            '{{menu_menu}}',
            array(
                'id'          => 1,
                'name'        => 'Верхнее меню',
                'code'        => 'top-menu',
                'description' => Yii::t('MenuModule.menu', 'Main site menu. Located at top in "main menu" block.'),
                'status'      => 1
            )
        );

        $items = array(
            array('parent_id', 'menu_id', 'title', 'href', 'class', 'title_attr', 'before_link', 'after_link', 'target', 'rel', 'condition_name', 'condition_denial', 'sort', 'status'),
            array(0, 1, 'Главная', '/site/index', '', 'Главная страница сайта', '', '', '', '', '', 0, 1, 1),
            array(0, 1, 'Блоги', '/blog/blog/index', '', 'Блоги', '', '', '', '', '', 0, 2, 1),
            array(2, 1, 'Пользователи', '/user/people/index', '', 'Пользователи', '', '', '', '', '', 0, 3, 1),
            array(0, 1, 'Wiki', '/wiki/default/index', '', 'Wiki', '', '', '', '', '', 0, 9, 0),
            array(0, 1, 'Войти', '/login', 'login-text', 'Войти на сайт', '', '', '', '', 'isAuthenticated', 1, 11, 1),
            array(0, 1, 'Выйти', '/logout', 'login-text', 'Выйти', '', '', '', '', 'isAuthenticated', 0, 12, 1),
            array(0, 1, 'Регистрация', '/registration', 'login-text', 'Регистрация на сайте', '', '', '', '', 'isAuthenticated', 1, 10, 1),
            array(0, 1, 'Панель управления', '/yupe/backend/index', 'login-text', 'Панель управления сайтом', '', '', '', '', 'isSuperUser', 0, 13, 1),
            array(0, 1, 'FAQ', '/faq', '', 'FAQ', '', '', '', '', '', 0, 7, 1),
            array(0, 1, 'Контакты', '/contacts', '', 'Контакты', '', '', '', '', '', 0, 7, 1),
        ) ;

        $columns = array_shift($items);
        /**
         * Как нибудь описать процесс надо, для большей понятности
         */
        foreach ($items as $i) {
            $item = array();
            $n    = 0;

            foreach ($columns as $c)
                $item[$c] = $i[$n++];
            $this->insert(
                '{{menu_menu_item}}',
                $item
            );
        }
    }
}