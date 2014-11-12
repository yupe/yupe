<?php
/**
 * MetrikaController контроллер для учета переходов в публичной части сайта
 *
 * @author apexwire <apexwire@amylabs.ru>
 * @link http://yupe.ru
 * @copyright 2009-2014 amyLabs && Yupe! team
 * @package yupe.modules.metrika.controllers
 * @since 0.1
 *
 */
class MetrikaController extends yupe\components\controllers\FrontController
{
    public function actionIndex()
    {
        if ( !Yii::app()->getRequest()->getIsAjaxRequest() ) {
            throw new CHttpException('404', Yii::t('MetrikaModule.metrika', 'Page was not found'));
        }

        $referrer = explode('?',Yii::app()->getRequest()->urlReferrer);
        $transaction = Yii::app()->db->beginTransaction();

        try {

            $modelUrl = MetrikaUrl::model()->findByAttributes(array('url' => $referrer[0]));

            if ( $modelUrl === null ) {
                $modelUrl = new MetrikaUrl();
                $modelUrl->setAttributes(array(
                    'url' => $referrer[0],
                ));
            }else {
                $modelUrl->views++;
            }

            $modelUrl->save();

            $modelTransitions = new MetrikaTransitions();
            $modelTransitions->setAttributes(array(
                'url_id' => $modelUrl->id,
                'params_get' => isset($referrer[1]) ? $referrer[1] : ''
            ));
            $modelTransitions->save();

            $transaction->commit();

        } catch(Exception $e) {
            $transaction->rollback();
        }
    }
}