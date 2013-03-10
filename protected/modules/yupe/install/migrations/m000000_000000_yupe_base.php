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
class m000000_000000_yupe_base extends YDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {        
        $this->createTable('{{yupe_settings}}', array(
                'id' => 'pk',
                'module_id'=> 'varchar(100) NOT NULL',
                'param_name'=> 'varchar(100) NOT NULL',
                'param_value' => 'varchar(255) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'type' => "integer NOT NULL DEFAULT '1'",
            ), $this->getOptions()
        );

        $this->createIndex("ix_{{yupe_settings}}_module_id",'{{yupe_settings}}', "module_id", false);
        $this->createIndex("ix_{{yupe_settings}}_param_name",'{{yupe_settings}}', "param_name", false);
        $this->createIndex("ux_{{yupe_settings}}_param_name",'{{yupe_settings}}', "module_id,param_name", true);
    }
 
    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropTable('{{yupe_settings}}');
    }
}