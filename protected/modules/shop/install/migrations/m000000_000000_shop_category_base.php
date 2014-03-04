<?php

class m000000_000000_shop_category_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_category}}',
            array(
                'id'                => 'pk',
                'parent_id'         => 'integer DEFAULT NULL',
                'alias'             => 'varchar(150) NOT NULL',
                'name'              => 'varchar(250) NOT NULL',
                'image'             => 'varchar(250) DEFAULT NULL',
                'short_description' => 'text',
                'description'       => 'text',
                'meta_title'        => 'varchar(250) DEFAULT NULL',
                'meta_description'  => 'varchar(250) DEFAULT NULL',
                'meta_keywords'     => 'varchar(250) DEFAULT NULL',
                'status'            => "boolean NOT NULL DEFAULT '1'",
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        //ix
        $this->createIndex("ux_{{shop_category}}_alias", '{{shop_category}}', "alias", true);
        $this->createIndex("ix_{{shop_category}}_parent_id", '{{shop_category}}', "parent_id", false);
        $this->createIndex("ix_{{shop_category}}_status", '{{shop_category}}', "status", false);
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable('{{shop_category}}');
    }
}