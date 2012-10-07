<?php

class DefaultController extends YBackController
{
    /**
     * Отображает конкурс по указанному идентификатору
     * @param integer $id Идинтификатор конкурс для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель конкурса.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Contest;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Contest']))
        {
            $model->attributes = $_POST['Contest'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('contest', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }

        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование конкурса.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Contest']))
        {
            $model->attributes = $_POST['Contest'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('contest', 'Запись обновлена!')
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
     * Удаяет модель конкурса из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор конкурса, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('contest', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы');
    }

    /**
     * Управление конкурсами.
     */
    public function actionIndex()
    {
        $model = new Contest('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Contest']))
            $model->attributes = $_GET['Contest'];

        $this->render('index', array('model' => $model));
    }

    /**
     * Добавление изображения.
     */
    public function actionAddImage($contest_id)
    {
        $contest = $this->loadModel((int) $contest_id);

        $image = new Image;

        if (Yii::app()->request->isPostRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                if ($image->create($_POST['Image']))
                {
                    if ($contest->addImage($image))
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('contest', 'Фотография добавлена!')
                        );

                    $transaction->commit();

                    $this->redirect(array('/contest/default/view/', 'id' => $contest->id));
                }

                throw new CDbException(Yii::t('contest', 'При добавлении изображения произошла ошибка!'));
            }
            catch (Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('contest','Произошла ошибка!')
                );
            }

            $this->redirect(array('/contest/default/addImage/', 'id' => $contest->id));
        }

        $this->render('addImage', array('contest' => $contest, 'model' => $image));
    }

    /**
     * Удаление изображения.
     */
    public function actionDeleteImage($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            ImageToContest::model()->findByPk((int) $id)->delete();

            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Contest::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрошенная страница не найдена.');
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contest-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
