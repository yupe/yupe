<?php
class PeopleController extends YFrontController
{
    // Вывод публичной страницы всех пользователей
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

    // Вывод публичной страницы пользователя
    public function actionUserInfo($username, $mode=null)
    {
        $user = User::model()->findByAttributes(array("nick_name" => $username));

    	if (!$user)
			throw new CHttpException(404, Yii::t('user', 'Пользователь не найден!'));

    	$this->render('userInfo', array(
    	   'user' => $user,
    	   'mode' => $mode
        ));
    }

    public function actionProfile()
    {
        if(!Yii::app()->user->isAuthenticated())
        {
            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE,Yii::t('user','Пожалуйста, авторизуйтесь!'));

            $this->redirect(array('/user/account/login/'));
        }

        $user = User::model()->findByPk(Yii::app()->user->getId());

        if(!$user)
            throw new CHttpException(404, Yii::t('user', 'Пользователь не найден!'));

        if(Yii::app()->request->isPostRequest && !empty($_POST['User']))
        {
            $user->setAttributes(Yii::app()->request->getPost('User'));

            if($user->save())
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE,Yii::t('user','Профиль изменен!'));

                $this->redirect(array('/user/people/profile/'));
            }
        }

        $this->render('profile',array('model' => $user));
    }
}