<?php
class YDbMigration extends CDbMigration
{
    public function getOptions()
    {
    	return Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
    }

    /**
     * Safely drops table having foreign keys dropped first
     * @param $table
     */
    public function dropTableWithForeignKeys($table) {
        $schema = $this->getDbConnection()->schema;
        if ($schema->getTable($table) !== null) {
            // drop foreign keys
            foreach ( $schema->getTable($table)->foreignKeys as $fk_name) {
                $this->dropForeignKey($fk_name, $table);
            }
            $this->dropTable($table);
        }
    }
}
