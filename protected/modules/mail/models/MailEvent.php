<?php

/**
 * This is the model class for table "mail_event".
 *
 * The followings are the available columns in table 'mail_event':
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property MailTemplate[] $mailTemplates
 */
class MailEvent extends YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailEvent the static model class
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
        return '{{mail_event}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array( 'name, code, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array( 'code, name', 'required' ),
            array( 'code', 'length', 'max' => 100 ),
            array( 'name', 'length', 'max' => 300 ),
            array( 'description', 'safe' ),
            array( 'code', 'unique' ),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array( 'id, code, name, description', 'safe', 'on' => 'search' ),
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
            'templates' => array( self::HAS_MANY, 'MailTemplate', 'event_id' ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('mail', 'ID'),
            'code'        => Yii::t('mail', 'Символьный код'),
            'name'        => Yii::t('mail', 'Название'),
            'description' => Yii::t('mail', 'Описание'),
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}