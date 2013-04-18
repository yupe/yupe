<?php
class YDbMigration extends CDbMigration
{
    public function getOptions()
    {
    	return Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
    }

    /**
     * SQLite ?
     *
     * @return bool true if instance of CSqliteSchema
     **/
    static public function isSQLite()
    {
        return Yii::app()->db->schema instanceof CSqliteSchema;
    }

    /**
     * addForeignKey 
     *
     * @param string $name       - имя внешнего ключа
     * @param string $table      - таблица, к которой будет добавлен внешний ключ
     * @param string $columns    - имя столбца, для которого будет добавлено ограничение. Если это несколько
     * столбцов, то они должны быть разделены запятыми
     * @param string $refTable   - таблица, на которую ссылается внешний ключ
     * @param string $refColumns - имя столбца, на который ссылается внешний ключ. Если это несколько
     * столбцов, то они должны быть разделены запятыми
     * @param string $delete     - опция ON DELETE. Большинство СУБД поддерживают данные опции: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
     * @param string $update     - опция ON UPDATE. Большинство СУБД поддерживают данные опции: RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
     *
     * @return desctription of returned
     **/
    public function addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete=null, $update=null)
    {
        return $this->isSQLite()
            ? false
            : parent::addForeignKey($name, $table, $columns, $refTable, $refColumns, $delete, $update);
    }

    /**
     * Заглушка renameColumn для SQLite 
     *
     * @param string $table   - the table whose column is to be renamed. The name will be properly quoted by the method.
     * @param string $name    - the old name of the column. The name will be properly quoted by the method.
     * @param string $newName - the new name of the column. The name will be properly quoted by the method.
     *
     * @return desctription of returned
     **/
    public function renameColumn($table, $name, $newName)
    {
        if (!$this->isSQLite())
            return parent::renameColumn($table, $name, $newName);

        /**
         * Данный код выполняет следующее:
         *
         * - получаем список всех полей таблицы
         * - проходим по списку и обрабатываем
         *   квотим все поля, а то которое переименовываем
         *   подменяем на нужное нам
         * - выполняем запрос
         *   1. удаляем временную таблицу, если таковая есть
         *   2. создаём новую таблицу из выборки
         *   3. удаляем старую таблицу
         *   4. переименовываем временную таблицу в старую
         *
         * это позволяет добиться эфекта переименования полей
         */
        $columns = Yii::app()->db->schema->tables[$this->normTable($table)]->columns;

        $cNames = array_keys($columns);

        $subQuery = implode(
            ', ', array_map(
                function ($a) use ($name, $newName) {
                    return $a == $name
                        ? Yii::app()->db->schema->quoteColumnName($name) . ' as ' . Yii::app()->db->schema->quoteColumnName($newName)
                        : Yii::app()->db->schema->quoteColumnName($a);
                }, $cNames
            )
        );
        $tempTable = $this->normTable($table) . '_temporary';
        Yii::app()->db->createCommand(
            'drop table if exists ' . $tempTable . ';'
            . 'create table ' . $tempTable . ' as select ' . $subQuery . ' from ' . $this->normTable($table) . ';'
            . 'drop table ' . $this->normTable($table) . ';'
            . 'alter table ' . $tempTable . ' rename to ' . $this->normTable($table) . ';'
        )->query();

        return true;
    }

    /**
     * Создает SQL-выражение для удаления столбца таблицы (доработан для SQLite).
     * 
     * @param string $table  - таблица, столбец которой будет удален. Имя будет заключено в кавычки
     * @param string $column - имя удаляемого столбца. Имя будет заключено в кавычки
     * 
     * @return string SQL-выражение для удаления столбца таблицы
     * 
     * @since 1.1.6
     */
    public function dropColumn($table, $column)
    {
        if (!$this->isSQLite())
            return parent::dropColumn($table, $column);

        /**
         * Данный код выполняет следующее:
         *
         * - получаем список всех полей таблицы
         * - проходим по списку и обрабатываем
         *   квотим все поля, а то которое удаляем убираем
         *   из массива
         * - выполняем запрос
         *   1. удаляем временную таблицу, если таковая есть
         *   2. создаём новую таблицу из выборки
         *   3. удаляем старую таблицу
         *   4. переименовываем временную таблицу в старую
         *
         * это позволяет добиться эфекта переименования полей
         */
        $columns = Yii::app()->db->schema->tables[$this->normTable($table)]->columns;

        $cNames = array_diff(
            array_keys($columns), array($column)
        );


        $subQuery = implode(
            ', ', array_map(
                function ($a) {
                    return Yii::app()->db->schema->quoteColumnName($a);
                }, $cNames
            )
        );

        $tempTable = $this->normTable($table) . '_temporary';
        
        Yii::app()->db->createCommand(
            'drop table if exists ' . $tempTable . ';'
            . 'create table ' . $tempTable . ' as select ' . $subQuery . ' from ' . $this->normTable($table) . ';'
            . 'drop table ' . $this->normTable($table) . ';'
            . 'alter table ' . $tempTable . ' rename to ' . $this->normTable($table) . ';'
        )->query();

        return true;
    }

    /**
     * Обёртка для CDbExpression
     *
     * @param string $exp    - выполняемый запрос
     * @param array  $params - параметры
     *
     * @return CDbExpression
     **/
    static public function expression($exp = null, $params=array())
    {
        $replacements = array(
            'NOW()' => 'DATETIME("now")',
        );

        return new CDbExpression(
            self::isSQLite() && isset($replacements[$exp])
            ? $replacements[$exp]
            : $exp,
            $params
        );
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
}
