<?php

use yupe\components\Event;

class AccessControlListener
{
    public static function onBackendControllerInit(Event $event)
    {
        $filters = Yii::app()->getModule('yupe')->getBackendFilters();
        $filters = array_replace(
            $filters,
            array_fill_keys(
                array_keys($filters, array('yupe\filters\YBackAccessControl')),
                array('rbac\filters\RbacBackAccessControl')
            )
        );
        Yii::app()->getModule('yupe')->setBackendFilters($filters);
        Yii::app()->getModule('yupe')->addBackendFilter('accessControl');
    }
}
