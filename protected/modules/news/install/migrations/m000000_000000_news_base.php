<?php

/**
 * News install migration
 * Класс миграций для модуля News
 *
 * @category YupeMigration
 * @package  yupe.modules.news.install.migrations
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class m000000_000000_news_base extends yupe\components\DbMigration
{

    public function safeUp()
    {
        $this->createTable(
            '{{news_news}}',
            [
                'id'            => 'pk',
                'category_id'   => 'integer DEFAULT NULL',
                'lang'          => 'char(2) DEFAULT NULL',
                'creation_date' => 'datetime NOT NULL',
                'change_date'   => 'datetime NOT NULL',
                'date'          => 'date NOT NULL',
                'title'         => 'varchar(250) NOT NULL',
                'alias'         => 'varchar(150) NOT NULL',
                'short_text'    => 'text',
                'full_text'     => 'text NOT NULL',
                'image'         => 'varchar(300) DEFAULT NULL',
                'link'          => 'varchar(300) DEFAULT NULL',
                'user_id'       => 'integer DEFAULT NULL',
                'status'        => "integer NOT NULL DEFAULT '0'",
                'is_protected'  => "boolean NOT NULL DEFAULT '0'",
                'keywords'      => 'varchar(250) NOT NULL',
                'description'   => 'varchar(250) NOT NULL',
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{news_news}}_alias_lang", '{{news_news}}', "alias,lang", true);
        $this->createIndex("ix_{{news_news}}_status", '{{news_news}}', "status", false);
        $this->createIndex("ix_{{news_news}}_user_id", '{{news_news}}', "user_id", false);
        $this->createIndex("ix_{{news_news}}_category_id", '{{news_news}}', "category_id", false);
        $this->createIndex("ix_{{news_news}}_date", '{{news_news}}', "date", false);

        //fk
        $this->addForeignKey(
            "fk_{{news_news}}_user_id",
            '{{news_news}}',
            'user_id',
            '{{user_user}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
        $this->addForeignKey(
            "fk_{{news_news}}_category_id",
            '{{news_news}}',
            'category_id',
            '{{category_category}}',
            'id',
            'SET NULL',
            'NO ACTION'
        );
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys('{{news_news}}');
    }
}
