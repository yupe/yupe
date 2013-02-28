<?php
/**
 * FileDocComment
 * Yeeki install migration
 * Класс миграций для модуля Yeeki:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * Yeeki install migration
 * Класс миграций для модуля Yeeki:
 *
 * @category YupeMigration
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_yeeki_base extends CDbMigration
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
         * wiki_page:
         **/
        $this->createTable(
            $db->tablePrefix . 'wiki_page', array(
                'id' => 'pk',
                'is_redirect' => "boolean DEFAULT '0'",
                'page_uid' => 'string DEFAULT NULL',
                'namespace' => 'string DEFAULT NULL',
                'content' => 'text',
                'revision_id' => 'integer DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
                'updated_at' => 'integer DEFAULT NULL',
            ), $options
        );

        $this->createIndex($db->tablePrefix . "wiki_page_revision_idx", $db->tablePrefix . 'wiki_page', "revision_id", false);
        $this->createIndex($db->tablePrefix . "wiki_page_uid", $db->tablePrefix . 'wiki_page', "user_id", false);
        $this->createIndex($db->tablePrefix . "wiki_page_namespace", $db->tablePrefix . 'wiki_page', "namespace", false);
        $this->createIndex($db->tablePrefix . "wiki_page_created", $db->tablePrefix . 'wiki_page', "created_at", false);
        $this->createIndex($db->tablePrefix . "wiki_page_updated", $db->tablePrefix . 'wiki_page', "updated_at", false);

        $this->addForeignKey($db->tablePrefix . "wiki_page_user_fk", $db->tablePrefix . 'wiki_page', 'user_id', $db->tablePrefix . 'user', 'id', 'SET NULL', 'CASCADE');

        /**
         * wiki_page_revision:
         **/
        $this->createTable(
            $db->tablePrefix . 'wiki_page_revision', array(
                'id' => 'pk',
                'page_id' => 'integer NOT NULL',
                'comment' => 'string DEFAULT NULL',
                'is_minor' => 'boolean DEFAULT NULL',
                'content' => 'text',
                'user_id' => 'string DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
            ), $options
        );
        $this->createIndex($db->tablePrefix . "wiki_page_revision_pageid", $db->tablePrefix . 'wiki_page_revision', "page_id", false);
        $this->addForeignKey($db->tablePrefix . "wiki_page_revision_page_fk", $db->tablePrefix . 'wiki_page_revision', 'page_id', $db->tablePrefix . 'wiki_page', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "wiki_page_revision_fk", $db->tablePrefix . "wiki_page", 'revision_id', $db->tablePrefix . 'wiki_page_revision', 'id', 'CASCADE', 'CASCADE');

        /**
         * wiki_link
         **/
        $this->createTable(
            $db->tablePrefix . 'wiki_link', array(
                'id' => 'pk',
                'page_from_id' => 'integer NOT NULL',
                'page_to_id' => 'integer DEFAULT NULL',
                'wiki_uid' => 'string DEFAULT NULL',
                'title' =>  'string DEFAULT NULL'
            ), $options
        );

        $this->createIndex($db->tablePrefix . "wiki_link_code_unique", $db->tablePrefix . 'wiki_link', "page_from_id", false);
        $this->createIndex($db->tablePrefix . "wiki_link_status", $db->tablePrefix . 'wiki_link', "page_to_id", false);
        $this->createIndex($db->tablePrefix . "wiki_link_uid", $db->tablePrefix . 'wiki_link', "wiki_uid", false);

        $this->addForeignKey($db->tablePrefix . "wiki_link_page_from_fk", $db->tablePrefix . 'wiki_link', 'page_from_id', $db->tablePrefix . 'wiki_page', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey($db->tablePrefix . "wiki_link_page_to_fk", $db->tablePrefix . 'wiki_link', 'page_to_id', $db->tablePrefix . 'wiki_page', 'id', 'CASCADE', 'CASCADE');
    }
 
    /**
     * Откатываем страницу:
     *
     * @return nothing
     **/
    public function safeDown()
    {
        $db = $this->getDbConnection();

        /**
         * Убиваем внешние ключи, индексы и таблицу - wiki_page_revision
         * @todo найти как проверять существование индексов, что бы их подчищать:
         **/

        if ($db->schema->getTable($db->tablePrefix . 'wiki_page_revision') !== null) {
            
            /*
            $this->dropIndex($db->tablePrefix . "wiki_page_revision_pageid", $db->tablePrefix . 'wiki_page_revision');
            */

            if (in_array($db->tablePrefix . "wiki_page_revision_pagefk", $db->schema->getTable($db->tablePrefix . 'wiki_page_revision')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "wiki_page_revision_pagefk", $db->tablePrefix . 'wiki_page_revision');

            if (in_array($db->tablePrefix . "wiki_page_revision_fk", $db->schema->getTable($db->tablePrefix . 'wiki_page_revision')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "wiki_page_revision_fk", $db->tablePrefix . 'wiki_page_revision');

            $this->dropTable($db->tablePrefix . 'wiki_page_revision');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - wiki_page
         * @todo найти как проверять существование индексов, что бы их подчищать:
         **/

        if ($db->schema->getTable($db->tablePrefix . 'wiki_page') !== null) {
            
            /*
            $this->dropIndex($db->tablePrefix . "wiki_page_revision", $db->tablePrefix . 'wiki_page');
            $this->dropIndex($db->tablePrefix . "wiki_page_uid", $db->tablePrefix . 'wiki_page');
            $this->dropIndex($db->tablePrefix . "wiki_page_namespace", $db->tablePrefix . 'wiki_page');
            $this->dropIndex($db->tablePrefix . "wiki_page_created", $db->tablePrefix . 'wiki_page');
            $this->dropIndex($db->tablePrefix . "wiki_page_updated", $db->tablePrefix . 'wiki_page');
            */

            if (in_array($db->tablePrefix . "wiki_page_user_fk", $db->schema->getTable($db->tablePrefix . 'wiki_page')->foreignKeys))
                $this->dropForeignKey($db->tablePrefix . "wiki_page_user_fk", $db->tablePrefix . 'wiki_page');

            $this->dropTable($db->tablePrefix . 'wiki_page');
        }

    }
}