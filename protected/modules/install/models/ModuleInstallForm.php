<?php
class ModuleInstallForm extends YFormModel
{
    public function rules()
    {
        return array(
            array('name', 'safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'  => Yii::t('install', 'модуль'),
        );
    }

    public function attributeDescriptions()
    {
        return array(
            'name'  => Yii::t('install', 'модуль'),
        );
    }
}