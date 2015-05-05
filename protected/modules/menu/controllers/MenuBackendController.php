<?php

/**
 * MenuBackendController контроллер для управления меню в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package yupe.modules.menu.controllers
 * @since 0.1
 *
 */
class MenuBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Menu.MenuBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Menu.MenuBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Menu.MenuBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Menu.MenuBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Menu.MenuBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Menu',
                'validAttributes' => ['name', 'code', 'status', 'description']
            ]
        ];
    }

    /**
     * Отображает меню по указанному идентификатору
     * @param integer $id Идинтификатор меню для отображения
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $code = "<?php \$this->widget(
                    'application.modules.menu.widgets.MenuWidget', array(
                        'name'         => '{$model->code}',
                        'params'       => array('hideEmptyItems' => true),
                        'layoutParams' => array(
                            'htmlOptions' => array(
                                'class' => 'jqueryslidemenu',
                                'id'    => 'myslidemenu',
                            )
                        ),
                    )
                ); ?>";

        $highlighter = new CTextHighlighter();
        $highlighter->language = 'PHP';
        $example = $highlighter->highlight($code);

        $this->render(
            'view',
            [
                'model'   => $model,
                'example' => $example,
            ]
        );
    }

    /**
     * Создает новую модель меню.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Menu();

        if (($data = Yii::app()->getRequest()->getPost('Menu')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('MenuModule.menu', 'Menu was created!')
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
     * Редактирование меню.
     * @param integer $id Идинтификатор меню для редактирования
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Menu')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
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
     * Удаляет модель меню из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор меню, который нужно удалить
     *
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

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
     * Управление блогами.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Menu('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Menu',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return Menu $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = Menu::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('MenuModule.menu', 'Page was not found!')
            );
        }

        return $model;
    }
}
