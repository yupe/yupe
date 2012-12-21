<?php
class m000000_000000_contentblock_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'content_block';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'name' => 'string NOT NULL',
            'code' => 'string NOT NULL',
            'type' => "tinyint(4) NOT NULL DEFAULT '1'",
            'content' => "text NOT NULL",
            'description' => "varchar(300) DEFAULT NULL"
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("contentblock_code_unique",$tableName,"code", true);
        $this->createIndex("contentblock_type",$tableName,"type", false);
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'content_block');
    }
}