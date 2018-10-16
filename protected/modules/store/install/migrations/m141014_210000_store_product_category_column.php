<?php

class m141014_210000_store_product_category_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_product}}', 'category_id', 'int null AFTER `producer_id`');
        $this->addForeignKey('fk_{{store_product}}_category', '{{store_product}}', 'category_id', '{{store_category}}', 'id', 'SET NULL', 'CASCADE');
        $this->dropColumn('{{store_product_category}}', 'is_main');
    }

    public function safeDown()
    {

    }
}
