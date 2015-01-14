<?php

class m140814_000000_store_product_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_product}}",
            [
                "id" => "pk",
                "type_id" => "integer default null",
                "producer_id" => "integer default null",
                "sku" => "varchar(100) default null",
                "name" => "varchar(250) not null",
                "alias" => "varchar(150) not null",
                "price" => "decimal(19,3) not null default '0'",
                "discount_price" => "decimal(19,3) null",
                "discount" => "decimal(19,3) null",
                "description" => "text",
                "short_description" => "text",
                "data" => "text",
                "is_special" => "boolean not null default '0'",
                "length" => "decimal(19,3) null",
                "width" => "decimal(19,3) null",
                "height" => "decimal(19,3) null",
                "weight" => "decimal(19,3) null",
                "quantity" => "int(11) null",
                "in_stock" => "tinyint not null default '1'",
                "status" => "tinyint not null default '1'",
                "create_time" => "datetime not null",
                "update_time" => "datetime not null",
                "meta_title" => "varchar(250) default null",
                "meta_keywords" => "varchar(250) default null",
                "meta_description" => "varchar(250) default null",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{store_product}}_alias", "{{store_product}}", "alias", true);
        $this->createIndex("ix_{{store_product}}_status", "{{store_product}}", "status", false);
        $this->createIndex("ix_{{store_product}}_type_id", "{{store_product}}", "type_id", false);
        $this->createIndex("ix_{{store_product}}_producer_id", "{{store_product}}", "producer_id", false);
        $this->createIndex("ix_{{store_product}}_price", "{{store_product}}", "price", false);
        $this->createIndex("ix_{{store_product}}_discount_price", "{{store_product}}", "discount_price", false);
        $this->createIndex("ix_{{store_product}}_create_time", "{{store_product}}", "create_time", false);
        $this->createIndex("ix_{{store_product}}_update_time", "{{store_product}}", "update_time", false);

        //fk
        $this->addForeignKey("fk_{{store_product}}_type", "{{store_product}}", "type_id", "{{store_type}}", "id", "SET NULL", "CASCADE");
        $this->addForeignKey("fk_{{store_product}}_producer", "{{store_product}}", "producer_id", "{{store_producer}}", "id", "SET NULL", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_product}}");
    }
}
