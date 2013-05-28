<?php

class DefaultController extends YBackController
{
    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $this->render('view', array('model' => $this->loadModel()));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Page;

        if (isset($_POST['Page']))
        {
            $model->attributes = $_POST['Page'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('PageModule.page', 'Страница добавлена!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->request->getQuery('id');
        $lang = Yii::app()->request->getQuery('lang');

        if(!empty($id) && !empty($lang)){
            $page = Page::model()->findByPk($id);
            if(null === $page){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('PageModule.page','Целевая страница не найдена!'));
                $this->redirect(array('/news/default/create'));
            }
            if(!array_key_exists($lang,$languages)){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('PageModule.page','Язык не найден!'));
                $this->redirect(array('/news/default/create'));
            }
            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE,Yii::t('PageModule.page','Вы добавляете перевод на {lang} язык!',array(
                        '{lang}' => $languages[$lang]
                    )));
            $model->lang = $lang;
            $model->slug = $page->slug;
            $model->category_id = $page->category_id;
            $model->title = $page->title;
            $model->title_short = $page->title_short;
            $model->parent_id = $page->parent_id;
            $model->order = $page->order;
        }else{
            $model->lang = Yii::app()->language;
        }


        $this->render('create', array(
            'model' => $model,
            'pages' => Page::model()->getAllPagesList(),
            'languages' => $languages
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate($id)
    {
        // Указан ID страницы, редактируем только ее
        $model = $this->loadModel((int)$id);

        if (isset($_POST['Page']))
        {
            $model->setAttributes(Yii::app()->request->getPost('Page'));

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('PageModule.page', 'Страница обновлена!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }

        // найти по slug страницы на других языках
        $langModels = Page::model()->findAll('slug = :slug AND id != :id',array(
            ':slug' => $model->slug,
            ':id' => $model->id
        ));

        $this->render('update', array(
            'langModels' => CHtml::listData($langModels,'lang','id'),
            'model' => $model,
            'pages' => Page::model()->getAllPagesList($model->id),
            'languages' => $this->yupe->getLanguagesList()
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();
            // if AJAX request (triggered by deletion via index grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(404,Yii::t('PageModule.page', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Page('search');
        if (isset($_GET['Page']))
            $model->attributes = $_GET['Page'];
        $this->render('index', array(
            'model' => $model,
            'pages' => Page::model()->getAllPagesList(),
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     */
    public function loadModel()
    {
        if ($this->_model === null)
        {
            if (isset($_GET['id']))
                $this->_model = Page::model()->with('author', 'changeAuthor')->findbyPk($_GET['id']);
            if ($this->_model === null)
                throw new CHttpException(404,Yii::t('PageModule.page', 'Запрошенная страница не найдена!'));
        }
        return $this->_model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'page-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}