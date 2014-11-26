<?php

/**
 * Yupe install migration
 * Класс миграций для модуля Yupe
 *
 * @category YupeMigration
 * @package yupe.modules.user.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_yupe_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{yupe_settings}}',
            [
                'id'            => 'pk',
                'module_id'     => 'varchar(100) NOT NULL',
                'param_name'    => 'varchar(100) NOT NULL',
                'param_value'   => 'varchar(255) NOT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date'   => 'datetime NOT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'type'          => "integer NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex(
            "ux_{{yupe_settings}}_module_id_param_name",
            '{{yupe_settings}}',
            "module_id,param_name",
            true
        );
        $this->createIndex("ix_{{yupe_settings}}_module_id", '{{yupe_settings}}', "module_id", false);
        $this->createIndex("ix_{{yupe_settings}}_param_name", '{{yupe_settings}}', "param_name", false);

        //fk
        $this->addForeignKey(
            "fk_{{yupe_settings}}_user_id",
            '{{yupe_settings}}',
            'user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{yupe_settings}}');
    }
}
