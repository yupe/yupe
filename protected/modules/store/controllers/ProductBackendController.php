<?php

class ProductBackendController extends yupe\components\controllers\BackController
{
    public function actions()
    {
        return array(
            'inline' => array(
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Product',
                'validAttributes' => array(
                    'status',
                    'in_stock',
                    'price'
                )
            )
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('ajaxSearch'), 'roles' => array('Store.ProductBackend.Index'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Store.ProductBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Store.ProductBackend.Delete'),),
            array('allow', 'actions' => array('deleteImage'), 'roles' => array('Store.ProductBackend.Update'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Store.ProductBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Store.ProductBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Store.ProductBackend.View'),),
            array('allow', 'actions' => array('typeAttributes'), 'roles' => array('Store.ProductBackend.Create', 'Store.ProductBackend.Update'),),
            array('allow', 'actions' => array('typeAttributesForm'), 'roles' => array('Store.ProductBackend.Create', 'Store.ProductBackend.Update'),),
            array('allow', 'actions' => array('variantRow'), 'roles' => array('Store.ProductBackend.Create', 'Store.ProductBackend.Update'),),
            array('deny',),
        );
    }

    /**
     * Отображает товар по указанному идентификатору
     * @param integer $id Идентификатор товар для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель товара.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Product();

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Product')) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Product'));
            $model->setTypeAttributes(Yii::app()->getRequest()->getPost('Attribute', []));
            $model->setProductVariants(Yii::app()->getRequest()->getPost('ProductVariant', []));
            if ($model->save()) {
                $model->setProductCategories(Yii::app()->getRequest()->getPost('categories', []));

                $this->updateProductImages($model);

                Yii::app()->getUser()->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, Yii::t('StoreModule.store', 'Record was added!'));

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование товара.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getPost('Product')) {
            $model->setAttributes(Yii::app()->getRequest()->getPost('Product'));
            $model->setTypeAttributes(Yii::app()->getRequest()->getPost('Attribute', []));
            $model->setProductVariants(Yii::app()->getRequest()->getPost('ProductVariant', []));
            if ($model->save()) {
                $model->setProductCategories(Yii::app()->getRequest()->getPost('categories', []));
                $this->updateProductImages($model);
                Yii::app()->getUser()->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, Yii::t('StoreModule.store', 'Record was updated!'));

                if (!isset($_POST['submit-type'])) {
                    $this->redirect(array('update', 'id' => $model->id));
                } else {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
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

            if(null !== $model) {
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
        $this->render('index', array('model' => $model));
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
        $this->renderPartial('_attribute_form', array('type' => $type));
    }

    public function actionVariantRow($id)
    {
        $variant = new ProductVariant();
        $variant->attribute_id = $id;
        $this->renderPartial('_variant_row', array('variant' => $variant));
    }

    public function actionTypeAttributes($id)
    {
        $type_id = $id;
        $type = Type::model()->findByPk($type_id);
        if ($type) {
            $tmp = array();
            foreach ($type->typeAttributes as $attr) {
                if ($attr->type == Attribute::TYPE_DROPDOWN) {
                    $tmp[] = array_merge($attr->attributes, array('options' => $attr->options));
                } else {
                    if (in_array($attr->type, array(Attribute::TYPE_CHECKBOX, Attribute::TYPE_TEXT))) {
                        $tmp[] = array_merge($attr->attributes, array('options' => array()));
                    }
                }
            }
            Yii::app()->ajax->rawText(
                CJSON::encode($tmp)
            );
        }
    }
}
