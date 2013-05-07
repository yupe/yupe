<?php

class YLanguageSelector extends YWidget
{
    public $enableFlag = true;

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
            'languageselector',
            array(
                'langs' => $langs,
                'currentLanguage' => Yii::app()->language,
                'cleanUrl' => Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url),
                'homeUrl' => Yii::app()->homeUrl . (Yii::app()->homeUrl[strlen(
                    Yii::app()->homeUrl
                ) - 1] != "/" ? '/' : ''),
            )
        );
    }
}