<?php

use yupe\components\controllers\BackController;
use yupe\widgets\YFlashMessages;

/**
 * Class SitemapBackendController
 */
class SitemapBackendController extends BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'roles' => ['SitemapModule.SitemapBackend.manage']],
            ['deny'],
        ];
    }

    /**
     * @return array
     */
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
            ],
        ];
    }

    /**
     *
     */
    public function actionSettings()
    {
        $pages = new SitemapPage('search');
        $pages->unsetAttributes();
        $pages->setAttributes(
            Yii::app()->getRequest()->getParam('SitemapPage', [])
        );
        $this->render('settings', ['pages' => $pages->search(), 'page' => $pages]);
    }

    /**
     *
     */
    public function actionCreatePage()
    {
        $model = new SitemapPage('search');

        if ($data = Yii::app()->getRequest()->getPost('SitemapPage')) {
            $model->setAttributes($data);
            if ($model->save()) {
                Yii::app()->getUser()->setFlash(YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('SitemapModule.sitemap', 'Page added!'));
                $this->redirect(['settings']);
            }
        }

        $this->render('settings', ['pages' => $model->search(), 'page' => $model]);
    }

    /**
     * @throws CHttpException
     */
    public function actionRegenerate()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getPost('do')) {
            throw new CHttpException(404);
        }

        if (\yupe\helpers\YFile::rmIfExists($this->getModule()->getSiteMapPath())) {
            Yii::app()->getUser()->setFlash(YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('SitemapModule.sitemap', 'message.success'));
            Yii::app()->ajax->success();
        }

        Yii::app()->getUser()->setFlash(YFlashMessages::ERROR_MESSAGE,
            Yii::t('SitemapModule.sitemap', 'message.error'));
        Yii::app()->ajax->failure();
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $page = SitemapPage::model()->findByPk($id);

            if (null === $page) {
                throw new CHttpException(404);
            }

            $page->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['settings']);
            }
        }
    }
}
