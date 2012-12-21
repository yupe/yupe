<?php
class m000000_000000_dictionary_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'dictionary_group';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'code' => 'string NOT NULL',
            'name' => "string NOT NULL DEFAULT ''",
            'description' => "varchar(300) NOT NULL DEFAULT ''",
            'creation_date' => 'datetime NOT NULL',
            'update_date' => 'datetime NOT NULL',
            'create_user_id' => 'integer DEFAULT NULL',
            'update_user_id' => 'integer DEFAULT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("dictionary_group_code_unique",$tableName,"code", true);
        $this->createIndex("dictionary_group_create_user_id",$tableName,"create_user_id", false);
        $this->createIndex("dictionary_group_update_user_id",$tableName,"update_user_id", false);
        $this->addForeignKey("dictionary_group_createuser_id",$tableName,'create_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("dictionary_group_updateuser_id",$tableName,'update_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');


        $tableName = $db->tablePrefix.'dictionary_data';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'group_id' => 'integer NOT NULL',
                'code' => 'string NOT NULL',
                'name' => 'string NOT NULL',
                'value' => 'string NOT NULL',
                'description' => "varchar(300) NOT NULL DEFAULT ''",
                'creation_date' => 'datetime NOT NULL',
                'update_date' => 'datetime NOT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'status' => "tinyint(3) unsigned NOT NULL DEFAULT '1'",
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("dictionary_data_code_unique",$tableName,"code", true);
        $this->createIndex("dictionary_data_group_id",$tableName,"group_id", false);
        $this->createIndex("dictionary_data_create_user_id",$tableName,"create_user_id", false);
        $this->createIndex("dictionary_data_update_user_id",$tableName,"update_user_id", false);
        $this->createIndex("dictionary_data_status",$tableName,"status", false);

        $this->addForeignKey("dictionary_data_createuser_id",$tableName,'create_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("dictionary_data_updateuser_id",$tableName,'update_user_id',$db->tablePrefix.'user','id','SET NULL','CASCADE');
        $this->addForeignKey("dictionary_data_group_id",$tableName,'group_id',$db->tablePrefix.'dictionary_group','id','CASCADE','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'dictionary_group');
        $this->dropTable($db->tablePrefix.'dictionary_data');
        $this->dropTable($db->tablePrefix.'dictionary');
    }
}