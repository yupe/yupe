<?php

/**
 * Clean user table migration
 * Класс миграций для модуля User:
 *
 * @category YupeMigration
 * @package  yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m131025_152911_clean_user_table extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->dropColumn('{{user_user}}', 'creation_date');
        //$this->dropColumn('{{user_user}}', 'registration_date');
        $this->dropColumn('{{user_user}}', 'registration_ip');
        $this->dropColumn('{{user_user}}', 'activation_ip');
        $this->dropColumn('{{user_user}}', 'use_gravatar');
        $this->dropColumn('{{user_user}}', 'activate_key');
        $this->dropColumn('{{user_user}}', 'email_confirm');
        $this->dropColumn('{{user_user}}', 'online_status');

        $this->dropTableWithForeignKeys('{{user_recovery_password}}');
    }

    public function safeDown()
    {
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

        $this->addColumn('{{user_user}}', 'creation_date', 'datetime NOT NULL');
        //$this->addColumn('{{user_user}}', 'registration_date', 'datetime NOT NULL');
        $this->addColumn('{{user_user}}', 'registration_ip', 'varchar(50) NOT NULL');
        $this->addColumn('{{user_user}}', 'activation_ip', 'varchar(50) NOT NULL');
        $this->addColumn('{{user_user}}', 'use_gravatar', "boolean NOT NULL DEFAULT '1'");
        $this->addColumn('{{user_user}}', 'activate_key', 'char(32) NOT NULL');
        $this->addColumn('{{user_user}}', 'email_confirm', "boolean NOT NULL DEFAULT '0'");
        $this->addColumn('{{user_user}}', 'online_status', "varchar(250) NOT NULL DEFAULT ''");
    }
}
