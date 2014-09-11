<?php

/**
 * CatalogBackendController контроллер для управления каталогом в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog.controllers
 * @since 0.1
 *
 */
class CatalogBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Catalog.CatalogBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Catalog.CatalogBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Catalog.CatalogBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('Catalog.CatalogBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('Catalog.CatalogBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('Catalog.CatalogBackend.View')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Good',
                'validAttributes' => array('name', 'alias', 'price', 'article', 'status', 'category_id', 'is_special')
            )
        );
    }

    /**
     * Отображает товар по указанному идентификатору
     * @param integer $id Идинтификатор товар для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель товара.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Good();

        if (isset($_POST['Good'])) {
            $model->attributes = $_POST['Good'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CatalogModule.catalog', 'Record was added!')
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
     * Редактирование товара.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['Good'])) {
            $model->attributes = $_POST['Good'];

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CatalogModule.catalog', 'Record was updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаяет модель товара из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор товара, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('CatalogModule.catalog', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, Yii::t('CatalogModule.catalog', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * Управление товарами.
     */
    public function actionIndex()
    {
        $model = new Good('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Good'])) {
            $model->attributes = $_GET['Good'];
        }
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param $id integer идентификатор нужной модели
     * @throws CHttpException
     * @return Good
     */
    public function loadModel($id)
    {
        $model = Good::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CatalogModule.catalog', 'Page was not found!'));
        }

        return $model;
    }

}
