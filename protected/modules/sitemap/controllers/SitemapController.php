<?php

class SitemapController extends yupe\components\controllers\FrontController
{
    public $cacheKey = "sitemap::sitemap.xml";
    public $cacheKeyLock = "sitemap::lock";
    public $cacheKeyPart = "sitemap::part::";
    public $cacheKeyNumberParts = "sitemap::number::parts";

    private $maxLinksCount = 25000;

    public function actionIndex()
    {
        if (!($numberParts = Yii::app()->getCache()->get($this->cacheKeyNumberParts))) {
            if (!Yii::app()->getCache()->get($this->cacheKeyLock)) {
                Yii::app()->getCache()->set($this->cacheKeyLock, true, 90);

                set_time_limit(120);

                $urls = [];
                $cacheTime = $this->getModule()->cacheTime * 3600 + 1;

                $modules = require_once(Yii::getPathOfAlias('sitemap.config') . DIRECTORY_SEPARATOR . 'modules.php');

                foreach ($modules as $name => $moduleModels) {
                    $module = Yii::app()->getModule($name);
                    if (null != $module && $module->getIsInstalled()) {
                        foreach ($moduleModels as $options) {
                            $dataProvider = $options['getDataProvider']();
                            $iterator = new CDataProviderIterator($dataProvider, 100);
                            foreach ($iterator as $model) {
                                $urls[] = $this->getUrlRow(
                                    $options['getUrl']($model),
                                    $options['changeFreq'],
                                    $options['priority'],
                                    $options['getLastMod']($model)
                                );
                            }
                        }
                    }
                }

                $host = Yii::app()->getRequest()->hostInfo;
                $pagesDataProvider = new CActiveDataProvider(SitemapPage::model()->active(), []);
                $pagesIterator = new CDataProviderIterator($pagesDataProvider, 100);
                foreach ($pagesIterator as $page) {
                    $urls[] = $this->getUrlRow(
                        $host . '/' . ltrim(str_replace($host, '', $page->url), '/'),
                        $page->changefreq,
                        $page->priority
                    );
                }

                $parts = array_chunk($urls, $this->maxLinksCount);
                foreach ($parts as $key => $part) {
                    $xml = join("", $part);
                    Yii::app()->getCache()->set($this->cacheKeyPart . $key, $xml, $cacheTime);
                }

                $numberParts = count($parts);
                Yii::app()->getCache()->set($this->cacheKeyNumberParts, $numberParts, $cacheTime);

                Yii::app()->getCache()->delete($this->cacheKeyLock);
            }
        }

        header("Content-type: text/xml");
        echo $this->getXmlHead();

        if ($numberParts == 1) {
            echo $this->getUrlSetFromCache(0);
        } else {
            echo $this->getSitemapIndex($numberParts);
        }
        Yii::app()->end();
    }

    public function actionPart($number)
    {
        header("Content-type: text/xml");
        echo $this->getXmlHead();
        echo $this->getUrlSetFromCache($number);
    }

    private function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
    }

    private function getUrlSetFromCache($partNumber)
    {
        $res = CHtml::openTag('urlset', ['xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9']);
        $res .= Yii::app()->getCache()->get($this->cacheKeyPart . $partNumber);;
        $res .= CHtml::closeTag('urlset');

        return $res;
    }

    private function getSitemapIndex($numberParts = null)
    {
        $numberParts = $numberParts ? : Yii::app()->getCache()->get($this->cacheKeyNumberParts);
        $res = CHtml::openTag('sitemapindex', ['xmlns' => 'http://www.sitemaps.org/schemas/sitemap/0.9']);
        for ($i = 0; $i < (int)$numberParts; $i++) {
            $res .= CHtml::openTag('sitemap');
            $res .= CHtml::tag(
                'loc',
                [],
                htmlspecialchars(Yii::app()->createAbsoluteUrl('sitemap/sitemap/part', ['number' => $i]))
            );
            $res .= CHtml::closeTag('sitemap');
        }
        $res .= CHtml::closeTag('sitemapindex');

        return $res;
    }

    private function getUrlRow($loc, $changefreq = SitemapHelper::FREQUENCY_DAILY, $priority = 0.5, $lastmod = null)
    {
        $res = CHtml::openTag('url');
        $res .= CHtml::tag('loc', [], htmlspecialchars($loc));
        $res .= CHtml::tag('changefreq', [], $changefreq);
        $res .= CHtml::tag('priority', [], $priority);
        if ($lastmod) {
            $res .= CHtml::tag('lastmod', [], SitemapHelper::dateToW3C($lastmod));
        }
        $res .= CHtml::closeTag('url');

        return $res;
    }
}
