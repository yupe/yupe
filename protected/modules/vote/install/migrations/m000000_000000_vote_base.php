<?php
/**
 * File Doc Comment
 * Vote install migration
 * Класс миграций для модуля Vote:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Vote install migration
 * Класс миграций для модуля Vote:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_vote_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix . 'vote';
        $this->createTable(
            $db->tablePrefix . 'vote', array(
                'id' => 'pk',
                'model' => 'string NOT NULL',
                'model_id' => 'integer NOT NULL',
                'user_id' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'value'  => 'integer NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "vote_user", $db->tablePrefix . 'vote', "user_id", false);
        $this->createIndex($db->tablePrefix . "vote_model_model_id", $db->tablePrefix . 'vote', "model,model_id", false);
        $this->createIndex($db->tablePrefix . "vote_model", $db->tablePrefix . 'vote', "model", false);
        $this->createIndex($db->tablePrefix . "vote_model_id", $db->tablePrefix . 'vote', "model_id", false);

        $this->addForeignKey($db->tablePrefix . "vote_user_fk", $db->tablePrefix . 'vote', 'user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - vote
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'vote') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "vote_user", $db->tablePrefix . 'vote');
            $this->dropIndex($db->tablePrefix . "vote_model_model_id", $db->tablePrefix . 'vote');
            $this->dropIndex($db->tablePrefix . "vote_model", $db->tablePrefix . 'vote');
            $this->dropIndex($db->tablePrefix . "vote_model_id", $db->tablePrefix . 'vote');
            */

            if (in_array($db->tablePrefix . "vote_user_fk", $db->schema->getTable($db->tablePrefix . 'vote')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "vote_user_fk", $db->tablePrefix . 'vote');
            
            $this->dropTable($db->tablePrefix.'vote');
        }
    }
}