<?php

/**
 * FileDocComment
 * Category install migration
 * Класс миграций для модуля Category:
 *
 * @category YupeMigration
 * @package  yupe.modules.category.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_category_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{category_category}}',
            [
                'id'                => 'pk',
                'parent_id'         => 'integer DEFAULT NULL',
                'alias'             => 'varchar(150) NOT NULL',
                'lang'              => 'char(2) DEFAULT NULL',
                'name'              => 'varchar(250) NOT NULL',
                'image'             => 'varchar(250) DEFAULT NULL',
                'short_description' => 'text',
                'description'       => 'text NOT NULL',
                'status'            => "boolean NOT NULL DEFAULT '1'",
            ],
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{category_category}}_alias_lang", '{{category_category}}', "alias,lang", true);
        $this->createIndex("ix_{{category_category}}_parent_id", '{{category_category}}', "parent_id", false);
        $this->createIndex("ix_{{category_category}}_status", '{{category_category}}', "status", false);

        //fk
        $this->addForeignKey(
            "fk_{{category_category}}_parent_id",
            '{{category_category}}',
            'parent_id',
            '{{category_category}}',
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
        $this->dropTableWithForeignKeys('{{category_category}}');
    }
}
