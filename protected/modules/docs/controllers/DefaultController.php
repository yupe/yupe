<?php
/**
 * Класс для отображения файлов документации:
 *
 * @category YupeController
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class DefaultController extends YBackController
{
    /**
     * Экшен главной страницы:
     *
     * @return void
     **/
    public function actionIndex()
    {
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('application.modules.docs.views.assets') . '/css/docs.css'
            )
        );
        $this->render('index');
    }
}