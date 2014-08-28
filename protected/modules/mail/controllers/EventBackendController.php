<?php

/**
 * EventBackendController Класс контроллера Event
 *
 * @category YupeController
 * @package  yupe.modules.mail.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class EventBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Mail.EventBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Mail.EventBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Mail.EventBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('Mail.EventBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('Mail.EventBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('Mail.EventBackend.View')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'MailEvent',
                'validAttributes' => array('name', 'code', 'description')
            )
        );
    }

    /**
     * Отображает почтовое событие по указанному идентификатору
     *
     * @param integer $id Идинтификатор почтовое событие для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель почтового события.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new MailEvent();

        if (($data = Yii::app()->getRequest()->getPost('MailEvent')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MailModule.mail', 'Record was created!')
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
     * Редактирование почтового события.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('MailEvent')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MailModule.mail', 'Record was created!')
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
     * Удаяет модель почтового события из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор почтового события, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('MailModule.mail', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('MailModule.mail', 'Bad request. Please don\'t repeate similar request anymore')
            );
        }
    }

    /**
     * Управление почтовыми событиями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new MailEvent('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'MailEvent',
                array()
            )
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id - integer идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpExcetption
     */
    public function loadModel($id)
    {
        if (($model = MailEvent::model()->findByPk((int)$id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('MailModule.mail', 'Requested page was not found.')
            );
        }

        return $model;
    }
}
