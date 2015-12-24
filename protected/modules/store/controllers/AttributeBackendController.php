<?php

class AttributeBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Store.AttributeBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.AttributeBackend.View'],],
            ['allow', 'actions' => ['create', 'groupCreate'], 'roles' => ['Store.AttributeBackend.Create'],],
            ['allow', 'actions' => ['update', 'sortable', 'inlineEditGroup', 'groupCreate'], 'roles' => ['Store.AttributeBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Store.AttributeBackend.Delete'],],
            ['deny',],
        ];
    }

    public function actions()
    {
        return [
            'inlineEditGroup' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'AttributeGroup',
                'validAttributes' => ['name'],
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'AttributeGroup'
            ]
        ];
    }

    /**
     * Отображает атрибут по указанному идентификатору
     *
     * @param integer $id Идентификатор атрибута для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель атрибута.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Attribute();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('Attribute')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Attribute created')
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


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('Attribute')) !== null) {
            $currentType = $model->type;
            $model->setAttributes(Yii::app()->getRequest()->getPost('Attribute'));

            if ($model->save() && $model->changeType($currentType, $model->type)) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Attribute updated')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model->id,
                        ]
                    )
                );
            }
        }

        $this->render(
            'update',
            [
                'model' => $model,
            ]
        );
    }

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


    public function actionIndex()
    {
        $model = new Attribute('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Attribute'])) {
            $model->attributes = $_GET['Attribute'];
        }

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id - идентификатор нужной модели
     *
     * @return Attribute $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Attribute::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel $model - модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(Attribute $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'attribute-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionGroupCreate()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $group = new AttributeGroup();
            $group->name = Yii::app()->getRequest()->getParam('name');
            if ($group->save()) {
                Yii::app()->ajax->success();
            }
            Yii::app()->ajax->failure($group->getErrors());
        }
    }
}
