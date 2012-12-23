<?php
class m000000_000000_user_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'user';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'creation_date' => 'datetime NOT NULL',
            'change_date'   => 'datetime NOT NULL',
            'first_name'    => 'string DEFAULT NULL',
            'middle_name'   => 'string DEFAULT NULL',
            'last_name'     => 'string DEFAULT NULL',
            'nick_name'     => 'string NOT NULL',
            'email'         => 'string NOT NULL',
            'gender'        => "boolean NOT NULL DEFAULT '0'",
            'birth_date'    => 'date DEFAULT NULL',
            'site'          => "string NOT NULL DEFAULT ''",
            'about'         => "string NOT NULL DEFAULT ''",
            'location'      => "string NOT NULL DEFAULT ''",
            'online_status' => "string NOT NULL DEFAULT ''",
            'password'      => "char(32) NOT NULL",
            'salt'          => "char(32) NOT NULL",
            'status'        => "tinyint(1) NOT NULL DEFAULT '2'",
            'access_level'  => "tinyint(1) NOT NULL DEFAULT '0'",
            'last_visit'    => 'datetime DEFAULT NULL',
            'registration_date' => 'datetime NOT NULL',
            'registration_ip' => 'string NOT NULL',
            'activation_ip'   => 'string NOT NULL',
            'avatar'          => 'string DEFAULT NULL',
            'use_gravatar'    => "boolean NOT NULL DEFAULT '1'",
            'activate_key'    => 'char(32) NOT NULL',
            'email_confirm'   => "boolean NOT NULL DEFAULT '0'",
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("user_nickname_unique",$tableName,"nick_name", true);
        $this->createIndex("user_email_unique",$tableName,"email", true);
        $this->createIndex("user_status_index",$tableName,"status", false);
        $this->createIndex("user_email_confirm",$tableName,"email_confirm", false);

        $tableName = $db->tablePrefix.'recovery_password';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'user_id' => 'integer NOT NULL',
            'creation_date' => 'datetime NOT NULL',
            'code' =>  'char(32) NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("user_recovery_code",$tableName,"code", true);
        $this->createIndex("user_recovery_userid",$tableName,"user_id", false);

        $this->addForeignKey("user_recovery_uid_fk",$tableName,'user_id',$db->tablePrefix.'user','id','CASCADE','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'user_recovery');
        $this->dropTable($db->tablePrefix.'user');
    }
}