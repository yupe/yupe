<?php

/**
 * FeedbackBackendController контроллер для работы с сообщениями обратной связи в панели управления
 *
 * @category YupeController
 * @package  yupe.modules.feedback.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class FeedbackBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Feedback.FeedbackBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Feedback.FeedbackBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Feedback.FeedbackBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('Feedback.FeedbackBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('Feedback.FeedbackBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('Feedback.FeedbackBackend.View')),
            array('allow', 'actions' => array('answer'), 'roles' => array('Feedback.FeedbackBackend.Answer')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'FeedBack',
                'validAttributes' => array('name', 'email', 'theme', 'type', 'status', 'is_faq')
            )
        );
    }

    // FeedBack $model
    private $_model;

    /**
     * Displays a particular model.
     *
     * @param int $id - record id
     *
     * @return void
     */
    public function actionView($id = null)
    {
        // Обработка при Ajax-запросе:
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {
            return Yii::app()->ajax->success(
                array(
                    'html' => $this->renderPartial(
                            'view',
                            array(
                                'model' => $this->loadModel($id)
                            ),
                            true,
                            false
                        )
                )
            );
        }

        $this->render('view', array('model' => $this->loadModel()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new FeedBack();

        $model->email = Yii::app()->user->getProfileField('email');
        $model->name = Yii::app()->user->getProfileField('fullName');

        if (($data = Yii::app()->getRequest()->getPost('FeedBack')) !== null) {

            $model->setAttributes($data);

            if ($model->status == FeedBack::STATUS_ANSWER_SENDED) {
                $model->answer_user = Yii::app()->user->getId();
                $model->answer_date = new CDbExpression('NOW()');
            }

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'Message saved!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
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
     * @param int $id - record $id
     *
     * @return void
     */
    public function actionUpdate($id = null)
    {
        $model = $this->loadModel($id);

        $status = $model->status;

        if (($data = Yii::app()->getRequest()->getPost('FeedBack')) !== null) {
            $model->setAttributes($data);

            if ($status != FeedBack::STATUS_ANSWER_SENDED && $model->status == FeedBack::STATUS_ANSWER_SENDED) {
                $model->answer_user = Yii::app()->user->getId();
                $model->answer_date = new CDbExpression('NOW()');
            }

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'Message was updated')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('update', 'id' => $model->id)
                    )
                );
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
     *
     * @throws CHttpException
     */
    public function actionAnswer($id = null)
    {
        $model = $this->loadModel($id);

        $form = new AnswerForm();

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
                        'message' => Yii::t(
                                'FeedbackModule.feedback',
                                'Attention! Reply for this message already sent!'
                            )
                    )
                );
            }

            return Yii::app()->ajax->success(
                array(
                    'html' => $this->renderPartial(
                            '_ajax_answer',
                            array(
                                'model'      => $model,
                                'answerForm' => $form
                            ),
                            true,
                            false
                        )
                )
            );
        }

        if ($model->status == FeedBack::STATUS_ANSWER_SENDED) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('FeedbackModule.feedback', 'Attention! Reply for this message already sent!')
            );
        }

        list($form, $model) = $this->saveAnswer($form, $model);

        $this->render('answer', array('model' => $model, 'answerForm' => $form));
    }

    /**
     * Сохраняем данные в СУБД, при наявности POST-запросаЖ
     *
     * @param AnswerForm $form - форма ответа
     * @param FeedBack $model - модель
     *
     * @return mixed
     */
    public function saveAnswer(AnswerForm $form, FeedBack $model)
    {
        if (Yii::app()->getRequest()->getIsPostRequest() && ($data = Yii::app()->getRequest()->getPost(
                'AnswerForm'
            )) !== null
        ) {
            $form->setAttributes($data);

            if ($form->validate()) {

                $model->setAttributes(
                    array(
                        'answer'      => $form->answer,
                        'is_faq'      => $form->is_faq,
                        'answer_user' => Yii::app()->user->getId(),
                        'answer_date' => new CDbExpression('NOW()'),
                        'status'      => FeedBack::STATUS_ANSWER_SENDED,
                    )
                );

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
                            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
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
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getIsAjaxRequest() || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('FeedbackModule.feedback', 'Bad request. Please don\'t repeate similar requests anymore')
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
        $model = new FeedBack('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam('FeedBack', array())
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param int $id - record value
     *
     * @return FeedBack $model
     *
     * @throws CHttpException
     */
    public function loadModel($id = null)
    {
        if ($this->_model === null) {

            $id = $id ? : Yii::app()->getRequest()->getParam('id');

            if (($this->_model = FeedBack::model()->findByPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t('FeedbackModule.feedback', 'Requested page was not found!')
                );
            }
        }

        return $this->_model;
    }
}
