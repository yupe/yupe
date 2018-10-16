<?php

use yupe\components\ContentType;

/**
 * Class ExportController
 *
 */
class ExportController extends application\components\Controller
{
    public function actionView($id)
    {
        $model = Export::model()->findByPk($id);

        if (false === $model) {
            throw new CHttpException(404);
        }

        $criteria = new CDbCriteria();
        $categoryCriteria = new CDbCriteria();
        $criteria->compare('t.status', Product::STATUS_ACTIVE);

        if (!empty($model->categories)) {
            $criteria->addInCondition('t.category_id', (array)$model->categories);
            $categoryCriteria->addInCondition('t.id', (array)$model->categories);
        }

        if (!empty($model->brands)) {
            $criteria->addInCondition('t.producer_id', (array)$model->brands);
        }

        $dataProvider = new CActiveDataProvider('Product', ['criteria' => $criteria]);

        $offers = new CDataProviderIterator($dataProvider, 100);

        ContentType::setHeader(ContentType::TYPE_XML);

        $this->renderPartial(
            'view',
            [
                'model' => $model,
                'currencies' => Yii::app()->getModule('store')->getCurrencyList(),
                'categories' => StoreCategory::model()->published()->findAll($categoryCriteria),
                'offers' => $offers,
            ]
        );
    }

    /**
     * @return string
     */
    public function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'.PHP_EOL;
    }
}
