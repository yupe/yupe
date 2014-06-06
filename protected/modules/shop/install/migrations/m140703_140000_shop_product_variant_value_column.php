<?php

class m140703_140000_shop_product_variant_value_column extends yupe\components\DbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{shop_product_variant}}', 'value', 'varchar(250) null AFTER `option_id`');
    }

    public function safeDown()
    {
        $this->dropColumn('{{shop_product_variant}}', 'value');
    }
}