<?php

class CategoryBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Shop.CategoryBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Shop.CategoryBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Shop.CategoryBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Shop.CategoryBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Shop.CategoryBackend.View'),),
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
        $model = new ShopCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('ShopCategory')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.category', 'Record was created!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array('create')
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

        if (($data = Yii::app()->getRequest()->getPost('ShopCategory')) !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('ShopCategory'));

			if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.category', 'ShopCategory was changed!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array(
                            'update',
                            'id' => $model->id,
                        )
                    )
                );
            }
        }

        $this->render(
            'update', array(
                'model'      => $model,
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
                        (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
                    );
                }
            } catch(Exception $e) {
                $transaction->rollback();

                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('ShopModule.category', 'Bad request. Please don\'t use similar requests anymore')
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
        $model = new ShopCategory('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['ShopCategory'])) {
            $model->attributes = $_GET['ShopCategory'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return Category $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ShopCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('ShopModule.category', 'Page was not found!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(ShopCategory $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}