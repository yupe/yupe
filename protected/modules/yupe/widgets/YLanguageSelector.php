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
        $langs = array_keys($this->getController()->yupe->getLanguagesList());

        if (count($langs) <= 1) {
            return false;
        }

        if (!Yii::app()->getUrlManager() instanceof \yupe\components\urlManager\LangUrlManager) {
            Yii::log(
                'For use multi lang, please, enable "upe\components\urlManager\LangUrlManager" as default UrlManager',
                \CLogger::LEVEL_WARNING
            );

            return false;
        }

        if ($this->enableFlag) {
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->getTheme()->getAssetsUrl() . '/css/flags.css');
        }

        $this->render(
            $this->view,
            [
                'langs'           => $langs,
                'currentLanguage' => Yii::app()->getLanguage(),
                'cleanUrl'        => Yii::app()->getUrlManager()->getCleanUrl(Yii::app()->getRequest()->getUrl()),
                'homeUrl'         => Yii::app()->getHomeUrl() . (Yii::app()->getHomeUrl()[strlen(
                        Yii::app()->getHomeUrl()
                    ) - 1] != "/" ? '/' : ''),
            ]
        );
    }
}
