<?php
/**
 * File Doc Comment
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Menu install migration
 * Класс миграций для модуля Menu:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_menu_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        /**
         * menu:
         **/
        $this->createTable(
            '{{menu_menu}}', array(
                'id' => 'pk',
                'name' => 'varchar(300) NOT NULL',
                'code' => 'string NOT NULL',
                'description' => 'varchar(300) NOT NULL',
                'status'=> "integer NOT NULL DEFAULT '1'",
            ), $this->getOptions()
        );

        $this->createIndex("{{menu_menu_code_unique}}", "{{menu_menu}}", "code", true);
        $this->createIndex("{{menu_menu_status}}", "{{menu_menu}}", "status", false);

        /**
         * menu_item:
         **/
        $this->createTable(
            '{{menu_menu_item}}', array(
                'id' => 'pk',
                'parent_id' => 'integer NOT NULL',
                'menu_id' => 'integer NOT NULL',
                'title' => 'string NOT NULL',
                'href' => 'string NOT NULL',
                'class' => 'string NOT NULL',
                'title_attr' => 'string NOT NULL',
                'before_link' => 'string NOT NULL',
                'after_link' => 'string NOT NULL',
                'target' => 'string NOT NULL',
                'rel' => 'string NOT NULL',
                'condition_name' => "string DEFAULT '0'",
                'condition_denial' => "integer DEFAULT '0'",
                'sort' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '1'",
            ), $this->getOptions()
        );

        // ix
        $this->createIndex("ix_{{menu_menu_item_menuid}}", "{{menu_menu_item}}", "menu_id", false);
        $this->createIndex("ix_{{menu_menu_item_sort}}", "{{menu_menu_item}}", "sort", false);
        $this->createIndex("ix_{{menu_menu_item_status}}", "{{menu_menu_item}}", "status", false);

        // fk
        $this->addForeignKey(
            "fk_{{menu_item_menu}}",
            "{{menu_menu_item}}",
            'menu_id',
            '{{menu_menu}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropTable('{{menu_menu}}');
        $this->dropTable('{{menu_menu_item}}');
    }
}