<?php

class m141004_140000_sitemap_page_data extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->insert("{{sitemap_page}}", ['url' => '/', 'changefreq' => 'daily', 'priority' => '0.5', 'status' => 1]);
    }

    public function safeDown()
    {

    }
}
