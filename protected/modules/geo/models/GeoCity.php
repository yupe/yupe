<?php

/**
 * This is the model class for table "{{GeoCity}}".
 *
 * The followings are the available columns in table '{{GeoProfile}}':
 * @property integer $id
 * @property integer $geo_country_id
 * @property string $name
 * @property string $state
 */
class GeoCity extends YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{geo_city}}';
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
            //@formatter:off
            //@formatter:on
        );
    }

    public function relations()
    {
        return array(
            'country' => array(self::BELONGS_TO, 'GeoCountry', 'geo_country_id'),
        );
    }



    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('geo', 'Id'),
            'geo_country_id' => Yii::t('geo', 'Страна'),
            'name' => Yii::t('geo', 'Город'),
            'state' => Yii::t('geo', 'Область'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('geo_country_id', $this->geo_country_id, false);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider('GeoCity', array('criteria' => $criteria));
    }

    public function getCombinedName()
    {
        return $this->country->name.", ".$this->name." (".$this->state.")";
    }
}
