<?php
class GalleryController extends YFrontController
{
    const GALLERY_PER_PAGE = 10;

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Gallery');
        $this->render('list', array('dataProvider' => $dataProvider));
    }

    public function actionShow($id)
    {
        $gallery = Gallery::model()->findByPk((int) $id);

        if (!$gallery)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $image = new Image;

        if (Yii::app()->request->isPostRequest && !empty($_POST['Image']))
        {
            try
            {
                $transaction = Yii::app()->db->beginTransaction();
                $image->attributes = $_POST['Image'];
                if ($image->save() && $gallery->addImage($image))
                {
                    $transaction->commit();
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('GalleryModule.gallery', 'Фотография добавлена!')
                    );
                    $this->redirect(array('/gallery/gallery/show', 'id' => $gallery->id));
                }
                //throw new CDbException(Yii::t('GalleryModule.gallery', Yii::t('GalleryModule.gallery', 'При добавлении изображения произошла ошибка!')));
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

        $dataProvider = new CActiveDataProvider('ImageToGallery', array(
            'criteria'   => array(
                'condition' => 'gallery_id = :gallery_id',
                'params'    => array(':gallery_id' => $gallery->id),
                'limit'     => self::GALLERY_PER_PAGE,
                'order'     => 't.creation_date DESC',
                'with'      => 'image',
            ),
            'pagination' => array('pageSize' => self::GALLERY_PER_PAGE),
        ));

        $this->render('show', array(
            'image'        => $image,
            'model'        => $gallery,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionFoto($id)
    {
        $model = Image::model()->findByPk((int) $id);
        if (!$model)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));
        $this->render('foto', array('model' => $model));
    }
}