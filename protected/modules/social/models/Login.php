<?php
/**
 * This is the model class for table "Login".
 *
 * The followings are the available columns in table 'Login':
 * @property string $id
 * @property string $user_id
 * @property string $identity_id
 * @property string $type
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Login extends YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @return Login the static model class
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
        return '{{social_login}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, identity_id, type', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('identity_id', 'length', 'max' => 100),
            array('type', 'length', 'max' => 50),
            array('id, user_id, identity_id, type, creation_date', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->creation_date = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('Social.social', 'id'),
            'user_id'       => Yii::t('Social.social', 'Пользователь'),
            'identity_id'   => Yii::t('Social.social', 'Идентификатор'),
            'type'          => Yii::t('Social.social', 'Тип'),
            'creation_date' => Yii::t('Social.social', 'Дата создания'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('identity_id', $this->identity_id, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }
}