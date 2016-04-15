<?php

/**
 * QueueBackendController контроллер для управления очередью через панель управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package   yupe.modules.queue.controllers
 * @license   BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version   0.6
 *
 */
class QueueBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Queue.QueueBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Queue.QueueBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Queue.QueueBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Queue.QueueBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Queue.QueueBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Queue',
                'validAttributes' => ['status', 'priority'],
            ]
        ];
    }

    /**
     * Отображает задание по указанному идентификатору
     *
     * @param integer $id Идинтификатор задание для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель задание.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Queue();

        if (($data = Yii::app()->getRequest()->getPost('Queue')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('QueueModule.queue', 'Record was created!')
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
     * Редактирование задание.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Queue')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('QueueModule.queue', 'Record was updated!')
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
     * Удаляет модель задание из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @throws CHttpException
     *
     * @param integer $id идентификатор задание, который нужно удалить
     *
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('QueueModule.queue', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('QueueModule.queue', 'Bad request. Please don\'t repeat similar requests anymore')
            );
        }
    }

    /**
     * Управление заданиями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Queue('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Queue',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Очищаем все задачи:
     *
     * @return void
     */
    public function actionClear()
    {
        Yii::app()->queue->flush();

        Yii::app()->user->setFlash(
            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
            Yii::t('QueueModule.queue', 'Queue cleaned!')
        );

        $this->redirect(
            ($referrer = Yii::app()->getRequest()->getUrlReferrer()) !== null
                ? $referrer
                : ['/yupe/backend/index']
        );
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @throws CHttpException
     *
     * @param integer $id идентификатор нужной модели
     *
     * @return Queue $model
     *
     * @throws CHttpException If record not found
     */
    public function loadModel($id)
    {
        if (($model = Queue::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('QueueModule.queue', 'Requested page was not found.')
            );
        }

        return $model;
    }
}
