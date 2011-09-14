<?php

/**
 * This is the model class for table "Settings".
 *
 * The followings are the available columns in table 'Settings':
 * @property string $id
 * @property string $moduleId
 * @property string $paramName
 * @property string $paramValue
 * @property string $creationDate
 * @property string $changeDate
 * @property string $userId
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
        return '{{Settings}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('moduleId, paramName, paramValue', 'required'),
            array('moduleId, paramName, paramValue', 'length', 'max' => 150),
            array('userId', 'numerical', 'integerOnly' => true),
            //array('moduleId','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            //array('paramName, paramValue','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            array('id, moduleId, paramName, paramValue, creationDate, changeDate, userId', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->changeDate = $this->changeDate = new CDbExpression('NOW()');

                if (!$this->userId)
                {
                    $this->userId = Yii::app()->user->getId();
                }
            }
            else
            {
                $this->changeDate = new CDbExpression('NOW()');
            }

            return true;
        }

        return false;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'moduleId' => 'Module',
            'paramName' => 'Param Name',
            'paramValue' => 'Param Value',
            'creationDate' => 'Creation Date',
            'changeDate' => 'Change Date',
            'userId' => 'User',
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
        $criteria->compare('moduleId', $this->moduleId, true);
        $criteria->compare('paramName', $this->paramName, true);
        $criteria->compare('paramValue', $this->paramValue, true);
        $criteria->compare('creationDate', $this->creationDate, true);
        $criteria->compare('changeDate', $this->changeDate, true);
        $criteria->compare('userId', $this->userId, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }
}