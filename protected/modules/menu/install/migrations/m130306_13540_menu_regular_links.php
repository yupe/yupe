<?php
/**
 * File Doc Comment
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130306_123540_menu_regular_links extends YDbMigration
{

    public function safeUp()
    {
        $this->addColumn('{{menu_menu_item}}', 'regular_link', 'boolean');
    }
 

    public function safeDown()
    {
        $this->dropColumn('{{menu_menu_item}}', 'regular_link');
    }
}