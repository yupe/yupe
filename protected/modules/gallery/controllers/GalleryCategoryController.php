<?php

use yupe\components\controllers\FrontController;

class GalleryCategoryController extends FrontController
{
    public function actionIndex()
    {
        $categoryId = $this->getModule()->mainCategory;

        $this->render('index', [
            'categories' => Yii::app()->getComponent('categoriesRepository')->getDescendants($categoryId),
        ]);
    }

    public function actionView($slug = null)
    {
        $category = Yii::app()->getComponent('categoriesRepository')->getByAlias($slug);

        if (is_null($category)) {
            throw new CHttpException(404, Yii::t('GalleryModule.gallery', 'Requested page was not found.'));
        }

        $dataProvider = new CActiveDataProvider(
            'Gallery', [
                'criteria' => [
                    'condition' => 'category_id = :category_id',
                    'scopes' => 'published',
                    'params' => [
                        ':category_id' => $category->id,
                    ],
                ],
                'sort' => [
                    'defaultOrder' => 'id DESC',
                ],
            ]
        );

        $this->render('view', [
            'dataProvider' => $dataProvider,
            'category' => $category,
        ]);
    }
}