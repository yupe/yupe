<?php
/**
 * FileDocComment
 * Yupe install migration
 * Класс миграций для модуля Yupe:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Yupe install migration
 * Класс миграций для модуля Yupe:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_yupe_base extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $this->createTable(
            $db->tablePrefix . 'settings', array(
                'id' => 'pk',
                'module_id'=> 'string NOT NULL',
                'param_name'=> 'string NOT NULL',
                'param_value' => 'string  NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'type' => "integer NOT NULL DEFAULT '1'",
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex("settings_module_id", $db->tablePrefix . 'settings', "module_id", false);
        $this->createIndex("settings_param_name", $db->tablePrefix . 'settings', "param_name", false);
        $this->createIndex("settings_param_name_uniq", $db->tablePrefix . 'settings', "module_id,param_name", true);
    }
 
    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - settings
         * @todo найти как проверять существование индексов, что бы их подчищать:
         **/

        /*
        $this->dropIndex("settings_module_id", $db->tablePrefix . 'settings');
        $this->dropIndex("settings_param_name", $db->tablePrefix . 'settings');
        $this->dropIndex("settings_param_name_uniq", $db->tablePrefix . 'settings');
        */
        if ($db->schema->getTable($db->tablePrefix . 'settings') !== null)
            $this->dropTable($db->tablePrefix . 'settings');
    }
}