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
class m000000_000000_menu_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{menu_menu}}',
            array(
                'id' => 'pk',
                'name' => 'varchar(300) NOT NULL',
                'code' => 'string NOT NULL',
                'description' => 'varchar(300) NOT NULL',
                'status'=> "integer NOT NULL DEFAULT '1'",
            ),
            $this->getOptions()
        );

        //ix
        $this->createIndex("ux_{{menu_menu}}_code", '{{menu_menu}}', "code", true);
        $this->createIndex("ix_{{menu_menu}}_status", '{{menu_menu}}', "status", false);


        $this->createTable(
            '{{menu_menu_item}}',
            array(
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
            ),
            $this->getOptions()
        );

        $this->createIndex("ix_{{menu_menu_item}}_menu_id", '{{menu_menu_item}}', "menu_id", false);
        $this->createIndex("ix_{{menu_menu_item}}_sort", '{{menu_menu_item}}', "sort", false);
        $this->createIndex("ix_{{menu_menu_item}}_status", '{{menu_menu_item}}', "status", false);

        //fk
        $this->addForeignKey("fk_{{menu_menu_item}}_menu_id", '{{menu_menu_item}}', 'menu_id', '{{menu_menu}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * Откатываем миграцию:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{menu_menu_item}}');
        $this->dropTableWithForeignKeys('{{menu_menu}}');
    }
}