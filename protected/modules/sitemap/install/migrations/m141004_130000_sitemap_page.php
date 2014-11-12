<?php

class m141004_130000_sitemap_page extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->createTable(
            "{{sitemap_page}}",
            [
                "id" => "pk",
                "url" => "varchar(250) not null",
                "changefreq" => "varchar(20) not null",
                "priority" => "float not null default '0.5'",
                "status" => "integer not null default '0'",
            ],
            $this->getOptions()
        );

        $this->createIndex("ux_{{sitemap_page}}_url", "{{sitemap_page}}", "url", true);
    }

    public function safeDown()
    {
        $this->dropTableWithForeignKeys("{{sitemap_page}}");
    }
}
