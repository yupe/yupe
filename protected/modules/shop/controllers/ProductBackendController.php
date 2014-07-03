<?php

class ProductBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin'),),
            array('allow', 'actions' => array('ajaxSearch'), 'roles' => array('Shop.ProductBackend.Index'),),
            array('allow', 'actions' => array('create'), 'roles' => array('Shop.ProductBackend.Create'),),
            array('allow', 'actions' => array('delete'), 'roles' => array('Shop.ProductBackend.Delete'),),
            array('allow', 'actions' => array('deleteImage'), 'roles' => array('Shop.ProductBackend.Update'),),
            array('allow', 'actions' => array('update'), 'roles' => array('Shop.ProductBackend.Update'),),
            array('allow', 'actions' => array('index'), 'roles' => array('Shop.ProductBackend.Index'),),
            array('allow', 'actions' => array('view'), 'roles' => array('Shop.ProductBackend.View'),),
            array('allow', 'actions' => array('typeAttributes'), 'roles' => array('Shop.ProductBackend.Create', 'Shop.ProductBackend.Update'),),
            array('allow', 'actions' => array('typeAttributesForm'), 'roles' => array('Shop.ProductBackend.Create', 'Shop.ProductBackend.Update'),),
            array('allow', 'actions' => array('variantRow'), 'roles' => array('Shop.ProductBackend.Create', 'Shop.ProductBackend.Update'),),
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Product']))
        {
            $model->attributes = $_POST['Product'];
            $model->setTypeAttributes($_POST['Attribute']);
            if ($model->save())
            {
                $model->setProductCategories($_POST['categories'], $_POST['categories']['main']);

                $this->updateProductImages($model);

                Yii::app()->user->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, Yii::t('ShopModule.product', 'Record was added!'));

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type', array('create')
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Product']))
        {
            $model->attributes = $_POST['Product'];
            $model->setTypeAttributes($_POST['Attribute']);
            $model->setProductVariants($_POST['ProductVariant']);
            if ($model->save())
            {
                $model->setProductCategories($_POST['categories'], $_POST['categories']['main']);
                $this->updateProductImages($model);
                Yii::app()->user->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, Yii::t('ShopModule.product', 'Record was updated!'));

                if (!isset($_POST['submit-type']))
                {
                    $this->redirect(array('update', 'id' => $model->id));
                }
                else
                {
                    $this->redirect(array($_POST['submit-type']));
                }
            }
        }
        $this->render('update', array('model' => $model));
    }

    public function updateProductImages(Product $product)
    {
        $setFirstImageAsMain = !isset($_POST['main_image']);

        if (isset($_POST['main_image']))
        {
            $productMainImage = $product->mainImage;
            if ($productMainImage && $productMainImage->id != $_POST['main_image'])
            {
                $productMainImage->is_main = 0;
                $productMainImage->save();
                $productMainImage = false;
            }
            if (!$productMainImage)
            {
                $newProductMainImage = ProductImage::model()->findByPk($_POST['main_image']);
                if ($newProductMainImage)
                {
                    $newProductMainImage->is_main = 1;
                    $newProductMainImage->save();
                }
            }
        }

        foreach (CUploadedFile::getInstancesByName('ProductImage') as $key => $image)
        {
            $productImage             = new ProductImage();
            $productImage->product_id = $product->id;
            $productImage->attributes = $_POST['ProductImage'][$key];
            $productImage->is_main    = ($key == 0 && $setFirstImageAsMain) ? 1 : 0;
            $productImage->addFileInstanceName('ProductImage[' . $key . '][name]');
            $productImage->save();
        }
    }

    public function actionDeleteImage($id)
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            ProductImage::model()->findByPk($id)->delete();
        }
    }

    /**
     * Удаяет модель товара из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор товара, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            // поддерживаем удаление только из POST-запроса
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('ShopModule.product', 'Record was removed!')
            );

            // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
            throw new CHttpException(400, Yii::t('ShopModule.product', 'Unknown request. Don\'t repeat it please!'));
    }

    /**
     * Управление товарами.
     */
    public function actionIndex()
    {
        $model = new Product('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];
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
        if ($model === null)
        {
            throw new CHttpException(404, Yii::t('ShopModule.product', 'Page was not found!'));
        }
        return $model;
    }


    protected function performAjaxValidation(Product $model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'good-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }


    public function actionTypeAttributesForm($id)
    {
        $type = Type::model()->findByPk($id);
        $this->renderPartial('_attribute_form', array('type' => $type));
    }

    public function actionVariantRow($id)
    {
        $variant               = new ProductVariant();
        $variant->attribute_id = $id;
        $this->renderPartial('_variant_row', array('variant' => $variant));
    }

    public function actionTypeAttributes($id)
    {
        $type_id = $id;
        $type    = Type::model()->findByPk($type_id);
        if ($type)
        {
            $tmp = array();
            foreach ($type->typeAttributes as $attr)
            {
                if ($attr->type == Attribute::TYPE_DROPDOWN)
                {
                    $tmp[] = array_merge($attr->attributes, array('options' => $attr->options));
                }
                else if (in_array($attr->type, array(Attribute::TYPE_CHECKBOX, Attribute::TYPE_TEXT)))
                {
                    $tmp[] = array_merge($attr->attributes, array('options' => array()));
                }
            }
            Yii::app()->ajax->rawText(
                CJSON::encode($tmp)
            );
        }
    }

    public function actionAjaxSearch()
    {
        if (isset($_GET['q']))
        {
            $search = $_GET['q'];

            $model = Product::model()->findAll(array(
                'condition' => 'name LIKE :name',
                'params' => array(':name' => '%' . str_replace(' ', '%', $search) . '%')
            ));
            $data  = array();
            foreach ($model as $product)
            {
                $data[] = array(
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumb' => $product->mainImage ? $product->mainImage->getImageUrl(50, 50) : '',
                );
            }
            Yii::app()->ajax->rawText(
                CJSON::encode($data)
            );
        }
        Yii::app()->end();
    }
}