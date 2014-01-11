<?php
/**
 * HomepageModule основной класс модуля homepage
 *
 * @author Andrey Opeykin <hello@amylabs.ru>
 * @link http://amylabs.ru
 * @copyright 2013 amyLabs
 * @package yupe.modules.homepage
 * @since 0.1
 *
 */
Yii::import('application.modules.page.models.Page');
Yii::import('application.modules.blog.models.Post');

class HomepageModule extends yupe\components\WebModule
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
            $modes[self::MODE_POSTS] = Yii::t('HomepageModule.homepage', 'Posts');
        }
        if(Yii::app()->hasModule('page')){
            $modes[self::MODE_PAGE] = Yii::t('HomepageModule.homepage', 'Page');
        }
        if(empty($modes)){
            $modes[null] = Yii::t('HomepageModule.homepage', 'Please activate "Blogs" or/and "Pages" module');
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
        return Yii::t('HomepageModule.homepage', 'Home page');
    }

    public function getCategory()
    {
        return Yii::t('HomepageModule.homepage', 'Yupe!');
    }

    public function getDescription()
    {
        return Yii::t('HomepageModule.homepage', 'Main page management module');
    }

    public function getAuthor()
    {
        return Yii::t('HomepageModule.homepage', 'Andrey Opeykin');
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
        return array(
            '/yupe/backend/modulesettings',
            'module' => $this->getId()
        );
    }

    public function getEditableParams()
    {
        return array(
            'mode'  => $this->getModes(),           
            'target' => $this->getTargets(),
            'limit'
        );
    }

    public function getEditableParamsGroups()
    {
        return array(
            'main' => array(
                'label' => Yii::t('YupeModule.yupe', 'Main settings'),
            )
        );
    }


    public function getParamsLabels()
    {
        return array(
            'mode' => Yii::t('HomepageModule.homepage', 'Whats will be displayed'),
            'limit' => Yii::t('HomepageModule.homepage', 'Pages count'),
            'target' => Yii::t('HomepageModule.homepage', 'Page or post')
        );
    }

    public function init()
    {
        parent::init();
    }

}