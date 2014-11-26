<?php
/**
 * YFrontAccessControl фильтр, контроллирующий доступ к публичной части сайта
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
use Yii;
use yupe\helpers\Url;

class YFrontUnAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        if ( !Yii::app()->getUser()->isAuthenticated() ) {
            return true;
        }

        $filterChain->controller->redirect(Url::redirectUrl(Yii::app()->getBaseUrl(true)));
    }
}
