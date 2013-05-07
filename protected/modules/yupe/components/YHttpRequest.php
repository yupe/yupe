<?php
/**
 * CHttpRequest переопределен для загрузки файлов через ajax, подробнее:
 * http://www.yiiframework.com/forum/index.php/topic/8689-disable-csrf-verification-per-controller-action/
 * 
 */

class YHttpRequest extends CHttpRequest
{
    public $noCsrfValidationRoutes = array();

    protected function normalizeRequest()
    {
        parent::normalizeRequest();

        if ($this->enableCsrfValidation)
        {
            foreach ($this->noCsrfValidationRoutes as $route)
            {
                if (strpos($this->pathInfo, $route) === 0)
                    Yii::app()->detachEventHandler('onBeginRequest', array($this, 'validateCsrfToken'));
            }
        }
    }

    public function urlReferer($urlIfNull = null)
    {
        return isset($_SERVER['HTTP_REFERER'])
            ? $_SERVER['HTTP_REFERER']
            : $urlIfNull;
    }
}