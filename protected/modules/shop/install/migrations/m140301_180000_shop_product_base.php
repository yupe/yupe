<?php

class m140301_180000_shop_product_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product}}', array(
                'id'                => 'pk',
                'type_id'           => 'integer DEFAULT NULL',
                'producer_id'       => "integer DEFAULT NULL",
                'sku'               => 'varchar(100) DEFAULT NULL',
                'name'              => 'varchar(250) NOT NULL',
                'alias'             => 'varchar(150) NOT NULL',
                'price'             => "decimal(19,3) NOT NULL DEFAULT '0'",
                'discount_price'    => "decimal(19,3) NULL",
                'discount'          => "decimal(19,3) NULL",
                'description'       => 'text',
                'short_description' => 'text',
                'data'              => 'text',
                'is_special'        => "boolean NOT NULL DEFAULT '0'",
                'length'            => "DECIMAL(19,3) NULL",
                'width'             => "DECIMAL(19,3) NULL",
                'height'            => "DECIMAL(19,3) NULL",
                'weight'            => "DECIMAL(19,3) NULL",
                'quantity'          => "INT(11) NULL",
                'in_stock'          => "tinyint NOT NULL DEFAULT '1'",
                'status'            => "tinyint NOT NULL DEFAULT '1'",
                'create_time'       => 'datetime NOT NULL',
                'update_time'       => 'datetime NOT NULL',
                'meta_title'        => 'varchar(250) DEFAULT NULL',
                'meta_keywords'     => 'varchar(250) DEFAULT NULL',
                'meta_description'  => 'varchar(250) DEFAULT NULL',
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );

        $this->createIndex("ux_{{shop_product}}_alias", '{{shop_product}}', "alias", true);
        $this->createIndex("ix_{{shop_product}}_status", '{{shop_product}}', "status", false);
        $this->createIndex("ix_{{shop_product}}_type_id", '{{shop_product}}', "type_id", false);
        $this->createIndex("ix_{{shop_product}}_producer_id", '{{shop_product}}', "producer_id", false);
        $this->createIndex("ix_{{shop_product}}_price", '{{shop_product}}', "price", false);
        $this->createIndex("ix_{{shop_product}}_discount_price", '{{shop_product}}', "discount_price", false);
        $this->createIndex("ix_{{shop_product}}_create_time", '{{shop_product}}', "create_time", false);
        $this->createIndex("ix_{{shop_product}}_update_time", '{{shop_product}}', "update_time", false);
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product}}');
    }
}