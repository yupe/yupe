<?php

/**
 * CategoryBackendController контроллер для управления категориями в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.category.controllers
 * @version   0.6
 *
 */
class CategoryBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Category.CategoryBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Category.CategoryBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Category.CategoryBackend.Index')),
            array('allow', 'actions' => array('inlineEdit'), 'roles' => array('Category.CategoryBackend.Update')),
            array('allow', 'actions' => array('update'), 'roles' => array('Category.CategoryBackend.Update')),
            array('allow', 'actions' => array('view'), 'roles' => array('Category.CategoryBackend.View')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Category',
                'validAttributes' => array('name', 'description', 'alias', 'status')
            )
        );
    }

    /**
     * Отображает категорию по указанному идентификатору
     *
     * @param integer $id Идинтификатор категорию для отображения
     *
     * @return void
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель категории.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Category();

        if (($data = Yii::app()->getRequest()->getPost('Category')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CategoryModule.category', 'Record was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $lang = Yii::app()->getRequest()->getQuery('lang');

        if (!empty($id) && !empty($lang)) {
            $category = Category::model()->findByPk($id);

            if (null === $category) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('CategoryModule.category', 'Targeting category was not found!')
                );
                $this->redirect(array('create'));
            }

            if (!array_key_exists($lang, $languages)) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('CategoryModule.category', 'Language was not found!')
                );

                $this->redirect(array('create'));
            }

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    'CategoryModule.category',
                    'You are adding translate in to {lang}!',
                    array(
                        '{lang}' => $languages[$lang]
                    )
                )
            );

            $model->lang = $lang;
            $model->alias = $category->alias;
            $model->parent_id = $category->parent_id;
            $model->name = $category->name;
        } else {
            $model->lang = Yii::app()->language;
        }

        $this->render('create', array('model' => $model, 'languages' => $languages));
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
        // Указан ID новости страницы, редактируем только ее
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Category')) !== null) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Category'));

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('CategoryModule.category', 'Category was changed!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array(
                            'update',
                            'id' => $model->id,
                        )
                    )
                );
            }
        }

        // найти по alias страницы на других языках
        $langModels = Category::model()->findAll(
            'alias = :alias AND id != :id',
            array(
                ':alias' => $model->alias,
                ':id'    => $model->id
            )
        );

        $this->render(
            'update',
            array(
                'model'      => $model,
                'langModels' => CHtml::listData($langModels, 'lang', 'id'),
                'languages'  => $this->yupe->getLanguagesList()
            )
        );
    }

    /**
     * Удаяет модель категории из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id идентификатор категории, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $transaction = Yii::app()->db->beginTransaction();

            try {
                // поддерживаем удаление только из POST-запроса
                $this->loadModel($id)->delete();
                // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

                $transaction->commit();

                if (!isset($_GET['ajax'])) {
                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();

                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('CategoryModule.category', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }

    /**
     * Управление категориями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Category('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Category'])) {
            $model->attributes = $_GET['Category'];
        }

        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer идентификатор нужной модели
     *
     * @return Category $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('CategoryModule.category', 'Page was not found!'));
        }

        return $model;
    }

}
