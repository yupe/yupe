<?php
class HpModule extends YWebModule
{
    const MODE_POSTS = 1;

    const MODE_PAGE = 2;

    public $mode;

    public $limit;

    public $target;

    public function getModes()
    {
        $modes = array();
        if(Yii::app()->hasModule('blog')){
            $modes[self::MODE_POSTS] = Yii::t('HpModule.hp', 'Посты');
        }
        if(Yii::app()->hasModule('page')){
            $modes[self::MODE_PAGE] = Yii::t('HpModule.hp', 'Страница');
        }
        if(empty($modes)){
            $modes[null] = Yii::t('HpModule.hp', 'Активируйте модуль "блоги" и/или "страницы"');
        }
        return $modes;
    }

    public function getTargets()
    {
        if($this->mode == self::MODE_POSTS){
            return CHtml::listData(Post::model()->public()->published()->findAll(),'id','title');
        }

        if($this->mode == self::MODE_PAGE){
            return CHtml::listData(Page::model()->public()->published()->findAll(),'id','title');
        }

        return array();
    }



    public function getName()
    {
        return Yii::t('HpModule.hp', 'Домашняя страница');
    }

    public function getCategory()
    {
        return Yii::t('HpModule.hp', 'Юпи!');
    }

    public function getDescription()
    {
        return Yii::t('HpModule.hp', 'Модуль для управления главной страницей');
    }

    public function getAuthor()
    {
        return Yii::t('HpModule.hp', 'Андрей Опейкин');
    }

    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru';
    }

    public function getIcon()
    {
        return 'home';
    }

    public function getAdminPageLink()
    {
        return sprintf('/yupe/backend/modulesettings/%s',$this->getId());
    }

    public function getEditableParams()
    {
        return array(
            'mode'  => $this->getModes(),
            'limit',
            'target' => $this->getTargets()
        );
    }

    public function getParamsLabels()
    {
        return array(
            'mode' => Yii::t('HpModule.hp', 'Что отображать'),
            'limit' => Yii::t('HpModule.hp', 'Кол-во записей (только для постов)'),
            'target' => Yii::t('HpModule.hp', 'Страница или пост')
        );
    }

    public function init()
    {
        parent::init();
    }

}