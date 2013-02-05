<?php
/**
 * File Doc Comment
 * Social install migration
 * Класс миграций для модуля Social:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Social install migration
 * Класс миграций для модуля Social:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_social_base extends CDbMigration
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
            $db->tablePrefix . 'login', array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'identity_id' => 'string NOT NULL',
                'type' => 'string NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "social_identity_uniq", $db->tablePrefix . 'login', "identity_id", true);
        $this->createIndex($db->tablePrefix . "social_user_id", $db->tablePrefix . 'login', "user_id", false);
        $this->createIndex($db->tablePrefix . "social_type", $db->tablePrefix . 'login', "type", false);

        $this->addForeignKey($db->tablePrefix . "social_user_fk", $db->tablePrefix . 'login', 'user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - login
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'login') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "social_type", $db->tablePrefix . 'login');
            $this->dropIndex($db->tablePrefix . "social_user_id", $db->tablePrefix . 'login');
            $this->dropIndex($db->tablePrefix . "social_identity_uniq", $db->tablePrefix . 'login');
            */

            if (in_array($db->tablePrefix . "social_user_fk", $db->schema->getTable($db->tablePrefix . 'login')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "social_user_fk", $db->tablePrefix . 'login');

            $this->dropTable($db->tablePrefix.'login');
        }
    }
}