<?php
/**
 * Создание заказа логируется в категорию shop.order.create
 * + выбрасывается почтовое событие new-order
 */
use yupe\components\WebModule;

class ShopModule extends WebModule
{
    public function getAdminPageLink()
    {
        return '/shop/orderBackend/index';
    }
    // название модуля
    public function getName()
    {
        return Yii::t('ShopModule.shop', 'Shop');
    }

    public function getDependencies()
    {
        return array(
            'catalog',
            'mail'
        );
    }

    // описание модуля
    public function getDescription()
    {
        return Yii::t('ShopModule.shop', 'Light e-shop');
    }

    // автор модуля (Ваше Имя, название студии и т.п.)
    public function getAuthor()
    {
        return Yii::t('ShopModule.shop', 'amarin');
    }

    // контактный email автора
    public function getAuthorEmail()
    {
        return Yii::t('ShopModule.shop', 'antonaryo@yandex.ru');
    }

    // сайт автора или страничка модуля
    public function getUrl()
    {
        return Yii::t('ShopModule.shop', 'http://coder1.ru');
    }

    // категория модуля
    public function getCategory()
    {
        return Yii::t('ShopModule.shop', 'Services');
    }

    public function getIcon()
    {
        return "shopping-cart";
    }

    public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'shop.models.*',
			'shop.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
