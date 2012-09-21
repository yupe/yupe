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
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{geo_profile}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id, geo_city_id', 'required'),
            array('user_id, geo_city_id', 'numerical', 'integerOnly' => true),
            array('geo_city_id', 'exist', 'allowEmpty' => true, 'attributeName' => 'id', 'className' => 'GeoCity'),
        );
    }

    public function relations()
    {
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
            'user_id'     => Yii::t('geo', 'Пользователь'),
            'geo_city_id' => Yii::t('geo', 'Город'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->id, true);
        $criteria->compare('geo_city_id', $this->geo_city_id, true);

        return new CActiveDataProvider('GeoProfile', array('criteria' => $criteria));
    }
}