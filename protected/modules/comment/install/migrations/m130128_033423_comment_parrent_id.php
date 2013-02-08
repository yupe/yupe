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

        $this->addColumn($db->tablePrefix . 'comment', 'parrent_id', 'integer DEFAULT NULL');

        $this->createIndex($db->tablePrefix . "comment_parrent_id", $db->tablePrefix . 'comment', "parrent_id", false);

        $this->addForeignKey($db->tablePrefix . "comment_parrent_id_fk", $db->tablePrefix . 'comment', "parrent_id",$db->tablePrefix . 'comment', "id",'CASCADE','NO ACTION');
    }

    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - comment
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'comment') !== null) {
            
            /*
            $this->dropIndex($db->tablePrefix . "comment_parrent_id", $db->tablePrefix . 'comment');
            */

            if (in_array("parrent_id", $db->schema->getTable($db->tablePrefix . 'comment')->columns))
                $this->dropColumn($db->tablePrefix . 'comment', 'parrent_id');
        }
    }
}