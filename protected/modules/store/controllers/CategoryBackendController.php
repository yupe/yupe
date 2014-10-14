<?php

class CategoryBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'StoreCategory',
                'validAttributes' => array(
                    'status',
                    'alias'
                )
            )
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Store.CategoryBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Store.CategoryBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Store.CategoryBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Store.CategoryBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Store.CategoryBackend.View'),),
            array('deny',),
        );
    }

    /**
     * Отображает категорию по указанному идентификатору
     *
     * @param integer $id Идинтификатор категорию для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель категории.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new StoreCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('StoreCategory')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        // Указан ID новости страницы, редактируем только ее
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('StoreCategory')) !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('StoreCategory'));

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Category was changed!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array(
                            'update',
                            'id' => $model->id,
                        )
                    )
                );
            }
        }

        $this->render(
            'update',
            array(
                'model' => $model,
            )
        );
    }

    /**
     * Удаяет модель категории из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор категории, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                // поддерживаем удаление только из POST-запроса
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

                $transaction->commit();

                if (!isset($_GET['ajax'])) {
                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();

                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }

    /**
     * Управление категориями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new StoreCategory('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['StoreCategory'])) {
            $model->attributes = $_GET['StoreCategory'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id идентификатор нужной модели
     *
     * @return StoreCategory $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = StoreCategory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page was not found!'));
        }
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param StoreCategory $model модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(StoreCategory $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
