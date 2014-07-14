<?php
/**
 * Created by PhpStorm.
 * User: coder1
 * Date: 08.06.14
 * Time: 18:34
 */

class OrderBackendController extends yupe\components\controllers\BackController {
    public function actions()
    {
        return array(
            'inline' => array(
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'ShopOrder',
                'validAttributes' => array('recipient', 'alias', 'status')
            )
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @throws CHttpException
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('ShopOrder')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ShopModule.shop', 'Order was updated!')
                );
                $this->redirect(array('index'));
            }
        }


        $this->render(
            'update',array(
                'model'      => $model,
            )
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id the ID of the model to be deleted
     *
     * @throws CHttpException
     *
     * @return void
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.news', 'Order was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array) Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('ShopModule.news', 'Bad request. Please don\'t use similar requests anymore!')
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
        $model = new ShopOrder('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'ShopOrder', array()
            )
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
     * @return ShopOrder
     *
     * @throws CHttpException If record not found
     */
    public function loadModel($id)
    {
        $model = ShopOrder::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(
                404,
                Yii::t('ShopModule.shop', 'Requested page was not found!')
            );
        }

        return $model;
    }

    /**
     * Performs the AJAX validation.
     *
     * @param \ShopOrder $model the model to be validated
     *
     * @return void
     */
    protected function performAjaxValidation(ShopOrder $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'shoporder-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

} 