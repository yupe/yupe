<?php
/**
 * Add category relations to feedback
 */
class m130115_155600_columns_rename extends CDbMigration
{
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'page';
        $this->renameColumn($tableName, 'menu_order', 'order');
        $this->renameColumn($tableName, 'name', 'title_short');
    }

    public function safeDown()
    {
        $db = $this->getDbConnection();
        $tableName = $db->tablePrefix.'page';
        $this->renameColumn($tableName, 'order', 'menu_order');
        $this->renameColumn($tableName, 'title_short', 'name');
    }
}