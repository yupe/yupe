<?php

class m141218_091834_default_null extends CDbMigration
{
	public function safeUp()
	{
        $this->alterColumn('{{store_product}}', 'discount_price', 'decimal(19,3) default null');
        $this->alterColumn('{{store_product}}', 'discount', 'decimal(19,3) default null');
	}

	public function safeDown()
	{
        $this->alterColumn('{{store_product}}', 'discount_price', 'decimal(19,3) null');
        $this->alterColumn('{{store_product}}', 'discount', 'decimal(19,3)  null');
	}
}
