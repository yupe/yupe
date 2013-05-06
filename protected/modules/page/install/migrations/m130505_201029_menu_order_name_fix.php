<?php
/**
 * FileDocComment
 * Page install migration
 * Класс миграций для модуля Page:
 * revert изменений названий полей, сделанных в прошлую миграцию
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130505_201029_menu_order_name_fix extends YDbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'order', 'menu_order');
    }

    public function safeDown()
    {
        $this->renameColumn('{{page_page}}', 'menu_order', 'order');
    }
}