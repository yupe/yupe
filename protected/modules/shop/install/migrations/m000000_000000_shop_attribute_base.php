<?php

class m000000_000000_shop_attribute_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_attribute}}',
            array(
                'id'       => 'pk',
                'name'     => 'varchar(250) NOT NULL',
                'title'    => 'varchar(250) DEFAULT NULL',
                'type'     => 'TINYINT(4) NULL DEFAULT NULL',
                'required' => "boolean NOT NULL DEFAULT '0'",
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        //ix
        $this->createIndex("ux_{{shop_attribute}}_name", '{{shop_attribute}}', "name", true);
        $this->createIndex("ix_{{shop_attribute}}_title", '{{shop_attribute}}', "title", false);

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable('{{shop_attribute}}');
    }
}