<?php

/**
 * This is the model class for table "Profile".
 *
 * The followings are the available columns in table 'Profile':
 * @property integer $id
 * @property integer $userId
 * @property string $twitter
 * @property string $livejournal
 * @property string $vkontakte
 * @property string $odnoklassniki
 * @property string $facebook
 * @property string $yandex
 * @property string $google
 * @property string $blog
 * @property string $site
 * @property string $about
 * @property string $location
 * @property string $phone
 */
class Profile extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Profile the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{Profile}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {

        return array(
            array('userId', 'required'),
            array('userId', 'numerical', 'integerOnly' => true),
            array('twitter, livejournal, vkontakte, odnoklassniki, facebook, yandex, google, blog, site, location', 'length', 'max' => 100),
            array('phone', 'length', 'max' => 45),
            array('about', 'length', 'max' => 5000),
            array('twitter, livejournal, vkontakte, odnoklassniki, facebook, yandex, google, blog, site', 'url'),
            array('userId, twitter, livejournal, vkontakte, odnoklassniki, facebook, yandex, google, blog, site, about, location, phone', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'userId' => Yii::t('user', 'Пользователь'),
            'twitter' => Yii::t('user', 'Твиттер'),
            'livejournal' => Yii::t('user', 'LiveJournal'),
            'vkontakte' => Yii::t('user', 'ВКонтакте'),
            'odnoklassniki' => Yii::t('user', 'Одноклассники'),
            'facebook' => Yii::t('user', 'FaceBook'),
            'yandex' => Yii::t('user', 'Яндекс'),
            'google' => Yii::t('user', 'Google'),
            'blog' => Yii::t('user', 'Блог'),
            'site' => Yii::t('user', 'Сайт'),
            'about' => Yii::t('user', 'Обо мне'),
            'location' => Yii::t('user', 'Расположение'),
            'phone' => Yii::t('user', 'Телефон'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('userId', $this->userId);

        $criteria->compare('twitter', $this->twitter, true);

        $criteria->compare('livejournal', $this->livejournal, true);

        $criteria->compare('vkontakte', $this->vkontakte, true);

        $criteria->compare('odnoklassniki', $this->odnoklassniki, true);

        $criteria->compare('facebook', $this->facebook, true);

        $criteria->compare('yandex', $this->yandex, true);

        $criteria->compare('google', $this->google, true);

        $criteria->compare('blog', $this->blog, true);

        $criteria->compare('site', $this->site, true);

        $criteria->compare('about', $this->about, true);

        $criteria->compare('location', $this->location, true);

        $criteria->compare('phone', $this->phone, true);

        return new CActiveDataProvider('Profile', array(
                                                       'criteria' => $criteria,
                                                  ));
    }

}