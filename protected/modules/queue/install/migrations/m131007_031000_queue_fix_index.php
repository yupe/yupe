<?php

/**
 * Queue fix index migration
 * Класс миграций для модуля Queue
 *
 * @category YupeMigration
 * @package  yupe.modules.queue.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m131007_031000_queue_fix_index extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->dropIndex("ux_{{queue_queue}}_worker", '{{queue_queue}}');
        $this->dropIndex("ux_{{queue_queue}}_priority", '{{queue_queue}}');

        $this->createIndex("ux_{{queue_queue}}_worker", '{{queue_queue}}', "worker");
        $this->createIndex("ux_{{queue_queue}}_priority", '{{queue_queue}}', "priority");
    }

    public function safeDown()
    {

    }
}
