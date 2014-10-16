<?php

class m141015_170000_store_product_image_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_product}}', 'image', 'varchar(250) null');
        $this->dropColumn('{{store_product_image}}', 'is_main');
    }

    public function safeDown()
    {

    }
}
