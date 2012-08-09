<?php

class DefaultController extends YBackController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new News;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['News']))
        {
            $model->attributes = $_POST['News'];

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

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('news', 'Новость добавлена!'));

                if(count(explode(',',Yii::app()->getModule('yupe')->availableLanguages)))
                    $this->redirect(array( 'update', 'alias' => $model->alias ));

                $this->redirect(array( 'view', 'id' => $model->id ));
            }
        }

        $model->date = date('d.m.Y');

        $this->render('create', array(
            'model' => $model,
        ));
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

            if (isset($_POST['News']))
            {
                $model->attributes = $_POST['News'];

                if ($model->save())
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('news', 'Новость изменена!'));
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

            $models = News::model()->findAllByAttributes(array( 'alias' => $alias ));
            if (!$models)
                throw new CHttpException(404, Yii::t('news', 'Указанная новость не найдена'));


            $model = null;
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
                    $news = new News;
                    $news->setAttributes(
                        array(
                            'alias'         => $alias,
                            'lang'          => $l,
                            'date'          => $model->date,
                            'category_id'   => $model->category_id,
                            'iamge'         => $model->image,
                            'creation_date' => $model->creation_date,
                            'change_date'   => $model->change_date,
                            'user_id'       => Yii::app()->user->id,
                            'status'        => $model->status,
                            'is_protected'  => $model->is_protected,
                        )
                    );

                    if ($l != Yii::app()->sourceLanguage)
                        $news->scenario = 'altlang';

                    $modelsByLang[$l] = $news;
                }
            }

            // Проверим пост
            if (isset($_POST['News']))
            {
                $wasError = false;

                foreach ($langs as $l)
                {
                    $img = $modelsByLang[$l]->image;

                    $modelsByLang[$l]->image = CUploadedFile::getInstance($modelsByLang[$l], 'image') !== null ? CUploadedFile::getInstance($modelsByLang[$l], 'image') : $img;

                    if (isset($_POST['News'][$l]))
                    {
                        $p = $_POST['News'][$l];

                        $modelsByLang[$l]->setAttributes(array(
                            'alias'        => $_POST['News']['alias'],
                            'is_protected' => $_POST['News']['is_protected'],
                            'date'         => $_POST['News']['date'],
                            'category_id'  => $_POST['News']['category_id'],
                            'image'        => $modelsByLang[$l]->image,
                            'title'        => $p['title'],
                            'short_text'   => $p['short_text'],
                            'full_text'    => $p['full_text'],
                            'keywords'     => $p['keywords'],
                            'description'  => $p['description'],
                            'status'       => $p['status']
                        ));

                        if ($l != Yii::app()->sourceLanguage)
                            $modelsByLang[$l]->scenario = 'altlang';

                        if (!$modelsByLang[$l]->save())                        
                            $wasError = true;                 
                                                               
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
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('news', 'Новость обновлена!'));

                    if (isset($_POST['saveAndClose']))
                        $this->redirect(array( 'admin' ));

                    $this->redirect(array( 'update', 'alias' => $alias ));
                }
                else
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('news', 'Ошибки при сохранении новости!'));
            }


            $this->render('updateMultilang', array(
                'model'  => $model,
                'models' => $modelsByLang,
                'langs'  => $langs,
            ));
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($alias = null, $id = null)
    {
        if (Yii::app()->request->isPostRequest)
        {
            if ($alias)
            {
                if (!($model = News::model()->findAllByAttributes(array( 'alias' => $alias ))))
                    throw new CHttpException(404, Yii::t('news', 'Новость не нейдена'));
                $model->delete();
            }
            else
            {
                // we only allow deletion via POST request
                $this->loadModel($id)->delete();
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array( 'admin' ));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('News');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new News('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['News']))
            $model->attributes = $_GET['News'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = News::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'news-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}