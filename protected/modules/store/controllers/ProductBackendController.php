<?php

class ProductBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Product',
                'validAttributes' => [
                    'status',
                    'in_stock',
                    'price',
                    'discount',
                    'discount_price',
                    'sku',
                    'type_id'
                ]
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Product'
            ]
        ];
    }

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['allow', 'actions' => ['index', 'ajaxSearch'], 'roles' => ['Store.ProductBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.ProductBackend.View'],],
            ['allow', 'actions' => ['create', 'copy'], 'roles' => ['Store.ProductBackend.Create'],],
            [
                'allow',
                'actions' => ['update', 'inline', 'sortable', 'deleteImage'],
                'roles' => ['Store.ProductBackend.Update'],
            ],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Store.ProductBackend.Delete'],],
            [
                'allow',
                'actions' => ['typeAttributes'],
                'roles' => ['Store.ProductBackend.Create', 'Store.ProductBackend.Update'],
            ],
            [
                'allow',
                'actions' => ['typeAttributesForm'],
                'roles' => ['Store.ProductBackend.Create', 'Store.ProductBackend.Update'],
            ],
            [
                'allow',
                'actions' => ['variantRow'],
                'roles' => ['Store.ProductBackend.Create', 'Store.ProductBackend.Update'],
            ],
            ['deny',],
        ];
    }

    /**
     * Отображает товар по указанному идентификатору
     * @param integer $id Идентификатор товар для отображения
     */
    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id)]);
    }

    /**
     * Создает новую модель товара.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Product();

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Product')) {

            $attributes = Yii::app()->getRequest()->getPost('Product');
            $typeAttributes = Yii::app()->getRequest()->getPost('Attribute', []);
            $variants = Yii::app()->getRequest()->getPost('ProductVariant', []);
            $categories = Yii::app()->getRequest()->getPost('categories', []);

            if ($model->saveData($attributes, $typeAttributes, $variants, $categories)) {

                $this->updateProductImages($model);

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was added!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['create']
                    )
                );
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('StoreModule.store', 'Failed to save product!')
                );
            }
        }
        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование товара.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Product')) {

            $attributes = Yii::app()->getRequest()->getPost('Product');
            $typeAttributes = Yii::app()->getRequest()->getPost('Attribute', []);
            $variants = Yii::app()->getRequest()->getPost('ProductVariant', []);
            $categories = Yii::app()->getRequest()->getPost('categories', []);

            if ($model->saveData($attributes, $typeAttributes, $variants, $categories)) {

                $this->updateProductImages($model);

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            }
        }

        $searchModel = new ProductSearch('search');
        $searchModel->unsetAttributes();

        $this->render('update', ['model' => $model, 'searchModel' => $searchModel]);
    }

    public function updateProductImages(Product $product)
    {
        foreach (CUploadedFile::getInstancesByName('ProductImage') as $key => $image) {
            $productImage = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->attributes = $_POST['ProductImage'][$key];
            $productImage->addFileInstanceName('ProductImage[' . $key . '][name]');
            $productImage->save();
        }
    }

    public function actionDeleteImage()
    {
        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest()) {

            $id = (int)Yii::app()->getRequest()->getPost('id');

            $model = ProductImage::model()->findByPk($id);

            if (null !== $model) {
                $model->delete();
                Yii::app()->ajax->success();
            }
        }

        throw new CHttpException(404);
    }

    /**
     * Удаяет модель товара из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор товара, который нужно удалить
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('StoreModule.store', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            }
        } else {
            throw new CHttpException(400, Yii::t('StoreModule.store', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * Управление товарами.
     */
    public function actionIndex()
    {
        $model = new Product('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Product'])) {
            $model->attributes = $_GET['Product'];
        }
        $this->render('index', ['model' => $model]);
    }

    /**
     * @param $id
     * @return Product
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Product::model()->with('images')->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page was not found!'));
        }

        return $model;
    }

    public function actionTypeAttributesForm($id)
    {
        $type = Type::model()->findByPk($id);

        if (null === $type) {
            throw new CHttpException(404);
        }

        $this->renderPartial('_attribute_form', ['type' => $type, 'model' => new Product()]);
    }

    public function actionVariantRow($id)
    {
        $variant = new ProductVariant();
        $variant->setAttributes(
            [
                'attribute_id' => (int)$id
            ]
        );
        $this->renderPartial('_variant_row', ['variant' => $variant]);
    }

    public function actionTypeAttributes($id)
    {
        $type = Type::model()->findByPk($id);

        if (null === $type) {
            throw new CHttpException(404);
        }

        $out = [];
        foreach ($type->typeAttributes as $attr) {
            if ($attr->type === Attribute::TYPE_DROPDOWN) {
                $out[] = array_merge($attr->attributes, ['options' => $attr->options]);
            } else {
                if (in_array($attr->type, [Attribute::TYPE_CHECKBOX, Attribute::TYPE_SHORT_TEXT])) {
                    $out[] = array_merge($attr->attributes, ['options' => []]);
                }
            }
        }
        Yii::app()->ajax->rawText(
            CJSON::encode($out)
        );
    }


    public function actionAjaxSearch()
    {
        if (!Yii::app()->getRequest()->getQuery('q')) {
            throw new CHttpException(404);
        }

        $model = Product::model()->searchByName(Yii::app()->getRequest()->getQuery('q'));

        $data = [];

        foreach ($model as $product) {
            $data[] = [
                'id' => $product->id,
                'name' => $product->name . ($product->sku ? " ({$product->sku}) " : ' ') . $product->getPrice(
                    ) . ' ' . Yii::t('StoreModule.store', 'руб.'),
                'thumb' => $product->image ? $product->getImageUrl(50, 50) : '',
            ];
        }

        Yii::app()->ajax->raw($data);

    }

    public function actionCopy()
    {
        if ($data = Yii::app()->getRequest()->getPost('items')) {
            foreach ($data as $id) {
                $model = Product::model()->findByPk($id);
                if ($model) {
                    $model->copy();
                }
            }

            Yii::app()->ajax->success();
        }
    }
}
