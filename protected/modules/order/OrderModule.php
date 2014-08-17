<?php

use yupe\components\WebModule;

class OrderModule extends WebModule
{
    const VERSION = '0.1';

    public $notifyEmailFrom = '';
    public $notifyEmailsTo = '';

    public $assetsPath = "order.views.assets";

    public function getDependencies()
    {
        return array('store', 'payment', 'delivery', 'mail');
    }

    public function getEditableParams()
    {
        return array(
            'notifyEmailFrom',
            'notifyEmailsTo',
        );
    }

    public function getParamsLabels()
    {
        return array(
            'notifyEmailFrom' => Yii::t('OrderModule.order', 'Email, от имени которого отправлять оповещения'),
            'notifyEmailsTo' => Yii::t('OrderModule.order', 'Получатели оповещений (через запятую)'),
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            '0.notify' => array(
                'label' => Yii::t('OrderModule.order', 'Оповещения'),
                'items' => array(
                    'notifyEmailFrom',
                    'notifyEmailsTo',
                ),
            ),
        );
    }

    public function getCategory()
    {
        return Yii::t('OrderModule.order', 'Store');
    }

    public function getNavigation()
    {
        return array(
            array('icon' => 'glyphicon glyphicon-gift', 'label' => Yii::t('OrderModule.order', 'Заказы'), 'url' => array('/order/orderBackend/index')),
        );
    }

    public function getExtendedNavigation()
    {
        return array(
            array('icon' => 'glyphicon glyphicon-gift', 'label' => Yii::t('OrderModule.order', 'Заказы'), 'url' => array('/order/orderBackend/index')),
        );
    }

    public function getAdminPageLink()
    {
        return '/order/orderBackend/index';
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function getName()
    {
        return Yii::t('OrderModule.order', 'Заказы');
    }

    public function getDescription()
    {
        return Yii::t('OrderModule.order', 'Модуль для управления заказами');
    }

    public function getAuthor()
    {
        return Yii::t('OrderModule.order', 'Dark_Cs');
    }

    public function getAuthorEmail()
    {
        return Yii::t('OrderModule.order', 'darkcs2@gmail.com');
    }

    public function getIcon()
    {
        return 'glyphicon glyphicon-gift';
    }

    public function init()
    {
        parent::init();

        $this->setImport(
            array(
                'order.models.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        $mainAssets = $this->getAssetsUrl();
        if ($controller instanceof \yupe\components\controllers\BackController) {
            Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-backend.css');
        } else {
            Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/order-frontend.css');
            Yii::app()->getClientScript()->registerScriptFile(Yii::app()->getModule('store')->getAssetsUrl() . '/js/store.js');
        }
        return parent::beforeControllerAction($controller, $action);
    }

    public function sendNotifyOrder($type, Order $order, $theme = "")
    {
        $emailsTo = array();
        $emailFrom = $this->notifyEmailFrom ?: Yii::app()->getModule('yupe')->email;
        $emailBody = "";
        switch ($type) {
            case "admin":
                $theme = $theme ?: Yii::t('OrderModule.order', 'Новый заказ №{n} в магазине {site}', array('{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName));
                $emailsTo = preg_split('/,/', $this->notifyEmailsTo);
                $emailBody = Yii::app()->controller->renderPartial('/email/newOrderAdmin', array('order' => $order), true);
                break;
            case "user":
                $theme = $theme ?: Yii::t('OrderModule.order', 'Заказ №{n} в магазине {site}', array('{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName));
                $emailsTo = array($order->email);
                $emailBody = Yii::app()->controller->renderPartial('/email/newOrderUser', array('order' => $order), true);
                break;
            default:
                return;
        }
        foreach ($emailsTo as $email) {
            $email = trim($email);
            if ($email) {
                Yii::app()->mail->send(
                    $emailFrom,
                    $email,
                    $theme,
                    $emailBody
                );
                Yii::app()->mail->reset();
            }
        }
    }

    public function sendNotifyOrderCreated(Order $order)
    {
        // оповещение пользователя
        $this->sendNotifyOrder('user', $order);
        // оповещение администраторов
        $this->sendNotifyOrder('admin', $order);
    }

    public function sendNotifyOrderChanged(Order $order)
    {
        /* при изменении заказа, наверно, не стоит уведомлять администратора*/
        $this->sendNotifyOrder('user', $order);
    }

    public function sendNotifyOrderPaid(Order $order)
    {
        $this->sendNotifyOrder('user', $order);
        $this->sendNotifyOrder('admin', $order, Yii::t('OrderModule.order', 'Заказ №{n} в магазине {site} оплачен', array('{n}' => $order->id, '{site}' => Yii::app()->getModule('yupe')->siteName)));
    }

    public function getAuthItems()
    {
        return array(
            array(
                'type' => AuthItem::TYPE_TASK,
                'name' => 'Order.OrderBackend.Management',
                'description' => 'Управление заказами',
                'items' => array(
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Index', 'description' => Yii::t("OrderModule.order", 'Просмотр списка заказов'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Create', 'description' => Yii::t("OrderModule.order", 'Создание заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Update', 'description' => Yii::t("OrderModule.order", 'Редактирование заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.View', 'description' => Yii::t("OrderModule.order", 'Просмотр заказа'),),
                    array('type' => AuthItem::TYPE_OPERATION, 'name' => 'Order.OrderBackend.Delete', 'description' => Yii::t("OrderModule.order", 'Удаление заказа'),),
                ),
            ),
        );
    }
}
