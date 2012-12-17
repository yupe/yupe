<?php

class TemplateAdminController extends YBackController
{
    /**
     * Отображает почтовый шаблон по указанному идентификатору
     * @param integer $id Идинтификатор почтовый шаблон для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель почтового шаблона.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new MailTemplate;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (Yii::app()->request->getParam('eid'))
            $model->event_id = (int) Yii::app()->request->getParam('eid');

        if (isset($_POST['MailTemplate']))
        {
            $model->attributes = $_POST['MailTemplate'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('mail', 'Запись добавлена!')
                );

                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование почтового шаблона.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MailTemplate']))
        {
            $model->attributes = $_POST['MailTemplate'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('mail', 'Запись обновлена!')
                );

                $this->redirect(array('update','id' => $model->id));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаяет модель почтового шаблона из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор почтового шаблона, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('mail', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'index' ));
        }
        else
            throw new CHttpException(400, Yii::t('mail', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление почтовыми шаблонами.
     */
    public function actionIndex()
    {
        $model = new MailTemplate('search');
        $model->unsetAttributes();  // clear any default values
        if (Yii::app()->request->getQuery('event'))
            $model->event_id = (int) Yii::app()->request->getQuery('event');
        if (isset($_GET['MailTemplate']))
            $model->attributes = $_GET['MailTemplate'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = MailTemplate::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('mail', 'Запрошенная страница не найдена'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'mail-template-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}