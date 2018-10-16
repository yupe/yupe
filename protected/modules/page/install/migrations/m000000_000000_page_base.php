<?php

/**
 * m000000_000000_page_base install migration
 * Класс миграций для модуля Page:
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.install.migrations
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 1.0
 *
 */
class m000000_000000_page_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{page_page}}',
            [
                'id'             => 'pk',
                'category_id'    => 'integer DEFAULT NULL',
                'lang'           => 'char(2) DEFAULT NULL',
                'parent_id'      => 'integer DEFAULT NULL',
                'creation_date'  => 'datetime NOT NULL',
                'change_date'    => 'datetime NOT NULL',
                'user_id'        => 'integer  DEFAULT NULL',
                'change_user_id' => 'integer DEFAULT NULL',
                'name'           => 'varchar(150) NOT NULL',
                'title'          => 'varchar(250) NOT NULL',
                'slug'           => 'varchar(150) NOT NULL',
                'body'           => 'text NOT NULL',
                'keywords'       => 'varchar(250) NOT NULL',
                'description'    => 'varchar(250) NOT NULL',
                'status'         => 'integer NOT NULL',
                'is_protected'   => "boolean NOT NULL DEFAULT '0'",
                'menu_order'     => "integer NOT NULL DEFAULT '0'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{page_page}}_slug_lang", '{{page_page}}', "slug,lang", true);
        $this->createIndex("ix_{{page_page}}_status", '{{page_page}}', "status", false);
        $this->createIndex("ix_{{page_page}}_is_protected", '{{page_page}}', "is_protected", false);
        $this->createIndex("ix_{{page_page}}_user_id", '{{page_page}}', "user_id", false);
        $this->createIndex("ix_{{page_page}}_change_user_id", '{{page_page}}', "change_user_id", false);
        $this->createIndex("ix_{{page_page}}_menu_order", '{{page_page}}', "menu_order", false);
        $this->createIndex("ix_{{page_page}}_category_id", '{{page_page}}', "category_id", false);

        //fk
        $this->addForeignKey(
            "fk_{{page_page}}_category_id",
            '{{page_page}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{page_page}}_user_id",
            '{{page_page}}',
            'user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{page_page}}_change_user_id",
            '{{page_page}}',
            'change_user_id',
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
        $this->dropTableWithForeignKeys("{{page_page}}");
    }
}
