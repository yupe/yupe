<?php

class m150210_063409_add_store_menu_item extends CDbMigration
{
	public function safeUp()
	{
        if(Yii::app()->hasModule('menu')) {

            Yii::import('application.modules.menu.models.*');

            Yii::import('application.modules.menu.MenuModule');

            $menu = Menu::model()->find(['order' => 'id ASC', 'limit' => 1]);

            if(null !== $menu) {

                $item = MenuItem::model()->find('href = :href', [':href' => '/store/product/index']);

                if(null != $item) {

                    $item = new MenuItem();
                    $item->menu_id = $menu->id;
                    $item->title   = 'Магазин';
                    $item->href    = '/store/product/index';
                    $item->parent_id = 0;
                    $item->condition_name = null;
                    $item->save();
                }
            }
        }
	}

	public function safeDown()
	{
        if(Yii::app()->hasModule('menu')) {

            Yii::import('application.modules.menu.models.*');

            Yii::import('application.modules.menu.MenuModule');

            $item = MenuItem::model()->find('href = :href', [':href' => '/store/product/index']);

            if($item !== null) {
                $item->delete();
            }
        }
	}
}
