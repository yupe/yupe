<?php

class m180421_143937_update_blog_meta_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{blog_post}}', 'keywords', 'meta_keywords');
        $this->renameColumn('{{blog_post}}', 'description', 'meta_description');
    }
}