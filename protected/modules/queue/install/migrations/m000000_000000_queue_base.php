<?php
class m000000_000000_queue_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'queue';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'worker' => 'tinyint(3) unsigned NOT NULL',
            'create_time' => 'datetime NOT NULL',
            'task' => 'text NOT NULL',
            'start_time' => 'datetime DEFAULT NULL',
            'complete_time' => 'datetime DEFAULT NULL',
            'priority' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            'status' => "tinyint(3) unsigned NOT NULL DEFAULT '0'",
            'notice' => 'varchar(300) DEFAULT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("queue_worker",$tableName,"worker", true);
        $this->createIndex("queue_priority",$tableName,"priority", true);

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'queue');
    }
}