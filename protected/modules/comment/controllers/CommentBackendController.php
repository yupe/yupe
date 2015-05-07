<?php

/**
 * CommentBackendController контроллер для управления комментариями в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.comment.controllers
 * @version   0.6
 *
 */
class CommentBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Comment.CommentBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Comment.CommentBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Comment.CommentBackend.Create']],
            ['allow', 'actions' => ['update', 'inline', 'approve'], 'roles' => ['Comment.CommentBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Comment.CommentBackend.Delete']],
            ['deny']
        ];
    }

    public function actionInline()
    {
        if (!Yii::app()->request->getIsAjaxRequest() || !Yii::app()->request->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $pk = (int)Yii::app()->request->getPost('pk');

        if (!isset($name, $value, $pk)) {
            throw new CHttpException(404);
        }

        if (!in_array($name, ['status'])) {
            throw new CHttpException(404);
        }

        $model = Comment::model()->findByPk($pk);

        if (null === $model) {
            throw new CHttpException(404);
        }

        $model->$name = $value;

        if ($model->saveNode()) {
            Yii::app()->ajax->success();
        }

        throw new CHttpException(500, $model->getError($name));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Comment();

        if (($data = Yii::app()->getRequest()->getPost('Comment')) !== null) {

            $model->setAttributes($data);

            $saveStatus = false;
            $parentId = $model->getAttribute('parent_id');

            // Если указан parent_id просто добавляем новый комментарий.
            if ($parentId > 0) {
                $rootForComment = Comment::model()->findByPk($parentId);
                $saveStatus = $model->appendTo($rootForComment);
            } else { // Иначе если parent_id не указан...

                $rootNode = $model->createRootOfCommentsIfNotExists(
                    $model->getAttribute("model"),
                    $model->getAttribute("model_id")
                );

                // Добавляем комментарий к корню.
                if ($rootNode !== false && $rootNode->id > 0) {
                    $saveStatus = $model->appendTo($rootNode);
                }
            }

            if ($saveStatus) {

                Yii::app()->getCache()->delete("Comment{$model->model}{$model->model_id}");

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CommentModule.comment', 'Comment was created!')
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        Yii::app()->getCache()->delete("Comment{$model->model}{$model->model_id}");

        if (($data = Yii::app()->getRequest()->getPost('Comment')) !== null) {

            $model->setAttributes($data);

            if ($model->saveNode()) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CommentModule.comment', 'Comment was updated!')
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // we only allow deletion via POST request
            $model = $this->loadModel($id);

            Yii::app()->getCache()->delete("Comment{$model->model}{$model->model_id}");

            $model->deleteNode();

            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(400, Yii::t(
                'CommentModule.comment',
                'Bad request. Please don\'t repeate similar requests anymore'
            ));
        }
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Comment('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Comment',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    public function actionMultiaction()
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest() || !Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $items = Yii::app()->getRequest()->getPost('items');

        if (!is_array($items) || empty($items)) {
            Yii::app()->ajax->success();
        }

        if ($count = Comment::model()->multiDelete($items)) {

            Yii::app()->ajax->success(
                Yii::t(
                    'YupeModule.yupe',
                    'Removed {count} records!',
                    [
                        '{count}' => $count
                    ]
                )
            );
        } else {
            Yii::app()->ajax->failure(
                Yii::t('YupeModule.yupe', 'There was an error when processing the request')
            );
        }
    }

    public function actionApprove()
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest() || !Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        if ($items = Yii::app()->getRequest()->getPost('items')) {
            if (Yii::app()->commentManager->multiApprove($items)) {
                Yii::app()->ajax->success();
            } else {
                Yii::app()->ajax->failure();
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Comment::model()->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CommentModule.comment', 'Requested page was not found!'));
        }

        return $model;
    }
}
