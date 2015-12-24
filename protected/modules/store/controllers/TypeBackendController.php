<?php

/**
 * Class TypeBackendController
 */
class TypeBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Store.TypeBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.TypeBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Store.TypeBackend.Create'],],
            ['allow', 'actions' => ['update'], 'roles' => ['Store.TypeBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Store.TypeBackend.Delete'],],
            ['deny',],
        ];
    }


    /**
     *
     */
    public function actionCreate()
    {
        $model = new Type();

        if (($data = Yii::app()->getRequest()->getPost('Type')) !== null) {

            $model->setAttributes($data);

            if ($model->save() && $model->storeTypeAttributes(Yii::app()->getRequest()->getPost('attributes', []))) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Product type is created')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render(
            'create',
            [
                'model' => $model,
                'availableAttributes' => Attribute::model()->findAll(),
            ]
        );
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Type')) !== null) {

            $model->setAttributes($data);

            if ($model->save() && $model->storeTypeAttributes(Yii::app()->getRequest()->getPost('attributes', []))) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Product type is updated')
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
        $criteria = new CDbCriteria();
        $criteria->addNotInCondition('id', CHtml::listData($model->attributeRelation, 'attribute_id', 'attribute_id'));
        $availableAttributes = Attribute::model()->findAll($criteria);
        $this->render('update', ['model' => $model, 'availableAttributes' => $availableAttributes]);
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            if (!Yii::app()->getRequest()->getQuery('ajax')) {
                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                );
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }


    /**
     *
     */
    public function actionIndex()
    {
        $model = new Type('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Type'])) {
            $model->attributes = $_GET['Type'];
        }

        $this->render('index', ['model' => $model]);
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
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        return $model;
    }


    protected function performAjaxValidation(Attribute $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost(
                'ajax'
            ) === 'attribute-form'
        ) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
