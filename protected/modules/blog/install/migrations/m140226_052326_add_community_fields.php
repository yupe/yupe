<?php

class m140226_052326_add_community_fields extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{blog_blog}}', 'member_status', 'integer NOT NULL  DEFAULT 1');
        $this->addColumn('{{blog_blog}}', 'post_status', 'integer NOT NULL DEFAULT 1');
    }

    public function safeDown()
    {
        $this->dropColumn('{{blog_blog}}', 'member_status');
        $this->dropColumn('{{blog_blog}}', 'post_status');
    }
}
