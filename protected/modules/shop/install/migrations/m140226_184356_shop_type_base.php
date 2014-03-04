<?php

class m140226_184356_shop_type_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_type}}',
            array(
                'id'               => 'pk',
                'name'             => "VARCHAR(255) NOT NULL",
                'main_category_id' => 'INT(11) NULL DEFAULT NULL',
                'categories'       => 'TEXT NULL DEFAULT NULL',
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        $this->createIndex("ux_{{shop_type}}_name", '{{shop_type}}', "name", true);
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable('{{shop_type}}');
    }
}