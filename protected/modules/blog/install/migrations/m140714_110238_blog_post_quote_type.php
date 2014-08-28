<?php

class m140714_110238_blog_post_quote_type extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->alterColumn('{{blog_post}}', 'quote', 'VARCHAR(500)');
    }
}
