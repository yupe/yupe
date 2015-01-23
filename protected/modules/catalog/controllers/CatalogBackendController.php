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
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['Catalog.CatalogBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['Catalog.CatalogBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['Catalog.CatalogBackend.Index']],
            ['allow', 'actions' => ['inlineEdit'], 'roles' => ['Catalog.CatalogBackend.Update']],
            ['allow', 'actions' => ['update'], 'roles' => ['Catalog.CatalogBackend.Update']],
            ['allow', 'actions' => ['view'], 'roles' => ['Catalog.CatalogBackend.View']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Good',
                'validAttributes' => ['name', 'alias', 'price', 'article', 'status', 'category_id', 'is_special']
            ],
            'view'   => [
                'class'        => '\yupe\components\actions\ViewAction',
                'modelClass'   => 'Good',
                'errorMessage' => Yii::t('CatalogModule.catalog', 'Page was not found!'),
            ],
            'update' => [
                'class'          => '\yupe\components\actions\UpdateAction',
                'modelClass'     => 'Good',
                'successMessage' => Yii::t('CatalogModule.catalog', 'Record was updated!'),
                'errorMessage'   => Yii::t('CatalogModule.catalog', 'Page was not found!'),
            ],
            'index'  => [
                'class'      => '\yupe\components\actions\IndexAction',
                'modelClass' => 'Good',
            ],
        ];
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
                        ['create']
                    )
                );
            }
        }
        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование товара.
     * @param integer $id the ID of the model to be updated
     */
    /*public function actionUpdate($id)
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
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }
        $this->render('update', ['model' => $model]);
    }*/

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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t('CatalogModule.catalog', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * Управление товарами.
     */
    /*public function actionIndex()
    {
        $model = new Good('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Good'])) {
            $model->attributes = $_GET['Good'];
        }
        $this->render('index', ['model' => $model]);
    }*/

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
