<?php
namespace rbac\filters;

use CAccessControlFilter;
use CHttpException;
use Yii;
use yupe\components\WebModule;

class RbacBackAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        $ips = $filterChain->controller->yupe->getAllowedIp();

        if (!empty($ips) && !in_array(Yii::app()->getRequest()->getUserHostAddress(), $ips)) {
            throw new CHttpException(404);
        }

        Yii::app()->getUser()->loginUrl = ['/user/account/backendlogin'];

        if (Yii::app()->getUser()->getIsGuest()) {
            if ($filterChain->controller->yupe->hidePanelUrls == WebModule::CHOICE_YES) {
                throw new CHttpException(404);
            }
            Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getUrl());
            $filterChain->controller->redirect(['/user/account/backendlogin']);
        }

        return true;
    }
}
