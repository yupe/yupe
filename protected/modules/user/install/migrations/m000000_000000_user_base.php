<?php

/**
 * User install migration
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_user_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{user_user}}',
            [
                'id'                => 'pk',
                'creation_date'     => 'datetime NOT NULL',
                'change_date'       => 'datetime NOT NULL',
                'first_name'        => 'varchar(250) DEFAULT NULL',
                'middle_name'       => 'varchar(250) DEFAULT NULL',
                'last_name'         => 'varchar(250) DEFAULT NULL',
                'nick_name'         => 'varchar(250) NOT NULL',
                'email'             => 'varchar(250) NOT NULL',
                'gender'            => "boolean NOT NULL DEFAULT '0'",
                'birth_date'        => 'date DEFAULT NULL',
                'site'              => "varchar(250) NOT NULL DEFAULT ''",
                'about'             => "varchar(250) NOT NULL DEFAULT ''",
                'location'          => "varchar(250) NOT NULL DEFAULT ''",
                'online_status'     => "varchar(250) NOT NULL DEFAULT ''",
                'password'          => "char(32) NOT NULL",
                'salt'              => "char(32) NOT NULL",
                'status'            => "integer NOT NULL DEFAULT '2'",
                'access_level'      => "integer NOT NULL DEFAULT '0'",
                'last_visit'        => 'datetime DEFAULT NULL',
                'registration_date' => 'datetime NOT NULL',
                'registration_ip'   => 'varchar(50) NOT NULL',
                'activation_ip'     => 'varchar(50) NOT NULL',
                'avatar'            => 'varchar(150) DEFAULT NULL',
                'use_gravatar'      => "boolean NOT NULL DEFAULT '1'",
                'activate_key'      => 'char(32) NOT NULL',
                'email_confirm'     => "boolean NOT NULL DEFAULT '0'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{user_user}}_nick_name", '{{user_user}}', "nick_name", true);
        $this->createIndex("ux_{{user_user}}_email", '{{user_user}}', "email", true);
        $this->createIndex("ix_{{user_user}}_status", '{{user_user}}', "status", false);
        $this->createIndex("ix_{{user_user}}_email_confirm", '{{user_user}}', "email_confirm", false);

        // recovery password table
        $this->createTable(
            '{{user_recovery_password}}',
            [
                'id'            => 'pk',
                'user_id'       => 'integer NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'code'          => 'char(32) NOT NULL',
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{user_recovery_password}}_code", '{{user_recovery_password}}', "code", true);
        $this->createIndex("ix_{{user_recovery_password}}_user_id", '{{user_recovery_password}}', "user_id", false);
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{user_recovery_password}}');
        $this->dropTableWithForeignKeys('{{user_user}}');
    }
}
