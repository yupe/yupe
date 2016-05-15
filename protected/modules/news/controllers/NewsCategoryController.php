<?php

use yupe\components\controllers\FrontController;

class NewsCategoryController extends FrontController
{
    public function actionIndex()
    {
        $categoryId = $this->getModule()->mainCategory;

        $this->render('index', [
            'categories' => Category::model()->getDescendants($categoryId),
        ]);
    }

    public function actionView($slug)
    {
        $category = Category::model()->getByAlias($slug);

        if (is_null($category)) {
            throw new CHttpException(404, Yii::t('NewsModule.news', 'Requested page was not found!'));
        }

        $dbCriteria = new CDbCriteria([
            'condition' => 't.status = :status AND t.category_id = :category_id',
            'params' => [
                ':status' => News::STATUS_PUBLISHED,
                ':category_id' => $category->id,
            ],
            'order' => 't.date DESC',
        ]);

        if (!Yii::app()->getUser()->isAuthenticated()) {
            $dbCriteria->mergeWith(
                [
                    'condition' => 'is_protected = :is_protected',
                    'params' => [
                        ':is_protected' => News::PROTECTED_NO
                    ]
                ]
            );
        }

        if ($this->isMultilang()) {
            $dbCriteria->mergeWith(
                [
                    'condition' => 't.lang = :lang',
                    'params' => [':lang' => Yii::app()->language],
                ]
            );
        }

        $dataProvider = new CActiveDataProvider('News', [
            'criteria' => $dbCriteria,
            'pagination' => [
                'pageSize' => $this->getModule()->perPage
            ]
        ]);

        $this->render('view', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }
}