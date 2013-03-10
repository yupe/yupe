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
class m130115_155600_columns_rename extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $this->renameColumn($db->tablePrefix . 'page_page', 'menu_order', 'order');
        $this->renameColumn($db->tablePrefix . 'page_page', 'name', 'title_short');
    }

    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        if ($db->schema->getTable($db->tablePrefix . 'page_page') !== null) {

            if (in_array($db->tablePrefix . "page_order", $db->schema->getTable($db->tablePrefix . 'page_page')->columns))
                $this->renameColumn($db->tablePrefix . 'page_page', 'order', 'menu_order');
            
            if (in_array($db->tablePrefix . "page_title_short", $db->schema->getTable($db->tablePrefix . 'page_page')->columns))
                $this->renameColumn($db->tablePrefix . 'page_page', 'title_short', 'name');
        }
    }
}