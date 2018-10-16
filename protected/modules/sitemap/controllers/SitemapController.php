<?php

use yupe\components\controllers\FrontController;


/**
 * Class SitemapController
 */
class SitemapController extends FrontController
{
    /**
     * @var
     */
    protected $generator;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->generator = Yii::app()->getComponent('sitemapGenerator');

    }

    /**
     *
     */
    public function actionIndex()
    {
        $module = Yii::app()->getModule('sitemap');

        $sitemapFile = $module->getSiteMapPath();

        if (!file_exists($sitemapFile)) {

            $staticPages = SitemapPage::model()->getData();

            $this->generator->generate($sitemapFile, $staticPages);
        }

        $this->redirect(['/sitemap/sitemap/index'], 301);
    }
}
