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
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Blog.UserToBlogBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Blog.UserToBlogBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Blog.UserToBlogBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Blog.UserToBlogBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Blog.UserToBlogBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'UserToBlog',
                'validAttributes' => ['status', 'role', 'note']
            ]
        ];
    }

    /**
     * Отображает участника по указанному идентификатору
     * @param integer $id Идинтификатор участника для отображения
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель участника.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new UserToBlog();

        try {
            if (isset($_POST['UserToBlog'])) {
                $model->attributes = $_POST['UserToBlog'];

                if ($model->save()) {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('BlogModule.blog', 'Member was added!')
                    );

                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost(
                            'submit-type',
                            ['create']
                        )
                    );
                }
            }
        } catch (Exception $e) {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::WARNING_MESSAGE,
                Yii::t('BlogModule.blog', 'Cannot add user to the blog. Please make sure he is not a member already.')
            );

            $this->redirect(['create']);
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование участника.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['UserToBlog'])) {
            $model->attributes = $_POST['UserToBlog'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Member was updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $this->render('update', ['model' => $model]);
    }

    /**
     * Удаляет модель участника из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор участника, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('BlogModule.blog', 'Member was deleted!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'BlogModule.blog',
                'Wrong request. Please don\'t repeate requests like this!'
            ));
        }
    }

    /**
     * Управление участниками.
     */
    public function actionIndex()
    {
        $model = new UserToBlog('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['UserToBlog'])) {
            $model->attributes = $_GET['UserToBlog'];
        }
        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     * @return UserToBlog $model
     */
    public function loadModel($id)
    {
        $model = UserToBlog::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found!'));
        }

        return $model;
    }
}
