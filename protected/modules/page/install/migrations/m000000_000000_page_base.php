<?php
class m000000_000000_page_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'page';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'category_id' => 'integer DEFAULT NULL',
            'lang' => 'char(2) DEFAULT NULL',
            'parent_id' => 'integer DEFAULT NULL',
            'creation_date' => 'datetime NOT NULL',
            'change_date' => 'datetime NOT NULL',
            'user_id' => 'integer  DEFAULT NULL',
            'change_user_id' => 'integer DEFAULT NULL',
            'name' => 'string NOT NULL',
            'title' => 'string NOT NULL',
            'slug' => 'string NOT NULL',
            'body' => 'text NOT NULL',
            'keywords' => 'string NOT NULL',
            'description' => 'string NOT NULL',
            'status' => 'tinyint(4) NOT NULL',
            'is_protected' => "boolean NOT NULL DEFAULT '0'",
            'menu_order' => "integer NOT NULL DEFAULT '0'",
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("page_slug_uniq",$tableName,"slug,lang", true);
        $this->createIndex("page_status",$tableName,"status", false);
        $this->createIndex("page_protected",$tableName,"is_protected", false);
        $this->createIndex("page_user_id",$tableName,"user_id", false);
        $this->createIndex("page_change_user_id",$tableName,"change_user_id", false);
        $this->createIndex("page_order",$tableName,"menu_order", false);
        $this->createIndex("page_category_id",$tableName,"category_id", false);

        $this->addForeignKey("page_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','SET NULL','CASCADE');
        $this->addForeignKey("page_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("page_user_change_fk",$tableName,'change_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'page');
    }
}