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
            $db->tablePrefix . 'news', array(
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

        $this->createIndex($db->tablePrefix . "news_alias_unique", $db->tablePrefix . 'news', "alias,lang", true);
        $this->createIndex($db->tablePrefix . "news_status", $db->tablePrefix . 'news', "status", false);
        $this->createIndex($db->tablePrefix . "news_user", $db->tablePrefix . 'news', "user_id", false);
        $this->createIndex($db->tablePrefix . "news_category", $db->tablePrefix . 'news', "category_id", false);
        $this->createIndex($db->tablePrefix . "news_date", $db->tablePrefix . 'news', "date", false);

        $this->addForeignKey($db->tablePrefix . "news_user_fk", $db->tablePrefix . 'news', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "news_category_fk", $db->tablePrefix . 'news', 'category_id', $db->tablePrefix . 'category_category', 'id', 'SET NULL', 'CASCADE');

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
        if ($db->schema->getTable($db->tablePrefix . 'news') !== null) {

            /*
            $this->dropIndex($db->tablePrefix . "news_alias_unique", $db->tablePrefix . 'news');
            $this->dropIndex($db->tablePrefix . "news_status", $db->tablePrefix . 'news');
            $this->dropIndex($db->tablePrefix . "news_user", $db->tablePrefix . 'news');
            $this->dropIndex($db->tablePrefix . "news_category", $db->tablePrefix . 'news');
            $this->dropIndex($db->tablePrefix . "news_date", $db->tablePrefix . 'news');
            */

            if (in_array($db->tablePrefix . "news_user_fk", $db->schema->getTable($db->tablePrefix . 'news')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "news_user_fk", $db->tablePrefix . 'news');

            if (in_array($db->tablePrefix . "news_category_fk", $db->schema->getTable($db->tablePrefix . 'news')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "news_user_fk", $db->tablePrefix . 'news');

            $this->dropTable($db->tablePrefix . 'news');
        }
    }
}