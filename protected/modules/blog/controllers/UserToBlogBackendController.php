<?php
/**
 * UserToBlogBackendController контроллер для управления участниками блога
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */

class UserToBlogBackendController extends yupe\components\controllers\BackController
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
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'Member was added!')
                    );

                    $this->redirect(
                        (array) Yii::app()->getRequest()->getPost(
                            'submit-type', array('create')
                        )
                    );
                }
            }
        }
        catch(Exception $e)
        {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::WARNING_MESSAGE,
                Yii::t('BlogModule.blog', 'Cannot add user to the blog. Please make sure he is not a member already.')
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
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Member was updated!')
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
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('BlogModule.blog', 'Member was deleted!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Wrong request. Please don\'t repeate requests like this!'));
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
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation(UserToBlog $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-to-blog-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}