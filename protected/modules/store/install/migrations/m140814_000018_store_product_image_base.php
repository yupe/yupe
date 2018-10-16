<?php

class m140814_000018_store_product_image_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_product_image}}",
            [
                "id" => "pk",
                "product_id" => "integer not null",
                "name" => "varchar(250) not null",
                "title" => "varchar(250) null",
                "is_main" => "boolean not null default '0'",
            ],
            $this->getOptions()
        );

        //fk
        $this->addForeignKey("fk_{{store_product_image}}_product", "{{store_product_image}}", "product_id", "{{store_product}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_product_image}}");
    }
}
