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

/**
 * Class HomepageModule
 */
class HomepageModule extends yupe\components\WebModule
{
    /**
     *
     */
    const VERSION = '0.9.9';

    /**
     *
     */
    const MODE_POSTS = 1;

    /**
     *
     */
    const MODE_PAGE = 2;

    /**
     *
     */
    const MODE_STORE = 3;

    /**
     * @var int
     */
    public $mode = 1;

    /**
     * @var
     */
    public $limit;

    /**
     * @var
     */
    public $target;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            'blog',
            'page'
        ];
    }

    /**
     * @return array
     */
    public function getModes()
    {
        $modes = [];
        if (Yii::app()->hasModule('blog')) {
            $modes[self::MODE_POSTS] = Yii::t('HomepageModule.homepage', 'Posts');
        }
        if (Yii::app()->hasModule('page')) {
            $modes[self::MODE_PAGE] = Yii::t('HomepageModule.homepage', 'Page');
        }
        if (Yii::app()->hasModule('store')) {
            $modes[self::MODE_STORE] = Yii::t('HomepageModule.homepage', 'Store');
        }
        if (empty($modes)) {
            $modes[null] = Yii::t('HomepageModule.homepage', 'Please activate "Blogs" or/and "Pages" module');
        }

        return $modes;
    }

    /**
     * @return array
     */
    public function getTargets()
    {
        if ($this->mode == self::MODE_POSTS) {
            return CHtml::listData(Post::model()->public()->published()->findAll(), 'id', 'title');
        }

        if ($this->mode == self::MODE_PAGE) {
            return CHtml::listData(Page::model()->public()->published()->findAll(), 'id', 'title');
        }

        return [];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('HomepageModule.homepage', 'Home page');
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return self::VERSION;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('HomepageModule.homepage', 'Structure');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('HomepageModule.homepage', 'Main page management module');
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return 'amylabs team';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://amylabs.ru';
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return 'hello@amylabs.ru';
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-home';
    }

    /**
     * @return array
     */
    public function getAdminPageLink()
    {
        return ['/yupe/backend/modulesettings', 'module' => 'homepage'];
    }

    /**
     * @return array
     */
    public function getEditableParams()
    {
        return [
            'mode' => $this->getModes(),
            'target' => $this->getTargets(),
            'limit'
        ];
    }

    /**
     * @return array
     */
    public function getEditableParamsGroups()
    {
        return [
            '0.main' => [
                'label' => Yii::t('HomepageModule.homepage', 'Main settings'),
                'items' => [
                    'mode',
                    'target',
                    'limit'
                ]
            ]
        ];
    }

    /**
     * @return array
     */
    public function getParamsLabels()
    {
        return [
            'mode' => Yii::t('HomepageModule.homepage', 'Whats will be displayed'),
            'limit' => Yii::t('HomepageModule.homepage', 'Pages count'),
            'target' => Yii::t('HomepageModule.homepage', 'Page or post')
        ];
    }

    /**
     *
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return bool
     */
    public function getIsInstallDefault()
    {
        return true;
    }

    /**
     * @return array
     */
    public function getAuthItems()
    {
        return [
            [
                'name' => 'ManageHomePage',
                'description' => Yii::t('HomepageModule.homepage', 'Manage home page'),
                'type' => AuthItem::TYPE_TASK,
                'items' => [
                    [
                        'type' => AuthItem::TYPE_OPERATION,
                        'name' => 'Homepage.YupeBackend.Modulesettings',
                        'description' => Yii::t('HomepageModule.homepage', 'Manage home page')
                    ],
                ]
            ]
        ];
    }
}
