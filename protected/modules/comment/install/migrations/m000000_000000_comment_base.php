<?php
/**
 * FileDocComment
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
 **/
class m000000_000000_comment_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $this->createTable(
            $db->tablePrefix . 'comment', array(
                'id'            => 'pk',
                'user_id'       => 'integer DEFAULT NULL',
                'model'         => 'string NOT NULL',
                'model_id'      => 'integer NOT NULL',
                'url'           => 'string DEFAULT NULL',
                'lang'          => 'char(2) DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'name'          => 'string NOT NULL',
                'email'         => 'string NOT NULL',
                'text'          => 'text NOT NULL',
                'status'        => "tinyint(4) NOT NULL DEFAULT '0'",
                'ip'            => 'string DEFAULT NULL'
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        //$this->createIndex($db->tablePrefix . "comment_url", $db->tablePrefix . 'comment', "url", false);
        $this->createIndex($db->tablePrefix . "comment_status", $db->tablePrefix . 'comment', "status", false);
        $this->createIndex($db->tablePrefix . "comment_model", $db->tablePrefix . 'comment', "model", false);
        $this->createIndex($db->tablePrefix . "comment_model_id", $db->tablePrefix . 'comment', "model_id", false);
        $this->createIndex($db->tablePrefix . "comment_user_id", $db->tablePrefix . 'comment', "user_id", false);


        $this->addForeignKey($db->tablePrefix . "comment_user_fk", $db->tablePrefix . 'comment', 'user_id', $db->tablePrefix . 'user', 'id', 'RESTRICT', 'NO ACTION');
    }
 
    /**
     * Откатываем миграцию:
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
            
            if (in_array($db->tablePrefix . "comment_user_fk", $db->schema->getTable($db->tablePrefix . 'comment')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "comment_user_fk", $db->tablePrefix . 'comment');

            /*
            $this->dropIndex($db->tablePrefix . "comment_url", $db->tablePrefix . 'comment');
            $this->dropIndex($db->tablePrefix . "comment_status", $db->tablePrefix . 'comment');
            $this->dropIndex($db->tablePrefix . "comment_model", $db->tablePrefix . 'comment');
            $this->dropIndex($db->tablePrefix . "comment_model_id", $db->tablePrefix . 'comment');
            $this->dropIndex($db->tablePrefix . "comment_user_id", $db->tablePrefix . 'comment');
            */

            $this->dropTable($db->tablePrefix.'comment');
        }
    }
}