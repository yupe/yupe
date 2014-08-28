<?php

/**
 * MenuitemBackendController контроллер для управления пунктами меню в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu.controllers
 * @since 0.1
 *
 */
class MenuitemBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Menu.MenuitemBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Menu.MenuitemBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Menu.MenuitemBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('Menu.MenuitemBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('Menu.MenuitemBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('Menu.MenuitemBackend.View')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'MenuItem',
                'validAttributes' => array('title', 'href', 'status', 'menu_id', 'sort')
            )
        );
    }

    public function actionSortable()
    {
        $sortOrder = Yii::app()->request->getPost('sortOrder');

        if (empty($sortOrder)) {
            throw new CHttpException(404);
        }

        if (MenuItem::model()->sort($sortOrder)) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->failure();
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

        if (($menuId = Yii::app()->getRequest()->getPost('menuId')) == null) {
            throw new CHttpException(404);
        }

        $items = MenuItem::model()->public()->findAll(
            array(
                'condition' => 'menu_id = :menu_id',
                'order'     => 'title DESC',
                'params'    => array(
                    ':menu_id' => $menuId
                )
            )
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
        $this->render('view', array('model' => $this->loadModel($id)));
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

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MenuModule.menu', 'New item was added to menu!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }

        $criteria = new CDbCriteria();

        $criteria->select = new CDbExpression('MAX(sort) as sort');

        $max = $model->find($criteria);

        $model->sort = $max->sort + 1; // Set sort in Adding Form as ma x+ 1

        $this->render('create', array('model' => $model));
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

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MenuModule.menu', 'Record was updated!')
                );

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

            Yii::app()->user->setFlash(
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

        $this->render('index', array('model' => $model));
    }

    /**
     * Обновление дерева пунктов меню в завимости от родителя.
     *
     * @return void
     */
    public function actionDynamicParent()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && ($data = Yii::app()->getRequest()->getParam(
                'MenuItem'
            )) !== null
        ) {
            $model = new MenuItem('search');

            $model->setAttributes($data);

            if ($model->menu_id) {
                if (isset($_GET['id'])) {
                    $model->id = $_GET['id'];
                }

                $data = $model->parentTree;

                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $value), $name, true);
                }
            }
        }

        Yii::app()->end();
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpException If MenuItem record not found
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
