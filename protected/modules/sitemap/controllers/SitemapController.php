<?php

class SitemapController extends yupe\components\controllers\FrontController
{
    public $cacheKey = "sitemap::sitemap.xml";
    public $cacheKeyLock = "sitemap::lock";

    public function actionIndex()
    {
        if (!($xml = Yii::app()->cache->get($this->cacheKey))) {

            if (!Yii::app()->cache->get($this->cacheKeyLock)) {
                Yii::app()->cache->set($this->cacheKeyLock, true, 90);


                $modules = require_once(Yii::getPathOfAlias('application.modules.sitemap.config') . DIRECTORY_SEPARATOR . 'modules.php');

                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

                $activeModels = SitemapModel::model()->active()->findAll();

                /* @var $item SitemapModel */
                foreach ($activeModels as $item) {
                    if (isset($modules[$item->module]) && isset($modules[$item->module][$item->model])) {
                        $options = $modules[$item->module][$item->model];
                        $module = Yii::app()->getModule($item->module);
                        if ($module->isInstalled) {
                            $dataProvider = $options['getDataProvider']();
                            $iterator = new CDataProviderIterator($dataProvider, 100);
                            foreach ($iterator as $model) {
                                $xml .= $this->getUrlRow(
                                    $options['getUrl']($model),
                                    $item->changefreq,
                                    $item->priority,
                                    $options['getLastMod']($model)
                                );
                            }
                        }
                    }
                }

                $host = Yii::app()->getRequest()->hostInfo;
                $pages = SitemapPage::model()->active()->findAll();
                foreach ($pages as $page) {
                    $xml .= $this->getUrlRow($host . '/' . ltrim(str_replace($host, '', $page->url), '/'), $page->changefreq, $page->priority);
                }

                $xml .= '</urlset>';
                Yii::app()->cache->set($this->cacheKey, $xml, $this->getModule()->cacheTime * 3600 + 1);
                Yii::app()->cache->delete($this->cacheKeyLock);
            } else {
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
            }
        }

        header("Content-type: text/xml");
        echo $xml;
        Yii::app()->end();
    }

    private function getUrlRow($loc, $changefreq = SitemapHelper::DAILY, $priority = 0.5, $lastmod = null)
    {
        $res = '<url>';
        $res .= '<loc>' . $loc . '</loc>';
        $res .= '<changefreq>' . $changefreq . '</changefreq>';
        $res .= '<priority>' . $priority . '</priority>';
        if ($lastmod) {
            $res .= '<lastmod>' . SitemapHelper::dateToW3C($lastmod) . '</lastmod>';
        }
        $res .= '</url>';
        return $res;
    }
}
