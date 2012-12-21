<?php
class m000000_000000_menu_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'menu';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'name' => 'varchar(300) NOT NULL',
            'code' => 'string NOT NULL',
            'description' => 'varchar(300) NOT NULL',
            'status'=> "tinyint(3) unsigned NOT NULL DEFAULT '1'",
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("menu_code_unique",$tableName,"code", true);
        $this->createIndex("menu_status",$tableName,"status", false);

        $tableName = $db->tablePrefix.'menu_item';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'parent_id' => 'integer NOT NULL',
                'menu_id' => 'integer NOT NULL',
                'title' => 'string NOT NULL',
                'href' => 'string NOT NULL',
                'class' => 'string NOT NULL',
                'title_attr' => 'string NOT NULL',
                'before_link' => 'string NOT NULL',
                'after_link' => 'string NOT NULL',
                'target' => 'string NOT NULL',
                'rel' => 'string NOT NULL',
                'condition_name' => "string DEFAULT '0'",
                'condition_denial' => "tinyint(4) DEFAULT '0'",
                'sort' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
                'status' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("menu_item_menuid",$tableName,"menu_id", false);
        $this->createIndex("menu_item_sort",$tableName,"sort", false);
        $this->createIndex("menu_item_status",$tableName,"status", false);

        $this->addForeignKey("menu_item_menu_fk",$tableName,'menu_id',$db->tablePrefix.'menu','id','CASCADE','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'menu_item');
        $this->dropTable($db->tablePrefix.'menu');
    }
}