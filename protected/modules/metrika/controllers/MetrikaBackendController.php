<?php
/**
 * MetrikaBackendController контроллер для учета переходов
 *
 * @author    apexwire <apexwire@amylabs.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2014 amyLabs && Yupe! team
 * @package   yupe.modules.metrika.controllers
 * @version   0.6
 *
 */
class MetrikaBackendController extends yupe\components\controllers\BackController
{

    /**
     * Просмотр отдельной страницы
     *
     * @return void
     */
    public function actionView($id)
    {
        $modelUrl = $this->loadModel($id);
        $modelTransitions = new MetrikaTransitions();
        $modelTransitions->url_id = $modelUrl->id;

        $this->render('view', array(
            'model' => $modelUrl,
            'transitions' => $modelTransitions,
        ));
    }

    /**
     * Просмотр списка страниц
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new MetrikaUrl('search');
        
        $model->unsetAttributes(); // clear any default values
        
        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'MetrikaUrl', array()
            )
        );
        
        $this->render('index', array('model' => $model));
    }

    /**
     * Просмотр списка переходов по страницам
     *
     * @return void
     */
    public function actionTransitions()
    {
        $model = new MetrikaTransitions('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'MetrikaTransitions', array()
            )
        );

        $this->render('transitions', array('model' => $model));
    }

    public function loadModel($id)
    {
        if (($model = MetrikaUrl::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('MetrikaModule.metrika', 'Requested page was not found!')
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
    protected function performAjaxValidation(News $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'news-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}