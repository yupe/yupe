<?php

class m180421_142416_update_news_meta_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{news_news}}', 'keywords', 'meta_keywords');
        $this->renameColumn('{{news_news}}', 'description', 'meta_description');
    }
}