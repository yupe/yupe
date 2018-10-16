<?php

class m140814_200000_store_order_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_order}}",
            [
                "id" => "pk",
                "delivery_id" => "integer null",
                "delivery_price" => "decimal(10, 2) not null default '0'",
                "payment_method_id" => "integer null",
                "paid" => "tinyint null default '0'",
                "payment_date" => "datetime",
                "payment_details" => "text null",
                "total_price" => "decimal(10, 2) not null default '0'",
                "discount" => "decimal(10, 2) not null default '0'",
                "coupon_discount" => "decimal(10, 2) not null default '0'",
                "coupon_code" => "varchar(255) not null default ''",
                "separate_delivery" => "tinyint null default '0'",
                "status" => "tinyint not null default '0'",
                "date" => "datetime",
                "user_id" => "integer null",
                "name" => "varchar(255) not null default ''",
                "address" => "varchar(255) not null default ''",
                "phone" => "varchar(255) not null default ''",
                "email" => "varchar(255) not null default ''",
                "comment" => "varchar(1024) not null default ''",
                "ip" => "varchar(15) null",
                "url" => "varchar(255) null",
                "note" => "varchar(1024) not null default ''",
                "modified" => "datetime",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{store_order}}_user_id", "{{store_order}}", "user_id");
        $this->createIndex("idx_{{store_order}}_date", "{{store_order}}", "date");
        $this->createIndex("idx_{{store_order}}_status", "{{store_order}}", "status");
        $this->createIndex("udx_{{store_order}}_url", "{{store_order}}", "url", true);
        $this->createIndex("idx_{{store_order}}_paid", "{{store_order}}", "paid");

        //fk
        $this->addForeignKey("fk_{{store_order}}_delivery", "{{store_order}}", "delivery_id", "{{store_delivery}}", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_{{store_order}}_payment", "{{store_order}}", "payment_method_id", "{{store_payment}}", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_{{store_order}}_user", "{{store_order}}", "user_id", "{{user_user}}", "id", "SET NULL", "CASCADE");

        $this->createTable(
            "{{store_order_product}}",
            [
                "id" => "pk",
                "order_id" => "integer not null",
                "product_id" => "integer null",
                "product_name" => "varchar(255) not null",
                "variants" => "text null",
                "variants_text" => "varchar(1024) null",
                "price" => "decimal(10, 2) not null default '0'",
                "quantity" => "integer not null default '0'",
                "sku" => "varchar(255) null",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{store_order_product}}_order_id", "{{store_order_product}}", "order_id");
        $this->createIndex("idx_{{store_order_product}}_product_id", "{{store_order_product}}", "product_id");

        $this->addForeignKey("fk_{{store_order_product}}_order", "{{store_order_product}}", "order_id", "{{store_order}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_order_product}}_product", "{{store_order_product}}", "product_id", "{{store_product}}", "id", "SET NULL", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_order_product}}");
        $this->dropTable("{{store_order}}");
    }
}
