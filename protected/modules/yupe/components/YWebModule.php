<?php
abstract class YWebModule extends CWebModule
{
    const CHECK_ERROR = 'error';

    public $adminMenuOrder = 0;

    public function getVersion()
    {
        return '0.1';
    }

    public function getUrl()
    {
        return 'http://yupe.ru';
    }

    public function getAuthor()
    {
        return Yii::t('yupe', 'Сообщество Юпи!');
    }

    public function getAuthorEmail()
    {
        return 'support@yupe.ru';
    }

    public function getAdminPageLink()
    {
        return '/' . strtolower($this->id) . '/default/admin/';
    }

    public function checkSelf()
    {
        return true;
    }

    public function getCategory()
    {
        return null;
    }

    public function getParamsLabels()
    {
        return array(
            'adminMenuOrder' => Yii::t('yupe', 'Порядок следования в меню'),
        );
    }

    public function getEditableParams()
    {
        return array('adminMenuOrder');
    }

    public function getAdminMenuOrder()
    {
        return $this->adminMenuOrder;
    }

    public function getIsShowInAdminMenu()
    {
        return true;
    }

    public function init()
    {
        parent::init();

        if (is_object(Yii::app()->theme))
        {
            $this->layout = 'webroot.themes.' . Yii::app()->theme->name . '.views.layouts.main';
        }

        // инициализация модуля		
        $settings = Settings::model()->cache(Yii::app()->yupe->coreCacheTime)->findAll('module_id = :module_id', array('module_id' => $this->getId()));

        $editableParams = $this->getEditableParams();

        //@TODO обход не settings а editableParams как вариант =)
        foreach ($settings as $model)
        {
            $propertie = $model->param_name;

            if (property_exists($this, $propertie) && in_array($propertie, $editableParams))
            {
                $this->$propertie = $model->param_value;
            }
        }
    }
}