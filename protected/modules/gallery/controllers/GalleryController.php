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
        $model = Gallery::model()->findByPk((int) $id);

        if (!$model)
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Страница не найдена!'));

        $image = new Image;
        $gallery = new ImageToGallery;

        if (Yii::app()->request->isPostRequest && !empty($_POST['Image']))
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                $image->attributes = $_POST['Image'];
                if ($image->save())
                {
                    $gallery->gallery_id = $model->id;
                    $gallery->image_id = $image->id;
                    if ($gallery->save())
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('GalleryModule.gallery', 'Фотография добавлена!')
                        );
                        $this->redirect(array('/gallery/gallery/show', 'id' => $model->id));
                    }
                }
                throw new CDbException(Yii::t('GalleryModule.gallery', Yii::t('GalleryModule.gallery', 'При добавлении изображения произошла ошибка!')));
            }
            catch (Exception $e)
            {
                $transaction->rollback();
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('GalleryModule.gallery', 'При добавлении изображения произошла ошибка!')
                );
            }
        }

        $dataProvider = new CActiveDataProvider('ImageToGallery', array(
            'criteria'   => array(
                'condition' => 'gallery_id = :gallery_id',
                'params'    => array(':gallery_id' => $model->id),
                'limit'     => self::GALLERY_PER_PAGE,
                'order'     => 't.creation_date DESC',
                'with'      => 'image',
            ),
            'pagination' => array('pageSize' => self::GALLERY_PER_PAGE),
        ));

        $this->render('show', array(
            'image'        => $image,
            'model'        => $model,
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