<?php

/**
 * Виджет учета перехода по ссылкам
 *
 * @category YupeWidget
 * @package  yupe.modules.metrika.widgets
 * @author   apexwire <apexwire@amylabs.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

class MetrikaWidget extends yupe\widgets\YWidget
{
    public $view = 'view';

    public function init()
    {
        $this->publishAssets();
    }

    public function publishAssets()
    {
        Yii::app()->clientScript->registerCoreScript('jquery');
    }

    public function run()
    {
        $this->render($this->view, array(
            'url' => Yii::app()->getBaseUrl(true).'/metrika'
        ));
    }
}