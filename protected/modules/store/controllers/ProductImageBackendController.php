<?php

use yupe\components\controllers\BackController;

/**
 * Class ProductImageBackendController
 */
class ProductImageBackendController extends BackController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->productRepository = Yii::app()->getComponent('productRepository');
    }

    /**
     * @return array|mixed
     */
    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            [
                'postOnly + delete, addImages',
            ]
        );
    }

    /**
     * @param integer $id Product Id
     * @throws CHttpException
     */
    public function actionIndex($id)
    {
        $product = $this->productRepository->getById($id, []);
        $model = new ProductImage();

        if (null === $product) {
            throw new CHttpException(404);
        }

        $this->render('index', [
            'product' => $product,
            'model' => $model,
        ]);
    }

    /**
     * Функция добавления группы изображений
     *
     * @param int $id - id-галереи
     *
     * @return void
     *
     * @throws CHttpException
     * @throws CException
     */
    public function actionAddImages($id)
    {
        $product = $this->productRepository->getById($id, []);
        $image = new ProductImage();
        $image->product_id = $product->id;

        if (null === $product) {
            throw new CHttpException(404);
        }

        if (($imageData = Yii::app()->getRequest()->getPost('ProductImage')) !== null) {
            $imageData = $imageData[$_FILES['ProductImage']['name']['name']];

            $this->_addImage($image, $imageData, $product);
            if ($image->hasErrors()) {
                $data[] = ['error' => $image->getErrors()];
            } else {
                $data[] = [
                    'name' => $image->name,
                    'type' => $_FILES['ProductImage']['type']['name'],
                    'size' => $_FILES['ProductImage']['size']['name'],
                    'url' => $image->getImageUrl(),
                    'thumbnail_url' => $image->getImageUrl(80, 80),
                    'delete_url' => $this->createUrl(
                        '/store/productImageBackend/deleteImage',
                        [
                            'id' => $image->id,
                            'method' => 'uploader'
                        ]
                    ),
                    'delete_type' => 'GET'
                ];
            }

            Yii::app()->ajax->raw($data);
        } else {
            throw new CHttpException(
                404,
                Yii::t('StoreModule.store', 'Page not found!')
            );
        }
    }

    /**
     * Метод добавления одной фотографии:
     *
     * @param ProductImage $image - инстанс изображения
     * @param mixed $imageData - POST-массив данных
     * @param Product $product - инстанс галереи
     *
     * @return void
     *
     */
    private function _addImage(ProductImage $image, array $imageData, Product $product)
    {
        try {
            $transaction = Yii::app()->getDb()->beginTransaction();
            $image->setAttributes($imageData);

            if ($image->save()) {

                $transaction->commit();

                if (Yii::app()->getRequest()->getPost('ajax') === null) {
                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('StoreModule.store', 'Image created')
                    );
                    $this->redirect(['/store/productImageBackend/index', 'id' => $product->id]);
                }
            }
        } catch (Exception $e) {

            $transaction->rollback();

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }
    }

    /**
     * Ajax/Get-обёртка для удаления изображения:
     *
     * @param int $id - id-изображения
     * @param int $product - id-товара
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDeleteImage($id, $product)
    {
        $image = ProductImage::model()->findByPk($id);

        if ($image === null) {
            throw new CHttpException(
                404,
                Yii::t('StoreModule.store', 'Page not found!')
            );
        }

        $message = Yii::t(
            'StoreModule.store',
            'Image #{id} {result} deleted',
            [
                '{id}' => $id,
                '{result}' => ($result = $image->delete())
                    ? Yii::t('StoreModule.store', 'success')
                    : Yii::t('StoreModule.store', 'not')
            ]
        );

        if (Yii::app()->getRequest()->getIsPostRequest() && Yii::app()->getRequest()->getIsAjaxRequest) {
            $result === true
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);
        }

        Yii::app()->getUser()->setFlash(
            $result ? yupe\widgets\YFlashMessages::SUCCESS_MESSAGE : yupe\widgets\YFlashMessages::ERROR_MESSAGE,
            $message
        );

        $this->redirect(['/store/productImageBackend/index', 'id' => $product]);
    }
}