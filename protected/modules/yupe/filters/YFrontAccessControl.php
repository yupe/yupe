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

class YFrontAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isAuthenticated()) {
            return true;
        }

        $this->accessDenied(Yii::app()->user, Yii::t('yii', 'You are not authorized to perform this action.'));
    }
}