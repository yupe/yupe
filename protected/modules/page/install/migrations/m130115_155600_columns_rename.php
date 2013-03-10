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

/**
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 * rename columns
 */
class m130115_155600_columns_rename extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->renameColumn('{{page_page}}', 'menu_order', 'order');
        $this->renameColumn('{{page_page}}', 'name', 'title_short');
    }

    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        if ($db->schema->getTable('{{page_page}}') !== null) {

            if (in_array("menu_order", $db->schema->getTable('{{page_page}}')->columns))
                $this->renameColumn('{{page_page}}', 'order', 'menu_order');
            
            if (in_array("title_short", $db->schema->getTable('{{page_page}}')->columns))
                $this->renameColumn('{{page_page}}', 'title_short', 'name');
        }
    }
}