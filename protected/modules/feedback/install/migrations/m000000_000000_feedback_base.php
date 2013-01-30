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
 */
class m000000_000000_feedback_base extends CDbMigration
{
    /**
     * Накатываем миграцию
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $this->createTable(
            $db->tablePrefix . 'feedback', array(
                'id' => 'pk',
                'answer_user' => 'integer DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date' => 'datetime NOT NULL',
                'name' => 'string NOT NULL',
                'email' => 'string NOT NULL',
                'phone' => 'string DEFAULT NULL',
                'theme' => 'string NOT NULL',
                'text' => 'text NOT NULL',
                'type' => "tinyint(4) NOT NULL DEFAULT '0'",
                'answer' => 'text NOT NULL',
                'answer_date' => 'datetime DEFAULT NULL',
                'is_faq' => "tinyint(1) NOT NULL DEFAULT '0'",
                'status' => "tinyint(4) NOT NULL DEFAULT '0'",
                'ip' => 'string NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "feedback_type", $db->tablePrefix . 'feedback', "type", false);
        $this->createIndex($db->tablePrefix . "feedback_status", $db->tablePrefix . 'feedback', "status", false);
        $this->createIndex($db->tablePrefix . "feedback_isfaq", $db->tablePrefix . 'feedback', "is_faq", false);
        $this->createIndex($db->tablePrefix . "feedback_answer_user", $db->tablePrefix . 'feedback', "answer_user", false);
        $this->createIndex($db->tablePrefix . "feedback_answer_date", $db->tablePrefix . 'feedback', "answer_date", false);

        $this->addForeignKey($db->tablePrefix . "feedback_answer_user_fk", $db->tablePrefix . 'feedback', 'answer_user', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');

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
            $this->dropIndex($db->tablePrefix . "feedback_type", $db->tablePrefix . 'feedback');
            $this->dropIndex($db->tablePrefix . "feedback_status", $db->tablePrefix . 'feedback');
            $this->dropIndex($db->tablePrefix . "feedback_isfaq", $db->tablePrefix . 'feedback');
            $this->dropIndex($db->tablePrefix . "feedback_answer_user", $db->tablePrefix . 'feedback');
            $this->dropIndex($db->tablePrefix . "feedback_answer_date", $db->tablePrefix . 'feedback');
            */
            
            if (in_array($db->tablePrefix . "feedback_answer_user_fk", $db->schema->getTable($db->tablePrefix . 'feedback')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "feedback_answer_user_fk", $db->tablePrefix . 'feedback');
            
            $this->dropTable($db->tablePrefix . 'feedback');
        }
    }
}