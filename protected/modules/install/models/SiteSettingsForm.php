<?php
class SiteSettingsForm extends YFormModel
{
    public $siteName = 'Юпи!';
    public $siteDescription = 'Юпи! - самый быстрый способ создать сайт на Yii';
    public $siteKeyWords = 'Юпи!, yupe, yii, cms, цмс';
    public $email;
    public $theme = 'default';
    public $backendTheme = '';

    public function rules()
    {
        return array(
            array('siteName, siteDescription, siteKeyWords, email', 'required'),
            array('siteName', 'length', 'max' => 64),
            array('siteDescription, siteKeyWords', 'length', 'max' => 180),
            array('email', 'email'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'siteName'        => Yii::t('InstallModule.install', 'Название сайта'),
            'siteDescription' => Yii::t('InstallModule.install', 'Описание сайта'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Ключевые слова сайта'),
            'email'           => Yii::t('InstallModule.install', 'Email администратора'),
            'theme'           => Yii::t('InstallModule.install', 'Тема оформления публичной части'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Тема оформления панели управления'),
        );
    }
    
    public function attributeDescriptions()
    {
        return array(
            'siteName'        => Yii::t('InstallModule.install', 'Используется в заголовке сайта.'),
            'siteDescription' => Yii::t('InstallModule.install', 'Используется в поле description meta-тега.'),
            'siteKeyWords'    => Yii::t('InstallModule.install', 'Используется в поле keywords meta-тега.'),
            'email'           => Yii::t('InstallModule.install', 'Используется для административной рассылки.'),
            'theme'           => Yii::t('InstallModule.install', 'Определяет внешний вид Вашего сайта.'),
            'backendTheme'    => Yii::t('InstallModule.install', 'Определяет внешний вид панели управления.'),
        );
    }

    public function getEmailName()
    {
        return User::model()->admin()->find()->getAttribute('email');
    }

}
