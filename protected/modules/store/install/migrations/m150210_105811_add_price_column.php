<?php

class m150210_105811_add_price_column extends CDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_product}}', 'average_price', "decimal(19,3) default null");
        $this->addColumn('{{store_product}}', 'purchase_price', "decimal(19,3) default null");
        $this->addColumn('{{store_product}}', 'recommended_price', "decimal(19,3) default null");
    }

    public function safeDown()
    {
        $this->dropColumn('{{store_product}}', 'average_price');
        $this->dropColumn('{{store_product}}', 'purchase_price');
        $this->dropColumn('{{store_product}}', 'recommended_price');
    }
}
