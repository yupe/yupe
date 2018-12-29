<?php

class m181218_121815_store_product_variant_quantity_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{store_product_variant}}', 'quantity', 'int(11) null');
    }

    public function safeDown()
    {
        $this->dropColumn('{{store_product_variant}}', 'quantity');
    }
}