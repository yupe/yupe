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
        $db = $this->getDbConnection();

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
                'name' => 'varchar(150) NOT NULL',
                'title' => 'varchar(250) NOT NULL',
                'slug' => 'varchar(150) NOT NULL',
                'body' => 'text NOT NULL',
                'keywords' => 'varchar(250) NOT NULL',
                'description' => 'varchar(250) NOT NULL',
                'status' => 'integer NOT NULL',
                'is_protected' => "boolean NOT NULL DEFAULT '0'",
                'menu_order' => "integer NOT NULL DEFAULT '0'",
            ),  $this->getOptions()
        );

        $this->createIndex("ux_{{page_page}}_slug", '{{page_page}}', "slug,lang", true);
        $this->createIndex("ix_{{page_page}}_status", '{{page_page}}', "status", false);
        $this->createIndex("ix_{{page_page}}_protected", '{{page_page}}', "is_protected", false);
        $this->createIndex("ix_{{page_page}}_user_id", '{{page_page}}', "user_id", false);
        $this->createIndex("ix_{{page_page}}_change_user_id", '{{page_page}}', "change_user_id", false);
        $this->createIndex("ix_{{page_page}}_order", '{{page_page}}', "menu_order", false);
        $this->createIndex("ix_{{page_page}}_category_id", '{{page_page}}', "category_id", false);

        $this->addForeignKey("fk_{{page_page}}_category", '{{page_page}}', 'category_id', '{{category_category}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey("fk_{{page_page}}_user", '{{page_page}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey("fk_{{page_page}}_user_change", '{{page_page}}', 'change_user_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');
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
         * Убиваем внешние ключи, индексы и таблицу - page
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне, без привязки к БД):
         **/

        if ($db->schema->getTable('{{page_page}}') !== null) {
            if (in_array( "fk_{{page_page}}_category", $db->schema->getTable('{{page_page}}')->foreignKeys))
                $this->dropForeignKey("fk_{{page_page}}_category", '{{page_page}}');
            
            if (in_array("fk_{{page_page}}_user", $db->schema->getTable('{{page_page}}')->foreignKeys))
                $this->dropForeignKey("fk_{{page_page}}_user", '{{page_page}}');

            if (in_array("fk_{{page_page}}_user_change", $db->schema->getTable('{{page_page}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{page_page}}_user_change", '{{page_page}}');
            
            $this->dropTable('{{page_page}}');
        }
    }
}