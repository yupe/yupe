<?php
/**
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  yupe.modules.menu.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 **/

use yupe\components\DAO;

class m131017_064101_fix_menu_test_data extends yupe\components\DbMigration
{
    // Пары значений:
    // старое -> новое
    protected $replaces = array(
        '/'             => '/site/index',
        '/contacts'     => '/feedback/contact/index',
        '/login'        => '/user/account/login',
        '/logout'       => '/user/account/logout',
        '/registration' => '/user/account/registration',
        '/faq'          => 'feedback/contact/faq',
    );

    public function safeUp()
    {
        // Проходим по массиву выполняя замены:
        foreach ($this->replaces as $old => $new) {
            DAO::wrapper()
                ->in('{{menu_menu_item}}')
                ->where('href = :link', array(':link' => $old))
                ->update(
                    array(
                        'href' => $new,
                    )
                );
        }
    }

    /**
     * Всё тоже самое что и в накате миграции,
     * только поменяны местами элементы:
     * 
     * @return void
     */
    public function safeDown()
    {
        // Проходим по массиву выполняя замены:
        foreach ($this->replaces as $new => $old) {
            DAO::wrapper()
                ->in('{{menu_menu_item}}')
                ->where('href = :link', array(':link' => $old))
                ->update(
                    array(
                        'href' => $new,
                    )
                );
        }
    }
}