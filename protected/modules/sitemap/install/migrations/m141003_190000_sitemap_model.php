<?php

class m141003_190000_sitemap_model extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{sitemap_model}}",
            [
                "id" => "pk",
                "module" => "varchar(20) not null",
                "model" => "varchar(20) not null",
                "changefreq" => "varchar(20) not null",
                "priority" => "float not null default '0.5'",
                "status" => "integer not null default '0'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{sitemap_model}}_module_model", "{{sitemap_model}}", "module, model", true);
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys("{{sitemap_model}}");
    }
}
