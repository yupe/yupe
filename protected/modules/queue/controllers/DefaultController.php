<?php

class DefaultController extends YBackController
{
    /**
     * Отображает задание по указанному идентификатору
     * @param integer $id Идинтификатор задание для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model'=> $this->loadModel($id)));
    }

    /**
     * Создает новую модель задание.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Queue;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Queue']))
        {
            $model->attributes = $_POST['Queue'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('QueueModule.queue', 'Запись добавлена!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model'=> $model));
    }

    /**
     * Редактирование задание.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Queue']))
        {
            $model->attributes = $_POST['Queue'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('QueueModule.queue', 'Запись обновлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model'=> $model));
    }

    /**
     * Удаляет модель задание из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор задание, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('QueueModule.queue', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление заданиями.
     */
    public function actionIndex()
    {
        $model = new Queue('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Queue']))
            $model->attributes = $_GET['Queue'];
        $this->render('index', array('model'=> $model));
    }

    public function actionClear()
    {
        Yii::app()->queue->flush();
        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('QueueModule.queue', 'Очередь очищена!'));
        $this->redirect(($referrer = Yii::app()->getRequest()->getUrlReferrer()) !== null ? $referrer : array("/yupe/backend"));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Queue::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('QueueModule.queue', 'Запрошенная страница не найдена.'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'queue-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
