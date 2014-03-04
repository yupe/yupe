<?php

class m140225_162600_shop_attribute_option_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_attribute_option}}',
            array(
                'id'           => 'pk',
                'attribute_id' => 'INT(11) NULL DEFAULT NULL',
                'position'     => 'TINYINT(4) NULL DEFAULT NULL',
                'value'        => "VARCHAR(255) NULL DEFAULT ''",
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        //ix
        $this->createIndex("ix_{{shop_attribute_option}}_attribute_id", '{{shop_attribute_option}}', "attribute_id", false);
        $this->createIndex("ix_{{shop_attribute_option}}_position", '{{shop_attribute_option}}', "position", false);

    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable('{{shop_attribute_option}}');
    }
}