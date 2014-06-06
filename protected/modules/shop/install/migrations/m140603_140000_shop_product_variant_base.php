<?php

class m140603_140000_shop_product_variant_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_variant}}', array(
                'id' => 'pk',
                'product_id' => 'integer not null',
                'attribute_id' => 'integer null',
                'option_id' => 'integer null',
                'amount' => "float null",
                'type' => "tinyint not null",
                'sku' => "varchar(50) null",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->createIndex("idx_{{shop_product_variant}}_product", '{{shop_product_variant}}', "product_id");
        $this->createIndex("idx_{{shop_product_variant}}_attribute", '{{shop_product_variant}}', "attribute_id");
        $this->createIndex("idx_{{shop_product_variant}}_option", '{{shop_product_variant}}', "option_id");
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_variant}}');
    }
}