<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 11/8/13
 * Time: 7:09 PM
 * To change this template use File | Settings | File Templates.
 */

class UserManager extends CApplicationComponent
{
    public $hasher;    
    
    public $tokenManager;
    
    public function init()
    {
        $this->setHasher(Yii::createComponent($this->hasher));
        
        $this->setTokenManager(Yii::createComponent($this->tokenManager));
        
        parent::init();
    }
    
    public function setTokenManager(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }    
    
    public function setHasher(Hasher $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function createUser(RegistrationForm $form)
    {
        $transaction = Yii::app()->db->beginTransaction();
        
        try
        {
            $user = new User;            
            $data = $form->getAttributes();
            unset($data['cPassword'], $data['verifyCode']);
            $user->setAttributes($data);
            $user->hash = $this->hasher->hashPassword($form->password);
            
            if($user->save() && $this->tokenManager->createAccountActivationToken($user)) {
                Yii::log(
                    Yii::t('UserModule.user', 'Account {nick_name} was created', array('{nick_name}' => $user->nick_name)),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );
                
                $transaction->commit();
                return $user;
            }
            
            throw new CException(Yii::t('UserModule.user','Error creating account!'));
            
        }
        catch(Exception $e)
        {
            //@TODO __toString
            Yii::log(
                Yii::t('UserModule.user', 'Error {error} account creating!', array('{error}' => $e->__toString())),
                CLogger::LEVEL_INFO, UserModule::$logCategory
            );
            
            CVarDumper::dump($e,10,true);die();
            
            $transaction->rollback();
            return false;
        }
    }
}