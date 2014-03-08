<?php

class SitemapController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        $sitemapModule = Yii::app()->getModule('sitemap');
        $host          = Yii::app()->request->hostInfo;

        if (!$xml = Yii::app()->cache->get('sitemap'))
        {
            $modules = array(
                'page' => array(
                    'model' => 'Page',
                    'changefreq' => SitemapHelper::DAILY,
                    'priority' => 0.5,
                    'getUrlFunction' => function ($model)
                        {
                            return Yii::app()->createAbsoluteUrl('page/page/show', array('slug' => $model->slug));
                        },
                    'lastModAttribute' => 'change_date'
                ),
                'news' => array(
                    'model' => 'News',
                    'changefreq' => SitemapHelper::DAILY,
                    'priority' => 0.5,
                    'getUrlFunction' => function ($model)
                        {
                            return Yii::app()->createAbsoluteUrl('news/news/show', array('alias' => $model->alias));
                        },
                    'lastModAttribute' => 'change_date'
                ),
                'catalog' => array(
                    'model' => 'Good',
                    'changefreq' => SitemapHelper::DAILY,
                    'priority' => 0.5,
                    'getUrlFunction' => function ($model)
                        {
                            return Yii::app()->createAbsoluteUrl('catalog/catalog/show', array('name' => $model->alias));
                        },
                    'lastModAttribute' => 'update_time'
                ),
                'shop' => array(
                    'model' => 'Product',
                    'changefreq' => SitemapHelper::DAILY,
                    'priority' => 0.5,
                    'getUrlFunction' => function ($model)
                        {
                            return Yii::app()->createAbsoluteUrl('shop/product/show', array('name' => $model->alias));
                        },
                    'lastModAttribute' => 'update_time'
                ),
            );

            $pages = array(
                '/' => array(
                    'changefreq' => SitemapHelper::DAILY,
                    'priority' => 0.5
                ),
            );

            $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL .
                '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            foreach ($modules as $module_id => $options)
            {
                $module = Yii::app()->getModule($module_id);
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