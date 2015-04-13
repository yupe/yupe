<?php

class m150406_094809_blog_post_quote_type extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->alterColumn('{{blog_post}}', 'quote', 'TEXT');
    }
}