<?php

class m141003_210000_sitemap_model_data_page_news extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->insert("{{sitemap_model}}", ['module' => 'page', 'model' => 'Page', 'changefreq' => 'weekly', 'priority' => '0.5', 'status' => 1]);
        $this->insert("{{sitemap_model}}", ['module' => 'news', 'model' => 'News', 'changefreq' => 'weekly', 'priority' => '0.5', 'status' => 1]);
    }

    public function safeDown()
    {
        $this->delete("{{sitemap_model}}", ['module = :module'], [':module' => 'page']);
        $this->delete("{{sitemap_model}}", ['module = :module'], [':module' => 'news']);
    }
}
