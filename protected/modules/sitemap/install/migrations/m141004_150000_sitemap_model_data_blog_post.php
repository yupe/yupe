<?php

class m141004_150000_sitemap_model_data_blog_post extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->insert("{{sitemap_model}}", ['module' => 'blog', 'model' => 'Blog', 'changefreq' => 'weekly', 'priority' => '0.5', 'status' => 1]);
        $this->insert("{{sitemap_model}}", ['module' => 'blog', 'model' => 'Post', 'changefreq' => 'weekly', 'priority' => '0.5', 'status' => 1]);
    }

    public function safeDown()
    {
        $this->delete("{{sitemap_model}}", ['module = :module'], [':module' => 'blog']);
    }
}
