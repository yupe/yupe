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

        $tableName = $db->tablePrefix . 'page';
        $this->renameColumn($db->tablePrefix . 'page', 'menu_order', 'order');
        $this->renameColumn($db->tablePrefix . 'page', 'name', 'title_short');
    }

    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        if ($db->schema->getTable($db->tablePrefix . 'page') !== null) {

            if (in_array($db->tablePrefix . "order", $db->schema->getTable($db->tablePrefix . 'page')->columns))
                $this->renameColumn($db->tablePrefix . 'page', 'order', 'menu_order');
            
            if (in_array($db->tablePrefix . "title_short", $db->schema->getTable($db->tablePrefix . 'page')->columns))
                $this->renameColumn($db->tablePrefix . 'page', 'title_short', 'name');
        }
    }
}