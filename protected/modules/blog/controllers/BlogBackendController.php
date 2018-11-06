<?php

/**
 * BlogBackendController контроллер для блогов в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.controllers
 * @since 0.1
 *
 */
class BlogBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Blog.BlogBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Blog.BlogBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Blog.BlogBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Blog.BlogBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Blog.BlogBackend.Delete']],
            ['deny'],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Blog',
                'validAttributes' => ['name', 'slug', 'status', 'type'],
            ],
        ];
    }

    /**
     * Отображает блог по указанному идентификатору
     * @throws CHttpException
     * @param  integer $id Идинтификатор блог для отображения
     *
     * @return nothing
     **/
    public function actionView($id)
    {
        if (($model = Blog::model()->findByPk($id)) === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Page was not found!'));
        }

        $this->render('view', ['model' => $model]);
    }

    /**
     * Создает новую модель блога.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return nothing
     **/
    public function actionCreate()
    {
        $model = new Blog();

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Blog') !== null) {

            $model->setAttributes(Yii::app()->getRequest()->getPost('Blog'));

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Blog was added!')
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
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        if (($model = Blog::model()->findByPk($id)) === null) {
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Page was not found!'));
        }

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Blog') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Blog'));
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('BlogModule.blog', 'Blog was updated!')
                );
                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model->id,
                        ]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }


    /**
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            if (($model = Blog::model()->findByPk($id)) === null) {
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Page was not found!'));
            }

            $model->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('BlogModule.blog', 'Blog was deleted!')
            );

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(Yii::app()->getRequest()->getPost('returnUrl', ['index']));
            }
        } else {
            throw new CHttpException(400, Yii::t(
                'BlogModule.blog',
                'Wrong request. Please don\'t repeate requests like this anymore!'
            ));
        }
    }

    /**
     * Управление блогами.
     *
     * @return nothing
     **/
    public function actionIndex()
    {
        $model = new Blog('search');
        $model->unsetAttributes();
        if (Yii::app()->getRequest()->getParam('Blog') !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getParam('Blog'));
        }
        $this->render('index', ['model' => $model]);
    }
}
