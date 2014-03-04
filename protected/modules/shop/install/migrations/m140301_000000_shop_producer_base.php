<?php

class m140301_000000_shop_producer_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_producer}}',
            array(
                'id'                => 'pk',
                'name_short'        => 'varchar(150) NOT NULL',
                'name'              => 'varchar(250) NOT NULL',
                'slug'              => 'varchar(150) NOT NULL',
                'image'             => 'varchar(250) DEFAULT NULL',
                'short_description' => 'text',
                'description'       => 'text',
                'meta_title'        => 'varchar(250) DEFAULT NULL',
                'meta_keywords'     => 'varchar(250) DEFAULT NULL',
                'meta_description'  => 'varchar(250) DEFAULT NULL',
                'status'            => "integer NOT NULL DEFAULT '1'",
                'order'             => "integer NOT NULL DEFAULT '0'",
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        $this->createIndex("ix_{{shop_producer}}_slug", '{{shop_producer}}', "slug", false);
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable("{{shop_producer}}");
    }
}