<?php
class DefaultController extends YBackController
{
    private $_model;

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view', array(
                                   'model' => $this->loadModel(),
                              ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new FeedBack;

        if (isset($_POST['FeedBack']))
        {
            $model->attributes = $_POST['FeedBack'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, 'Сообщение сохранено!');

                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
                                     'model' => $model,
                                ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();
        
        if (isset($_POST['FeedBack']))
        {
            $model->attributes = $_POST['FeedBack'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, 'Сообщение обновлено!');

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
                                     'model' => $model,
                                ));
    }


    public function actionAnswer($id)
    {
        $model = FeedBack::model()->findbyPk((int)$id);

        if (!$model)        
            throw new CHttpException(404, Yii::t('feedback', 'Страница не найдена!'));        

        $form = new AnswerForm;

        $form->setAttributes(array(
                                  'answer' => $model->answer,
                                  'is_faq' => $model->is_faq
                             ));
        

        if ($model->status == FeedBack::STATUS_ANSWER_SENDED)        
            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('feedback', 'Внимание! Ответ на это сообщение уже был отправлен!'));        

        if (Yii::app()->request->isPostRequest && isset($_POST['AnswerForm']))
        {
            $form->setAttributes($_POST['AnswerForm']);

            if ($form->validate())
            {                
                $model->setAttributes(array(
                                           'answer' => $form->answer,
                                           'is_faq' => $form->is_faq,
                                           'answer_user' => Yii::app()->user->getId(),
                                           'answer_date' => new CDbExpression('NOW()'),
                                           'status' => FeedBack::STATUS_ANSWER_SENDED
                                      ));

                if ($model->save())
                {
                    //отправка ответа
                    $body = $this->renderPartial('answerEmail',array('model' => $model),true);

                    Yii::app()->mail->send(Yii::app()->getModule('feedback')->notifyEmailFrom, $model->email, 'RE: '.$model->theme, $body);

                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('feedback', 'Ответ на сообщение отправлен!'));

                    $this->redirect(array('/feedback/default/view/', 'id' => $model->id));
                }
            }
        }
        
        $this->render('answer', array('model' => $model, 'answerForm' => $form));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))            
                $this->redirect(array('index'));            
        }
        else        
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');        
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('FeedBack');

        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new FeedBack('search');

        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['FeedBack']))        
            $model->attributes = $_GET['FeedBack'];
        

        $this->render('admin', array(
                                    'model' => $model,
                               ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null)
        {
            if (isset($_GET['id']))            
                $this->_model = FeedBack::model()->findbyPk($_GET['id']);
            
            if ($this->_model === null)            
                throw new CHttpException(404, 'The requested page does not exist.');            
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'feed-back-form')
        {
            echo CActiveForm::validate($model);

            Yii::app()->end();
        }
    }
}