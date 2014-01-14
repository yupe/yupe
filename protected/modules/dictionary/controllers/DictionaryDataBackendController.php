<?php
/**
 * DictionaryDataBackend контроллер для управления данными справочников в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.dictionary
 * @since     0.6
 *
 */
class DictionaryDataBackendController extends yupe\components\controllers\BackController
{
    /**
     * Displays a particular model.
     * 
     * @param integer $id the ID of the model to be displayed
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new DictionaryData;

        $gid = (int) Yii::app()->getRequest()->getQuery('gid');
        
        if ($gid) {
            $model->group_id = $gid;
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (($data = Yii::app()->getRequest()->getPost('DictionaryData')) !== null) {
            
            $model->setAttributes($data);

            if ($model->save()) {
                
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (($data = Yii::app()->getRequest()->getPost('DictionaryData')) !== null) {
            
            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('DictionaryModule.dictionary', 'Record was updated')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array('update', 'id' => $model->id)
                    )
                );
            }
        }

        $this->render('update', array('model' => $model));
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
                (array) Yii::app()->getRequest()->getPost(
                    'returnUrl', 'index'
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
        $model = new DictionaryData('search');
        
        $model->unsetAttributes();  // clear any default values

        $group_id = (int) Yii::app()->getRequest()->getQuery('group_id');
        
        if ($group_id) {
            $model->group_id = $group_id;
        }

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'DictionaryData', array()
            )
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * 
     * @param integer the ID of the model to be loaded
     *
     * @return DictionaryData $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = DictionaryData::model()->findByPk((int) $id);
        
        if ($model === null) {
            throw new CHttpException(
                404,
                Yii::t('DictionaryModule.dictionary', 'Requested page was not found')
            );
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     * 
     * @param CModel the model to be validated
     *
     * @return void
     */
    protected function performAjaxValidation(DictionaryData $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'dictionary-data-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}