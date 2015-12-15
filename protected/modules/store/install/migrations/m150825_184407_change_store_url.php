<?php

class m150825_184407_change_store_url extends yupe\components\DbMigration
{
	public function safeUp()
	{
        if(Yii::app()->hasModule('menu')) {

            Yii::import('application.modules.menu.models.*');
            Yii::import('application.modules.menu.MenuModule');

            $item = MenuItem::model()->find('href = :href', [':href' => '/store/catalog/index']);

            if(null !== $item) {
                $item->href = '/store/product/index';
                $item->save();
            }
        }
	}
}