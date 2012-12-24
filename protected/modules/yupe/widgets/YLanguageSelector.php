<?php

class YLanguageSelector extends YWidget
{
    public $enableFlag = true;

    public function run()
    {
        $langs = explode(',', Yii::app()->getModule('yupe')->availableLanguages);
        if (count($langs) <= 1)
            return false;
        if ($this->enableFlag)
            Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/flags.css');
        $this->render('languageselector', array(
            'langs'           => $langs,
            'currentLanguage' => Yii::app()->language,
            'cleanUrl'        => Yii::app()->urlManager->getCleanUrl(Yii::app()->request->url),
            'homeUrl'         => Yii::app()->homeUrl . (Yii::app()->homeUrl[strlen(Yii::app()->homeUrl) - 1] != "/" ? '/' : ''),
        ));
    }
}