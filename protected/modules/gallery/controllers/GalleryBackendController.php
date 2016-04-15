<?php

/**
 * GalleryBackendController контроллер для управления галереями в панели управления
 *
 * @category YupeController
 * @package  yupe.modules.gallety.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class GalleryBackendController extends yupe\components\controllers\BackController
{
    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            [
                'postOnly + delete, addImages',
            ]
        );
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Gallery.GalleryBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Gallery.GalleryBackend.View']],
            ['allow', 'actions' => ['images'], 'roles' => ['Gallery.GalleryBackend.Images']],
            ['allow', 'actions' => ['create'], 'roles' => ['Gallery.GalleryBackend.Create']],
            ['allow', 'actions' => ['addimages'], 'roles' => ['Gallery.GalleryBackend.Addimages']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Gallery.GalleryBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Gallery.GalleryBackend.Delete']],
            ['allow', 'actions' => ['deleteImage'], 'roles' => ['Gallery.GalleryBackend.DeleteImage']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Gallery',
                'validAttributes' => ['name', 'description', 'status']
            ]
        ];
    }

    /**
     * Создает новую модель галереи.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Gallery();

        if (($data = Yii::app()->getRequest()->getPost('Gallery')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('GalleryModule.gallery', 'Record was created')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }
        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование галереи.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Gallery')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('GalleryModule.gallery', 'Record was updated')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Удаяет модель галереи из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор галереи, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('GalleryModule.gallery', 'Record was removed')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('GalleryModule.gallery', 'Bad request. Please don\'t repeat similar requests anymore')
            );
        }
    }

    /**
     * Управление галереями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Gallery('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Gallery',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Отображение изображений галереи:
     *
     * @param int $id - id-галереи
     *
     * @return void
     **/
    public function actionImages($id)
    {
        if (($gallery = Gallery::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('GalleryModule.gallery', 'Page was not found!')
            );
        }

        $image = new Image();

        if (Yii::app()->getRequest()->getIsPostRequest() && ($imageData = Yii::app()->getRequest()->getPost(
                'Image'
            )) !== null
        ) {
            $this->_addImage($image, $imageData, $gallery);
        }

        $dataProvider = new CActiveDataProvider(
            'ImageToGallery', [
                'criteria' => [
                    'condition' => 't.gallery_id = :gallery_id',
                    'params'    => [':gallery_id' => $gallery->id],
                    'order'     => 'image.sort',
                    'with'      => 'image',
                ],
            ]
        );

        $this->render(
            'images',
            [
                'dataProvider' => $dataProvider,
                'image'        => $image,
                'model'        => $gallery,
                'tab'          => !($errors = $image->getErrors())
                    ? '_images_show'
                    : '_image_add'
            ]
        );
    }

    /**
     * Метод добавления одной фотографии:
     *
     * @param Image $image - инстанс изображения
     * @param mixed $imageData - POST-массив данных
     * @param Gallery $gallery - инстанс галереи
     *
     * @return void
     **/
    private function _addImage(Image $image, array $imageData, Gallery $gallery)
    {
        try {
            $transaction = Yii::app()->getDb()->beginTransaction();
            $image->setAttributes($imageData);

            if ($image->save() && $gallery->addImage($image)) {

                $transaction->commit();

                if (Yii::app()->getRequest()->getPost('ajax') === null) {
                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('GalleryModule.gallery', 'Photo was created!')
                    );
                    $this->redirect(['/gallery/galleryBackend/images', 'id' => $gallery->id]);
                }
            }
        } catch (Exception $e) {

            $transaction->rollback();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }
    }

    /**
     * Ajax/Get-обёртка для удаления изображения:
     *
     * @param int $id - id-изображения
     * @param string $method - тип с помощью чего удаляем
     *
     * @return void
     *
     * @throws CHttpException
     **/
    public function actionDeleteImage($id = null, $method = null)
    {
        if (($image = Image::model()->findByPk($id)) === null || $image->canChange() === false) {
            throw new CHttpException(
                404,
                Yii::t('GalleryModule.gallery', 'Page was not found!')
            );
        }

        $message = Yii::t(
            'GalleryModule.gallery',
            'Image #{id} {result} deleted',
            [
                '{id}'     => $id,
                '{result}' => ($result = $image->delete())
                    ? Yii::t('GalleryModule.gallery', 'success')
                    : Yii::t('GalleryModule.gallery', 'not')
            ]
        );

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest) {
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);
        }

        Yii::app()->getUser()->setFlash(
            $result ? yupe\widgets\YFlashMessages::SUCCESS_MESSAGE : yupe\widgets\YFlashMessages::ERROR_MESSAGE,
            $message
        );

        $this->redirect(
            Yii::app()->getRequest()->urlReferer(
                $this->createAbsoluteUrl('gallery/default/images')
            )
        );
    }

    /**
     * Функция добавления группы изображений
     *
     * @param int $id - id-галереи
     *
     * @return void
     *
     * @throws CHttpException
     **/
    public function actionAddImages($id)
    {
        $gallery = $this->loadModel($id);

        $image = new Image();

        if (($imageData = Yii::app()->getRequest()->getPost('Image')) !== null) {
            $imageData = $imageData[$_FILES['Image']['name']['file']];

            $this->_addImage($image, $imageData, $gallery);
            if ($image->hasErrors()) {
                $data[] = ['error' => $image->getErrors()];
            } else {
                $data[] = [
                    'name'          => $image->name,
                    'type'          => $_FILES['Image']['type']['file'],
                    'size'          => $_FILES['Image']['size']['file'],
                    'url'           => $image->getImageUrl(),
                    'thumbnail_url' => $image->getImageUrl(80, 80),
                    'delete_url'    => $this->createUrl(
                        '/gallery/galleryBackend/deleteImage',
                        [
                            'id'     => $image->id,
                            'method' => 'uploader'
                        ]
                    ),
                    'delete_type'   => 'GET'
                ];
            }

           Yii::app()->ajax->raw($data);
        } else {
            throw new CHttpException(
                404,
                Yii::t('GalleryModule.gallery', 'Page was not found!')
            );
        }
    }

    /**
     * Для перезагрузки контента:
     *
     * @param int $id - id-галереи
     * @param string $view - необходимая вьюшка
     * @throws CHttpException
     * @return void
     **/
    public function actionReloadContent($id = null, $view = null)
    {
        if (($gallery = Gallery::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404, Yii::t('GalleryModule.gallery', 'Page was not found!')
            );
        }

        $this->renderPartial(
            $view,
            [
                'model' => $gallery,
            ]
        );
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return Gallery $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = Gallery::model()->findByPk($id)) === null) {

            throw new CHttpException(
                404,
                Yii::t('GalleryModule.gallery', 'Requested page was not found.')
            );
        }

        return $model;
    }
}
