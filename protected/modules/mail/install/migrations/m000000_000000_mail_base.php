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
class m000000_000000_mail_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        /**
         * mail_event:
         **/
        $this->createTable(
            $db->tablePrefix . 'mail_event', array(
                    'id'          => 'pk',
                    'code'        => 'string NOT NULL',
                    'name'        => 'string NOT NULL',
                    'description' => 'text',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "mail_event_code_unique", $db->tablePrefix . 'mail_event', "code", true);

        /**
         * mail_template:
         **/
        $this->createTable(
            $db->tablePrefix . 'mail_template', array(
                'id'          => 'pk',
                'code'        => 'string NOT NULL',
                'event_id'    => 'integer NOT NULL',
                'name'        => 'string NOT NULL',
                'description' => 'text',
                'from'        => 'string NOT NULL',
                'to'          => 'string NOT NULL',
                'theme'       => 'tinytext NOT NULL',
                'body'        => 'text NOT NULL',
                'status'      => "tinyint(3) NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "mail_template_unique", $db->tablePrefix . 'mail_template', "code", true);
        $this->createIndex($db->tablePrefix . "mail_template_status", $db->tablePrefix . 'mail_template', "status", false);
        $this->createIndex($db->tablePrefix . "mail_template_event", $db->tablePrefix . 'mail_template', "event_id", false);
        $this->addForeignKey($db->tablePrefix . "mail_event_template_fk", $db->tablePrefix . 'mail_template', 'event_id', $db->tablePrefix . 'mail_event', 'id', 'CASCADE', 'CASCADE');

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
        if ($db->schema->getTable($db->tablePrefix . 'mail_template') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "mail_event_code_unique", $db->tablePrefix . 'mail_event');
            */

            $this->dropTable($db->tablePrefix.'mail_template');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'mail_event') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "mail_template_unique", $db->tablePrefix . 'mail_event');
            $this->dropIndex($db->tablePrefix . "mail_template_status", $db->tablePrefix . 'mail_event');
            $this->dropIndex($db->tablePrefix . "mail_template_event", $db->tablePrefix . 'mail_event');
            */

            if (in_array($db->tablePrefix . "mail_event_template_fk", $db->schema->getTable($db->tablePrefix . 'mail_event')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "mail_event_template_fk", $db->tablePrefix . 'mail_event');

            $this->dropTable($db->tablePrefix . 'mail_event');
        }
    }
}