<?php
class YBackAccessControl extends CFilter
{
    public function preFilter($filterChain)
    {
        if (Yii::app()->user->isSuperUser())        
            return true;        

        $filterChain->controller->redirect(array(Yii::app()->user->loginUrl));
    }
}