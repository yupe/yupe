<?php

/**
 * Class AttributeBackendController
 */
class AttributeBackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index'], 'roles' => ['Store.AttributeBackend.Index'],],
            ['allow', 'actions' => ['create', 'groupCreate', 'inline'], 'roles' => ['Store.AttributeBackend.Create'],],
            [
                'allow',
                'actions' => [
                    'update',
                    'sortable',
                    'sortattr',
                    'sortoptions',
                    'inlineEditGroup',
                    'groupCreate',
                    'addOption',
                    'deleteOption',
                    'inlineattr',
                    'inline',
                ],
                'roles' => ['Store.AttributeBackend.Update'],
            ],
            [
                'allow',
                'actions' => ['delete', 'multiaction', 'deleteFile'],
                'roles' => ['Store.AttributeBackend.Delete'],
            ],
            ['deny',],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inlineEditGroup' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'AttributeGroup',
                'validAttributes' => ['name'],
            ],
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'AttributeOption',
                'validAttributes' => ['value'],
            ],
            'inlineattr' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Attribute',
                'validAttributes' => ['required', 'is_filter'],
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'AttributeGroup',
            ],
            'sortattr' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Attribute',
                'attribute' => 'sort',
            ],
            'sortoptions' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'AttributeOption',
            ],
        ];
    }

    public function actionDeleteFile()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException();
        }

        $product = (int)Yii::app()->getRequest()->getPost('product');
        $attribute = (int)Yii::app()->getRequest()->getPost('attribute');

        $model = AttributeValue::model()->find('product_id = :product AND attribute_id = :attribute', [
            ':product' => $product,
            ':attribute' => $attribute,
        ]);

        if (null === $model || null === $model->getFilePath()) {
            Yii::app()->ajax->success();
        }

        $model->delete();

        Yii::app()->ajax->success();
    }


    /**
     * Создает новую модель атрибута.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Attribute();

        if (($data = Yii::app()->getRequest()->getPost('Attribute')) !== null) {

            $model->setAttributes($data);

            if ($model->save() && $model->setTypes(Yii::app()->getRequest()->getPost('types',
                    [])) && $model->setMultipleValuesAttributes(explode(PHP_EOL, $model->rawOptions))
            ) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Attribute created')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            }
        }

        $this->render('create', [
            'model' => $model,
            'types' => Type::model()->findAll(),
        ]);
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Attribute')) !== null) {

            $currentType = $model->type;

            $model->setAttributes(Yii::app()->getRequest()->getPost('Attribute'));

            if ($model->save() && $model->changeType($currentType,
                    $model->type) && $model->setTypes(Yii::app()->getRequest()->getPost('types', []))
            ) {

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Attribute updated')
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

        $this->render(
            'update',
            [
                'model' => $model,
                'types' => Type::model()->findAll(),
            ]
        );
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $transaction = Yii::app()->getDb()->beginTransaction();

            try {
                // поддерживаем удаление только из POST-запроса
                $this->loadModel($id)->delete();

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
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteOption($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $option = AttributeOption::model()->findByPk($id);

            if (null === $option) {
                throw new CHttpException(404);
            }

            $option->delete();

            if (!isset($_GET['ajax'])) {
                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
                );
            }

        } else {
            throw new CHttpException(
                400,
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }


    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionAddOption($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $model = $this->loadModel($id);

            $option = new AttributeOption();
            $option->setAttributes([
                'value' => Yii::app()->getRequest()->getPost('value'),
                'attribute_id' => $model->id
            ]);

            if (true === $option->save()) {
                Yii::app()->ajax->success();
            }

            Yii::app()->ajax->failure();


        } else {
            throw new CHttpException(
                400,
                Yii::t('StoreModule.store', 'Bad request. Please don\'t use similar requests anymore')
            );
        }
    }


    /**
     *
     */
    public function actionIndex()
    {
        $model = new Attribute('search');
        $model->unsetAttributes();

        $attributeGroup = new AttributeGroup('search');
        $attributeGroup->unsetAttributes();

        if (isset($_GET['Attribute'])) {
            $model->setAttributes($_GET['Attribute']);
        }

        $this->render('index', [
            'model' => $model,
            'attributeGroup' => $attributeGroup,
        ]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id - идентификатор нужной модели
     *
     * @return Attribute $model
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Attribute::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        return $model;
    }

    /**
     * Производит AJAX-валидацию
     *
     * @param CModel $model - модель, которую необходимо валидировать
     *
     * @return void
     */
    protected function performAjaxValidation(Attribute $model)
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost(
                'ajax'
            ) === 'attribute-form'
        ) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     *
     */
    public function actionGroupCreate()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $group = new AttributeGroup();
            $group->name = Yii::app()->getRequest()->getParam('name');
            if ($group->save()) {
                Yii::app()->ajax->success();
            }
            Yii::app()->ajax->failure($group->getErrors());
        }
    }
}
