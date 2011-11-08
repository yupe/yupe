<?php
class VoteController extends YFrontController
{
    public function actionAddVote()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest)
        {
            $modelType = Yii::app()->request->getPost('modelType');

            $model_id = (int)Yii::app()->request->getPost('model_id');

            $value = (int)Yii::app()->request->getPost('value');

            if (!$model_id || !$value || !$modelType)            
                Yii::app()->ajax->failure(Yii::t('contest', 'Произошла ошибка!'));            

            $model = new Vote;

            $model->setAttributes(array(
                                       'model' => $modelType,
                                       'model_id' => $model_id,
                                       'value' => $value
                                  ));

            if ($model->save())
                Yii::app()->ajax->success();            

            Yii::app()->ajax->failure(Yii::t('vote', 'Произошла ошибка!'));
        }

        throw new CHttpException(404, Yii::t('vote', 'Страница не найдена!'));
    }
}