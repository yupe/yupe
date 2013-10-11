<?php
/**
 * HpModule основной класс модуля hp
 *
 * @author Andrey Opeykin <hello@amylabs.ru>
 * @link http://amylabs.ru
 * @copyright 2013 amyLabs
 * @package yupe.modules.hp
 * @since 0.1
 *
 */

class HpModule extends yupe\components\WebModule
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
            $modes[self::MODE_POSTS] = Yii::t('HpModule.hp', 'Posts');
        }
        if(Yii::app()->hasModule('page')){
            $modes[self::MODE_PAGE] = Yii::t('HpModule.hp', 'Page');
        }
        if(empty($modes)){
            $modes[null] = Yii::t('HpModule.hp', 'Please activate "Blogs" or/and "Pages" module');
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
        return Yii::t('HpModule.hp', 'Home page');
    }

    public function getCategory()
    {
        return Yii::t('HpModule.hp', 'Yupe!');
    }

    public function getDescription()
    {
        return Yii::t('HpModule.hp', 'Main page management module');
    }

    public function getAuthor()
    {
        return Yii::t('HpModule.hp', 'Andrey Opeykin');
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
            'mode' => Yii::t('HpModule.hp', 'Whats will be displayed'),
            'limit' => Yii::t('HpModule.hp', 'Pages count'),
            'target' => Yii::t('HpModule.hp', 'Page or post')
        );
    }

    public function init()
    {
        parent::init();
    }

}