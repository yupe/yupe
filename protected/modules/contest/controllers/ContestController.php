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

        if (!$model)        
            throw new CHttpException(404, Yii::t('contest', 'Страница не найдена!'));        

        $image = new Image;

        if (Yii::app()->request->isPostRequest && isset($_POST['Image']))
        {
            $transaction = Yii::app()->db->beginTransaction();

            try
            {                
                if ($image->create($_POST['Image']))
                {
                    if ($model->addImage($image))                    
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('contest', 'Фотография добавлена!'));                    

                    $transaction->commit();

                    $this->redirect(array('/contest/contest/show/', 'id' => $model->id));
                }

                throw new CDbException(Yii::t('contest', 'При добавлении изображения произошла ошибка!'));
            }
            catch (Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('contest', $e->getMessage()));
            }
        }

        $dataProvider = new CActiveDataProvider('ImageToContest', array(
                                                                       'criteria' => array(
                                                                           'condition' => 'contest_id = :contest_id',
                                                                           'params' => array(':contest_id' => $model->id),
                                                                           'limit' => self::CONTEST_PER_PAGE,
                                                                           'order' => 't.creation_date DESC',
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

        if (!$model)        
            throw new CHttpException(404, Yii::t('gallery', 'Страница не найдена!'));        

        $this->render('foto', array('model' => $model));
    }
}