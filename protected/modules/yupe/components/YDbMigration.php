<?php
class YDbMigration extends CDbMigration
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
     * SQLite ?
     *
     * @return bool true if instance of CSqliteSchema
     **/
    static function isSQLite()
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
        return self::isSQLite()
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
        if (!self::isSQLite())
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
        $normTable = $this->normTable($table);

        $columns = Yii::app()->db->schema->tables[$normTable]->columns;

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


        // Подготовка завершена, осуществляем alter-table через временную таблицу, комментарии ниже


        // для удобства, можно глобально заменить на полную строчку
        $db = Yii::app()->db;
        // получаем все STATEMENT'ы для нужной таблицы
        $statements = $db->createCommand('SELECT * FROM sqlite_master where tbl_name = :table AND sql is not NULL')->queryAll(true, array(':table'=>$normTable));
        if(empty($statements)) {
            return false; // нечего делать, не обрабатываем. достаточно?, можно заменить EXCEPTION'ом но я не знаю какой лучше подойдет
        }

        // отключаем все проверки на внешние ключи
        $db->createCommand('PRAGMA foreign_keys = off');
        $db->createCommand('PRAGMA ignore_check_constraints = on');

        $db->createCommand('DROP TABLE IF EXISTS ' . $tempTable)->execute();
        // делаем move таблицы с данными во временную таблицу
        $db->createCommand('ALTER TABLE '.$normTable.' RENAME TO '.$tempTable)->execute();
        // создаем новую таблицу со всеми нужными стейтментами
        foreach ($statements as $statement) {
            // пересоздаём связанные элементы, кто хочет, может оптимизировать и не пересоздавать все, а интеллектуально матчить по названию
            switch ($statement['type']) {
                case 'index':
                    $db->createCommand('DROP INDEX IF EXISTS '.$statement['name'])->execute();
                    break;
                case 'trigger':
                    $db->createCommand('DROP TRIGGER IF EXISTS '.$statement['name'])->execute();
                    break;
                case 'view':
                    $db->createCommand('DROP VIEW IF EXISTS '.$statement['name'])->execute();
                    break;
            }

            $sql = $statement['sql'];
            $sql = preg_replace('/\b'.$name.'\b/ui', $newName, $sql); // \b - это разделитель слова, может быть '"-, пробелом и т.д.
            $db->createCommand($sql)->execute();
        }
        // переносим данные
        $db->createCommand('INSERT INTO '.$normTable.' SELECT ' . $subQuery . ' FROM ' . $tempTable)->execute();
        // удаляем временную таблицу
        $db->createCommand('DROP TABLE IF EXISTS ' . $tempTable)->execute();
        // включаем проверки на внешние ключи
        $db->createCommand('PRAGMA foreign_keys = on');
        $db->createCommand('PRAGMA ignore_check_constraints = off');
        // обновляем схему базы данных, т.к. мы внесли изменения и они должны отразиться в кэше
        $db->schema->refresh();

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
        if (!self::isSQLite())
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
     * 
     * @param string $table - tableName
     *
     * @return void
     */
    public function dropTableWithForeignKeys($table)
    {
        $schema = $this->getDbConnection()->schema;
        
        if ($schema->getTable($table) !== null) {
            $foreignKeys = (array) $this->getTableForeignKeys($table);

            // Получаем форейнкеи от которых зависит таблица:
            foreach ($schema->getTable($table)->foreignKeys as $foreignKey) {
                $foreignKeys = array_merge(
                    (array) $foreignKeys, (array) $this->getTableForeignKeys($foreignKey[0])
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
        $schema      = $this->dbConnection->schema;
        $command     = Yii::app()->db->createCommand();
        $foreignKeys = array();
        
        if (!($schema instanceof CPgsqlSchema) && !($schema instanceof CMysqlSchema))
            return array();

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
                "CONSTRAINT_TYPE = :consType AND TABLE_SCHEMA = :dbName AND TABLE_NAME = :tableName", array(
                    ':consType'  => 'FOREIGN KEY',
                    ':dbName'    => $dbName,
                    ':tableName' => $this->normTable($tableName),

                )
            );
        }
        
        foreach ((array) $command->queryAll() as $fkey)
            $foreignKeys[$this->normTable($tableName)][] = $fkey['name'];

        return $foreignKeys;
    }
}
