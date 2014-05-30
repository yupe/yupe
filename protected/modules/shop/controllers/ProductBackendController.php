<?php

class ProductBackendController extends yupe\components\controllers\BackController
{
    /**
     * Отображает товар по указанному идентификатору
     * @param integer $id Идинтификатор товар для отображения
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
            ProductImage::model()->deleteByPk($id);
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
}