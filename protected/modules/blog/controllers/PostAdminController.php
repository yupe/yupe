<?php

class PostAdminController extends yupe\components\controllers\BackController
{
    /**
     * Отображает запись по указанному идентификатору
     * 
     * @param integer $id Идинтификатор запись для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        if (($post = Post::model()->loadModel($id)) === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found'));
        }

        $this->render('view', array('model' => $post));
    }

    /**
     * Создает новую модель записи.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Post;
        $model->publish_date_tmp = date('d-m-Y');
        $model->publish_time_tmp = date('h:i');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        if (Yii::app()->request->getQuery('blog')) {
            $model->blog_id = (int) Yii::app()->request->getQuery('blog');
        }

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Post')) {
            $model->setAttributes(
                Yii::app()->request->getPost('Post')
            );
            $model->setTags(
                Yii::app()->request->getPost('tags')
            );

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Post was created!')
                );
                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование записи.
     * 
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        if (($model = Post::model()->loadModel($id)) === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found!'));
        }

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Post')) {
            $model->setAttributes(
                Yii::app()->request->getPost('Post')
            );
            $model->setTags(
                Yii::app()->request->getPost('tags')
            );

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Post was updated!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array(
                            'update',
                            'id' => $model->id,
                        )
                    )
                );
            }
        }

        $this->render('update', array('model' => $model));
    }

    /**
     * Удаляет модель записи из базы.
     * Если удаление прошло успешно - возвращется в index
     * 
     * @param integer $id идентификатор записи, который нужно удалить
     *
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // поддерживаем удаление только из POST-запроса
            
            if (($post = Post::model()->loadModel($id)) === null)
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found'));
            else
                $post->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('BlogModule.blog', 'Post was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'returnUrl', array('index')
                    )
                );
        } else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Wrong request. Please don\'t repeate requests like this anymore!'));
    }

    /**
     * Управление записями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Post('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->request->getParam('Post'))
            $model->setAttributes(
                Yii::app()->request->getParam('Post')
            );
        $this->render('index', array('model' => $model));
    }

    /**
     * Производит AJAX-валидацию
     * 
     * @param CModel $model - модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation($model)
    {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->getPost('ajax') === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}