<?php
class SiteSettingsForm extends CFormModel
{
    public $siteName = 'Юпи!';
    public $siteDescription = 'Юпи! - самый быстрый способ создать сайт на Yii';
    public $siteKeyWords = 'Юпи!, yupe, yii, cms, цмс';
    public $email;

    public function rules()
    {
        return array(
            //@formatter:off
            array('siteName, siteDescription, siteKeyWords, email', 'required'),
            array('siteName', 'length', 'max' => 30),
            array('siteDescription, siteKeyWords', 'length', 'max' => 180),
            array('email', 'email'),
            //@formatter:on
        );
    }

    public function attributeLabels()
    {
        return array(
            'siteName' => Yii::t('install', 'Название сайта'),
            'siteDescription' => Yii::t('install', 'Описание сайта'),
            'siteKeyWords' => Yii::t('install', 'Ключевые слова сайта'),
            'email' => Yii::t('install', 'Email администратора'),
        );
    }

    public function getEmailName()
    {
        $user = User::model()->admin()->find();
        return $user->email;
    }

}
