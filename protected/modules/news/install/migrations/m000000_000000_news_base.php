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
        $db = $this->getDbConnection();

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
                'title' => 'varchar(250) NOT NULL',
                'alias' => 'varchar(150) NOT NULL',
                'short_text' => 'text',
                'full_text' => 'text NOT NULL',
                'image' => 'varchar(300) DEFAULT NULL',
                'link' => 'varchar(300) DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'status' => "integer NOT NULL DEFAULT '0'",
                'is_protected' => "boolean NOT NULL DEFAULT '0'",
                'keywords' => 'varchar(250) NOT NULL',
                'description' => 'varchar(250) NOT NULL',
            ), $this->getOptions()
        );

        $this->createIndex("ux_{{news_news}}_alias", $db->tablePrefix . 'news', "alias,lang", true);
        $this->createIndex("ix_{{news_news}}_status", $db->tablePrefix . 'news', "status", false);
        $this->createIndex("ix_{{news_news}}_user", $db->tablePrefix . 'news', "user_id", false);
        $this->createIndex("ix_{{news_news}}_category", $db->tablePrefix . 'news', "category_id", false);
        $this->createIndex("ix_{{news_news}}_date", $db->tablePrefix . 'news', "date", false);

        $this->addForeignKey("fk_{{news_news}}_user", '{{news_news}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey("fk_{{news_news}}_category", '{{news_news}}', 'category_id', '{{category_category}}', 'id', 'SET NULL', 'CASCADE');

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
         * Убиваем внешние ключи, индексы и таблицу - news
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable('{{news_news}}') !== null) {

            if (in_array("fk_{{news_news}}_user", $db->schema->getTable('{{news_news}}')->foreignKeys))
                $this->dropForeignKey("fk_{{news_news}}_user", '{{news_news}}');

            if (in_array("fk_{{news_news}}_category", $db->schema->getTable('{{news_news}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{news_news}}_user", '{{news_news}}');

            $this->dropTable( '{{news_news}}');
        }
    }
}