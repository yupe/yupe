<?php
/**
 * Форма профиля
 *
 * @category YupeComponents
 * @package  yupe.modules.user.forms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class ProfileForm extends CFormModel
{
    public $nick_name;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $email;
    public $password;
    public $cPassword;
    public $verifyCode;
    public $about;
    public $gender;
    public $birth_date;
    public $use_gravatar;
    public $avatar;
    public $site;
    public $location;

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return array(
            array('nick_name, email, first_name, last_name, middle_name, about', 'filter', 'filter' => 'trim'),
            array('nick_name, email, first_name, last_name, middle_name, about', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('nick_name, email', 'required'),
            array('gender', 'numerical', 'min' => 0, 'max' => 3, 'integerOnly' => true),
            array('gender', 'default', 'value' => 0),
            array('birth_date', 'default', 'value' => null),
            array('nick_name, email, first_name, last_name, middle_name', 'length', 'max' => 50),
            array('about', 'length', 'max' => 300),
            array('location', 'length', 'max' => 150),            
            array('password, cPassword', 'length', 'min' => $module->minPasswordLength),
            array('nick_name', 'match', 'pattern' => '/^[A-Za-z0-9]{2,50}$/', 'message' => Yii::t('UserModule.user','Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols')),
            array('nick_name', 'checkNickName'),
            array('cPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('UserModule.user', 'Password is not coincide')),
            array('email', 'email'),
            array('email', 'checkEmail'),
            array('site', 'url', 'allowEmpty' => true),
            array('site', 'length', 'max' => 100),
            array('use_gravatar', 'in', 'range' => array(0, 1)),
            array('avatar', 'file', 'types' => implode(',', $module->avatarExtensions), 'maxSize' => $module->avatarMaxSize, 'allowEmpty' => true),
        );
    }

    public function attributeLabels()
    {
        return array(
            'first_name'  => Yii::t('UserModule.user', 'Name'),
            'last_name'   => Yii::t('UserModule.user', 'Last name'),
            'middle_name' => Yii::t('UserModule.user', 'Family name'),
            'nick_name'   => Yii::t('UserModule.user', 'User name'),
            'email'       => Yii::t('UserModule.user', 'Email'),
            'password'    => Yii::t('UserModule.user', 'New password'),
            'cPassword'   => Yii::t('UserModule.user', 'Password confirmation'),
            'gender'      => Yii::t('UserModule.user', 'Sex'),
            'birth_date'  => Yii::t('UserModule.user', 'Birthday date'),
            'about'       => Yii::t('UserModule.user', 'About yourself'),
            'avatar'      => Yii::t('UserModule.user', 'Avatar'),
            'use_gravatar'=> Yii::t('UserModule.user', 'Gravatar'),
            'site'        => Yii::t('UserModule.user', 'Site'),
            'location'    => Yii::t('UserModule.user', 'Location'),
        );
    }

    public function checkNickName($attribute,$params)
    {
        // Если ник поменяли
        if (Yii::app()->user->profile->nick_name != $this->$attribute)
        {
            $model = User::model()->find('nick_name = :nick_name', array(':nick_name' => $this->$attribute));
            if ($model){
                 $this->addError('nick_name', Yii::t('UserModule.user', 'Nick in use'));
            }
        }
    }

    public function checkEmail($attribute,$params)
    {
        // Если мыло поменяли
        if (Yii::app()->user->profile->email != $this->$attribute)
        {
            $model = User::model()->find('email = :email', array(':email' => $this->$attribute));
            if ($model){
                $this->addError('email', Yii::t('UserModule.user', 'Email already busy'));
            }
        }
    }
}