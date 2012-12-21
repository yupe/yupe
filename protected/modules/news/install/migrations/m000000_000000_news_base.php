<?php
class m000000_000000_news_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'news';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'category_id' => 'integer DEFAULT NULL',
            'lang' => 'char(2) DEFAULT NULL',
            'creation_date' => 'datetime NOT NULL',
            'change_date' => 'datetime NOT NULL',
            'date' => 'date NOT NULL',
            'title' => 'string NOT NULL',
            'alias' => 'string NOT NULL',
            'short_text' => 'text',
            'full_text' => 'text NOT NULL',
            'image' => 'varchar(300) DEFAULT NULL',
            'link' => 'varchar(300) DEFAULT NULL',
            'user_id' => 'integer DEFAULT NULL',
            'status' => "tinyint(4) NOT NULL DEFAULT '0'",
            'is_protected' => "boolean NOT NULL DEFAULT '0'",
            'keywords' => 'string NOT NULL',
            'description' => 'string NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("news_alias_unique",$tableName,"alias,lang", true);
        $this->createIndex("news_status",$tableName,"status", false);
        $this->createIndex("news_user",$tableName,"user_id", false);
        $this->createIndex("news_category",$tableName,"category_id", false);
        $this->createIndex("news_date",$tableName,"date", false);

        $this->addForeignKey("news_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("news_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','SET NULL','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'news');
    }
}