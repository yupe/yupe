<?php

class SitemapBackendController extends \yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['settings'], 'roles' => ['Sitemap.SitemapBackend.Settings']],
            ['allow', 'actions' => ['inlineModel', 'inlinePage'], 'roles' => ['Sitemap.SitemapBackend.Update']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inlineModel' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'SitemapModel',
                'validAttributes' => ['changefreq', 'priority', 'status'],
            ],
            'inlinePage' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'SitemapPage',
                'validAttributes' => ['url', 'changefreq', 'priority', 'status'],
            ]
        ];
    }

    public function actionSettings()
    {
        $sitemapPage = new SitemapPage('search');
        $sitemapPage->unsetAttributes();
        $sitemapPage->setAttributes(Yii::app()->getRequest()->getParam('SitemapPage', []));

        if (Yii::app()->getRequest()->isPostRequest) {
            \yupe\models\Settings::saveModuleSettings($this->getModule()->id, ['cacheTime' => Yii::app()->getRequest()->getParam('cacheTime')]);
            $this->getModule()->getSettings(true);
            $this->redirect('settings');
        }
        $this->render('settings', ['sitemapPage' => $sitemapPage]);
    }

    public function actionCreatePage()
    {
        if ($data = Yii::app()->getRequest()->getPost('SitemapPage')) {
            $model = new SitemapPage();
            $model->setAttributes($data);
            $model->save();
        }
        $this->redirect(['settings']);
    }
}
