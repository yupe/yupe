<?php
class m000000_000000_comment_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'comment';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'user_id' => 'integer DEFAULT NULL',
            'model' => 'string NOT NULL',
            'model_id' => 'integer NOT NULL',
            'url' => 'string DEFAULT NULL',
            'lang' => 'char(2) DEFAULT NULL',
            'creation_date' => 'datetime NOT NULL',
            'name' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'text' => 'text NOT NULL',
            'status' => "tinyint(4) NOT NULL DEFAULT '0'",
            'ip' => 'string DEFAULT NULL'
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("comment_url",$tableName,"url", false);
        $this->createIndex("comment_status",$tableName,"status", false);
        $this->createIndex("comment_model",$tableName,"model", false);
        $this->createIndex("comment_model_id",$tableName,"model_id", false);
        $this->createIndex("comment_user_id",$tableName,"user_id", false);


        $this->addForeignKey("comment_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'comment');
    }
}