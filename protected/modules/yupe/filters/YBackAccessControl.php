<?php
class YBackAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isSuperUser())
            return true;
        $this->accessDenied(Yii::app()->user, Yii::t('yii', 'You are not authorized to perform this action.'));
    }
}