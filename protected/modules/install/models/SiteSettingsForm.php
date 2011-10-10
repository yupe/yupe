<?php
class SiteSettingsForm extends CFormModel
{
    public $siteName = 'Юпи!';

    public $siteDescription = 'Юпи! - самый быстрый способ создать сайт на фреймворке Yii';

    public $siteKeyWords = 'Юпи!, yupe, yii, cms, цмс';

    public function rules()
    {
        return array(
            array('siteName, siteDescription, siteKeyWords', 'required'),
            array('siteName', 'length', 'max' => 30),
            array('siteDescription, siteKeyWords', 'length', 'max' => 180),
        );
    }

    public function attributeLabels()
    {
        return array(
            'siteName' => Yii::t('install', 'Название сайта'),
            'siteDescription' => Yii::t('install', 'Описание сайта'),
            'siteKeyWords' => Yii::t('install', 'Ключевые слова сайта'),
        );
    }
}

?>