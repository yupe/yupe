<?php
/**
 * FileDocComment
 * Yeeki install migration
 * Класс миграций для модуля Yeeki:
 *
 * @category YupeMigration
 * @package  yupe.modules.yeeki.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_yeeki_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{wiki_wiki_page}}',
            array(
                'id' => 'pk',
                'is_redirect' => "boolean DEFAULT '0'",
                'page_uid' => 'varchar(250) DEFAULT NULL',
                'namespace' => 'varchar(250) DEFAULT NULL',
                'content' => 'text',
                'revision_id' => 'integer DEFAULT NULL',
                'user_id' => 'integer DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
                'updated_at' => 'integer DEFAULT NULL',
            ),
            $this->getOptions()
        );

        $this->createIndex("ix_{{wiki_wiki_page}}_revision_id", '{{wiki_wiki_page}}', "revision_id", false);
        $this->createIndex("ix_{{wiki_wiki_page}}_user_id", '{{wiki_wiki_page}}', "user_id", false);
        $this->createIndex("ix_{{wiki_wiki_page}}_namespace", '{{wiki_wiki_page}}', "namespace", false);
        $this->createIndex("ix_{{wiki_wiki_page}}_created_at", '{{wiki_wiki_page}}', "created_at", false);
        $this->createIndex("ix_{{wiki_wiki_page}}_updated_at", '{{wiki_wiki_page}}', "updated_at", false);

        //fk
        $this->addForeignKey("fk_{{wiki_wiki_page}}_user_id", '{{wiki_wiki_page}}', 'user_id', '{{user_user}}', 'id', 'SET NULL', 'CASCADE');

        /**
         * wiki_page_revision:
         **/
        $this->createTable(
            '{{wiki_wiki_page_revision}}',
            array(
                'id' => 'pk',
                'page_id' => 'integer NOT NULL',
                'comment' => 'varchar(250) DEFAULT NULL',
                'is_minor' => 'boolean DEFAULT NULL',
                'content' => 'text',
                'user_id' => 'varchar(250) DEFAULT NULL',
                'created_at' => 'integer DEFAULT NULL',
            ),
            $this->getOptions()
        );
        $this->createIndex( "ix_{{wiki_wiki_page_revision}}_pageid",  '{{wiki_wiki_page_revision}}', "page_id", false);
        $this->addForeignKey( "fk_{{wiki_wiki_page_revision}}_page",  '{{wiki_wiki_page_revision}}', 'page_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey( "fk_{{wiki_wiki_page}}_revision_id",  "{{wiki_wiki_page}}", 'revision_id',  '{{wiki_wiki_page_revision}}', 'id', 'CASCADE', 'CASCADE');

        /**
         * wiki_link
         **/
        $this->createTable(
            '{{wiki_wiki_link}}',
            array(
                'id' => 'pk',
                'page_from_id' => 'integer NOT NULL',
                'page_to_id' => 'integer DEFAULT NULL',
                'wiki_uid' => 'string DEFAULT NULL',
                'title' => 'string DEFAULT NULL'
            ),
            $this->getOptions()
        );

        $this->createIndex( "ix_{{wiki_wiki_link}}_code_unique",  '{{wiki_wiki_link}}', "page_from_id", false);
        $this->createIndex( "ix_{{wiki_wiki_link}}_status",  '{{wiki_wiki_link}}', "page_to_id", false);
        $this->createIndex( "ix_{{wiki_wiki_link}}_uid",  '{{wiki_wiki_link}}', "wiki_uid", false);

        $this->addForeignKey( "fk_{{wiki_wiki_link}}_page_from_fk",  '{{wiki_wiki_link}}', 'page_from_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey( "fk_{{wiki_wiki_link}}_page_to_fk",  '{{wiki_wiki_link}}', 'page_to_id',  '{{wiki_wiki_page}}', 'id', 'CASCADE', 'CASCADE');
    }
 
    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{wiki_wiki_link}}');
        $this->dropTableWithForeignKeys('{{wiki_wiki_page_revision}}');
        $this->dropTableWithForeignKeys('{{wiki_wiki_page}}');
    }
}