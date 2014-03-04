<?php

class m140302_180000_shop_product_category_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_category}}', array(
                'id' => 'pk',
                'product_id' => 'integer',
                'category_id' => "integer",
                'is_main' => "boolean NOT NULL DEFAULT '0'",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        $this->createIndex("ix_{{shop_product_category}}_product_id", '{{shop_product_category}}', "product_id", false);
        $this->createIndex("ix_{{shop_product_category}}_category_id", '{{shop_product_category}}', "category_id", false);
        $this->createIndex("ix_{{shop_product_category}}_is_main", '{{shop_product_category}}', "is_main", false);

    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_category}}');
    }
}