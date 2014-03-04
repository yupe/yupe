<?php

class m140226_194156_shop_type_attribute_base extends yupe\components\DbMigration
{
    /**
     * Функция настройки и создания таблицы:
     *
     * @return null
     **/
    public function safeUp()
    {
        $this->createTable(
            '{{shop_type_attribute}}',
            array(
                'type_id'      => 'INT(11) NOT NULL',
                'attribute_id' => 'INT(11) NOT NULL',
            ),
            'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->addPrimaryKey('pk_{{shop_type_attribute}}', '{{shop_type_attribute}}', 'type_id, attribute_id');
    }

    /**
     * Функция удаления таблицы:
     *
     * @return null
     **/
    public function safeDown()
    {
        $this->dropTable('{{shop_type_attribute}}');
    }
}