<?php
class m000000_000000_social_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'login';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'identity_id' => 'string NOT NULL',
            'type' => 'string NOT NULL',
            'creation_date' => 'datetime NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("social_identity_uniq",$tableName,"identity_id", true);
        $this->createIndex("social_user_id",$tableName,"user_id", false);
        $this->createIndex("social_type",$tableName,"type", false);

        $this->addForeignKey("social_user_fk",$tableName,'user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'login');
    }
}