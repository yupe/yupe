<?php
/**
 * Add category relations to blog
 */
class m130104_035800_feedback_category extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $tableName = $db->tablePrefix.'feedback';

        $this->addColumn($tableName, 'category_id', 'integer DEFAULT NULL');

        $this->createIndex("feedback_category_idx",$tableName,"category_id", false);
        $this->addForeignKey("feedback_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','SET NULL','CASCADE');
    }

    public function safeDown()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'feedback';
        $this->dropForeignKey("feedback_category_fk", $tableName);
        $this->dropIndex("feedback_category_idx", $tableName);
        $this->dropColumn($tableName,'category_id');
    }
}