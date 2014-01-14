<?php
/**
 * Виджет для отображения выбора языка сайта
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
namespace yupe\widgets;
use Yii;

class YLanguageSelector extends YWidget
{
    public $enableFlag = true;

    public $view = 'languageselector';

    public function run()
    {
        $langs = array_keys($this->controller->yupe->getLanguagesList());
        if (count($langs) <= 1) {
            return false;
        }
        if ($this->enableFlag) {
            Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/web/css/flags.css');
        }
        $this->render(
            $this->view,
            array(
                'langs' => $langs,
                'currentLanguage' => Yii::app()->language,
                'cleanUrl' => Yii::app()->urlManager->getCleanUrl(Yii::app()->getRequest()->url),
                'homeUrl' => Yii::app()->homeUrl . (Yii::app()->homeUrl[strlen(
                    Yii::app()->homeUrl
                ) - 1] != "/" ? '/' : ''),
            )
        );
    }
}