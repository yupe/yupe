<?php

/**
 * CatalogController контроллер для вывода каталога товаров в публичной части сайта
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog.controllers
 * @since 0.1
 *
 */
class CatalogController extends \yupe\components\controllers\FrontController
{
    const GOOD_PER_PAGE = 10;

    public function actionShow($name)
    {
        $model = Good::model()->published()->findByAttributes(['slug' => $name]);

        if (!$model) {
            throw new CHttpException(404, Yii::t('CatalogModule.catalog', 'Product was not found!'));
        }

        $this->render('show', ['model' => $model]);
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider(Good::model()->published(), [
            'criteria' => new CDbCriteria([
                'limit' => self::GOOD_PER_PAGE,
                'order' => 't.create_time DESC',
            ]),
        ]);

        $this->render('index', ['dataProvider' => $dataProvider]);
    }
}
