<?php

class DefaultAdminController extends YBackController
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
        $this->render('view', array('model' => $this->loadModel($id)));
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

        if (isset($_POST['Blog'])) {
            $model->attributes = $_POST['Blog'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Блог добавлен!')
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
     * Редактирование блога.
     *
     * @param integer $id Идинтификатор блога для редактирования
     *
     * @return nothing
     **/
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Blog'])) {
            $model->attributes = $_POST['Blog'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('BlogModule.blog', 'Блог обновлен!')
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
     * Удаляет модель блога из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id          идентификатор блога, который нужно удалить
     * @param bool    $multiaction запрос из мультиекшена
     *
     * @return nothing
     **/
    public function actionDelete($id, $multiaction = false)
    {
        if (Yii::app()->request->isPostRequest || $multiaction === true) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('BlogModule.blog', 'Блог удален!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
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
        if (isset($_GET['Blog']))
            $model->attributes = $_GET['Blog'];
        $this->render('index', array('model' => $model));
    }

    /**
     *  Мультиекшен:
     *
     *  в массиве $_GET передаются:
     *      do    - действие над объектами
     *      items - массив эллементов
     *
     * @return nothing
     **/
    public function actionMultiaction()
    {
        if ((isset($_GET['ajax'])) && ($_GET['ajax'] == 'Blog') && (isset($_GET['do'])) && (isset($_GET['items'])) && (is_array($_GET['items'])) && (!empty($_GET['items']))) {
            switch ($_GET['do']) {
            case 'delete':
                foreach ($_GET['items'] as $itemId)
                    $this->actionDelete($itemId, true);
                break;
                
            default:
                throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));
                break;
            }
        }

        return $this->actionIndex();
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id - идентификатор нужной модели
     *
     * @return BlogModel
     **/
    public function loadModel($id)
    {
        $model = Blog::model()->with('postsCount', 'membersCount')->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('BlogModule.blog', 'Запрошенная страница не найдена!'));
        return $model;
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'blog-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}