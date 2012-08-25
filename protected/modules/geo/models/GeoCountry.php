<?php

/**
 * This is the model class for table "{{GeoCountry}}".
 *
 * The followings are the available columns in table '{{GeoProfile}}':
 * @property integer $id
 * @property string $name
 */
class GeoCountry extends CActiveRecord
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{geo_country}}';
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
            'cities' => array(self::HAS_MANY, 'GeoCity', 'geo_country_id'),
        );
    }



    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('geo', 'Id'),
            'name' => Yii::t('geo', 'Страна'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider('GeoCountry', array('criteria' => $criteria));
    }

}
