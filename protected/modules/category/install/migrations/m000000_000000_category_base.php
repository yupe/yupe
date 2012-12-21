<?php
class m000000_000000_category_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'category';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'parent_id' => 'integer DEFAULT NULL',
            'alias' => 'string NOT NULL',
            'lang' => 'char(2) DEFAULT NULL',
            'name' => 'string NOT NULL',
            'image' => 'varchar(300) DEFAULT NULL',
            'short_description' => 'text',
            'description' => 'text NOT NULL',
            'status' => "smallint(1) NOT NULL DEFAULT '1'",
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("category_alias_uniq",$tableName,"alias,lang", true);
        $this->createIndex("category_parent_id",$tableName,"parent_id", false);
        $this->createIndex("category_status",$tableName,"status", false);
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'category');
    }
}