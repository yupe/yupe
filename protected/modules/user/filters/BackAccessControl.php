<?php
class BackAccessControl extends CFilter
{
    public function preFilter(CFilterChain  $filterChain)
    {
        if (Yii::app()->user->isSuperUser()) {
            return true;
        }
        $filterChain->controller->redirect(array(Yii::app()->user->loginUrl));
    }
}

?>