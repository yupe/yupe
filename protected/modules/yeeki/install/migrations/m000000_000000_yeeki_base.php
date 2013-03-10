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
class m000000_000000_yeeki_base extends YDbMigration
{
    /**
     * Накатываем миграцию:
     *
     * @return nothing
     **/
    public function safeUp()
    {
        /**
         * wiki_page:
         **/
        $this->createTable(
             '{{wiki_wiki_page}}', array(
                'id' => 'pk',
                'is_redirect' => "boolean DEFAULT '0'",
                'page_uid' => 'varchar(250) DEFAULT NULL',
                'namespace' => 'varchar(250) DEFAULT NULL',
                'content' => 'text',
                'revision_id' => 'integer DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
                'updated_at' => 'integer DEFAULT NULL',
            ), $this->getOptions()
        );

        $this->createIndex( "ix_{{wiki_wiki_page}}_revision_idx",  '{{wiki_wiki_page}}', "revision_id", false);
        $this->createIndex( "ix_{{wiki_wiki_page}}_uid",  '{{wiki_wiki_page}}', "user_id", false);
        $this->createIndex( "ix_{{wiki_wiki_page}}_namespace",  '{{wiki_wiki_page}}', "namespace", false);
        $this->createIndex( "ix_{{wiki_wiki_page}}_created",  '{{wiki_wiki_page}}', "created_at", false);
        $this->createIndex( "ix_{{wiki_wiki_page}}_updated",  '{{wiki_wiki_page}}', "updated_at", false);

        $this->addForeignKey( "fk_{{wiki_wiki_page}}_user",  '{{wiki_wiki_page}}', 'user_id',  '{{user_user}}', 'id', 'SET NULL', 'CASCADE');

        /**
         * wiki_page_revision:
         **/
        $this->createTable(
             '{{wiki_wiki_page_revision}}', array(
                'id' => 'pk',
                'page_id' => 'integer NOT NULL',
                'comment' => 'varchar(250) DEFAULT NULL',
                'is_minor' => 'boolean DEFAULT NULL',
                'content' => 'text',
                'user_id' => 'varchar(250) DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
            ), $this->getOptions()
        );
        $this->createIndex( "ix_{{wiki_wiki_page_revision}}_pageid",  '{{wiki_wiki_page_revision}}', "page_id", false);
        $this->addForeignKey( "fk_{{wiki_wiki_page_revision}}_page",  '{{wiki_wiki_page_revision}}', 'page_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey( "fk_{{wiki_wiki_page}}_revision_id",  "{{wiki_wiki_page}}", 'revision_id',  '{{wiki_wiki_page_revision}}', 'id', 'CASCADE', 'CASCADE');

        /**
         * wiki_link
         **/
        $this->createTable(
             '{{wiki_wiki_link}}', array(
                'id' => 'pk',
                'page_from_id' => 'integer NOT NULL',
                'page_to_id' => 'integer DEFAULT NULL',
                'wiki_uid' => 'varchar(250) DEFAULT NULL',
                'title' =>  'varchar(250) DEFAULT NULL'
            ), $this->getOptions()
        );

        $this->createIndex( "ix_{{wiki_wiki_link}}_code_unique",  '{{wiki_wiki_link}}', "page_from_id", false);
        $this->createIndex( "ix_{{wiki_wiki_link}}_status",  '{{wiki_wiki_link}}', "page_to_id", false);
        $this->createIndex( "ix_{{wiki_wiki_link}}_uid",  '{{wiki_wiki_link}}', "wiki_uid", false);

        $this->addForeignKey( "fk_{{wiki_wiki_link}}_page_from_fk",  '{{wiki_wiki_link}}', 'page_from_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey( "fk_{{wiki_wiki_link}}_page_to_fk",  '{{wiki_wiki_link}}', 'page_to_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
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

        if ($db->schema->getTable( '{{wiki_wiki_link}}') !== null) {

            if (in_array( "fk_{{wiki_wiki_link}}_page_from_fk", $db->schema->getTable( '{{wiki_wiki_link}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{wiki_wiki_link}}_page_from_fk",  '{{wiki_wiki_link}}');

            if (in_array( "fk_{{wiki_wiki_link}}_page_to_fk", $db->schema->getTable( '{{wiki_wiki_link}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{wiki_wiki_link}}_page_to_fk",  '{{wiki_wiki_link}}');


            $this->dropTable( '{{wiki_wiki_link}}');
        }

        if ($db->schema->getTable( '{{wiki_wiki_page_revision}}') !== null) {
            
            if (in_array( "fk_{{wiki_wiki_page_revision}}_page", $db->schema->getTable( '{{wiki_wiki_page_revision}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{wiki_wiki_page_revision}}_page",  '{{wiki_wiki_page_revision}}');

            if (in_array( "fk_{{wiki_wiki_page}}_revision_id", $db->schema->getTable( '{{wiki_wiki_page}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{wiki_wiki_page}}_revision_id",  '{{wiki_wiki_page}}');

            $this->dropTable( '{{wiki_wiki_page_revision}}');
        }

        /**
         * Убиваем внешние ключи, индексы и таблицу - wiki_page
         * @todo найти как проверять существование индексов, что бы их подчищать:
         **/

        if ($db->schema->getTable( '{{wiki_wiki_page}}') !== null) {

            if (in_array( "fk_{{wiki_wiki_page}}_user", $db->schema->getTable( '{{wiki_wiki_page}}')->foreignKeys))
                $this->dropForeignKey( "fk_{{wiki_wiki_page}}_user",  '{{wiki_wiki_page}}');

            $this->dropTable( '{{wiki_wiki_page}}');
        }

    }
}