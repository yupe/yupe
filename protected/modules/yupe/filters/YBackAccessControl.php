<?php
/**
 * YBackAccessControl фильтр, контролирующий доступ в панель управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.user.filters
 * @since 0.1
 *
 */
namespace yupe\filters;

use CAccessControlFilter;
use CHttpException;
use Yii;
use yupe\components\WebModule;

class YBackAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        $ips = $filterChain->controller->yupe->getAllowedIp();

        if (!empty($ips) && !in_array(Yii::app()->getRequest()->getUserHostAddress(), $ips)) {
            throw new CHttpException(404);
        }

        if (Yii::app()->user->isSuperUser()) {
            return true;
        }

        if (Yii::app()->user->isGuest)
        {
            Yii::app()->user->loginUrl = array('/user/account/backendlogin');
        }

        // если включен rbac, то он сам разберется какие страницы показывать
        if (Yii::app()->hasModule('rbac'))
        {
            return true;
        }
        else
        {
            if (Yii::app()->user->isGuest)
            {
                if ($filterChain->controller->yupe->hidePanelUrls == WebModule::CHOICE_YES)
                {
                    throw new CHttpException(404);
                }
                Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getUrl());
                $filterChain->controller->redirect(array('/user/account/backendlogin'));
            }
            else
            {
                // если пользователь авторизован, но не администратор, перекинем его на страницу для разлогиневшегося пользователя
                $filterChain->controller->redirect(Yii::app()->createAbsoluteUrl(Yii::app()->getModule('user')->logoutSuccess));
            }
            // не ясен смысл этой конструкции, если это где-то использовалось, то надо там переделать получение ответа
            /*if (Yii::app()->getRequest()->getIsAjaxRequest())
            {
                Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Session expired...'));
            }*/
        }
    }
}