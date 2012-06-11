<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 07.06.12
 * Time: 12:14
 * To change this template use File | Settings | File Templates.
 *
 * CHttpRequest переопределен для загрузки файлов через ajax, подробнее http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
 *
 */
class YHttpRequest extends CHttpRequest
{
    public $noCsrfValidationRoutes = array();

    protected function normalizeRequest()
    {
        parent::normalizeRequest();

        if($this->enableCsrfValidation)
        {
            $url = Yii::app()->getUrlManager()->parseUrl($this);

            foreach($this->noCsrfValidationRoutes as $route)
            {
                if(strpos($url,$route) === 0)
                    Yii::app()->detachEventHandler('onBeginRequest',array($this,'validateCsrfToken'));
            }
        }
    }
}