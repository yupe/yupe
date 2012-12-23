<?php
class m000000_000000_vote_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'vote';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'model' => 'string NOT NULL',
            'model_id' => 'integer NOT NULL',
            'user_id' => 'integer NOT NULL',
            'creation_date' => 'datetime NOT NULL',
            'value'  => 'integer NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("vote_user",$tableName,"user_id", false);
        $this->createIndex("vote_model_model_id",$tableName,"model,model_id", false);
        $this->createIndex("vote_model",$tableName,"model", false);
        $this->createIndex("vote_model_id",$tableName,"model_id", false);

        $this->addForeignKey("vote_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'vote');
    }
}