<?php

class m140814_000010_store_product_category_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_product_category}}",
            [
                "id" => "pk",
                "product_id" => "integer",
                "category_id" => "integer",
                "is_main" => "boolean NOT NULL DEFAULT '0'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ix_{{store_product_category}}_product_id", "{{store_product_category}}", "product_id", false);
        $this->createIndex("ix_{{store_product_category}}_category_id", "{{store_product_category}}", "category_id", false);
        $this->createIndex("ix_{{store_product_category}}_is_main", "{{store_product_category}}", "is_main", false);

        //fk
        $this->addForeignKey("fk_{{store_product_category}}_product", "{{store_product_category}}", "product_id", "{{store_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_product_category}}_category", "{{store_product_category}}", "category_id", "{{store_category}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_product_category}}");
    }
}
