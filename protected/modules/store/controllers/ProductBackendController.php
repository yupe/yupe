<?php

/**
 * Class ProductBackendController
 */
class ProductBackendController extends yupe\components\controllers\BackController
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->productRepository = Yii::app()->getComponent('productRepository');
    }

    /**
     * @return array
     */
    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            [
                'postOnly + batch',
            ]
        );
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'Product',
                'validateModel' => false,
                'validAttributes' => [
                    'status',
                    'in_stock',
                    'price',
                    'discount_price',
                    'sku',
                    'type_id',
                    'quantity',
                    'producer_id'
                ],
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Product',
            ],
            'sortrelated' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'ProductLink',
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
            ['allow', 'actions' => ['index'], 'roles' => ['Store.ProductBackend.Index'],],
            ['allow', 'actions' => ['view'], 'roles' => ['Store.ProductBackend.View'],],
            ['allow', 'actions' => ['create', 'copy', 'batch'], 'roles' => ['Store.ProductBackend.Create'],],
            [
                'allow',
                'actions' => ['update', 'inline', 'sortable', 'deleteImage', 'batch'],
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

                $this->uploadAttributesFiles($model);

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was created!')
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
        $this->render(
            'create',
            [
                'model' => $model,
                'imageGroup' => ImageGroup::model(),
            ]
        );
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

                $this->uploadAttributesFiles($model);

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was updated!')
                );

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(['update', 'id' => $model->id]);
                } else {
                    $this->redirect([$_POST['submit-type']]);
                }
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('StoreModule.store', 'Failed to save product!')
                );
            }
        }


        $searchModel = new ProductSearch('search');
        $searchModel->unsetAttributes();
        $searchModel->setAttributes(
            Yii::app()->getRequest()->getQuery('ProductSearch')
        );

        $this->render(
            'update',
            [
                'model' => $model,
                'searchModel' => $searchModel,
                'imageGroup' => ImageGroup::model(),
            ]
        );
    }

    /**
     * @param $model
     */
    protected function uploadAttributesFiles($model)
    {
        if (!empty($_FILES['Attribute']['name'])) {
            foreach ($_FILES['Attribute']['name'] as $key => $file) {
                $value = AttributeValue::model()->find('product_id = :product AND attribute_id = :attribute', [
                    ':product' => $model->id,
                    ':attribute' => $key,
                ]);

                $value = $value ?: new AttributeValue();

                $value->setAttributes([
                    'product_id' => $model->id,
                    'attribute_id' => $key,
                ]);

                $value->addFileInstanceName('Attribute['.$key.'][name]');
                if (false === $value->save()) {
                    Yii::app()->getUser()->setFlash(\yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        Yii::t('StoreModule.store', 'Error uploading some files...'));
                }
            }
        }
    }

    /**
     * @param Product $product
     */
    protected function updateProductImages(Product $product)
    {
        if (Yii::app()->getRequest()->getPost('ProductImage')) {
            foreach (Yii::app()->getRequest()->getPost('ProductImage') as $key => $val) {
                $productImage = ProductImage::model()->findByPk($key);
                if (null === $productImage) {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->addFileInstanceName('ProductImage['.$key.'][name]');
                }
                $productImage->setAttributes($_POST['ProductImage'][$key]);
                if (false === $productImage->save()) {
                    Yii::app()->getUser()->setFlash(\yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        Yii::t('StoreModule.store', 'Error uploading some images...'));
                }
            }
        }
    }

    /**
     * @throws CHttpException
     */
    public function actionDeleteImage()
    {
        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest()) {

            $id = (int)Yii::app()->getRequest()->getPost('id');

            $model = ProductImage::model()->findByPk($id);

            if (null !== $model && $model->delete()) {
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

            $this->loadModel($id)->delete();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('StoreModule.store', 'Record was removed!')
            );

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
        $model->unsetAttributes();
        if (Yii::app()->getRequest()->getQuery('Product')) {
            $model->setAttributes(
                Yii::app()->getRequest()->getQuery('Product')
            );
        }
        $this->render('index', [
            'model' => $model,
            'batchModel' => new ProductBatchForm(),
        ]);
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
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        return $model;
    }

    /**
     * @param $id
     * @throws CException
     * @throws CHttpException
     */
    public function actionTypeAttributesForm($id)
    {
        $type = Type::model()->findByPk($id);

        if (null === $type) {
            throw new CHttpException(404);
        }

        $this->renderPartial('_attribute_form', ['groups' => $type->getAttributeGroups(), 'model' => new Product()]);
    }

    /**
     * @param $id
     * @throws CException
     */
    public function actionVariantRow($id)
    {
        $variant = new ProductVariant();
        $variant->setAttributes(
            [
                'attribute_id' => (int)$id,
            ]
        );
        $this->renderPartial('_variant_row', ['variant' => $variant]);
    }

    /**
     * @param $id
     * @throws CHttpException
     */
    public function actionTypeAttributes($id)
    {
        $type = Type::model()->findByPk($id);

        if (null === $type) {
            throw new CHttpException(404);
        }

        $types = [];

        $noSupported = [Attribute::TYPE_FILE, Attribute::TYPE_TEXT, Attribute::TYPE_CHECKBOX_LIST];

        foreach ($type->typeAttributes as $attr) {

            if (in_array($attr->type, $noSupported)) {
                continue;
            }

            if ($attr->type == Attribute::TYPE_DROPDOWN) {
                $types[] = array_merge($attr->attributes, ['options' => $attr->options]);
            } else {
                if (in_array($attr->type, [Attribute::TYPE_CHECKBOX, Attribute::TYPE_SHORT_TEXT])) {
                    $types[] = array_merge($attr->attributes, ['options' => []]);
                } else {
                    $types[] = $attr->attributes;
                }
            }
        }

        Yii::app()->ajax->raw($types);
    }

    /**
     *
     */
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

    /**
     *
     */
    public function actionBatch()
    {
        $form = new ProductBatchForm();
        $form->setAttributes(Yii::app()->getRequest()->getPost('ProductBatchForm'));

        if ($form->validate() === false) {
            Yii::app()->ajax->failure(Yii::t('StoreModule.store', 'Wrong data'));
        }

        if ($this->productRepository->batchUpdate($form, explode(',', Yii::app()->getRequest()->getPost('ids')))) {
            Yii::app()->ajax->success('ok');
        }

        Yii::app()->ajax->failure();
    }
}
