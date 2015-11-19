<?php

/**
 * GalleryController контроллер для просмотра галерей на публичной части сайта
 *
 * @category YupeController
 * @package  yupe.modules.gallety.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class GalleryController extends \yupe\components\controllers\FrontController
{
    /**
     *
     */
    const GALLERY_PER_PAGE = 10;

    /**
     *
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(
            'Gallery', [
                'criteria' => [
                    'scopes' => 'published'
                ],
                'sort' => [
                    'defaultOrder' => 'id DESC',
                ]
            ]
        );

        $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionView($id)
    {
        if (($gallery = Gallery::model()->published()->findByPk($id)) === null) {
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Page was not found!'));
        }

        $image = new Image();

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['Image'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $image->attributes = $_POST['Image'];
                if ($image->save() && $gallery->addImage($image)) {
                    $transaction->commit();
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('GalleryModule.gallery', 'Photo was created!')
                    );
                    $this->redirect(['/gallery/gallery/view', 'id' => $gallery->id]);
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        if ($gallery->status == Gallery::STATUS_PRIVATE && $gallery->owner != Yii::app()->user->id) {
            throw new CHttpException(404);
        }

        $this->render(
            'view',
            [
                'image' => $image,
                'model' => $gallery,
            ]
        );
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionImage($id)
    {
        $model = Image::model()->findByPk((int)$id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Page was not found!'));
        }

        $this->render('image', ['model' => $model]);
    }


    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionDeleteImage($id = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false) {
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Page was not found!'));
        }

        $message = Yii::t(
            'GalleryModule.gallery',
            'Image #{id} {result} deleted',
            [
                '{id}' => $id,
                '{result}' => ($result = $image->delete())
                    ? Yii::t('GalleryModule.gallery', 'успешно')
                    : Yii::t('GalleryModule.gallery', 'не')
            ]
        );

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest()) {
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);
        }

        Yii::app()->user->setFlash(
            $result ? yupe\widgets\YFlashMessages::SUCCESS_MESSAGE : yupe\widgets\YFlashMessages::ERROR_MESSAGE,
            $message
        );

        $this->redirect(
            Yii::app()->getRequest()->urlReferer(
                $this->createAbsoluteUrl('gallery/gallery/list')
            )
        );
    }


    /**
     * @param null $id
     * @throws CException
     * @throws CHttpException
     */
    public function actionEditImage($id = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false) {
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Page was not found!'));
        }

        if ((Yii::app()->getRequest()->getIsPostRequest() || Yii::app()->getRequest()->getIsAjaxRequest())
            && Yii::app()->getRequest()->getPost('Image') !== null
        ) {

            $image->setAttributes(Yii::app()->getRequest()->getPost('Image'));

            if ($image->validate() && $image->save()) {

                $message = Yii::t(
                    'GalleryModule.gallery',
                    'Image #{id} edited',
                    [
                        '{id}' => $id,
                    ]
                );

                if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->success(
                        [
                            'message' => $message,
                            'type' => 'saved',
                        ]
                    );
                }

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    $message
                );

                $this->redirect(
                    ['/gallery/gallery/view', 'id' => $image->gallery->id]
                );
            }
        }

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest()) {
            Yii::app()->ajax->success(
                [
                    'form' => $this->renderPartial('_form', ['model' => $image], true)
                ]
            );
        }
        $this->render('edit-image', ['model' => $image]);
    }
}
