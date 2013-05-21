<?php

class DefaultController extends YBackController
{
    /**
     * Отображает изображение по указанному идентификатору
     * 
     * @param integer $id Идинтификатор изображение для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Image;

        if (isset($_POST['Image'])) {

            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                $model->attributes = $_POST['Image'];

                if ($model->save()) {

                    if(Yii::app()->hasModule('gallery') && $model->galleryId){
                        if(!$model->setGalleryId($model->galleryId)){
                            throw new CDbException(Yii::t('ImageModule.image','При добавлении картинки в галерею произошла ошибка =('));
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('ImageModule.image', 'Изображение добавлено!')
                    );

                    $this->redirect(
                        (array) Yii::app()->request->getPost(
                            'submit-type', array('create')
                        )
                    );
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование изображения.
     * 
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        if (isset($_POST['Image'])) {
            $model->attributes = $_POST['Image'];
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('user', 'Изображение обновлено!')
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
     * Удаяет модель изображения из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     *  @param integer $id - идентификатор изображения, который нужно удалить
     *
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('user', 'Изображение удалено!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('ImageModule.image', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление изображениями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Image('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Image']))
            $model->attributes = $_GET['Image'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * 
     * @param integer $id идентификатор нужной модели
     *
     * @return void
     */
    public function loadModel($id)
    {
        $model = Image::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('ImageModule.image', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     *  @param CModel $model - модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'image-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}