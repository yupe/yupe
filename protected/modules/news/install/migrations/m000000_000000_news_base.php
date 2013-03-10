<?php
/**
 * File Doc Comment
 * News install migration
 * Класс миграций для модуля News:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * News install migration
 * Класс миграций для модуля News:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_news_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        /**
         * news:
         **/
        $this->createTable(
            '{{news_news}}', array(
                'id' => 'pk',
                'category_id' => 'integer DEFAULT NULL',
                'lang' => 'char(2) DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date' => 'datetime NOT NULL',
                'date' => 'date NOT NULL',
                'title' => 'string NOT NULL',
                'alias' => 'string NOT NULL',
                'short_text' => 'text',
                'full_text' => 'text NOT NULL',
                'image' => 'varchar(300) DEFAULT NULL',
                'link' => 'varchar(300) DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'status' => "integer NOT NULL DEFAULT '0'",
                'is_protected' => "boolean NOT NULL DEFAULT '0'",
                'keywords' => 'string NOT NULL',
                'description' => 'string NOT NULL',
            ), $this->getOptions()
        );

        // ix, ux
        $this->createIndex("ux_{{news_news}}_alias_lang", "{{news_news}}", "alias,lang", true);
        $this->createIndex("ix_{{news_news}}_status", "{{news_news}}", "status", false);
        $this->createIndex("ix_{{news_news}}_user", "{{news_news}}", "user_id", false);
        $this->createIndex("ix_{{news_news}}_category", "{{news_news}}", "category_id", false);
        $this->createIndex("ix_{{news_news}}_date", "{{news_news}}", "date", false);

        // fk
        $this->addForeignKey(
            "fk_{{news_news}}_user",
            "{{news_news}}",
            "user_id",
            "{{user}}", 
            "id",
            "SET NULL",
            "CASCADE"
        );
        $this->addForeignKey(
            "fk_{{news_news}}_category",
            "{{news_news}}",
            "category_id", 
            "{{category_category}}", 
            "id",
            "SET NULL",
            "CASCADE"
        );
    }
 
    /**
     * Откатываем миграцию:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $this->dropTable("{{news_news}}");    
    }
}