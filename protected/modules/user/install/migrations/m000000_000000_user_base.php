<?php
/**
 * FileDocComment
 * User install migration
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * User install migration
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_user_base extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            $db->tablePrefix . 'user', array(
                'id' => 'pk',
                'creation_date' => 'datetime NOT NULL',
                'change_date'   => 'datetime NOT NULL',
                'first_name'    => 'string DEFAULT NULL',
                'middle_name'   => 'string DEFAULT NULL',
                'last_name'     => 'string DEFAULT NULL',
                'nick_name'     => 'string NOT NULL',
                'email'         => 'string NOT NULL',
                'gender'        => "boolean NOT NULL DEFAULT '0'",
                'birth_date'    => 'date DEFAULT NULL',
                'site'          => "string NOT NULL DEFAULT ''",
                'about'         => "string NOT NULL DEFAULT ''",
                'location'      => "string NOT NULL DEFAULT ''",
                'online_status' => "string NOT NULL DEFAULT ''",
                'password'      => "char(32) NOT NULL",
                'salt'          => "char(32) NOT NULL",
                'status'        => "tinyint(1) NOT NULL DEFAULT '2'",
                'access_level'  => "tinyint(1) NOT NULL DEFAULT '0'",
                'last_visit'    => 'datetime DEFAULT NULL',
                'registration_date' => 'datetime NOT NULL',
                'registration_ip' => 'string NOT NULL',
                'activation_ip'   => 'string NOT NULL',
                'avatar'          => 'string DEFAULT NULL',
                'use_gravatar'    => "boolean NOT NULL DEFAULT '1'",
                'activate_key'    => 'char(32) NOT NULL',
                'email_confirm'   => "boolean NOT NULL DEFAULT '0'",
            ), $options
        );

        $this->createIndex($db->tablePrefix . "user_nickname_unique", $db->tablePrefix . 'user', "nick_name", true);
        $this->createIndex($db->tablePrefix . "user_email_unique", $db->tablePrefix . 'user', "email", true);
        $this->createIndex($db->tablePrefix . "user_status_index", $db->tablePrefix . 'user', "status", false);
        $this->createIndex($db->tablePrefix . "user_email_confirm", $db->tablePrefix . 'user', "email_confirm", false);

        $this->createTable(
            $db->tablePrefix.'recovery_password', array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'code' =>  'char(32) NOT NULL',
            ), $options
        );

        $this->createIndex($db->tablePrefix . "user_recovery_code", $db->tablePrefix.'recovery_password', "code", true);
        $this->createIndex($db->tablePrefix . "user_recovery_userid", $db->tablePrefix.'recovery_password', "user_id", false);

        $this->addForeignKey($db->tablePrefix . "user_recovery_uid_fk", $db->tablePrefix . 'recovery_password', 'user_id', $db->tablePrefix . 'user', 'id', 'CASCADE', 'CASCADE');

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
         * Убиваем внешние ключи, индексы и таблицу - recovery_password
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне, без привязки к БД):
         **/
        
        /*
        $this->dropIndex($db->tablePrefix . "user_recovery_code", $db->tablePrefix . 'recovery_password');
        $this->dropIndex($db->tablePrefix . "user_recovery_userid", $db->tablePrefix . 'recovery_password');
        */

        if ($db->schema->getTable($db->tablePrefix . 'recovery_password') !== null) {
            if (in_array($db->tablePrefix . "user_recovery_uid_fk", $db->schema->getTable($db->tablePrefix . 'recovery_password')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "user_recovery_uid_fk", $db->tablePrefix . 'recovery_password');
            $this->dropTable($db->tablePrefix . 'recovery_password');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - user
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к БД):
         **/
        
        /*
        $this->dropIndex($db->tablePrefix . "user_nickname_unique", $db->tablePrefix . 'user');
        $this->dropIndex($db->tablePrefix . "user_email_unique", $db->tablePrefix . 'user');
        $this->dropIndex($db->tablePrefix . "user_status_index", $db->tablePrefix . 'user');
        $this->dropIndex($db->tablePrefix . "user_email_confirm", $db->tablePrefix . 'user');
        */

        if ($db->schema->getTable($db->tablePrefix . 'user') !== null)
            $this->dropTable($db->tablePrefix.'user');
    }
}