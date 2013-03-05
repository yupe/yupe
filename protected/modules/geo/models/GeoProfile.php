<?php

/**
 * This is the model class for table "{{GeoProfile}}".
 *
 * The followings are the available columns in table '{{GeoProfile}}':
 * @property integer $user_id
 * @property integer $geo_city_id
 */
class GeoProfile extends YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return User the static model class
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
        return '{{geo_profile}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, geo_city_id', 'required'),
            array('user_id, geo_city_id', 'numerical', 'integerOnly' => true),
            array('geo_city_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'GeoCity'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'city' => array(self::BELONGS_TO, 'GeoCity', 'geo_city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id'     => Yii::t('GeoModule.geo', 'Пользователь'),
            'geo_city_id' => Yii::t('GeoModule.geo', 'Город'),
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

        $criteria->compare('user_id', $this->id, true);
        $criteria->compare('geo_city_id', $this->geo_city_id, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }
}