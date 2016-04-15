<?php

/**
 * ImageBackendController контроллер для управления изображениями в панели упраления
 *
 * @category YupeController
 * @package  yupe.modules.image.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class ImageBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Image.ImageBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Image.ImageBackend.View']],
            ['allow', 'actions' => ['create','AjaxImageUpload','AjaxImageChoose'], 'roles' => ['Image.ImageBackend.Create']],
            ['allow', 'actions' => ['update', 'sortable'], 'roles' => ['Image.ImageBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Image.ImageBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'AjaxImageUpload' => [
                'class'     => 'yupe\components\actions\YAjaxImageUploadAction',
                'maxSize'   => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types'     => $this->module->allowedExtensions
            ],
            'AjaxImageChoose' => [
                'class' => 'yupe\components\actions\YAjaxImageChooseAction'
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Image',
                'attribute' => 'sort'
            ]
        ];
    }

    /**
     * Отображает изображение по указанному идентификатору
     *
     * @param integer $id Идинтификатор изображение для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Image();

        if (($data = Yii::app()->getRequest()->getPost('Image')) !== null) {

            $model->setAttributes($data);

            $transaction = Yii::app()->db->beginTransaction();

            try {

                if ($model->save()) {

                    if (Yii::app()->hasModule('gallery') && $model->galleryId) {
                        if (!$model->setGalleryId($model->galleryId)) {
                            throw new CDbException(Yii::t(
                                'ImageModule.image',
                                'There is an error when adding new image =('
                            ));
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('ImageModule.image', 'Image created!')
                    );

                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost(
                            'submit-type',
                            ['create']
                        )
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование изображения.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Image')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ImageModule.image', 'Image updated!')
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
     * Удаяет модель изображения из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id - идентификатор изображения, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ImageModule.image', 'Image removed!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('ImageModule.image', 'Bad request. Please don\'t repeat similar requests anymore')
            );
        }
    }

    /**
     * Управление изображениями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Image('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Image',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = Image::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('ImageModule.image', 'Requested page was not found!')
            );
        }

        return $model;
    }
}
