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
    public $verifyCode;
    public $about;
    public $gender;
    public $birth_date;
    public $use_gravatar;
    public $avatar;
    public $site;
    public $location;
    public $phone;

    public function rules()
    {
        $module = Yii::app()->getModule('user');

        return [
            ['nick_name, first_name, last_name, middle_name, about', 'filter', 'filter' => 'trim'],
            [
                'nick_name, first_name, last_name, middle_name, about',
                'filter',
                'filter' => [$obj = new CHtmlPurifier(), 'purify']
            ],
            ['nick_name', 'required'],
            ['gender', 'numerical', 'min' => 0, 'max' => 3, 'integerOnly' => true],
            ['gender', 'default', 'value' => 0],
            ['birth_date', 'default', 'value' => null],
            ['birth_date', 'date', 'format' => 'yyyy-mm-dd'],
            ['nick_name, first_name, last_name, middle_name', 'length', 'max' => 50],
            ['about', 'length', 'max' => 300],
            ['location', 'length', 'max' => 150],
            [
                'nick_name',
                'match',
                'pattern' => '/^[A-Za-z0-9_-]{2,50}$/',
                'message' => Yii::t(
                    'UserModule.user',
                    'Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols'
                )
            ],
            ['nick_name', 'checkNickName'],
            ['site', 'url', 'allowEmpty' => true],
            ['site', 'length', 'max' => 100],
            ['use_gravatar', 'in', 'range' => [0, 1]],
            [
                'avatar',
                'file',
                'types' => $module->avatarExtensions,
                'maxSize' => $module->avatarMaxSize,
                'allowEmpty' => true
            ],
            [
                'phone',
                'match',
                'pattern' => $module->phonePattern,
                'message' => 'Некорректный формат поля {attribute}'
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('UserModule.user', 'Name'),
            'last_name' => Yii::t('UserModule.user', 'Last name'),
            'middle_name' => Yii::t('UserModule.user', 'Family name'),
            'nick_name' => Yii::t('UserModule.user', 'User name'),
            'gender' => Yii::t('UserModule.user', 'Sex'),
            'birth_date' => Yii::t('UserModule.user', 'Birthday date'),
            'about' => Yii::t('UserModule.user', 'About yourself'),
            'avatar' => Yii::t('UserModule.user', 'Avatar'),
            'use_gravatar' => Yii::t('UserModule.user', 'Gravatar'),
            'site' => Yii::t('UserModule.user', 'Site'),
            'location' => Yii::t('UserModule.user', 'Location'),
            'phone' => Yii::t('UserModule.user', 'Phone'),
        ];
    }

    public function checkNickName($attribute, $params)
    {
        // Если ник поменяли
        if (Yii::app()->user->profile->nick_name != $this->$attribute) {
            $model = User::model()->find('nick_name = :nick_name', [':nick_name' => $this->$attribute]);
            if ($model) {
                $this->addError('nick_name', Yii::t('UserModule.user', 'Nick in use'));
            }
        }
    }
}
