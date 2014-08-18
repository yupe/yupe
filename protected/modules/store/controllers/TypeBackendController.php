<?php

class TypeBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Store.TypeBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Store.TypeBackend.Delete'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Store.TypeBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Store.TypeBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Store.TypeBackend.View'),),
            array('deny',),
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    public function actionCreate()
    {
        $model = new Type();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('Type')) !== null) {
            $model->setAttributes($data);
            $model->categories = serialize(Yii::app()->getRequest()->getPost('categories'));
            if ($model->save()) {
                $model->setTypeAttributes(Yii::app()->getRequest()->getPost('attributes'));

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.type', 'Тип товара создан.')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }
        //$criteria = new CDbCriteria();
        //$criteria->addNotInCondition('id', CHtml::listData($model->attributeRelation, 'attribute_id', 'attribute_id'));
        $availableAttributes = Attribute::model()->findAll();
        $this->render('create', array('model' => $model, 'availableAttributes' => $availableAttributes));
    }


    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('Type')) !== null) {
            $model->setAttributes($data);
            $model->categories = serialize(Yii::app()->getRequest()->getPost('categories'));
            if ($model->save()) {
                $model->setTypeAttributes(Yii::app()->getRequest()->getPost('attributes'));

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.type', 'Тип обновлен.')
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
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('id', CHtml::listData($model->attributeRelation, 'attribute_id', 'attribute_id'));
        $availableAttributes = Attribute::model()->findAll($criteria);
        $this->render('update', array('model' => $model, 'availableAttributes' => $availableAttributes));
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
                Yii::t('StoreModule.type', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }


    public function actionIndex()
    {
        $model = new Type('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Type'])) {
            $model->attributes = $_GET['Type'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * @param $id
     * @return Type
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Type::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.type', 'Page was not found!'));
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
}
