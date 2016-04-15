<?php

/**
 * This is the model class for table "{{social_user}}".
 *
 * The followings are the available columns in table '{{social_user}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $provider
 * @property string $uid
 *
 * The followings are the available model relations:
 * @property User $user
 */
namespace application\modules\social\models;

use yupe\models\YModel;
use CDbCriteria;
use CActiveDataProvider;
use Yii;

class SocialUser extends YModel
{
    public $username;
    public $email;

    /**
     * @inheritdoc
     */
    public function tableName()
    {
        return '{{social_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['user_id, provider, uid', 'required'],
            ['user_id', 'numerical', 'integerOnly' => true],
            ['provider, uid', 'length', 'max' => 250],
            ['id, user_id, provider, uid', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'user_id'  => Yii::t('SocialModule.social', 'User'),
            'provider' => Yii::t('SocialModule.social', 'Service'),
            'uid'      => Yii::t('SocialModule.social', 'Uuid'),
            'username' => Yii::t('SocialModule.social', 'User name'),
            'email'    => Yii::t('SocialModule.social', 'Email')
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     *                             based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('provider', $this->provider, true);
        $criteria->compare('uid', $this->uid, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
