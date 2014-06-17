<?php

class m140608_180000_shop_order_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_order}}', array(
                'id' => 'pk',
                'delivery_id' => "integer null",
                'delivery_price' => "decimal(10, 2) not null default '0'",
                'payment_method_id' => "integer null",
                'paid' => "tinyint null default '0'",
                'payment_date' => 'datetime',
                'payment_details' => 'text null',
                'total_price' => "decimal(10, 2) not null default '0'",
                'discount' => "decimal(10, 2) not null default '0'",
                'coupon_discount' => "decimal(10, 2) not null default '0'",
                'coupon_code' => "varchar(255) not null default ''",
                'separate_delivery' => "tinyint null default '0'",
                'status' => "tinyint not null default '0'",
                'date' => 'datetime',
                'user_id' => "integer null",
                'name' => "varchar(255) not null default ''",
                'address' => "varchar(255) not null default ''",
                'phone' => "varchar(255) not null default ''",
                'email' => "varchar(255) not null default ''",
                'comment' => "varchar(1024) not null default ''",
                'ip' => "varchar(15) null",
                'url' => "varchar(255) null",
                'note' => "varchar(1024) not null default ''",
                'modified' => 'datetime',
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->createIndex("idx_{{shop_order}}_user_id", '{{shop_order}}', "user_id");
        $this->createIndex("idx_{{shop_order}}_date", '{{shop_order}}', "date");
        $this->createIndex("idx_{{shop_order}}_status", '{{shop_order}}', "status");
        $this->createIndex("udx_{{shop_order}}_url", '{{shop_order}}', "url", true);
        $this->createIndex("idx_{{shop_order}}_paid", '{{shop_order}}', "paid");

        $this->createTable('{{shop_order_product}}', array(
                'id' => 'pk',
                'order_id' => "integer not null",
                'product_id' => "integer null",
                'product_name' => "varchar(255) not null",
                'variants' => 'text null',
                'variants_text' => "varchar(1024) null",
                'price' => "decimal(10, 2) not null default '0'",
                'quantity' => "integer not null default '0'",
                'sku' => "varchar(255) null",
            ), 'ENGINE=MyISAM DEFAULT CHARSET=utf8'
        );
        $this->createIndex("idx_{{shop_order_product}}_order_id", '{{shop_order_product}}', "order_id");
        $this->createIndex("idx_{{shop_order_product}}_product_id", '{{shop_order_product}}', "product_id");
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_order}}');
        $this->dropTable('{{shop_order_product}}');
    }
}