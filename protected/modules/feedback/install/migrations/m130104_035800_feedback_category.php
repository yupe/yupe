<?php
/**
 * Feedback install migration
 * Класс миграций для модуля Feedback:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Feedback install migration
 * Класс миграций для модуля Feedback:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 *
 * Add category relations to feedback
 */
class m130104_035800_feedback_category extends CDbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $this->addColumn($db->tablePrefix . 'feedback', 'category_id', 'integer DEFAULT NULL');

        $this->createIndex($db->tablePrefix . "feedback_category_idx", $db->tablePrefix . 'feedback', "category_id", false);
        $this->addForeignKey($db->tablePrefix . "feedback_category_fk", $db->tablePrefix . 'feedback', 'category_id', $db->tablePrefix . 'category', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * Откатываем миграцию
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        /**
         * Убиваем внешние ключи, индексы и таблицу - feedback
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'feedback') !== null) {
            
            /*
            $this->dropIndex($db->tablePrefix . "feedback_category_idx", $db->tablePrefix . 'feedback');
            */

            if (in_array($db->tablePrefix . "feedback_category_fk", $db->schema->getTable($db->tablePrefix . 'feedback')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "feedback_category_fk", $db->tablePrefix . 'feedback');
            
            if (in_array("feedback", $db->schema->getTable($db->tablePrefix . 'feedback')->columns))
                $this->dropColumn($db->tablePrefix . 'feedback', 'category_id');

        }
    }
}