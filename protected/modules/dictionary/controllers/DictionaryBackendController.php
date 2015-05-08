<?php

/**
 * DictionaryBackendController контроллер для управления справочниками в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.dictionary
 * @since     0.6
 *
 */
class DictionaryBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Dictionary.DictionaryBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Dictionary.DictionaryBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Dictionary.DictionaryBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Dictionary.DictionaryBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Dictionary.DictionaryBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'DictionaryGroup',
                'validAttributes' => ['name', 'code', 'description']
            ]
        ];
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id the ID of the model to be displayed
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new DictionaryGroup();

        if (($data = Yii::app()->getRequest()->getPost('DictionaryGroup')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('DictionaryModule.dictionary', 'Record was created')
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('DictionaryGroup')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('DictionaryModule.dictionary', 'Record was created')
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
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

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getIsAjaxRequest() || $this->redirect(
                (array)Yii::app()->getRequest()->getPost(
                    'returnUrl',
                    'index'
                )
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('DictionaryModule.dictionary', 'Bad request. Please don\'t repeate similar requests anymore')
            );
        }
    }

    /**
     * Manages all models.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new DictionaryGroup('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'DictionaryGroup',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer the ID of the model to be loaded
     *
     * @return DictionaryGroup $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = DictionaryGroup::model()->findByPk((int)$id);

        if ($model === null) {
            throw new CHttpException(
                404,
                Yii::t('DictionaryModule.dictionary', 'Requested page was not found')
            );
        }

        return $model;
    }
}
