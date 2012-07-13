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
        $this->render('view', array(
                                   'model' => $this->loadModel(),
                              ));
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
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Страница добавлена!'));

                if (isset($_POST['saveAndClose']))                
                    $this->redirect(array('admin'));                

                $this->redirect(array('update', 'id' => $model->id));
            }
        }

        $this->render('create', array(
                                     'model' => $model,
                                     'pages' => Page::model()->getAllPagesList()
                                ));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdate($slug=null)
    {


        if ( !$slug )
        {
            // Указан ID страницы, редактируем только ее
            $model = $this->loadModel();

            if (isset($_POST['Page']))
            {
                $model->attributes = $_POST['Page'];

                if ($model->save())
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Страница обновлена!'));

                    if (isset($_POST['saveAndClose']))
                        $this->redirect(array('admin'));

                    $this->redirect(array('update', 'id' => $model->id));
                }
            }

            $this->render('update', array(
                                         'model' => $model,
                                         'pages' => Page::model()->getAllPagesList($model->id)
                                    ));

        } else {

            // Указано ключевое слово страницы, ищем все языки
            $yupe = Yii::app()->getModule('yupe');
            $langs = explode(",",$yupe->availableLanguages);

            $models = Page::model()->findAllByAttributes(array('slug'=>$slug));
            if (!$models)
                throw new CHttpException(404,Yii::t('page','Указанная страница не найдена'));


            $model=null;
            // Собираем модельки по языкам
            foreach ($models as $m)
                $modelsByLang[$m->lang]=$m;

            // Выберем модельку для вывода тайтлов и прочего
            $model = isset($modelsByLang[Yii::app()->language])?$modelsByLang[Yii::app()->language]:
                (isset($modelsByLang[Yii::app()->sourceLanguage])?$modelsByLang[Yii::app()->sourceLanguage]:reset($models));

            // Теперь создадим недостоающие
            foreach ($langs as $l)
                if ( !isset($modelsByLang[$l]))
                {
                    $page = new Page();
                    $page-> setAttributes(
                        array(
                            'slug'=>$slug,
                            'lang'=>$l,
                            'parent_Id'=>$model->parent_Id,
                            'user_id'=>Yii::app()->user->id,
                            'status'=> $model-> status,
                            'is_protected'=> $model-> is_protected,
                        )
                    );

                    if ($l!=Yii::app()->sourceLanguage)
                        $page->scenario = 'altlang';

                    $modelsByLang[$l]= $page;
                }

            // Проверим пост
            if ( isset($_POST['Page']) )
            {
                $wasError = false;
                foreach ($langs as $l)
                    if (isset($_POST['Page'][$l]))
                    {
                        $p = $_POST['Page'][$l];
                        $modelsByLang[$l]->setAttributes ( array(
                            'name'=> $p['name'],
                            'title'=> $p['title'],
                            'body'=> $p['body'],
                            'keywords'=> $p['keywords'],
                            'description'=> $p['description'],
                            'status' => $_POST['Page']['status'],
                            'is_protected' => $_POST['Page']['is_protected'],
                            'menu_order' => $_POST['Page']['menu_order'],
                        ));

                        if ($l!=Yii::app()->sourceLanguage)
                            $modelsByLang[$l]->scenario = 'altlang';

                        if (!$modelsByLang[$l]->save())
                            $wasError=true;
                    }

                if (!$wasError)
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Страница обновлена!'));

                    if (isset($_POST['saveAndClose']))
                        $this->redirect(array('admin'));

                    $this->redirect(array('update', 'slug' => $slug));
                } else Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('page', 'Ошибки при сохранении страницы!'));
            }


            $this->render('updateMultilang', array(
                'model' => $model,
                'models' => $modelsByLang,
                'pages' => Page::model()->getAllPagesListBySlug($slug),
                'langs' => $langs,
            ));


        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete()
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel()->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(array('index'));
        }
        else
            throw new YPageNotFoundException('Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Page');
        $this->render('index', array(
                                    'dataProvider' => $dataProvider,
                               ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Page('search');

        if (isset($_GET['Page']))        
            $model->attributes = $_GET['Page'];        

        $this->render('admin', array(
                                    'model' => $model,
                                    'pages' => Page::model()->getAllPagesList()
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
                throw new YPageNotFoundException('The requested page does not exist.');
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