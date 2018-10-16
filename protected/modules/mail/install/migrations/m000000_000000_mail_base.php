<?php

/**
 *
 * Mail install migration
 * Класс миграций для модуля Mail
 *
 * @category YupeMigration
 * @package  yupe.modules.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_mail_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        /**
         * mail_event:
         **/
        $this->createTable(
            '{{mail_mail_event}}',
            [
                'id'          => 'pk',
                'code'        => 'varchar(150) NOT NULL',
                'name'        => 'varchar(150) NOT NULL',
                'description' => 'text',
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{mail_mail_event}}_code", '{{mail_mail_event}}', "code", true);

        /**
         * mail_template:
         **/
        $this->createTable(
            '{{mail_mail_template}}',
            [
                'id'          => 'pk',
                'code'        => 'varchar(150) NOT NULL',
                'event_id'    => 'integer NOT NULL',
                'name'        => 'varchar(150) NOT NULL',
                'description' => 'text',
                'from'        => 'varchar(150) NOT NULL',
                'to'          => 'varchar(150) NOT NULL',
                'theme'       => 'text NOT NULL',
                'body'        => 'text NOT NULL',
                'status'      => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{mail_mail_template}}_code", '{{mail_mail_template}}', "code", true);
        $this->createIndex("ix_{{mail_mail_template}}_status", '{{mail_mail_template}}', "status", false);
        $this->createIndex("ix_{{mail_mail_template}}_event_id", '{{mail_mail_template}}', "event_id", false);

        //fk
        $this->addForeignKey(
            "fk_{{mail_mail_template}}_event_id",
            '{{mail_mail_template}}',
            'event_id',
            '{{mail_mail_event}}',
            'id',
            'CASCADE',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{mail_mail_template}}');
        $this->dropTableWithForeignKeys('{{mail_mail_event}}');
    }
}
