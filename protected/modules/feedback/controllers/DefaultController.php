<?php
/**
 * DefaultController контроллер для работы с сообщениями обратной связи в панели управления
 *
 * @category YupeController
 * @package  yupe.modules.feedback.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

class DefaultController extends yupe\components\controllers\BackController
{
    private $_model;

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        // Обработка при Ajax-запросе:
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            
            return Yii::app()->ajax->success(
                array(
                    'html' => $this->renderPartial('view', array('model' => $this->loadModel()), true, false)
                )
            );
        }

        $this->render('view', array('model' => $this->loadModel()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new FeedBack;

        if (($data = Yii::app()->getRequest()->getPost('FeedBack')) !== null) {
            
            $model->setAttributes($data);

            if ($model->status == FeedBack::STATUS_ANSWER_SENDED) {
                $model->answer_user = Yii::app()->user->getId();
                $model->answer_date = new CDbExpression('NOW()');
            }

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'Message saved!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
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
     */
    public function actionUpdate()
    {
        $model = $this->loadModel();

        $status = $model->status; 

        if (isset($_POST['FeedBack'])) {
            $model->attributes = $_POST['FeedBack'];

            if ($status != FeedBack::STATUS_ANSWER_SENDED && $model->status == FeedBack::STATUS_ANSWER_SENDED) {
                $model->answer_user = Yii::app()->user->getId();
                $model->answer_date = new CDbExpression('NOW()');
            }

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'Message was updated')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Экшен создания ответа на сообщение:
     * 
     * @param int $id - ID сообщения
     * 
     * @return void
     */
    public function actionAnswer($id)
    {
        $model = FeedBack::model()->findbyPk((int) $id);
        if (!$model)
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));

        $form = new AnswerForm;

        $form->setAttributes(
            array(
                'answer' => $model->answer,
                'is_faq' => $model->is_faq,
            )
        );

        // Обработка при Ajax-запросе:
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            
            if ($this->saveAnswer($form, $model) === true) {
                return true;
            }

            // Если уже отправили сообщение:
            if ($model->status == FeedBack::STATUS_ANSWER_SENDED) {
                return Yii::app()->ajax->failure(
                    array(
                        'message' => Yii::t('FeedbackModule.feedback', 'Attention! Reply for this message already sent!')
                    )
                );
            }

            return Yii::app()->ajax->success(
                array(
                    'html' => $this->renderPartial('_ajax_answer', array('model' => $model, 'answerForm' => $form), true, false) . '</div>'
                )
            );
        }

        if ($model->status == FeedBack::STATUS_ANSWER_SENDED)
            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('FeedbackModule.feedback', 'Attention! Reply for this message already sent!')
            );

        list($form, $model) = $this->saveAnswer($form, $model);

        $this->render('answer', array('model' => $model, 'answerForm' => $form));
    }

    public function saveAnswer($form, $model)
    {
        if (Yii::app()->request->isPostRequest && ($data = Yii::app()->request->getPost('AnswerForm')) !== null) {
            $form->setAttributes($data);

            if ($form->validate()) {
                $model->setAttributes(array(
                    'answer'      => $form->answer,
                    'is_faq'      => $form->is_faq,
                    'answer_user' => Yii::app()->user->getId(),
                    'answer_date' => new CDbExpression('NOW()'),
                    'status'      => FeedBack::STATUS_ANSWER_SENDED,
                 ));

                if ($model->save()) {
                    //отправка ответа
                    $body = $this->renderPartial('answerEmail', array('model' => $model), true);

                    Yii::app()->mail->send(
                        Yii::app()->getModule('feedback')->notifyEmailFrom,
                        $model->email,
                        'RE: ' . $model->theme,
                        $body
                    );
                    if (Yii::app()->getRequest()->getIsAjaxRequest() == false) {
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('FeedbackModule.feedback', 'Reply on message was sent!')
                        );

                        $this->redirect(array('/feedback/default/view/', 'id' => $model->id));
                    } else {
                        Yii::app()->ajax->success(
                            array(
                                'message' => Yii::t('FeedbackModule.feedback', 'Reply on message was sent!'),
                            )
                        );

                        return true;
                    }
                } else {
                    return array($form, $model);
                }
            }
        }

        return array($form, $model);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('FeedbackModule.feedback', 'Bad request. Please don\'t repeate similar requests anymore'));
    }
    
    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new FeedBack('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['FeedBack']))
            $model->attributes = $_GET['FeedBack'];
        $this->render('index', array('model' => $model));
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
                throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Requested page was not found!'));
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