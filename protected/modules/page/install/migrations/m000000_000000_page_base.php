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
class m000000_000000_page_base extends CDbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        $db = $this->getDbConnection();
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $this->createTable(
            $db->tablePrefix . 'page_page', array(
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
            ), $options
        );

        $this->createIndex($db->tablePrefix . "page_page_slug_uniq", $db->tablePrefix . 'page_page', "slug,lang", true);
        $this->createIndex($db->tablePrefix . "page_page_status", $db->tablePrefix . 'page_page', "status", false);
        $this->createIndex($db->tablePrefix . "page_page_protected", $db->tablePrefix . 'page_page', "is_protected", false);
        $this->createIndex($db->tablePrefix . "page_page_user_id", $db->tablePrefix . 'page_page', "user_id", false);
        $this->createIndex($db->tablePrefix . "page_page_change_user_id", $db->tablePrefix . 'page_page', "change_user_id", false);
        $this->createIndex($db->tablePrefix . "page_page_order", $db->tablePrefix . 'page_page', "menu_order", false);
        $this->createIndex($db->tablePrefix . "page_page_category_id", $db->tablePrefix . 'page_page', "category_id", false);

        $this->addForeignKey($db->tablePrefix . "page_page_category_fk", $db->tablePrefix . 'page_page', 'category_id', $db->tablePrefix . 'category_category', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "page_page_user_fk", $db->tablePrefix . 'page_page', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "page_page_user_change_fk", $db->tablePrefix . 'page_page', 'change_user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');
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
        /*
        $this->dropIndex($db->tablePrefix . "page_slug_uniq", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_status", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_protected", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_user_id", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_change_user_id", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_order", $db->tablePrefix . 'page');
        $this->dropIndex($db->tablePrefix . "page_category_id", $db->tablePrefix . 'page');
        */

        if ($db->schema->getTable($db->tablePrefix . 'page_page') !== null) {
            if (in_array($db->tablePrefix . "page_page_user_recovery_uid_fk", $db->schema->getTable($db->tablePrefix . 'page_page')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "page_page_category_fk", $db->tablePrefix . 'page_page');
            
            if (in_array($db->tablePrefix . "page_page_user_fk", $db->schema->getTable($db->tablePrefix . 'page_page')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "page_page_user_fk", $db->tablePrefix . 'page_page');

            if (in_array($db->tablePrefix . "page_page_user_change_fk", $db->schema->getTable($db->tablePrefix . 'page_page')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "page_page_user_change_fk", $db->tablePrefix . 'page_page');
            
            $this->dropTable($db->tablePrefix.'page_page');
        }
    }
}