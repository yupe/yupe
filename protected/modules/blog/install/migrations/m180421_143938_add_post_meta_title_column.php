<?php

class m180421_143938_add_post_meta_title_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{blog_post}}', 'meta_title', 'varchar(250) NOT NULL');
    }
}