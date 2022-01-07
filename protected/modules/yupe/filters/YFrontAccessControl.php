<?php
/**
 * YFrontAccessControl фильтр, контроллирующий доступ к публичной части сайта
 *
 * @author yupe team <support@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.user.filters
 * @since 0.1
 *
 */
namespace yupe\filters;

use CAccessControlFilter;
use Yii;

/**
 * Class YFrontAccessControl
 * @package yupe\filters
 */
class YFrontAccessControl extends CAccessControlFilter
{
    /**
     * @param \CFilterChain $filterChain
     * @return bool
     */
    public function preFilter($filterChain)
    {
        if (Yii::app()->getUser()->isAuthenticated()) {
            return true;
        }

        Yii::app()->getUser()->setReturnUrl(Yii::app()->getRequest()->getUrl());

        $filterChain->controller->redirect(['/user/account/login']);
    }
}
