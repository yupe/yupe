<?php

class m140816_200000_store_coupon_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_coupon}}",
            [
                "id" => "pk",
                "name" => "varchar(255) not null default ''",
                "code" => "varchar(255) not null",
                "type" => "tinyint not null default '0'",
                "value" => "decimal(10, 2) not null default '0'",
                "min_order_price" => "decimal(10, 2) not null default '0'",
                "registered_user" => "tinyint not null default '0'",
                "free_shipping" => "tinyint not null default '0'",
                "date_start" => "datetime null",
                "date_end" => "datetime null",
                "quantity" => "integer null",
                "quantity_per_user" => "integer null",
                "status" => "tinyint not null default '0'",
            ],
            $this->getOptions()
        );
    }

    public function safeDown()
    {
        $this->dropTable("{{store_coupon}}");
    }
}
