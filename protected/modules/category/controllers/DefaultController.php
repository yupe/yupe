<?php
class DefaultController extends YBackController
{
    /**
     * Отображает категорию по указанному идентификатору
     * @param integer $id Идинтификатор категорию для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
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
                $model->image = CUploadedFile::getInstance($model, 'image');

                if ($model->image)
                {
                    $imageName = $this->module->getUploadPath() . $model->alias . '.' . $model->image->extensionName;

                    if ($model->image->saveAs($imageName))
                    {
                        $model->image = basename($imageName);

                        $model->update(array( 'image' ));
                    }
                }

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Запись добавлена!'));

                $this->redirect(array( 'view', 'id' => $model->id ));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param null $alias
     * @param integer $id the ID of the model to be updated
     * @throws CHttpException
     * @return void
     */
    public function actionUpdate($alias = NULL, $id = NULL)
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
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('category', 'Категория изменена!'));

                    $this->redirect(array( 'update', 'id' => $model->id ));
                }
            }

            $this->render('update', array(
                'model' => $model,
            ));
        }
        else
        {
            $modelsByLang = array();
            // Указано ключевое слово новости, ищем все языки
            $yupe  = Yii::app()->getModule('yupe');
            $langs = explode(",", $yupe->availableLanguages);

            $models = Category::model()->findAllByAttributes(array( 'alias' => $alias ));
            if (!$models)
                throw new CHttpException(404, Yii::t('category', 'Указанная категория не найдена'));


            $model = NULL;
            // Собираем модельки по языкам
            foreach ($models as $m)
            {
                if (!$m->lang)
                    $m->lang = Yii::app()->sourceLanguage;
                $modelsByLang[$m->lang] = $m;
            }
            // Выберем модельку для вывода тайтлов и прочего
            $model = isset($modelsByLang[Yii::app()->language]) ? $modelsByLang[Yii::app()->language] :
                (isset($modelsByLang[Yii::app()->sourceLanguage]) ? $modelsByLang[Yii::app()->sourceLanguage] : reset($models));

            // Теперь создадим недостоающие
            foreach ($langs as $l)
            {
                if (!isset($modelsByLang[$l]))
                {
                    $news = new Category;
                    $news->setAttributes(
                        array(
                            'alias'         => $alias,
                            'lang'          => $l,
                            'parent_id'     => $model->parent_id,
                            'iamge'         => $model->image,
                        )
                    );

                    if ($l != Yii::app()->sourceLanguage)
                        $news->scenario = 'altlang';

                    $modelsByLang[$l] = $news;
                }
            }

            // Проверим пост
            if (isset($_POST['Category']))
            {
                $wasError = FALSE;

                foreach ($langs as $l)
                {
                    $img = $modelsByLang[$l]->image;

                    $modelsByLang[$l]->image = CUploadedFile::getInstance($modelsByLang[$l], 'image') !== NULL ? CUploadedFile::getInstance($modelsByLang[$l], 'image') : $img;

                    if (isset($_POST['Category'][$l]))
                    {
                        $p = $_POST['Category'][$l];

                        $modelsByLang[$l]->setAttributes(array(
                            'alias'        => $_POST['Category']['alias'],
                            'parent_id'    => $_POST['Category']['parent_id'],
                            'image'        => $modelsByLang[$l]->image,
                            'name'         => $p['name'],
                            'short_description' => $p['short_description'],
                            'description'  => $p['description'],
                            'status' => $p['status']
                        ));

                        if ($l != Yii::app()->sourceLanguage)
                            $modelsByLang[$l]->scenario = 'altlang';

                        if (!$modelsByLang[$l]->save())
                            $wasError = TRUE;

                        elseif(is_object($modelsByLang[$l]->image))
                        {
                            $imageName = $this->module->getUploadPath() . $model->alias . '.' . $modelsByLang[$l]->image->extensionName;

                            @unlink($this->module->getUploadPath() . $image);

                            if ($modelsByLang[$l]->image->saveAs($imageName))
                            {
                                $modelsByLang[$l]->image = basename($imageName);

                                $modelsByLang[$l]->update(array( 'image' ));
                            }
                        }
                        else
                            $alias = $modelsByLang[$l]->alias;
                    }
                }

                if (!$wasError)
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('category', 'Категория обновлена!'));

                    if (isset($_POST['saveAndClose']))
                        $this->redirect(array( 'admin' ));

                    $this->redirect(array( 'update', 'alias' => $alias ));
                }
                else
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('category', 'Ошибки при сохранении Категории!'));
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
            // поддерживаем удаление только из POST-запроса
            $model = $this->loadModel($id);

            if ($model->delete())
                @unlink($this->module->getUploadPath() . $model->image);

            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Запись удалена!'));

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'штвуч' ));
        }
        else
            throw new CHttpException(400, 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы');
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

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     * @return \CActiveRecord
     */
    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === NULL)
            throw new CHttpException(404, 'Запрошенная страница не найдена.');
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
