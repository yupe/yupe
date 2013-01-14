<?php
class m000000_000000_catalog_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'good';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'category_id' => 'integer NOT NULL',
            'name' => 'string NOT NULL',
            'price' => "decimal(19,3) NOT NULL DEFAULT '0'",
            'article' => 'string DEFAULT NULL',
            'image' => 'varchar(300) DEFAULT NULL',
            'short_description' => 'text',
            'description' => 'text NOT NULL',
            'alias' => 'string NOT NULL',
            'data' => 'text',
            'is_special' => "boolean NOT NULL DEFAULT '0'",
            'status' => "smallint(1) unsigned NOT NULL DEFAULT '1'",
            'create_time' => 'datetime NOT NULL',
            'update_time' => 'datetime NOT NULL',
            'user_id' => 'integer DEFAULT NULL',
            'change_user_id' => 'integer DEFAULT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("good_alias_uniq",$tableName,"alias", true);
        $this->createIndex("good_status",$tableName,"status", false);
        $this->createIndex("good_category",$tableName,"category_id", false);
        $this->createIndex("good_user",$tableName,"user_id", false);
        $this->createIndex("good_change_user",$tableName,"change_user_id", false);
        $this->createIndex("good_article",$tableName,"article", false);
        $this->createIndex("good_price",$tableName,"price", false);

        $this->addForeignKey("good_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("good_change_user_fk",$tableName,'change_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("good_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','CASCADE','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'good');
    }
}