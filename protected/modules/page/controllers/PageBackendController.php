<?php
/**
 * PageBackendController контроллер панели управления для управления страницами
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.page.controllers
 * @license   BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version   0.6
 *
 */
Yii::import('application.modules.menu.models.*');

class PageBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Page.PageBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Page.PageBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Page.PageBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Page.PageBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Page.PageBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Page',
                'validAttributes' => ['title', 'slug', 'status', 'title_short']
            ]
        ];
    }

    /**
     * @var Page $model the currently loaded data model instance.
     */
    private $_model;

    /**
     * Displays a particular model.
     *
     * @param int $id - record ID
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     *
     * @throws CDbException
     */
    public function actionCreate()
    {
        $model = new Page();
        $menuId = null;
        $menuParentId = 0;

        if (($data = Yii::app()->getRequest()->getPost('Page')) !== null) {
            $model->setAttributes($data);
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($model->save()) {
                    // если активен модуль "Меню" - сохраним в меню
                    if (Yii::app()->hasModule('menu')) {
                        $menuId = (int)Yii::app()->getRequest()->getPost('menu_id');
                        $parentId = (int)Yii::app()->getRequest()->getPost('parent_id');
                        $menu = Menu::model()->findByPk($menuId);
                        if ($menu) {
                            if (!$menu->addItem(
                                $model->title,
                                $model->getUrl(),
                                $parentId,
                                true
                            )
                            ) {
                                throw new CDbException(
                                    Yii::t('PageModule.page', 'There is an error when connecting page to menu...')
                                );
                            }
                        }
                    }

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('PageModule.page', 'Page was created')
                    );

                    $transaction->commit();

                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost(
                            'submit-type',
                            ['create']
                        )
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();
                $model->addError(false, $e->getMessage());
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $lang = Yii::app()->getRequest()->getQuery('lang');

        if (!empty($id) && !empty($lang)) {
            $page = Page::model()->findByPk($id);
            if (null === $page) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('PageModule.page', 'Targeting page was not found!')
                );

                $this->redirect(['index']);
            }

            if (!array_key_exists($lang, $languages)) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('PageModule.page', 'Language was not found!')
                );

                $this->redirect(['index']);
            }

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    'PageModule.page',
                    'You add translation for {lang}',
                    [
                        '{lang}' => $languages[$lang]
                    ]
                )
            );

            $model->lang = $lang;
            $model->slug = $page->slug;
            $model->category_id = $page->category_id;
            $model->title = $page->title;
            $model->title_short = $page->title_short;
            $model->parent_id = $page->parent_id;
            $model->order = $page->order;
            $model->layout = $page->layout;
        } else {
            $model->lang = Yii::app()->getLanguage();
        }

        $this->render(
            'create',
            [
                'model' => $model,
                'pages' => Page::model()->getFormattedList(),
                'languages' => $languages,
                'menuId' => $menuId,
                'menuParentId' => $menuParentId
            ]
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id - record ID
     *
     * @return void
     *
     * @throws CDbException
     */
    public function actionUpdate($id)
    {
        // Указан ID страницы, редактируем только ее
        $model = $this->loadModel($id);

        $oldTitle = $model->title;
        $menuId = null;
        $menuParentId = 0;

        if (($data = Yii::app()->getRequest()->getPost('Page')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                if (Yii::app()->hasModule('menu')) {

                    $menuId = (int)Yii::app()->getRequest()->getPost('menu_id');
                    $parentId = (int)Yii::app()->getRequest()->getPost('parent_id');
                    $menu = Menu::model()->findByPk($menuId);
                    if ($menu) {
                        if (!$menu->changeItem(
                            $oldTitle,
                            $model->title,
                            $model->getUrl(),
                            $parentId,
                            true
                        )
                        ) {
                            throw new CDbException(
                                Yii::t('PageModule.page', 'There is an error when connecting page to menu...')
                            );
                        }
                    }
                }

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('PageModule.page', 'Page was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        if (Yii::app()->hasModule('menu')) {

            $menuItem = MenuItem::model()->findByAttributes(
                [
                    "title" => $oldTitle
                ]
            );


            if ($menuItem !== null) {
                $menuId = (int)$menuItem->menu_id;
                $menuParentId = (int)$menuItem->parent_id;
            }
        }

        // найти по slug страницы на других языках
        $langModels = Page::model()->findAll(
            'slug = :slug AND id != :id',
            [
                ':slug' => $model->slug,
                ':id' => $model->id
            ]
        );

        $this->render(
            'update',
            [
                'langModels' => CHtml::listData($langModels, 'lang', 'id'),
                'model' => $model,
                'pages' => Page::model()->getFormattedList(
                        null,
                        0,
                        ['condition' => 'id != :id', 'params' => [':id' => $model->id]]
                    ),
                'languages' => $this->yupe->getLanguagesList(),
                'menuId' => $menuId,
                'menuParentId' => $menuParentId
            ]
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page
     *
     * @param int $id - record ID
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $model = $this->loadModel($id);

            if (Yii::app()->hasModule('menu')) {

                $menuItem = MenuItem::model()->findByAttributes(["title" => $model->title]);

                if ($menuItem !== null) {
                    $menuItem->delete();
                }
            }

            // we only allow deletion via POST request
            $model->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('PageModule.page', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                404,
                Yii::t('PageModule.page', 'Bad request. Please don\'t repeat similar requests anymore!')
            );
        }
    }

    /**
     * Manages all models.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Page('search');

        $model->unsetAttributes();

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Page',
                []
            )
        );

        $this->render(
            'index',
            [
                'model' => $model,
                'pages' => Page::model()->getAllPagesList(),
            ]
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     *
     * @param int $id - record ID
     *
     * @return Page $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if ($this->_model === null || $this->_model->id !== $id) {

            if (($this->_model = Page::model()->with('author', 'changeAuthor')->findByPk($id)) === null) {
                throw new CHttpException(
                    404,
                    Yii::t('PageModule.page', 'Page was not found')
                );
            }
        }

        return $this->_model;
    }
}
