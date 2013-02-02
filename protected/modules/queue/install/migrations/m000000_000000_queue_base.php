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
class m000000_000000_queue_base extends CDbMigration
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
            $db->tablePrefix . 'queue', array(
                'id' => 'pk',
                'worker' => 'tinyint(3) unsigned NOT NULL',
                'create_time' => 'datetime NOT NULL',
                'task' => 'text NOT NULL',
                'start_time' => 'datetime DEFAULT NULL',
                'complete_time' => 'datetime DEFAULT NULL',
                'priority' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
                'status' => "tinyint(3) unsigned NOT NULL DEFAULT '0'",
                'notice' => 'varchar(300) DEFAULT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex("queue_worker", $db->tablePrefix . 'queue', "worker", true);
        $this->createIndex("queue_priority", $db->tablePrefix . 'queue', "priority", true);

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
        if ($db->schema->getTable($db->tablePrefix . 'queue') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "queue_worker", $db->tablePrefix . 'queue');
            $this->dropIndex($db->tablePrefix . "queue_priority", $db->tablePrefix . 'queue');
            */
            
            $this->dropTable($db->tablePrefix . 'queue');
        }
    }
}