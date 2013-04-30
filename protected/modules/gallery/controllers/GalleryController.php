<?php
class GalleryController extends YFrontController
{
    const GALLERY_PER_PAGE = 10;

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider(
            'Gallery', array(
                'criteria' => array(
                    'scopes' => 'published'
                )
            )
        );
        $this->render('list', array('dataProvider' => $dataProvider));
    }

    public function actionShow($id)
    {
        if (($gallery = Gallery::model()->published()->findByPk($id)) === null)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $image = new Image;

        if (Yii::app()->request->isPostRequest && !empty($_POST['Image'])) {
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $image->attributes = $_POST['Image'];
                if ($image->save() && $gallery->addImage($image)) {
                    $transaction->commit();
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('GalleryModule.gallery', 'Фотография добавлена!')
                    );
                    $this->redirect(array('/gallery/gallery/show', 'id' => $gallery->id));
                }
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        $this->render(
            'show', array(
                'image'        => $image,
                'model'        => $gallery,
            )
        );
    }

    public function actionFoto($id)
    {
        $model = Image::model()->findByPk((int) $id);
        if (!$model)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));
        $this->render('foto', array('model' => $model));
    }

    /**
     * Ajax/Get-обёртка для удаления изображения:
     *
     * @param int $id - id-изображения
     *
     * @return void
     **/
    public function actionDeleteImage($id = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $message = Yii::t(
            'GalleryModule.gallery', 'Изображение #{id} {result} удалено!', array(
                '{id}' => $id,
                '{result}' => ($result = $image->delete())
                    ? Yii::t('GalleryModule.gallery', 'успешно')
                    : Yii::t('GalleryModule.gallery', 'не')
            )
        );

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);
        }

        Yii::app()->user->setFlash(
            $result ? YFlashMessages::NOTICE_MESSAGE : YFlashMessages::ERROR_MESSAGE,
            $message
        );

        $this->redirect(
            Yii::app()->request->urlReferer(
                $this->createAbsoluteUrl('gallery/gallery/list')
            )
        );
    }

    /**
     * Ajax/Get-обёртка для редактирования изображения:
     *
     * @param int $id - id-изображения
     *
     * @return void
     **/
    public function actionEditImage($id = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        if ((Yii::app()->request->isPostRequest || Yii::app()->request->isAjaxRequest)
            && Yii::app()->request->getPost('Image') !== null
        ) {
            
            $image->setAttributes(Yii::app()->request->getPost('Image'));

            if ($image->validate() && $image->save()) {

                $message = Yii::t(
                    'GalleryModule.gallery', 'Изображение #{id} отредактировано!', array(
                        '{id}' => $id,
                    )
                );

                if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->success(
                        array(
                            'message' => $message,
                            'type'    => 'saved',
                        )
                    );

                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    $message
                );

                $this->redirect(
                    array('/gallery/gallery/show', 'id' => $image->gallery[0]->id)
                );
            }
        }

        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
            Yii::app()->ajax->success(
                array(
                    'form'    => $this->renderPartial('_add_foto_form', array('model' => $image), true)
                )
            );
        $this->render('editimage', array('model' => $image));
    }
}