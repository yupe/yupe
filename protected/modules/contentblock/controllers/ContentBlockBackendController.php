<?php

/**
 * ContentBlockBackendController контроллер для управления блоками контента в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.contentblock.controllers
 * @since 0.1
 *
 */
class ContentBlockBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('ContentBlock.ContentblockBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('ContentBlock.ContentblockBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('ContentBlock.ContentblockBackend.Index')),
            array(
                'allow',
                'actions' => array('inlineEdit'),
                'roles'   => array('ContentBlock.ContentblockBackend.Update')
            ),
            array('allow', 'actions' => array('update'), 'roles' => array('ContentBlock.ContentblockBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('ContentBlock.ContentblockBackend.View')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'ContentBlock',
                'validAttributes' => array('name', 'code', 'type', 'description')
            )
        );
    }

    /**
     * Displays a particular model.
     *
     * @param integer $id the ID of the model to be displayed
     *
     * @return void
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $code = "<?php \$this->widget(\n\t\"application.modules.contentblock.widgets.ContentBlockWidget\",\n\tarray(\"code\" => \"{$model->code}\"));\n?>";
        $codeCategory          = "<?php \$this->widget(\n\t\"application.modules.contentblock.widgets.ContentBlockGroupWidget\",\n\tarray(\"category\" => \"{$model->getCategoryAlias()}\"));\n?>";

        $highlighter = new CTextHighlighter();
        $highlighter->language = 'PHP';
        $example = $highlighter->highlight($code);
        $exampleCategory = $highlighter->highlight($codeCategory);

        $this->render(
            'view',
            array(
                'model'   => $model,
                'example' => $example,
                'exampleCategory' => $exampleCategory
            )
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new ContentBlock();

        if (($data = Yii::app()->getRequest()->getPost('ContentBlock')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ContentBlockModule.contentblock', 'New content block was added!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('ContentBlock')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('ContentBlockModule.contentblock', 'Content block was changed!')
                );

                Yii::app()->cache->delete("ContentBlock{$model->code}");

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('update', 'id' => $model->id)
                    )
                );
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id the ID of the model to be deleted
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getIsAjaxRequest() || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );

        } else {
            throw new CHttpException(400, Yii::t('ContentBlockModule.contentblock', 'Unknown request!'));
        }
    }

    /**
     * Manages all models.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new ContentBlock('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'ContentBlock',
                array()
            )
        );

        $this->render('index', array('model' => $model));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param integer $id the ID of the model to be loaded
     *
     * @return ContentBlock $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ContentBlock::model()->with('category')->findByPk((int)$id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('ContentBlockModule.contentblock', 'Page was not found!'));
        }

        return $model;
    }
}
