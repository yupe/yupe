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
class m000000_000000_social_base extends YDbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{social_login}}', 
            array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'identity_id' => 'varchar(250) NOT NULL',
                'type' => 'varchar(150) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{social_login}}_identity", '{{social_login}}', "identity_id", true);
        $this->createIndex("ix_{{social_login}}_user_id", '{{social_login}}', "user_id", false);
        $this->createIndex("ix_{{social_login}}_type", '{{social_login}}', "type", false);

        $this->addForeignKey("fk_{{social_login}}_user", '{{social_login}}', 'user_id', '{{user_user}}', 'id', 'CASCADE', 'NO ACTION');
    }
 

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{social_login}}');
    }
}