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
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CategoryModule.category', 'Record was created!')
                );

                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->request->getQuery('id');
        $lang = Yii::app()->request->getQuery('lang');

        if(!empty($id) && !empty($lang)){
            $category = Category::model()->findByPk($id);
            if(null === $category){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('CategoryModule.category','Targeting category was not found!'));
                $this->redirect(array('/category/default/create'));
            }
            if(!array_key_exists($lang,$languages)){
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('CategoryModule.category','Language was not found!'));
                $this->redirect(array('/category/default/create'));
            }
            Yii::app()->user->setFlash(YFlashMessages::SUCCESS_MESSAGE,Yii::t('CategoryModule.category','You are adding translate in to {lang}!',array(
                        '{lang}' => $languages[$lang]
                    )));
            $model->lang = $lang;
            $model->alias = $category->alias;
            $model->parent_id = $category->parent_id;
            $model->name = $category->name;
        }else{
            $model->lang = Yii::app()->language;
        }

        $this->render('create', array('model' => $model, 'languages' => $languages));
    }

     /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        // Указан ID новости страницы, редактируем только ее
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (Yii::app()->request->isPostRequest && isset($_POST['Category']))
        {
            $model->setAttributes(Yii::app()->request->getPost('Category'));

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CategoryModule.category', 'Category was changed!')
                );

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }

        // найти по alias страницы на других языках
        $langModels = Category::model()->findAll('alias = :alias AND id != :id',array(
            ':alias' => $model->alias,
            ':id' => $model->id
        ));

        $this->render('update', array(
            'model' => $model,
            'langModels' => CHtml::listData($langModels,'lang','id'),
            'languages' => $this->yupe->getLanguagesList()
        ));
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
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

                $transaction->commit();

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
            throw new CHttpException(400, Yii::t('CategoryModule.category', 'Bad request. Please don\'t use similar requests anymore'));
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
            throw new CHttpException(404, Yii::t('CategoryModule.category', 'Page was not found!'));
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