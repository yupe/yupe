<?php
class PeopleController extends YFrontController
{
    // показать всех пользователей
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User', array(
                                                             'criteria' => array(
                                                                 'condition' => 'status = :status',
                                                                 'params' => array(':status' => User::STATUS_ACTIVE),
                                                                 'order' => 'last_visit DESC'
                                                             )
                                                        ));

        $this->render('index', array(
                                    'dataProvider' => $dataProvider
                               ));
    }

    // Публичная страница пользователя
    public function actionUserInfo($username=null, $mode=null)
    {

    	if ( !($user = $username?User::model()->findByAttributes(array("nick_name"=> $username)):Yii::app()->user) )
			throw new CHttpException(404, Yii::t('people','Пользователь не найден'));

    	$this->render('userInfo', array( 'user'=> $user, 'mode' => $mode));
    }
}