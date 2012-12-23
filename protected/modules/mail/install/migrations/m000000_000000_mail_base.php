<?php
class m000000_000000_mail_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'mail_event';
        $this->createTable($tableName, array(
                'id' => 'pk',
                'code' => 'string NOT NULL',
                'name' => 'string NOT NULL',
                'description' => 'text',
            ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("mail_event_code_unique",$tableName,"code", true);

        $tableName = $db->tablePrefix.'mail_template';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'code' => 'string NOT NULL',
            'event_id' => 'integer NOT NULL',
            'name' => 'string NOT NULL',
            'description' => 'text',
            'from' => 'string NOT NULL',
            'to' => 'string NOT NULL',
            'theme' => 'tinytext NOT NULL',
            'body' => 'text NOT NULL',
            'status' => "tinyint(3) NOT NULL DEFAULT '1'",

        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("mail_template_unique",$tableName,"code", true);
        $this->createIndex("mail_template_status",$tableName,"status", false);
        $this->createIndex("mail_template_event",$tableName,"event_id", false);
        $this->addForeignKey("mail_event_template_fk",$tableName,'event_id',$db->tablePrefix.'mail_event','id','CASCADE','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'mail_template');
        $this->dropTable($db->tablePrefix.'mail_event');
    }
}