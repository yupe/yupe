<?php
/**
 * Виджет для отображения выбора языка сайта
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     https://yupe.ru
 *
 **/
namespace yupe\widgets;

use Yii;

/**
 * Class YLanguageSelector
 * @package yupe\widgets
 */
class YLanguageSelector extends YWidget
{
    /**
     * @var bool
     */
    public $enableFlag = true;

    /**
     * @var string
     */
    public $view = 'languageselector';


    /**
     * @inheritdoc
     */
    public function run()
    {
        $langs = array_keys($this->getController()->yupe->getLanguagesList());

        if (count($langs) <= 1) {
            return;
        }

        if (!Yii::app()->getUrlManager() instanceof \yupe\components\urlManager\LangUrlManager) {
            Yii::log(
                'For use multi lang, please, enable "upe\components\urlManager\LangUrlManager" as default UrlManager',
                \CLogger::LEVEL_WARNING
            );

            return;
        }

        if ($this->enableFlag) {
            Yii::app()->getClientScript()->registerCssFile(Yii::app()->getTheme()->getAssetsUrl().'/css/flags.css');
        }


        $this->render(
            $this->view,
            [
                'langs' => $langs,
                'currentLanguage' => Yii::app()->getLanguage(),
                'currentUrl' => Yii::app()->getRequest()->getUrl(),
            ]
        );
    }
}
