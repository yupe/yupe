<?php
/**
 * DictionaryData модель "справочник"
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.dictionary.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "dictionary_group".
 *
 * The followings are the available columns in table 'dictionary_group':
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property string $update_time
 * @property string $create_user_id
 * @property string $update_user_id
 *
 * The followings are the available model relations:
 * @property DictionaryData[] $dictionaryDatas
 * @property User $updateUser
 * @property User $createUser
 */
class DictionaryGroup extends yupe\models\YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return DictionaryGroup the static model class
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
        return '{{dictionary_dictionary_group}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['code, name', 'required'],
            ['code', 'length', 'max' => 100],
            ['name, description', 'length', 'max' => 250],
            ['create_user_id, update_user_id', 'length', 'max' => 10],
            ['code', 'yupe\components\validators\YSLugValidator'],
            ['code', 'unique'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            [
                'id, code, name, description, create_time, update_time, create_user_id, update_user_id',
                'safe',
                'on' => 'search'
            ],
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
            'dictionaryData' => [self::HAS_MANY, 'DictionaryData', 'group_id'],
            'updateUser'     => [self::BELONGS_TO, 'User', 'update_user_id'],
            'createUser'     => [self::BELONGS_TO, 'User', 'create_user_id'],
            'dataCount'      => [self::STAT, 'DictionaryData', 'group_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('DictionaryModule.dictionary', 'id'),
            'code'           => Yii::t('DictionaryModule.dictionary', 'Code'),
            'name'           => Yii::t('DictionaryModule.dictionary', 'Title'),
            'description'    => Yii::t('DictionaryModule.dictionary', 'Description'),
            'create_time'  => Yii::t('DictionaryModule.dictionary', 'Created at'),
            'update_time'    => Yii::t('DictionaryModule.dictionary', 'Updated at'),
            'create_user_id' => Yii::t('DictionaryModule.dictionary', 'Created by.'),
            'update_user_id' => Yii::t('DictionaryModule.dictionary', 'Updated by'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    public function beforeSave()
    {
        $this->update_user_id = Yii::app()->user->getId();
        $this->update_time = new CDbExpression('NOW()');

        if ($this->isNewRecord) {
            $this->create_user_id = $this->update_user_id;
            $this->create_time = $this->update_time;
        }

        return parent::beforeSave();
    }

    public function getData()
    {
        return DictionaryData::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll(
            [
                'condition' => 'group_id = :group_id',
                'params'    => [':group_id' => $this->id],
                'order'     => 'name DESC',
            ]
        );
    }
}
