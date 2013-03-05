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
        return '{{geo_city}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array();
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
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
            'id'             => Yii::t('GeoModule.geo', 'Id'),
            'geo_country_id' => Yii::t('GeoModule.geo', 'Страна'),
            'name'           => Yii::t('GeoModule.geo', 'Город'),
            'state'          => Yii::t('GeoModule.geo', 'Область'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('geo_country_id', $this->geo_country_id, false);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getCombinedName()
    {
        return $this->country->name . ", " . $this->name . " (" . $this->state . ")";
    }
}