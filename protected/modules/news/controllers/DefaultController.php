<?php
/**
 * DefaultController контроллер для работы с новостями в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.news.controllers
 * @since 0.1
 *
 */
class DefaultController extends yupe\components\controllers\BackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new News;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && isset($_POST['News']))
        {
            $model->setAttributes(Yii::app()->request->getPost('News'));

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('NewsModule.news', 'News article was created!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->request->getQuery('id');
        $lang = Yii::app()->request->getQuery('lang');

        if(!empty($id) && !empty($lang)){
            $news = News::model()->findByPk($id);
            if(null === $news){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('NewsModule.news','Targeting news was not found!'));
                $this->redirect(array('/news/default/create'));
            }
            if(!array_key_exists($lang,$languages)){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('NewsModule.news','Language was not found!'));
                $this->redirect(array('/news/default/create'));
            }
            Yii::app()->user->setFlash(YFlashMessages::SUCCESS_MESSAGE,Yii::t('NewsModule.news','You inserting translation for {lang} language',array(
                        '{lang}' => $languages[$lang]
                    )));
            $model->lang = $lang;
            $model->alias = $news->alias;
            $model->date = $news->date;
            $model->category_id = $news->category_id;
            $model->title = $news->title;
        }else{
            $model->date = date('d.m.Y');
            $model->lang = Yii::app()->language;
        }

        $this->render('create', array('model' => $model, 'languages' => $languages));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param null $alias
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel((int)$id);

        if (Yii::app()->request->isPostRequest && isset($_POST['News'])) {
            $model->setAttributes(Yii::app()->request->getPost('News'));
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('NewsModule.news', 'News article was updated!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        // найти по alias страницы на других языках
        $langModels = News::model()->findAll('alias = :alias AND id != :id',array(
            ':alias' => $model->alias,
            ':id' => $model->id
        ));

        $this->render('update',array(
            'langModels' => CHtml::listData($langModels,'lang','id'),
            'model' => $model,
            'languages' => $this->yupe->getLanguagesList()
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param null $alias
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     * @return void
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('NewsModule.news', 'Bad raquest. Please don\'t use similar requests anymore!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new News('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = News::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('NewsModule.news', 'Requested page was not found!'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}