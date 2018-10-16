<?php

/**
 * Queue install migration
 * Класс миграций для модуля Queue
 *
 * @category YupeMigration
 * @package  yupe.modules.queue.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_queue_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{queue_queue}}',
            [
                'id'            => 'pk',
                'worker'        => 'integer NOT NULL',
                'create_time'   => 'datetime NOT NULL',
                'task'          => 'text NOT NULL',
                'start_time'    => 'datetime DEFAULT NULL',
                'complete_time' => 'datetime DEFAULT NULL',
                'priority'      => "integer NOT NULL DEFAULT '1'",
                'status'        => "integer NOT NULL DEFAULT '0'",
                'notice'        => 'varchar(255) DEFAULT NULL',
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{queue_queue}}_worker", '{{queue_queue}}', "worker", true);
        $this->createIndex("ux_{{queue_queue}}_priority", '{{queue_queue}}', "priority", true);
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{queue_queue}}');
    }
}
