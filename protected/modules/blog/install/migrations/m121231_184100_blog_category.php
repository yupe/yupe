<?php
/**
 * Add category relations to blog
 */
class m121231_184100_blog_category extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();

        // blog
        $tableName = $db->tablePrefix.'blog';

        $this->addColumn($tableName, 'category_id', 'integer DEFAULT NULL');

        $this->createIndex("blog_category_idx",$tableName,"category_id", false);
        $this->addForeignKey("blog_category_fk",$tableName,'category_id',$db->tablePrefix.'category','id','SET NULL','CASCADE');
    }

    public function safeDown()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'blog';
        $this->dropForeignKey("blog_category_fk", $tableName);
        $this->dropIndex("blog_category_idx", $tableName);
        $this->dropColumn($tableName,'category_id');
    }
}