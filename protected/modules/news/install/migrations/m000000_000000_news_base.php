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
class m000000_000000_news_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
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
            ), $options
        );

        $this->createIndex("{{news_news_alias_unique}}", "{{news_news}}", "alias,lang", true);
        $this->createIndex("{{news_news_status}", "{{news_news}}", "status", false);
        $this->createIndex("{{news_news_user}}", "{{news_news}}", "user_id", false);
        $this->createIndex("{{news_news_category}}", "{{news_news}}", "category_id", false);
        $this->createIndex("{{news_news_date}}", "{{news_news}}", "date", false);

        $this->addForeignKey("{{news_news_user_fk}}", "{{news_news}}", 'user_id', "{{user}}", 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey("{{news_news_category_fk}}", "{{news_news}}", 'category_id', "{{category_category}}", 'id', 'SET NULL', 'CASCADE');
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