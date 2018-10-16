<?php

class m140815_170000_store_payment_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_payment}}",
            [
                "id" => "pk",
                "module" => "varchar(100) not null",
                "name" => "varchar(255) not null",
                "description" => "text null",
                "settings" => "text null",
                "currency_id" => "integer null",
                "position" => "integer not null default '1'",
                "status" => "tinyint not null default '1'",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{store_payment}}_position", "{{store_payment}}", "position");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_payment}}");
    }
}
