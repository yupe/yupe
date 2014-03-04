<?php

class m140302_220000_shop_product_attribute_eav_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_attribute_eav}}', array(
                'product_id' => 'integer not null',
                'attribute' => "varchar(250) not null",
                'value' => "text",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        $this->createIndex("ix_{{shop_product_attribute_eav}}_product_id", '{{shop_product_attribute_eav}}', "product_id", false);
        $this->createIndex("ix_{{shop_product_attribute_eav}}_attribute", '{{shop_product_attribute_eav}}', "attribute", false);
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_attribute_eav}}');
    }
}