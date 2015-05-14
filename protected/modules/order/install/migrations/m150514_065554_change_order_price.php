<?php

class m150514_065554_change_order_price extends yupe\components\DbMigration
{
	public function safeUp()
	{
        Yii::app()->getDb()->createCommand('UPDATE {{store_order}} SET total_price = total_price - delivery_price')->execute();
	}
}