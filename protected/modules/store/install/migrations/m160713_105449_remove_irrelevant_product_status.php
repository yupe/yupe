<?php

class m160713_105449_remove_irrelevant_product_status extends yupe\components\DbMigration
{
	public function safeUp()
	{
        Yii::app()->getDb()->createCommand("UPDATE {{store_product}} SET status = 0 WHERE status = 2")->execute();
    }
}