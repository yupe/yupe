<?php
/**
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
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'mail_event';
        $this->createTable(
            $tableName, array(
                    'id'          => 'pk',
                    'code'        => 'string NOT NULL',
                    'name'        => 'string NOT NULL',
                    'description' => 'text',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex("mail_event_code_unique", $tableName, "code", true);

        $tableName = $db->tablePrefix.'mail_template';
        $this->createTable(
            $tableName, array(
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

        $this->createIndex("mail_template_unique", $tableName, "code", true);
        $this->createIndex("mail_template_status", $tableName, "status", false);
        $this->createIndex("mail_template_event", $tableName, "event_id", false);
        $this->addForeignKey("mail_event_template_fk", $tableName, 'event_id', $db->tablePrefix . 'mail_event', 'id', 'CASCADE', 'CASCADE');

    }
 
    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'mail_template');
        $this->dropTable($db->tablePrefix.'mail_event');
    }
}