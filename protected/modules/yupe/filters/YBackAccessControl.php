<?php
/**
 * YBackAccessControl фильтр, контроллирующий доступ в панель управления
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

        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Session expired...'));
        }

        Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getUrl());

        if($filterChain->controller->yupe->hidePanelUrls == WebModule::CHOICE_YES) {
            throw new CHttpException(404);
        }

        $filterChain->controller->redirect(array('/user/account/backendlogin'));
    }
}