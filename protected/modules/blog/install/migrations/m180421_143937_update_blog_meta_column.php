<?php

class m180421_143937_update_blog_meta_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->renameColumn('{{blog_blog}}', 'keywords', 'meta_keywords');
        $this->renameColumn('{{blog_blog}}', 'description', 'meta_description');


    }
}