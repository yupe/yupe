<?php

/**
 * This is the model class for table "Vote".
 *
 * The followings are the available columns in table 'Vote':
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property string $user_id
 * @property string $creation_date
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Vote extends YModel
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
        return '{{vote_vote}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('model, model_id, value', 'required'),
            array('user_id, value', 'numerical', 'integerOnly' => true),
            array('model_id, user_id', 'length', 'max' => 10),
            array('model', 'length', 'max' => 50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, model, model_id, user_id, creation_date, value', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('VoteModule.vote', 'ID'),
            'model'         => Yii::t('VoteModule.vote', 'Тип модели'),
            'model_id'      => Yii::t('VoteModule.vote', 'Модель'),
            'user_id'       => Yii::t('VoteModule.vote', 'Добавил'),
            'creation_date' => Yii::t('VoteModule.vote', 'Дата добавления'),
            'value'         => Yii::t('VoteModule.vote', 'Значение'),
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
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('value', $this->value);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');
            $this->user_id       = Yii::app()->user->getId();
        }
        return parent::beforeSave();
    }
}