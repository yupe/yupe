<?php
class DefaultController extends YBackController
{
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $code = "<?php \$this->widget(\"application.modules.contentblock.widgets.ContentBlockWidget\", array(\"code\" => \"{$model->code}\")); ?>";


        $highlighter = new CTextHighlighter;
        $highlighter->language = 'PHP';
        $example = $highlighter->highlight($code); 

        $this->render('view', array(
            'model'   => $model,
            'example' => $example,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new ContentBlock;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ContentBlock']))
        {
            $model->attributes = $_POST['ContentBlock'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('ContentBlockModule.contentblock', 'Новый контент блок добавлен!')
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ContentBlock']))
        {
            $model->attributes = $_POST['ContentBlock'];

            if ($model->save())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('ContentBlockModule.contentblock', 'Контент блок изменен!')
                );

                Yii::app()->cache->delete("ContentBlock{$model->code}");

                if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('ContentBlockModule.contentblock', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }

    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new ContentBlock('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['ContentBlock']))
            $model->attributes = $_GET['ContentBlock'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = ContentBlock::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('ContentBlockModule.contentblock', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'content-block-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}