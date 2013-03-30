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
        /**$schema = $this->getDbConnection()->schema;
        if ($schema->getTable($table) !== null) {
            // drop foreign keys
            foreach ( $schema->getTable($table)->foreignKeys as $fk_name) {
                $this->dropForeignKey($fk_name, $table);
            }
            $this->dropTable($table);
        }*/
        $this->dropTable($table);
    }

    /**
     * Inserts items, stored as array, column names on first row
     *         $items = array(
     *               array( 'id', 'name',  'somefield' ),
     *               array(  1,   'test1', 'some_value' ),
     *               ....................................
     *           ) ;
     * @param $itemsArray array Items array, first row - columns names
     * @param $tableName string Table name
     */
    public function insertItems($itemsArray, $tableName)
    {
        $columns = array_shift($itemsArray);
        foreach ($itemsArray as $i) {
            $item = array();
            $n    = 0;

            foreach ($columns as $c)
                $item[$c] = $i[$n++];

            $this->insert(
                $tableName,
                $item
            );
        }

    }
}
