<?php
/**
 * FileDocComment
 * Catalog install migration
 * Класс миграций для модуля Catalog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Catalog install migration
 * Класс миграций для модуля Catalog:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_good_base extends CDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();

        $this->createTable(
            $db->tablePrefix . 'good', array(
                'id' => 'pk',
                'category_id' => 'integer NOT NULL',
                'name' => 'string NOT NULL',
                'price' => "decimal(19,3) NOT NULL DEFAULT '0'",
                'article' => 'string DEFAULT NULL',
                'image' => 'varchar(300) DEFAULT NULL',
                'short_description' => 'text',
                'description' => 'text NOT NULL',
                'alias' => 'string NOT NULL',
                'data' => 'text',
                'is_special' => "boolean NOT NULL DEFAULT '0'",
                'status' => "smallint(1) unsigned NOT NULL DEFAULT '1'",
                'create_time' => 'datetime NOT NULL',
                'update_time' => 'datetime NOT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'change_user_id' => 'integer DEFAULT NULL',
            ), "ENGINE=InnoDB DEFAULT CHARSET=utf8"
        );

        $this->createIndex($db->tablePrefix . "good_alias_uniq", $db->tablePrefix . 'good', "alias", true);
        $this->createIndex($db->tablePrefix . "good_status", $db->tablePrefix . 'good', "status", false);
        $this->createIndex($db->tablePrefix . "good_category", $db->tablePrefix . 'good', "category_id", false);
        $this->createIndex($db->tablePrefix . "good_user", $db->tablePrefix . 'good', "user_id", false);
        $this->createIndex($db->tablePrefix . "good_change_user", $db->tablePrefix . 'good', "change_user_id", false);
        $this->createIndex($db->tablePrefix . "good_article", $db->tablePrefix . 'good', "article", false);
        $this->createIndex($db->tablePrefix . "good_price", $db->tablePrefix . 'good', "price", false);

        $this->addForeignKey($db->tablePrefix . "good_user_fk", $db->tablePrefix . 'good', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "good_change_user_fk", $db->tablePrefix . 'good', 'change_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "good_category_fk", $db->tablePrefix . 'good', 'category_id', $db->tablePrefix . 'category', 'id', 'RESTRICT', 'CASCADE');
    }
 
    /**
     * Откат миграции:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - good
         * @todo найти как проверять существование индексов, что бы их подчищать (на абстрактном уровне без привязки к типу БД):
         **/
        if ($db->schema->getTable($db->tablePrefix . 'good') !== null) {
            
            if (in_array($db->tablePrefix . "good_user_fk", $db->schema->getTable($db->tablePrefix . 'good')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "good_user_fk", $db->tablePrefix . 'good');
            
            if (in_array($db->tablePrefix . "good_change_user_fk", $db->schema->getTable($db->tablePrefix . 'good')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "good_change_user_fk", $db->tablePrefix . 'good');

            if (in_array($db->tablePrefix . "good_category_fk", $db->schema->getTable($db->tablePrefix . 'good')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "good_category_fk", $db->tablePrefix . 'good');
            /*
            $this->dropIndex($db->tablePrefix . "good_alias_uniq", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_status", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_category", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_user", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_change_user", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_article", $db->tablePrefix . 'good');
            $this->dropIndex($db->tablePrefix . "good_price", $db->tablePrefix . 'good');
            */
            
            $this->dropTable($db->tablePrefix . 'good');
        }
    }
}