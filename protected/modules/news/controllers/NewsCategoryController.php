<?php

use yupe\components\controllers\FrontController;

/**
 * Class NewsCategoryController
 */
class NewsCategoryController extends FrontController
{
    /**
     *
     */
    public function actionIndex()
    {
        $categoryId = $this->getModule()->mainCategory;

        $this->render('index', [
            'categories' => Yii::app()->getComponent('categoriesRepository')->getDescendants($categoryId),
        ]);
    }

    /**
     * @param $slug
     * @throws CHttpException
     */
    public function actionView($slug)
    {
        $category = Yii::app()->getComponent('categoriesRepository')->getByAlias($slug);

        if (null === $category) {
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
                        ':is_protected' => News::PROTECTED_NO,
                    ],
                ]
            );
        }

        if ($this->isMultilang()) {
            $dbCriteria->mergeWith(
                [
                    'condition' => 't.lang = :lang',
                    'params' => [':lang' => Yii::app()->getLanguage()],
                ]
            );
        }

        $dataProvider = new CActiveDataProvider('News', [
            'criteria' => $dbCriteria,
            'pagination' => [
                'pageSize' => $this->getModule()->perPage,
            ],
        ]);

        $this->render('view', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }
}