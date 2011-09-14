<?php
class ContestController extends YFrontController
{
    const CONTEST_PER_PAGE = 10;

    public function actionList()
    {
        $dataProvider = new CActiveDataProvider('Contest');

        $this->render('list', array('dataProvider' => $dataProvider));
    }

    public function actionShow($id)
    {
        $model = Contest::model()->findByPk((int)$id);

        if (is_null($model)) {
            throw new CHttpException(404, Yii::t('contest', 'Страница не найдена!'));
        }

        $image = new Image();

        if (Yii::app()->request->isPostRequest && isset($_POST['Image'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                $image = $image->create($_POST['Image']);

                if (!$image->hasErrors()) {
                    if ($model->addImage($image)) {
                        Yii::app()->user->setFlash(FlashMessagesWidget::NOTICE_MESSAGE, Yii::t('contest', 'Фотография добавлена!'));
                    }

                    $transaction->commit();

                    $this->redirect(array('/contest/contest/show/', 'id' => $model->id));
                }

                throw new CDbException(Yii::t('contest', 'При добавлении изображения произошла ошибка!'));
            }
            catch (Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(FlashMessagesWidget::ERROR_MESSAGE, Yii::t('contest', $e->getMessage()));
            }
        }

        $dataProvider = new CActiveDataProvider('ImageToContest', array(
                                                                       'criteria' => array(
                                                                           'condition' => 'contestId = :contestId',
                                                                           'params' => array(':contestId' => $model->id),
                                                                           'limit' => self::CONTEST_PER_PAGE,
                                                                           'order' => 't.creationDate DESC',
                                                                           'with' => 'image'
                                                                       ),
                                                                       'pagination' => array(
                                                                           'pageSize' => self::CONTEST_PER_PAGE,
                                                                       )
                                                                  ));

        $this->render('show', array('image' => $image, 'dataProvider' => $dataProvider, 'model' => $model));
    }

    public function actionFoto($id)
    {
        $model = Image::model()->findByPk((int)$id);

        if (is_null($model)) {
            throw new CHttpException(404, Yii::t('gallery', 'Страница не найдена!'));
        }

        $this->render('foto', array('model' => $model));
    }
}

?>