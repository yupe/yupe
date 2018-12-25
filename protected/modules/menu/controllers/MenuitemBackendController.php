<?php

/**
 * MenuitemBackendController контроллер для управления пунктами меню в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package yupe.modules.menu.controllers
 * @since 0.1
 *
 */
class MenuitemBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Menu.MenuitemBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Menu.MenuitemBackend.View']],
            [
                'allow',
                'actions' => ['create', 'dynamicParent', 'getjsonitems'],
                'roles' => ['Menu.MenuitemBackend.Create'],
            ],
            [
                'allow',
                'actions' => ['update', 'inline', 'sortable', 'dynamicParent', 'getjsonitems'],
                'roles' => ['Menu.MenuitemBackend.Update'],
            ],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Menu.MenuitemBackend.Delete']],
            ['deny'],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'MenuItem',
                'validAttributes' => ['title', 'href', 'status', 'menu_id', 'sort'],
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'MenuItem',
                'attribute' => 'sort',
            ],
        ];
    }

    /**
     * Получаем JSON меню через ajax-запрос:
     *
     * @return void
     *
     * @throws CHttpException If not ajax/post query || record not found
     */
    public function actionGetjsonitems()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404);
        }

        if (($menuId = Yii::app()->getRequest()->getPost('menuId')) === null) {
            throw new CHttpException(404);
        }

        $items = MenuItem::model()->public()->findAll(
            [
                'condition' => 'menu_id = :menu_id',
                'order' => 'title DESC',
                'params' => [
                    ':menu_id' => $menuId,
                ],
            ]
        );

        Yii::app()->ajax->success(
            CHtml::listData(
                $items,
                'id',
                'title'
            )
        );
    }

    /**
     * Отображает пункт меню по указанному идентификатору
     *
     * @param integer $id Идинтификатор меню для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель пунта меню.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new MenuItem();

        $model->menu_id = Yii::app()->getRequest()->getQuery('mid', null);

        if (($data = Yii::app()->getRequest()->getPost('MenuItem')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MenuModule.menu', 'New item was added to menu!')
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
     * Редактирование пункта меню.
     *
     * @param integer $id Идинтификатор пункта меню для редактирования
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('MenuItem')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MenuModule.menu', 'Record was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Удаляет модель пункта меню из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор пункта меню, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException If not POST-query
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // we only allow deletion via POST request
            $this->loadModel($id)->deleteWithChild();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('MenuModule.menu', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('MenuModule.menu', 'Bad request. Please don\'t try similar requests anymore!')
            );
        }
    }

    /**
     * Управление пунктами меню.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new MenuItem('search');

        $model->unsetAttributes(); // clear any default values

        if (($data = Yii::app()->getRequest()->getParam('MenuItem')) !== null) {
            $model->setAttributes($data);
        }

        $this->render('index', ['model' => $model]);
    }


    /**
     * @throws CHttpException
     */
    public function actionDynamicParent()
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404);
        }

        $model = new MenuItem('search');

        $model->setAttributes(
            Yii::app()->getRequest()->getParam('MenuItem')
        );

        if ($model->menu_id) {

            $model->id = Yii::app()->getRequest()->getQuery('id');

            $data = $model->getParentTree();

            foreach ($data as $value => $name) {
                echo CHtml::tag('option', ['value' => $value], $name, true);
            }
        }

        Yii::app()->end();
    }

    /**
     * @throws CHttpException
     */
    public function actionGetentities()
    {
        $request = Yii::app()->getRequest();

        if (!$entityModuleName = $request->getParam('entity_module_name')) {
            throw new CHttpException(404);
        }

        echo json_encode(Yii::app()->menu->getEntityList($entityModuleName));
        Yii::app()->end();
    }


    /**
     * @throws CHttpException
     */
    public function actionGetentityitems()
    {

        $request = Yii::app()->getRequest();

        if (!($entityModuleName = $request->getParam('entity_module_name')) || (!$entityName = $request->getParam('entity_name'))) {
            throw new CHttpException(404);
        }

        echo json_encode(Yii::app()->menu->getEntityItemList($entityModuleName, $entityName));
        Yii::app()->end();
    }

    /**
     * @throws CHttpException
     */
    public function actionGetentityurl()
    {
        $request = Yii::app()->getRequest();

        if ((!$entityModuleName = $request->getParam('entity_module_name')) ||
            (!$entityName = $request->getParam('entity_name')) || (!$entity_id = $request->getParam('entity_id'))) {
            throw new CHttpException(404);
        }

        echo Yii::app()->menu->getEntityItemUrl($entityModuleName, $entityName, $entity_id);
        Yii::app()->end();
    }

    /**
     * @param $id
     * @return array|mixed|null
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = MenuItem::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('MenuModule.menu', 'Page was not found!')
            );
        }

        return $model;
    }
}
