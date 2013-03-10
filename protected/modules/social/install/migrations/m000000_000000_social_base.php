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
    /**
     * Накатываем миграцию:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{login_login}}',
            array(
                'id' => 'pk',
                'user_id' => 'integer NOT NULL',
                'identity_id' => 'string NOT NULL',
                'type' => 'string NOT NULL',
                'creation_date' => 'datetime NOT NULL',
            ),
            $this->getOptions()
        );

        $this->createIndex("ux_{{login_login}}_identity_id", '{{login_login}}', "identity_id", true);
        $this->createIndex("ix_{{login_login}}_user_id", '{{login_login}}', "user_id", false);
        $this->createIndex("ix_{{login_login}}_type", '{{login_login}}', "type", false);

        //fk
        $this->addForeignKey("fk_{{login_login}}_user_id", '{{login_login}}', 'user_id', '{{user_user}}', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{login_login}}');
    }
}