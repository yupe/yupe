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

/**
 * Class YBackAccessControl
 * @package yupe\filters
 */
class YBackAccessControl extends CAccessControlFilter
{
    /**
     * @param \CFilterChain $filterChain
     * @return bool
     * @throws CHttpException
     */
    public function preFilter($filterChain)
    {
        $ips = $filterChain->controller->yupe->getAllowedIp();

        if (!empty($ips) && !in_array(Yii::app()->getRequest()->getUserHostAddress(), $ips)) {
            throw new CHttpException(404);
        }

        Yii::app()->getUser()->loginUrl = ['/user/account/backendlogin'];

        if (Yii::app()->getUser()->isGuest) {
            if ($filterChain->controller->yupe->hidePanelUrls == WebModule::CHOICE_YES) {
                throw new CHttpException(404);
            }
            Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getUrl());
            $filterChain->controller->redirect(['/user/account/backendlogin']);
        }

        if (Yii::app()->getUser()->isSuperUser()) {
            return true;
        }

        // если пользователь авторизован, но не администратор, перекинем его на страницу для разлогиневшегося пользователя
        $filterChain->controller->redirect(Yii::app()->createAbsoluteUrl(Yii::app()->getModule('user')->logoutSuccess));
    }
}
