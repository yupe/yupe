<?php
class m000000_000000_yupe_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'settings';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'module_id'=> 'string NOT NULL',
            'param_name'=> 'string NOT NULL',
            'param_value' => 'string  NOT NULL',
            'creation_date' => 'datetime NOT NULL',
            'change_date' => 'datetime NOT NULL',
            'user_id' => 'integer DEFAULT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("settings_module_id",$tableName,"module_id", false);
        $this->createIndex("settings_param_name",$tableName,"param_name", false);
        $this->createIndex("settings_param_name_uniq",$tableName,"module_id,param_name", true);
    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'settings');
    }
}