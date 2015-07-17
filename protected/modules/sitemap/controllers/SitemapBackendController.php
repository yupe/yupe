<?php

use yupe\components\controllers\BackController;
use yupe\widgets\YFlashMessages;

class SitemapBackendController extends BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'roles' => ['SitemapModule.SitemapBackend.manage']],
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

    public function actionRegenerate()
    {
        if(!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('do')) {
            throw new CHttpException(404);
        }

        if(\yupe\helpers\YFile::rmIfExists($this->getModule()->getSiteMapPath())){
            Yii::app()->getUser()->setFlash(YFlashMessages::SUCCESS_MESSAGE, Yii::t('SitemapModule.sitemap', 'Sitemap is deleted!'));
            Yii::app()->ajax->success();
        }

        Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('SitemapModule.sitemap', 'Sitemap is not deleted!'));
        Yii::app()->ajax->failure();
    }
}
