<?php

class DefaultController extends \yupe\components\controllers\FrontController
{
	/**
	 * @var FavoriteService
	 *
	 */

	protected $favorite;

	/**
	 * @var ProductRepository
	 */
	protected $productRepository;


	public function init()
	{
		$this->favorite = Yii::app()->getComponent('favorite');

		$this->productRepository = Yii::app()->getComponent('productRepository');

		parent::init();
	}

    public function actionAdd()
	{
        if(!Yii::app()->getRequest()->getIsPostRequest()){
			throw new CHttpException(404);
		}

		$productId = (int)Yii::app()->getRequest()->getPost('id');

		if(!$productId) {
			throw new CHttpException(404);
		}

		$product = $this->productRepository->getById($productId);

		if(null === $product) {
			throw new CHttpException(404);
		}

		if($this->favorite->add($product)) {
            Yii::app()->ajax->success(Yii::t('FavoriteModule.favorite', 'Success added!'));
		}

		Yii::app()->ajax->failure(Yii::t('FavoriteModule.favorite', 'Error added!'));
	}
}