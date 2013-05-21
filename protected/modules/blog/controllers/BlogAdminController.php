<?php

class BlogAdminController extends YBackController
{
    /**
     * Отображает блог по указанному идентификатору
     *
     * @param integer $id Идинтификатор блог для отображения
     *
     * @return nothing
     **/
    public function actionView($id)
    {
        if (($model = Blog::model()->loadModel($id)) !== null)
            $this->render('view', array('model' => $model));
        else
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));
    }

    /**
     * Создает новую модель блога.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return nothing
     **/
    public function actionCreate()
    {
        $model = new Blog;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Blog') !== null) {
            $model->setAttributes(Yii::app()->request->getPost('Blog'));

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Блог добавлен!')
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
     * Редактирование блога.
     *
     * @param integer $id Идинтификатор блога для редактирования
     *
     * @return nothing
     **/
    public function actionUpdate($id)
    {
        if (($model = Blog::model()->loadModel($id)) === null)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Blog') !== null) {
            $model->setAttributes(Yii::app()->request->getPost('Blog'));
            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Блог обновлен!')
                );
                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array(
                            'update',
                            'id' => $model->id
                        )
                    )
                );
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаляет модель блога из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id - идентификатор блога, который нужно удалить     
     *
     * @return nothing
     **/
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            
            // поддерживаем удаление только из POST-запроса
            if (($model = Blog::model()->loadModel($id)) === null)
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));
            
            $model->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('BlogModule.blog', 'Блог удален!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect(Yii::app()->request->getPost('returnUrl', array('index')));
        } else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Управление блогами.
     *
     * @return nothing
     **/
    public function actionIndex()
    {
        $model = new Blog('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->request->getParam('Blog') !== null)
            $model->setAttributes(Yii::app()->request->getParam('Blog'));
        $this->render('index', array('model' => $model));
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel $model - модель, которую необходимо валидировать
     *
     * @return nothing
     **/
    protected function performAjaxValidation($model)
    {
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->getPost('ajax') === 'blog-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}