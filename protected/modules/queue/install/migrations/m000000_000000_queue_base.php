<?php
/**
 * File Doc Comment
 * Queue install migration
 * Класс миграций для модуля Queue:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_queue_base extends YDbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{queue_queue}}',
            array(
                'id' => 'pk',
                'worker' => 'integer NOT NULL',
                'create_time' => 'datetime NOT NULL',
                'task' => 'text NOT NULL',
                'start_time' => 'datetime DEFAULT NULL',
                'complete_time' => 'datetime DEFAULT NULL',
                'priority' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '0'",
                'notice' => 'varchar(300) DEFAULT NULL',
            ),
            $this->getOptions()
        );

        $this->createIndex("ux_{{queue_queue}}_worker", '{{queue_queue}}', "worker", true);
        $this->createIndex("ux_{{queue_queue}}_priority", '{{queue_queue}}', "priority", true);
    }
 

    public function safeDown()
    {
        $this->dropTable('{{queue_queue}}');
    }
}