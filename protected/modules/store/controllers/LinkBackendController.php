<?php

class LinkBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['delete', 'index', 'link', 'inline', 'typeIndex', 'typeCreate', 'typeDelete', 'typeInline'], 'roles' => ['Store.ProductBackend.Update']],
            ['deny'],
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'ProductLink',
                'validAttributes' => ['type_id']
            ],
            'typeInline' => [
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'ProductLinkType',
                'validAttributes' => ['code', 'title']
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ProductSearch('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->getRequest()->getParam('ProductSearch');
        $this->render('/productBackend/_link_form', ['searchModel' => $model, 'product' => new Product()]);
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id)->delete();
        } else {
            throw new CHttpException(400, Yii::t('StoreModule.store', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    public function actionLink()
    {
        $r = Yii::app()->getRequest();
        if ($r->isPostRequest) {
            $product_id = $r->getParam('product_id');
            $linked_product_id = $r->getParam('linked_product_id');
            $type_id = $r->getParam('type_id');

            $product = Product::model()->findByPk($product_id);
            $linkedProduct = Product::model()->findByPk($linked_product_id);
            if ($product && $linkedProduct && $product->id != $linkedProduct->id) {
                Yii::app()->ajax->raw(['result' => $product->link($linkedProduct, $type_id)]);
            }
        }
    }

    public function actionTypeIndex()
    {
        $model = new ProductLinkType('search');
        $model->unsetAttributes();
        $model->attributes = Yii::app()->getRequest()->getParam('ProductLinkType');
        $this->render('index_type', ['model' => $model]);
    }

    public function actionTypeCreate()
    {
        $model = new ProductLinkType();
        if (($data = Yii::app()->getRequest()->getPost('ProductLinkType')) !== null) {
            $model->setAttributes($data);
            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('StoreModule.store', 'Record was created!')
                );

                $this->redirect((array)Yii::app()->getRequest()->getPost('submit-type', ['typeIndex']));
            }
        }
        $this->render('index_type', ['model' => $model]);
    }

    public function actionTypeDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $model = ProductLinkType::model()->findByPk($id);
            if ($model) {
                $model->delete();
            }
        } else {
            throw new CHttpException(400, Yii::t('StoreModule.store', 'Unknown request. Don\'t repeat it please!'));
        }
    }

    /**
     * @param $id
     * @return ProductLink
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = ProductLink::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('StoreModule.store', 'Page not found!'));
        }

        return $model;
    }

}
