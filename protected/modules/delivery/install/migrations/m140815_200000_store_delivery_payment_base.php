<?php

class m140815_200000_store_delivery_payment_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_delivery_payment}}",
            [
                "delivery_id" => "integer not null",
                "payment_id" => "integer not null",
                "PRIMARY KEY (`delivery_id`, `payment_id`)"
            ],
            $this->getOptions()
        );

        $this->addForeignKey("fk_{{store_delivery_payment}}_delivery", "{{store_delivery_payment}}", "delivery_id", "{{store_delivery}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_delivery_payment}}_payment", "{{store_delivery_payment}}", "payment_id", "{{store_payment}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_delivery_payment}}");
    }
}
