<?php

/**
 * NewsBackendController контроллер для работы с новостями в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2015 amyLabs && Yupe! team
 * @package   yupe.modules.news.controllers
 * @version   0.6
 *
 */
class NewsBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['News.NewsBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['News.NewsBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['News.NewsBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['News.NewsBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['News.NewsBackend.Delete']],
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
                'model' => 'News',
                'validAttributes' => ['title', 'slug', 'date', 'status'],
            ],
        ];
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
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new News();

        if (($data = Yii::app()->getRequest()->getPost('News')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('NewsModule.news', 'News article was created!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $lang = Yii::app()->getRequest()->getQuery('lang');

        if (!empty($id) && !empty($lang)) {
            $news = News::model()->findByPk($id);

            if (null === $news) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('NewsModule.news', 'Targeting news was not found!')
                );

                $this->redirect(['/news/newsBackend/create']);
            }

            if (!array_key_exists($lang, $languages)) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('NewsModule.news', 'Language was not found!')
                );

                $this->redirect(['/news/newsBackend/create']);
            }

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    'NewsModule.news',
                    'You inserting translation for {lang} language',
                    [
                        '{lang}' => $languages[$lang],
                    ]
                )
            );

            $model->setAttributes([
                'lang' => $lang,
                'slug' => $news->slug,
                'date' => $news->date,
                'category_id' => $news->category_id,
                'title' => $news->title,
            ]);
        } else {
            $model->setAttributes([
                'date' => date('d-m-Y'),
                'lang' => Yii::app()->getLanguage(),
            ]);
        }

        $this->render('create', ['model' => $model, 'languages' => $languages]);
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('News')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('NewsModule.news', 'News article was updated!')
                );

                $this->redirect(
                    Yii::app()->getRequest()->getIsPostRequest()
                        ? (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                        : ['view', 'id' => $model->id]
                );
            }
        }

        // найти по slug страницы на других языках
        $langModels = News::model()->findAll(
            'slug = :slug AND id != :id',
            [
                ':slug' => $model->slug,
                ':id' => $model->id,
            ]
        );

        $this->render(
            'update',
            [
                'langModels' => CHtml::listData($langModels, 'lang', 'id'),
                'model' => $model,
                'languages' => $this->yupe->getLanguagesList(),
            ]
        );
    }


    /**
     * @param null $id
     * @throws CHttpException
     */
    public function actionDelete($id = null)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('NewsModule.news', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t('NewsModule.news', 'Bad raquest. Please don\'t use similar requests anymore!')
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
        $model = new News('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'News',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }


    /**
     * @param $id
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = News::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('NewsModule.news', 'Requested page was not found!')
            );
        }

        return $model;
    }
}
