<?php
/**
 * File Doc Comment
 * Mail install migration
 * Класс миграций для модуля Mail:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Mail install migration
 * Класс миграций для модуля Mail:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 * @todo PSR message: Class name must begin with capital letter
 *                  : Class name is not valid; consider M000000_000000_Mail_Base instead
 **/
class m000000_000000_mail_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        /**
         * mail_event:
         **/
        $this->createTable(
            '{{mail_mail_event}}', array(
                    'id'          => 'pk',
                    'code'        => 'varchar(150) NOT NULL',
                    'name'        => 'varchar(150) NOT NULL',
                    'description' => 'text',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{mail_mail_event}}_code", '{{mail_mail_event}}', "code", true);

        /**
         * mail_template:
         **/
        $this->createTable(
           '{{mail_mail_template}}', array(
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
            ), $options
        );

        $this->createIndex("ux_{{mail_mail_template}}_unique",  '{{mail_mail_template}}', "code", true);
        $this->createIndex("ix_{{mail_mail_template}}_status",  '{{mail_mail_template}}', "status", false);
        $this->createIndex("ix_{{mail_mail_template}}_event",   '{{mail_mail_template}}', "event_id", false);

        $this->addForeignKey("fk_{{mail_mail_template}}_template", '{{mail_mail_template}}', 'event_id',  '{{mail_mail_event}}', 'id', 'CASCADE', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - mail_template
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{mail_mail_template}}') !== null) {

            if (in_array("fk_{{mail_mail_template}}_template", $db->schema->getTable('{{mail_mail_template}}')->foreignKeys))
                $this->dropForeignKey("fk_{{mail_mail_template}}_template", '{{mail_mail_template}}');

            $this->dropTable('{{mail_mail_template}}');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{mail_mail_event}}') !== null) {

            $this->dropTable('{{mail_mail_event}}');
        }
    }
}