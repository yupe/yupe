<?php
/**
 * DbMigration - переопределен для использования методов, которые не
 *               входят в "базовую поставку" CDbMigration
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

namespace yupe\components;

use CDbMigration;
use CMysqlSchema;
use CPgsqlSchema;
use Yii;

class DbMigration extends CDbMigration
{
    /**
     * get options for schema
     *
     * @return string options
     */
    public function getOptions()
    {
        return Yii::app()->db->schema instanceof CMysqlSchema
            ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8'
            : '';
    }

    /**
     * render Table name
     *
     * @param string $table - name of table
     *
     * @return normalize name of table
     **/
    public function normTable($table)
    {
        return preg_replace('/{{(.*?)}}/', $this->getDbConnection()->tablePrefix . '\1', $table);
    }

    /**
     * Safely drops table having foreign keys dropped first
     *
     * @param string $table - tableName
     *
     * @return void
     */
    public function dropTableWithForeignKeys($table)
    {
        $schema = $this->getDbConnection()->schema;

        if ($schema->getTable($table) !== null) {
            $foreignKeys = (array)$this->getTableForeignKeys($table);

            // Получаем форейнкеи от которых зависит таблица:
            foreach ($schema->getTable($table)->foreignKeys as $foreignKey) {
                $foreignKeys = array_merge(
                    (array)$foreignKeys,
                    (array)$this->getTableForeignKeys($foreignKey[0])
                );
            }

            // drop foreign keys
            foreach ($foreignKeys as $tableName => $fkeys) {
                foreach ($fkeys as $foreignKey) {
                    $this->dropForeignKey($foreignKey, $tableName);
                }
            }

            // Удаляем таблицу:
            $this->dropTable($table);
        }
    }

    /**
     * get Foreign key for table
     *
     * @param string $tableName - table name for getting foreign keys
     *
     * @return array of foreign keys
     **/
    public function getTableForeignKeys($tableName)
    {
        $schema = $this->dbConnection->schema;
        $command = Yii::app()->db->createCommand();
        $foreignKeys = [];

        if (!($schema instanceof CPgsqlSchema) && !($schema instanceof CMysqlSchema)) {
            return [];
        }

        // Получаем форейн-кеи для заданной таблицы,
        // для этого выполняем запрос вида:
        //
        // SELECT conname AS fk_name
        // FROM pg_constraint t
        // LEFT JOIN pg_class ON t.conrelid  = pg_class.oid
        // WHERE contype = 'f' AND relname = '$tableName'
        //
        if ($schema instanceof CPgsqlSchema) {
            $command->select('conname AS name');
            $command->from('pg_constraint');
            $command->setJoin('LEFT JOIN  pg_class ON pg_constraint.conrelid = pg_class.oid');
            $command->where("contype = 'f' AND relname = '{$tableName}'");
        }

        // Получаем форейн-кеи для заданной таблицы,
        // для этого выполняем запрос вида:
        //
        // SELECT CONSTRAINT_NAME AS name
        // FROM information_schema.TABLE_CONSTRAINTS
        // WHERE CONSTRAINT_TYPE =  'FOREIGN KEY'
        // AND TABLE_SCHEMA =  'yupe'
        // AND TABLE_NAME =  'yupe_blog_blog'
        //
        if ($schema instanceof CMysqlSchema) {
            list(, $dbName) = explode('dbname=', Yii::app()->db->connectionString);
            $command->select('CONSTRAINT_NAME AS name');
            $command->from('information_schema.TABLE_CONSTRAINTS');
            $command->where(
                "CONSTRAINT_TYPE = :consType AND TABLE_SCHEMA = :dbName AND TABLE_NAME = :tableName",
                [
                    ':consType'  => 'FOREIGN KEY',
                    ':dbName'    => $dbName,
                    ':tableName' => $this->normTable($tableName),

                ]
            );
        }

        foreach ((array)$command->queryAll() as $fkey) {
            $foreignKeys[$this->normTable($tableName)][] = $fkey['name'];
        }

        return $foreignKeys;
    }
}
