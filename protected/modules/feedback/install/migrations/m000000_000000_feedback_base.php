<?php
class m000000_000000_feedback_base extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'feedback';
        $this->createTable($tableName, array(
            'id' => 'pk',
            'answer_user' => 'integer DEFAULT NULL',
            'creation_date' => 'datetime NOT NULL',
            'change_date' => 'datetime NOT NULL',
            'name' => 'string NOT NULL',
            'email' => 'string NOT NULL',
            'phone' => 'string DEFAULT NULL',
            'theme' => 'string NOT NULL',
            'text' => 'text NOT NULL',
            'type' => "tinyint(4) NOT NULL DEFAULT '0'",
            'answer' => 'text NOT NULL',
            'answer_date' => 'datetime DEFAULT NULL',
            'is_faq' => "tinyint(1) NOT NULL DEFAULT '0'",
            'status' => "tinyint(4) NOT NULL DEFAULT '0'",
            'ip' => 'string NOT NULL',
        ),"ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $this->createIndex("feedback_type",$tableName,"type", false);
        $this->createIndex("feedback_status",$tableName,"status", false);
        $this->createIndex("feedback_isfaq",$tableName,"is_faq", false);
        $this->createIndex("feedback_answer_user",$tableName,"answer_user", false);
        $this->createIndex("feedback_answer_date",$tableName,"answer_date", false);

        $this->addForeignKey("feedback_answer_user_fk",$tableName,'answer_user',$db->tablePrefix.'user','id','SET NULL','CASCADE');

    }
 
    public function safeDown()
    {
        $db = $this->getDbConnection();
        $this->dropTable($db->tablePrefix.'feedback');
    }
}