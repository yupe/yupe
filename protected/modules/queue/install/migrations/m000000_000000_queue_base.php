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

/**
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
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        /**
         * queue:
         **/
        $this->createTable(
            '{{queue_queue}}', array(
                'id' => 'pk',
                'worker' => 'integer NOT NULL',
                'create_time' => 'datetime NOT NULL',
                'task' => 'text NOT NULL',
                'start_time' => 'datetime DEFAULT NULL',
                'complete_time' => 'datetime DEFAULT NULL',
                'priority' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '0'",
                'notice' => 'varchar(300) DEFAULT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ix_{{queue_queue}}_worker",  '{{queue_queue}}', "worker", false);
        $this->createIndex("ix_{{queue_queue}}_prioriy", '{{queue_queue}}', "priority", false);
        $this->createIndex("ix_{{queue_queue}}_status",  '{{queue_queue}}', "status", false);

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
         * Убиваем внешние ключи, индексы и таблицу - queue
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{queue_queue}}') !== null) {
            $this->dropTable('{{queue_queue}}');
        }
    }
}