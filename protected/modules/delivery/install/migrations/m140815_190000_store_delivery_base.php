<?php

class m140815_190000_store_delivery_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_delivery}}",
            [
                "id" => "pk",
                "name" => "varchar(255) not null",
                "description" => "text null",
                "price" => "float(10, 2) not null default '0'",
                "free_from" => "float(10, 2) null",
                "available_from" => "float(10, 2) null",
                "position" => "integer not null default '1'",
                "status" => "tinyint not null default '1'",
                "separate_payment" => "tinyint null default '0'",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{store_delivery}}_position", "{{store_delivery}}", "position");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_delivery}}");
    }
}
