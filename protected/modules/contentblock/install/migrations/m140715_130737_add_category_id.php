<?php

class m140715_130737_add_category_id extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{contentblock_content_block}}','category_id','integer DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('{{contentblock_content_block}}', 'category_id');
    }
}