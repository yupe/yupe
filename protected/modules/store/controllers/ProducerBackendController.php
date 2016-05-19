<?php

/**
 * Class ProducerBackendController
 */
class ProducerBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Producer',
                'validAttributes' => [
                    'status',
                    'slug',
                ],
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Producer',
                'attribute' => 'sort',
            ],
        ];
    }

    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Store.ProducerBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.ProducerBackend.View'],],
            ['allow', 'actions' => ['create'], 'roles' => ['Store.ProducerBackend.Create'],],
            ['allow', 'actions' => ['update', 'inline', 'sortable'], 'roles' => ['Store.ProducerBackend.Update'],],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Store.ProducerBackend.Delete'],],
            ['deny',],
        ];
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     *
     */
    public function actionCreate()
    {
        $model = new Producer();
        $data = Yii::app()->getRequest()->getPost('Producer');

        if (!is_null($data)) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was created!')
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
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $data = Yii::app()->getRequest()->getPost('Producer');

        if (!is_null($data)) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        [
                            'update',
                            'id' => $model->id,
                        ]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('StoreModule.store', 'Record was removed!')
            );

            if (Yii::app()->getRequest()->getQuery('ajax')) {
                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                );
            }
        } else {
            throw new CHttpException(400,
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore'));
        }
    }

    /**
     *
     */
    public function actionIndex()
    {
        $model = new Producer('search');
        $model->unsetAttributes();
        $data = Yii::app()->getRequest()->getQuery('Producer');

        if (!is_null($data)) {
            $model->attributes = $data;
        }

        $this->render('index', ['model' => $model]);
    }

    /**
     * @param $id
     * @return static
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Producer::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        return $model;
    }
}
