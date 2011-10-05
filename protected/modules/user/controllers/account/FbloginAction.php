<?php
class FbloginAction extends CAction
{
    private $type = 'facebook';

    public function run()
    {
        Yii::import('application.modules.user.extensions.FaceBook.*');

        $facebook = new Facebook(array(
                                      'appId' => Yii::app()->params['fbAppId'],
                                      'secret' => Yii::app()->params['fbAppSecret'],
                                      'cookie' => true,
                                 ));

        $session = $facebook->getSession();

        $myAccount = null;

        if ($session)
        {
            try
            {
                $uid = $facebook->getUser();

                $myAccount = $facebook->api('/me');

                $nickName = $myAccount['name'];

                if ($myAccount['username'])
                {
                    $nickName = $myAccount['username'];
                }

                $fbAuthData = array(
                    'id' => $myAccount['id'],
                    'firstName' => $myAccount['first_name'],
                    'lastName' => $myAccount['last_name'],
                    'nickName' => $nickName,
                    'email' => $myAccount['email']
                );

                //var_dump($myAccount);die();
                Yii::log(print_r($myAccount, true), CLogger::LEVEL_ERROR);

                /**
                 *  Все что ниже этого комментария должно быть общим для авторизации через все социальные сервисы
                 *
                 */


                // проверить наличие такого uid в базе
                $login = Login::model()->find('type = :type AND identityId = :identityId', array(
                                                                                                ':type' => $this->type,
                                                                                                ':identityId' => $fbAuthData['id']
                                                                                           ));

                // если такое uid уже есть - авторизуем пользователя и все
                if (!is_null($login))
                {
                    $identity = new SocialLoginIdentity($this->type, $fbAuthData['id']);

                    if ($identity->authenticate())
                    {
                        Yii::app()->user->login($identity);

                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы авторизовались!'));

                        $this->controller->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                    }
                    else
                    {
                        Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При авторизации произошла ошибка!'));

                        $this->controller->redirect(array('/'));
                    }
                }

                // проверить пользователья по email, если такой email есть - привязать этот аккаунт FaceBook к нему

                $user = User::model()->active()->find('email = :email', array(':email' => $fbAuthData['email']));

                if (!is_null($user))
                {
                    $login = new Login();

                    $login->setAttributes(array(
                                               'user_id' => $user->id,
                                               'identityId' => $fbAuthData['id'],
                                               'type' => $this->type
                                          ));

                    if ($login->save())
                    {
                        $identity = new SocialLoginIdentity($this->type, $fbAuthData['id']);

                        if ($identity->authenticate())
                        {
                            Yii::app()->user->login($identity);

                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы авторизовались!'));

                            $this->controller->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При авторизации произошла ошибка!!!' . print_r($login->getErrors(), true)));

                        $this->controller->redirect(array('/'));
                    }
                }


                // если email нет - создадим новый аккаунт и привяжем uid  к нему

                $myAccount['gender'] = $myAccount['gender'] == 'male'
                    ? User::GENDER_MALE : User::GENDER_FEMALE;

                $params = array(
                    'firstName' => $myAccount['first_name'],
                    'lastName' => $myAccount['last_name'],
                    'gender' => $myAccount['gender']
                );

                $userLogin = User::model()->createSocialAccount($fbAuthData['nickName'], $fbAuthData['email'], $fbAuthData['firstName'], $fbAuthData['firstName'], $fbAuthData['id'], $this->type, $params);

                if (is_object($userLogin) && !$userLogin->hasErrors())
                {
                    $identity = new SocialLoginIdentity($this->type, $fbAuthData['id']);

                    if ($identity->authenticate())
                    {
                        Yii::app()->user->login($identity);

                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('user', 'Вы авторизовались!'));

                        $this->controller->redirect(array(Yii::app()->getModule('user')->loginSuccess));
                    }
                }
                else
                {
                    Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При авторизации произошла ошибка!'));

                    $this->controller->redirect(array('/'));
                }

            }
            catch (Exception $e)
            {
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('user', 'При авторизации произошла ошибка!'));

                $this->controller->redirect(array('/'));
            }
        }
        else
        {
            $this->controller->redirect(array(Yii::app()->getModule('user')->loginSuccess));
        }
    }
}

?>