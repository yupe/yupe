<?php
/**
 * Dictionary install migration
 * Класс миграций для модуля Dictionary:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Dictionary install migration
 * Класс миграций для модуля Dictionary:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 */
class m000000_000000_dictionary_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            $db->tablePrefix . 'dictionary_group', array(
                'id' => 'pk',
                'code' => 'string NOT NULL',
                'name' => "string NOT NULL",
                'description' => "varchar(300) NOT NULL DEFAULT ''",
                'creation_date' => 'datetime NOT NULL',
                'update_date' => 'datetime NOT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
            ), $options
        );

        $this->createIndex($db->tablePrefix . "dictionary_group_code_unique", $db->tablePrefix . 'dictionary_group', "code", true);
        $this->createIndex($db->tablePrefix . "dictionary_group_create_user_id", $db->tablePrefix . 'dictionary_group', "create_user_id", false);
        $this->createIndex($db->tablePrefix . "dictionary_group_update_user_id", $db->tablePrefix . 'dictionary_group', "update_user_id", false);

        $this->addForeignKey($db->tablePrefix . "dictionary_group_createuser_id_fk", $db->tablePrefix . 'dictionary_group', 'create_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "dictionary_group_updateuser_id_fk", $db->tablePrefix . 'dictionary_group', 'update_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');

        /**
         * Dictionary_data
         **/
        $this->createTable(
            $db->tablePrefix . 'dictionary_data', array(
                'id' => 'pk',
                'group_id' => 'integer NOT NULL',
                'code' => 'string NOT NULL',
                'name' => 'string NOT NULL',
                'value' => 'string NOT NULL',
                'description' => "varchar(300) NOT NULL DEFAULT ''",
                'creation_date' => 'datetime NOT NULL',
                'update_date' => 'datetime NOT NULL',
                'create_user_id' => 'integer DEFAULT NULL',
                'update_user_id' => 'integer DEFAULT NULL',
                'status' => "integer NOT NULL DEFAULT '1'",
            ), $options
        );

        $this->createIndex($db->tablePrefix . "dictionary_data_code_unique", $db->tablePrefix . 'dictionary_data', "code", true);
        $this->createIndex($db->tablePrefix . "dictionary_data_group_id", $db->tablePrefix . 'dictionary_data', "group_id", false);
        $this->createIndex($db->tablePrefix . "dictionary_data_create_user_id", $db->tablePrefix . 'dictionary_data', "create_user_id", false);
        $this->createIndex($db->tablePrefix . "dictionary_data_update_user_id", $db->tablePrefix . 'dictionary_data', "update_user_id", false);
        $this->createIndex($db->tablePrefix . "dictionary_data_status", $db->tablePrefix . 'dictionary_data', "status", false);

        $this->addForeignKey($db->tablePrefix . "dictionary_data_createuser_id_fk", $db->tablePrefix . 'dictionary_data', 'create_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "dictionary_data_updateuser_id_fk", $db->tablePrefix . 'dictionary_data', 'update_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "dictionary_data_group_id_fk", $db->tablePrefix . 'dictionary_data', 'group_id', $db->tablePrefix . 'dictionary_group', 'id', 'CASCADE', 'CASCADE');

    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();
        /**
         * Убиваем внешние ключи, индексы и таблицу - dictionary_group
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'dictionary_group') !== null) {
            /*
            $this->dropIndex($db->tablePrefix . "dictionary_group_code_unique", $db->tablePrefix . 'dictionary_group');
            $this->dropIndex($db->tablePrefix . "dictionary_group_create_user_id", $db->tablePrefix . 'dictionary_group');
            $this->dropIndex($db->tablePrefix . "dictionary_group_update_user_id", $db->tablePrefix . 'dictionary_group');
            */
            if (in_array($db->tablePrefix . "dictionary_group_createuser_id", $db->schema->getTable($db->tablePrefix . 'dictionary_group')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "dictionary_group_createuser_id", $db->tablePrefix . 'dictionary_group');
            if (in_array($db->tablePrefix . "dictionary_group_updateuser_id", $db->schema->getTable($db->tablePrefix . 'dictionary_group')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "dictionary_group_updateuser_id", $db->tablePrefix . 'dictionary_group');
            $this->dropTable($db->tablePrefix . 'dictionary_group');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - dictionary_data
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'dictionary_data') !== null) {
            if (in_array($db->tablePrefix . "dictionary_data_createuser_id", $db->schema->getTable($db->tablePrefix . 'dictionary_group')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "dictionary_data_createuser_id", $db->tablePrefix . 'dictionary_data');
            if (in_array($db->tablePrefix . "dictionary_data_updateuser_id", $db->schema->getTable($db->tablePrefix . 'dictionary_group')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "dictionary_data_updateuser_id", $db->tablePrefix . 'dictionary_data');
            if (in_array($db->tablePrefix . "dictionary_data_group_id", $db->schema->getTable($db->tablePrefix . 'dictionary_group')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "dictionary_data_group_id", $db->tablePrefix . 'dictionary_data');
            /*
            $this->dropIndex($db->tablePrefix . "dictionary_data_code_unique", $db->tablePrefix . 'dictionary_data');
            $this->dropIndex($db->tablePrefix . "dictionary_data_group_id", $db->tablePrefix . 'dictionary_data');
            $this->dropIndex($db->tablePrefix . "dictionary_data_create_user_id", $db->tablePrefix . 'dictionary_data');
            $this->dropIndex($db->tablePrefix . "dictionary_data_update_user_id", $db->tablePrefix . 'dictionary_data');
            $this->dropIndex($db->tablePrefix . "dictionary_data_status", $db->tablePrefix . 'dictionary_data');
            */
            $this->dropTable($db->tablePrefix . 'dictionary_data');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - content_block
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'dictionary') !== null) {
            $this->dropTable($db->tablePrefix . 'dictionary');
        }
    }
}