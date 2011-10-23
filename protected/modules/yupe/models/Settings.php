<?php

/**
 * This is the model class for table "Settings".
 *
 * The followings are the available columns in table 'Settings':
 * @property string $id
 * @property string $module_id
 * @property string $param_name
 * @property string $param_value
 * @property string $creation_date
 * @property string $change_date
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Settings extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Settings the static model class
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
        return '{{settings}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('module_id, param_name', 'required'),
            array('module_id, param_name, param_value', 'length', 'max' => 150),
            array('user_id', 'numerical', 'integerOnly' => true),
            //array('module_id','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            //array('param_name, param_value','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            array('id, module_id, param_name, param_value, creation_date, change_date, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)        
            $this->creation_date = $this->change_date = new CDbExpression('NOW()');                                        
        else        
            $this->change_date = new CDbExpression('NOW()');
                
        $this->user_id = Yii::app()->user->getId();

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
            'id' => 'ID',
            'module_id' => 'Module',
            'param_name' => 'Param Name',
            'param_value' => 'Param Value',
            'creation_date' => 'Creation Date',
            'change_date' => 'Change Date',
            'user_id' => 'User',
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
        $criteria->compare('module_id', $this->module_id, true);
        $criteria->compare('param_name', $this->param_name, true);
        $criteria->compare('param_value', $this->param_value, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('user_id', $this->user_id, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }
}