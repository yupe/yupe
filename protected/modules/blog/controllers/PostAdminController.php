<?php

class PostAdminController extends YBackController
{
    /**
     * Отображает запись по указанному идентификатору
     * @param integer $id Идинтификатор запись для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель записи.
     * Если создание прошло успешно - перенаправляет на просмотр.
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
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Запись добавлена!')
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
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование записи.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->request->isPostRequest && Yii::app()->request->getPost('Post')) {
            $model->setAttributes(
                Yii::app()->request->getPost('Post')
            );
            $model->setTags(
                Yii::app()->request->getPost('tags')
            );

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Запись обновлена!')
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
     * @param integer $id идентификатор записи, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('BlogModule.blog', 'Запись удалена!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!Yii::app()->request->isAjaxRequest)
                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'returnUrl', array('index')
                    )
                );
        } else
            throw new CHttpException(400, Yii::t('BlogModule.blog', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Управление записями.
     */
    public function actionIndex()
    {
        $model = new Post('search');
        $model->unsetAttributes(); // clear any default values
        if (Yii::app()->request->getParam('Post'))
            $model->setAttributes(
                Yii::app()->request->getPost('Post')
            );
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Post::model()->findByPk($id);
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
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->getPost('ajax') === 'post-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}