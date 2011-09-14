<?php
class VoteController extends YFrontController
{
    public function actionAddVote()
    {
        if (Yii::app()->request->isPostRequest && Yii::app()->request->isAjaxRequest) {
            $modelType = Yii::app()->request->getPost('modelType');

            $modelId = (int)Yii::app()->request->getPost('modelId');

            $value = (int)Yii::app()->request->getPost('value');

            if (!$modelId || !$value || !$modelType) {
                Yii::app()->ajax->failure(Yii::t('contest', 'Произошла ошибка!'));
            }

            $model = new Vote;

            $model->setAttributes(array(
                                       'model' => $modelType,
                                       'modelId' => $modelId,
                                       'value' => $value
                                  ));

            if ($model->save()) {
                Yii::app()->ajax->success();
            }

            Yii::app()->ajax->failure(Yii::t('vote', 'Произошла ошибка!'));
        }

        throw new CHttpException(404, Yii::t('vote', 'Страница не найдена!'));
    }
}

?>