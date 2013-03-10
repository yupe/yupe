<?php
/**
 * FileDocComment
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Page install migration
 * Класс миграций для модуля Page:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_page_base extends YDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{page_page}}', array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'lang' => 'char(2) DEFAULT NULL',
                'parent_id' => 'integer DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date' => 'datetime NOT NULL',
                'user_id' => 'integer  DEFAULT NULL',
                'change_user_id' => 'integer DEFAULT NULL',
                'name' => 'string NOT NULL',
                'title' => 'string NOT NULL',
                'slug' => 'string NOT NULL',
                'body' => 'text NOT NULL',
                'keywords' => 'string NOT NULL',
                'description' => 'string NOT NULL',
                'status' => 'integer NOT NULL',
                'is_protected' => "boolean NOT NULL DEFAULT '0'",
                'menu_order' => "integer NOT NULL DEFAULT '0'",
            ), $this->getOptions()
        );

        // ix, ux
        $this->createIndex("ux_{{page_page_slug_lang}}", "{{page_page}}", "slug,lang", true);
        $this->createIndex("ix_{{page_page_status}}", "{{page_page}}", "status", false);
        $this->createIndex("ix_{{page_page_protected}}", "{{page_page}}", "is_protected", false);
        $this->createIndex("ix_{{page_page_user_id}}", "{{page_page}}", "user_id", false);
        $this->createIndex("ix_{{page_page_change_user_id}}", "{{page_page}}", "change_user_id", false);
        $this->createIndex("ix_{{page_page_order}}", "{{page_page}}", "menu_order", false);
        $this->createIndex("ix_{{page_page_category_id}}", "{{page_page}}", "category_id", false);

        // fk
        $this->addForeignKey(
            "fk_{{page_page_category}}",
            "{{page_page}}",
            "category_id",
            "{{category_category}}",
            "id",
            "SET NULL",
            "CASCADE"
        );
        $this->addForeignKey(
            "fk_{{page_page_user}}",
            "{{page_page}}", "user_id",
            "{{user}}",
            "id", 
            "SET NULL", 
            "CASCADE"
        );
        $this->addForeignKey(
            "fk_{{page_page_user_change}}",
            "{{page_page}}",
            "change_user_id",
            "{{user}}",
            "id",
            "SET NULL",
            "CASCADE"
        );
    }
 
    /**
     * Функция удаления таблицы:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropTable("{{page_page}}");
    }
}