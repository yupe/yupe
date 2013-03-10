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
        $db = $this->getDbConnection();
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

        $this->createIndex("ux_{{menu_menu}}_code", $db->tablePrefix . 'menu', "code", true);
        $this->createIndex("ix_{{menu_menu}}_status", $db->tablePrefix . 'menu', "status", false);

        /**
         * menu_item:
         **/
        $this->createTable(
            '{{menu_menu_item}}', array(
                'id' => 'pk',
                'parent_id' => 'integer NOT NULL',
                'menu_id' => 'integer NOT NULL',
                'title' => 'varchar(150) NOT NULL',
                'href' => 'varchar(150) NOT NULL',
                'class' => 'varchar(150) NOT NULL',
                'title_attr' => 'varchar(150) NOT NULL',
                'before_link' => 'varchar(150) NOT NULL',
                'after_link' => 'varchar(150) NOT NULL',
                'target' => 'varchar(150) NOT NULL',
                'rel' => 'varchar(150) NOT NULL',
                'condition_name' => "varchar(150) DEFAULT '0'",
                'condition_denial' => "integer DEFAULT '0'",
                'sort' => "integer NOT NULL DEFAULT '1'",
                'status' => "integer NOT NULL DEFAULT '1'",
            ), $this->getOptions()
        );

        $this->createIndex("ix_{{menu_menu_item}}_menuid", '{{menu_menu_item}}', "menu_id", false);
        $this->createIndex("ix_{{menu_menu_item}}_sort",   '{{menu_menu_item}}', "sort"   , false);
        $this->createIndex("ix_{{menu_menu_item}}_status", '{{menu_menu_item}}', "status" , false);

        $this->addForeignKey("fk_{{menu_menu_item}}_menu", '{{menu_menu_item}}', 'menu_id', '{{menu_menu}}', 'id', 'CASCADE', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{menu_menu_item}}') !== null) {

            if (in_array("fk_{{menu_menu_item}}_menu", $db->schema->getTable('{{menu_menu_item}}')->foreignKeys))
                $this->dropForeignKey("fk_{{menu_menu_item}}_menu", '{{menu_menu_item}}');

            $this->dropTable('{{menu_menu_item}}');
        }
        
        /**
         * Убиваем внешние ключи, индексы и таблицу - mail_event
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{menu_menu}}') !== null) {

            $this->dropTable('{{menu_menu}}');
        }
    }
}