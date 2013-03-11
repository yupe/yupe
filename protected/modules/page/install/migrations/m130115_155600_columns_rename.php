<?php
/**
 * FileDocComment
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m130115_155600_columns_rename extends YDbMigration
{

    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'menu_order', 'order');
        $this->renameColumn('{{page_page}}', 'name', 'title_short');
    }


    public function safeDown()
    {
        // не претендует на 100% failsafe вариант, но и авторский тоже не 100% failsafe
        // я решил реализовать миграцию по принципу KISS, в случае ошибки down откатиться назад
        $this->renameColumn('{{page_page}}', 'order', 'menu_order');
        $this->renameColumn('{{page_page}}', 'title_short', 'name');
    }
}