<?php

class m140814_000020_store_product_variant_base extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{store_product_variant}}",
            [
                "id" => "pk",
                "product_id" => "integer not null",
                "attribute_id" => "integer not null",
                "attribute_value" => "varchar(255) null default null",
                "amount" => "float null",
                "type" => "tinyint not null",
                "sku" => "varchar(50) null",
            ],
            $this->getOptions()
        );
        $this->createIndex("idx_{{store_product_variant}}_product", "{{store_product_variant}}", "product_id");
        $this->createIndex("idx_{{store_product_variant}}_attribute", "{{store_product_variant}}", "attribute_id");
        $this->createIndex("idx_{{store_product_variant}}_value", "{{store_product_variant}}", "attribute_value");
        //fk
        $this->addForeignKey("fk_{{store_product_variant}}_product", "{{store_product_variant}}", "product_id", "{{store_product}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk_{{store_product_variant}}_attribute", "{{store_product_variant}}", "attribute_id", "{{store_attribute}}", "id", "CASCADE", "CASCADE");
    }

    public function safeDown()
    {
        $this->dropTable("{{store_product_variant}}");
    }
}
