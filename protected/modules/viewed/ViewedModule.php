<?php
use yupe\components\WebModule;

/**
 * Class ViewedModule
 */
class ViewedModule extends WebModule
{
    /**
     *
     */
    const VERSION = '1.0';

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->setImport(array(
            'viewed.components.*',
        ));
    }

    /**
     * @return bool
     */
    public function getIsShowInAdminMenu()
    {
        return false;
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return ['store'];
    }

    /**
     * @return bool
     */
    public function getAdminPageLink()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return Yii::t('ViewedModule.viewed', 'Viewed');
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return Yii::t('ViewedModule.viewed', 'Store');
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return Yii::t('ViewedModule.viewed', 'Viewed products module');
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
    public function getAuthor()
    {
        return Yii::t('FavoriteModule.favorite', 'Oleg Filimonov (Yupe team)');
    }

    /**
     * @return string
     */
    public function getAuthorEmail()
    {
        return Yii::t('FavoriteModule.favorite', 'support@yupe.ru');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return Yii::t('ViewedModule.viewed', 'http://yupe.ru');
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return 'fa fa-fw fa-eye';
    }
}
