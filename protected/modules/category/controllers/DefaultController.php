<?php
class DefaultController extends YBackController
{
    /**
     * Отображает категорию по указанному идентификатору
     * @param integer $id Идинтификатор категорию для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель категории.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Category;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Category']))
        {
            $model->attributes = $_POST['Category'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('CategoryModule.category', 'Запись добавлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'alias' => $model->alias));
                else
                    $this->redirect(array($_POST['submit-type']));

                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $this->render('create', array('model' => $model));
    }

     /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($alias = null, $id = null)
    {
        if (!$alias)
        {
            // Указан ID новости страницы, редактируем только ее
            $model = $this->loadModel($id);

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['Category']))
            {
                $model->attributes = $_POST['Category'];

                if ($model->save())
                {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('CategoryModule.category', 'Категория изменена!')
                    );

                    if (!isset($_POST['submit-type']))
                        $this->redirect(array('update', 'alias' => $model->alias));
                    else
                        $this->redirect(array($_POST['submit-type']));
                }
            }
            $this->render('update', array('model' => $model));
        }
        else
        {
            $modelsByLang = array();
            // Указано ключевое слово категории, ищем все языки
            $yupe  = Yii::app()->getModule('yupe');
            $langs = explode(",", $yupe->availableLanguages);

            $models = Category::model()->findAllByAttributes(array('alias' => $alias));
            if (!$models)
                throw new CHttpException(404, Yii::t('CategoryModule.category', 'Указанная категория не найдена'));

            $model = null;
            // Собираем модельки по языкам
            foreach ($models as $m)
            {
                if (!$m->lang)
                    $m->lang = Yii::app()->sourceLanguage;
                $modelsByLang[$m->lang] = $m;
            }
            // Выберем модельку для вывода тайтлов и прочего
            $model = isset($modelsByLang[Yii::app()->language])
                ? $modelsByLang[Yii::app()->language]
                : (isset($modelsByLang[Yii::app()->sourceLanguage])
                    ? $modelsByLang[Yii::app()->sourceLanguage]
                    : reset($models)
                );

            // Теперь создадим недостающие
            foreach ($langs as $l)
            {
                if (!isset($modelsByLang[$l]))
                {
                    $category = new Category;
                    $category->image = $model->image;
                    $category->setAttributes( array(
                        'alias'     => $alias,
                        'lang'      => $l,
                        'parent_id' => $model->parent_id,
                        'image'     => $model->image,
                    ));

                    if ($l != Yii::app()->sourceLanguage)
                        $category->scenario = 'altlang';

                    $modelsByLang[$l] = $category;
                }
            }

            // Проверим пост
            if (isset($_POST['Category']))
            {
                $wasError = false;

                foreach ($langs as $l)
                {
                    if (isset($_POST['Category'][$l]))
                    {
                        $p = $_POST['Category'][$l];
                        $modelsByLang[$l]->setAttributes(array(
                            'alias'             => $_POST['Category']['alias'],
                            'parent_id'         => $_POST['Category']['parent_id'],
                            'name'              => $p['name'],
                            'short_description' => $p['short_description'],
                            'description'       => $p['description'],
                            'status'            => $p['status'],
                        ));

                        if ($l != Yii::app()->sourceLanguage)
                            $modelsByLang[$l]->scenario = 'altlang';

                        if (!$modelsByLang[$l]->save())
                            $wasError = true;
                    }
                }

                if (!$wasError)
                {
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('CategoryModule.category', 'Категория обновлена!')
                    );

                    if (!isset($_POST['submit-type']))
                        $this->redirect(array('update', 'alias' => $model->alias));
                    else
                        $this->redirect(array($_POST['submit-type']));
                }
                else
                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('CategoryModule.category', 'Ошибки при сохранении Категории!')
                    );
            }
            $this->render('updateMultilang', array(
                'model'  => $model,
                'models' => $modelsByLang,
                'langs'  => $langs,
            ));
        }
    }

    /**
     * Удаяет модель категории из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор категории, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                // поддерживаем удаление только из POST-запроса
                $model = $this->loadModel($id);
                if ($model->lang != Yii::app()->sourceLanguage)
                    $model->scenario = 'altlang';
                $model->delete();
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('CategoryModule.category', 'Запись удалена!')
                );

                $transaction->commit();

                // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
                if (!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
            catch(Exception $e)
            {
                $transaction->rollback();

                Yii::log($e->__toString(),  CLogger::LEVEL_ERROR);
            }

        }
        else
            throw new CHttpException(400, Yii::t('CategoryModule.category', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
     * Управление категориями.
     */
    public function actionIndex()
    {
        $model = new Category('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Category']))
            $model->attributes = $_GET['Category'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('CategoryModule.category', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'category-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}