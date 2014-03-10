<?php

class SitemapController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {

        if (!($xml = Yii::app()->cache->get('sitemap')))
        {
            if (!Yii::app()->cache->get('sitemap.lock'))
            {
                Yii::app()->cache->set('sitemap.lock', true, 90);

                $sitemapModule = Yii::app()->getModule('sitemap');
                $host          = Yii::app()->request->hostInfo;
                $modules       = require_once(Yii::getPathOfAlias('application.modules.sitemap.config') . DIRECTORY_SEPARATOR . 'modules.php');
                $pages         = require_once(Yii::getPathOfAlias('application.modules.sitemap.config') . DIRECTORY_SEPARATOR . 'pages.php');

                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
                foreach ($modules as $key => $options)
                {
                    $module = Yii::app()->getModule($options['module']);
                    if ($module->isInstalled)
                    {
                        $dataProvider = new CActiveDataProvider(CActiveRecord::model($options['model'])->published(), array());
                        $iterator     = new CDataProviderIterator($dataProvider, 100);
                        foreach ($iterator as $model)
                        {
                            $xml .= $this->getUrlRow(
                                $options['getUrlFunction']($model),
                                $options['changefreq'],
                                $options['priority'],
                                $options['lastModAttribute'] ? $model->{$options['lastModAttribute']} : null
                            );
                        }
                    }
                }

                foreach ($pages as $loc => $params)
                {
                    $xml .= $this->getUrlRow($host . $loc, $params['changefreq'], $params['priority']);
                }

                $xml .= '</urlset>';
                Yii::app()->cache->set('sitemap', $xml, $sitemapModule->cacheTime * 3600);
                Yii::app()->cache->delete('sitemap.lock');
            }
            else
            {
                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                    '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>';
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
        if ($lastmod)
        {
            $res .= '<lastmod>' . SitemapHelper::dateToW3C($lastmod) . '</lastmod>';
        }
        $res .= '</url>';
        return $res;
    }
}