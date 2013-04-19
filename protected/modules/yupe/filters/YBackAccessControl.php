<?php
class YBackAccessControl extends CAccessControlFilter
{
    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isSuperUser())
            return true;
        elseif (Yii::app()->user->isGuest)
            Yii::app()->request->redirect(
                Yii::app()->createAbsoluteUrl('/user/account/backendlogin')
            );
        $this->accessDenied(Yii::app()->user, Yii::t('yii', 'You are not authorized to perform this action.'));
    }
}