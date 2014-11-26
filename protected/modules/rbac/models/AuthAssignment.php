<?php

/**
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * @property AuthItem $item
 *
 * The followings are the available model relations:
 *
 */
class AuthAssignment extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return AuthAssignment the static model class
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
        return '{{user_user_auth_assignment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['itemname, userid', 'required'],
            ['itemname, userid', 'length', 'max' => 64],
            ['bizrule, data', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['itemname, userid, bizrule, data', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'item' => [self::BELONGS_TO, 'AuthItem', 'itemname'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'itemname' => 'Itemname',
            'userid'   => 'Userid',
            'bizrule'  => 'Bizrule',
            'data'     => 'Data',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('itemname', $this->itemname);
        $criteria->compare('userid', $this->userid);
        $criteria->compare('bizrule', $this->bizrule);
        $criteria->compare('data', $this->data);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }
}
