<?php
/**
 * PostBackendController контроллер для постов в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class PostBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Post',
                'validAttributes' => array('title', 'slug', 'publish_date')
            )
        );
    }

    /**
     * Отображает запись по указанному идентификатору
     * 
     * @param integer $id Идинтификатор запись для отображения
     * @throws CHttpException
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

        $model->publish_date = date('d-m-Y h:i');

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Post')) {
            $model->setAttributes(
                Yii::app()->getRequest()->getPost('Post')
            );
            $model->setTags(
                Yii::app()->getRequest()->getPost('tags')
            );

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Post was created!')
                );
                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
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
     * @throws CHttpException
     * @return void
     */
    public function actionUpdate($id)
    {
        if (($model = Post::model()->loadModel($id)) === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found!'));
        }

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Post')) {
            $model->setAttributes(
                Yii::app()->getRequest()->getPost('Post')
            );
            $model->setTags(
                Yii::app()->getRequest()->getPost('tags')
            );

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Post was updated!')
                );

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
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
     * @throws CHttpException
     * @return void
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            
            if (($post = Post::model()->loadModel($id)) === null)
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Requested page was not found'));
            else
                $post->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('BlogModule.blog', 'Post was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->getRequest()->getIsAjaxRequest())
                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'returnUrl', array('index')
                    )
                );
        } else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Wrong request. Please don\'t repeate requests like this!'));
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
        $model->comment_status = true;
        if (Yii::app()->getRequest()->getParam('Post'))
            $model->setAttributes(
                Yii::app()->getRequest()->getParam('Post')
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
    protected function performAjaxValidation(Post $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}