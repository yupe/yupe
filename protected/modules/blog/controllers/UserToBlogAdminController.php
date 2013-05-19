<?php

class UserToBlogAdminController extends YBackController
{
    /**
     * Отображает участника по указанному идентификатору
     * @param integer $id Идинтификатор участника для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель участника.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new UserToBlog;

        try
        {
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['UserToBlog']))
            {
                $model->attributes = $_POST['UserToBlog'];

                if ($model->save())
                {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('BlogModule.blog', 'Участник добавлен!')
                    );

                    $this->redirect(
                        (array) Yii::app()->request->getPost(
                            'submit-type', array('create')
                        )
                    );
                }
            }
        }
        catch(Exception $e)
        {
            Yii::app()->user->setFlash(
                YFlashMessages::WARNING_MESSAGE,
                Yii::t('BlogModule.blog', 'Ошибка! Возможно пользователь уже участник блога!')
            );
            $this->redirect(array('admin'));
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование участника.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['UserToBlog']))
        {
            $model->attributes = $_POST['UserToBlog'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Участник обновлен!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаляет модель участника из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор участника, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('BlogModule.blog', 'Участник удален!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Управление участниками.
     */
    public function actionIndex()
    {
        $model = new UserToBlog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['UserToBlog']))
            $model->attributes = $_GET['UserToBlog'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = UserToBlog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-to-blog-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}