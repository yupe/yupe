<?php

class DefaultController extends yupe\components\controllers\BackController
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

        $menuId = null;
        $menuParentId = 0;

        if (!empty($_POST['Page']))
        {
            $model->setAttributes(Yii::app()->request->getPost('Page'));

            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                if ($model->save())
                {
                    // если активен модуль "Меню" - сохраним в меню
                    if(Yii::app()->hasModule('menu')){

                        $menuId   = (int)Yii::app()->request->getPost('menu_id');
                        $parentId = (int)Yii::app()->request->getPost('parent_id');
                        $menu = Menu::model()->active()->findByPk($menuId);
                        if($menu){
                            if(!$menu->addItem($model->title, $this->createUrl('/page/page/show',array('slug' => $model->slug)),$parentId)){
                                throw new CDbException(Yii::t('PageModule.page','There is an error when connecting page to menu...'));
                            }
                        }
                    }

                    Yii::app()->user->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('PageModule.page', 'Page was created')
                    );

                    $transaction->commit();

                    $this->redirect(
                        (array) Yii::app()->request->getPost(
                            'submit-type', array('create')
                        )
                    );
                }
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                $model->addError(false,$e->getMessage());
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->request->getQuery('id');
        $lang = Yii::app()->request->getQuery('lang');

        if(!empty($id) && !empty($lang)){
            $page = Page::model()->findByPk($id);
            if(null === $page){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('PageModule.page','Targeting page was not found!'));
                $this->redirect(array('/news/default/create'));
            }
            if(!array_key_exists($lang,$languages)){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('PageModule.page','Language was not found!'));
                $this->redirect(array('/news/default/create'));
            }
            Yii::app()->user->setFlash(YFlashMessages::SUCCESS_MESSAGE,Yii::t('PageModule.page','You add translation for {lang}',array(
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
            'languages' => $languages,
            'menuId' => $menuId,
            'menuParentId' => $menuParentId
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

        $oldTitle = $model->title;
        $menuId = null;
        $menuParentId = 0;

        if (isset($_POST['Page']))
        {
            $model->setAttributes(Yii::app()->request->getPost('Page'));

            if ($model->save())
            {
                if(Yii::app()->hasModule('menu')){

                    $menuId   = (int)Yii::app()->request->getPost('menu_id');
                    $parentId = (int)Yii::app()->request->getPost('parent_id');
                    $menu = Menu::model()->active()->findByPk($menuId);
                    if($menu){
                        if(!$menu->changeItem($oldTitle, $model->title, $this->createUrl('/page/page/show',array('slug' => $model->slug)),$parentId)){
                            throw new CDbException(Yii::t('PageModule.page','There is an error when connecting page to menu...'));
                        }
                    }
                }

                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('PageModule.page', 'Page was updated!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }

        if(Yii::app()->hasModule('menu')){
            $menuItem = MenuItem::model()->findByAttributes(array("title"=>$oldTitle));
            if($menuItem!==null)
            {
                $menuId = (int)$menuItem->menu_id;
                $menuParentId = (int)$menuItem->parent_id;
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
            'languages' => $this->yupe->getLanguagesList(),
            'menuId'=>$menuId,
            'menuParentId'=>$menuParentId
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
            $model = $this->loadModel($id);

            if(Yii::app()->hasModule('menu')){
                $menuItem = MenuItem::model()->findByAttributes(array("title"=>$model->title));
                if($menuItem!==null)
                {
                    $menuItem->delete();
                }
            }
            // we only allow deletion via POST request
            $model->delete();
            // if AJAX request (triggered by deletion via index grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(404,Yii::t('PageModule.page', 'Bad request. Please don\'t repeat similar requests anymore!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new Page('search');
        $model->unsetAttributes();
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
                throw new CHttpException(404,Yii::t('PageModule.page', 'Page was not found'));
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
