<?php

/**
 * This is the model class for table "Vote".
 *
 * The followings are the available columns in table 'Vote':
 * @property string $id
 * @property string $model
 * @property string $modelId
 * @property string $userId
 * @property string $creationDate
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Vote extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Vote the static model class
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
        return 'Vote';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model, modelId, value', 'required'),
            array('userId, value', 'numerical', 'integerOnly' => true),
            array('modelId, userId', 'length', 'max' => 10),
            array('model', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model, modelId, userId, creationDate, value', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('vote', 'id'),
            'model' => Yii::t('vote', 'Тип модели'),
            'modelId' => Yii::t('vote', 'Модель'),
            'userId' => Yii::t('vote', 'Добавил'),
            'creationDate' => Yii::t('vote', 'Дата добавления'),
            'value' => Yii::t('vote', 'Значение'),
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
        $criteria->compare('model', $this->model, true);
        $criteria->compare('modelId', $this->modelId, true);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('creationDate', $this->creationDate, true);
        $criteria->compare('value', $this->value);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->creationDate = new CDbExpression('NOW()');

                $this->userId = Yii::app()->user->getId();
            }

            return true;
        }

        return false;
    }
}