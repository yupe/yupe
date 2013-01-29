<?php
/**
 * Comment install migration
 * Класс миграций для модуля Comment:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Comment install migration
 * Класс миграций для модуля Comment:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 * Add parrent_id column to comment table
 */
class m130128_033423_comment_parrent_id extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $tableName = $db->tablePrefix . 'comment';

        $this->addColumn($tableName, 'parrent_id', 'integer DEFAULT NULL');

        $this->createIndex("comment_parrent_id", $tableName, "parrent_id", false);
    }

    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix . 'comment';
        $this->dropIndex("comment_parrent_id", $tableName);
        $this->dropColumn($tableName, 'parrent_id');
    }
}