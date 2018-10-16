<?php
/**
 * DictionaryData модель "данные справочника"
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.dictionary.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "dictionary_data".
 *
 * The followings are the available columns in table 'dictionary_data':
 * @property string $id
 * @property string $group_id
 * @property string $code
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $create_time
 * @property string $update_time
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $updateUser
 * @property DictionaryGroup $group
 * @property User $createUser
 */
class DictionaryData extends yupe\models\YModel
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return DictionaryData the static model class
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
        return '{{dictionary_dictionary_data}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['group_id, code, name, value', 'required'],
            ['status', 'numerical', 'integerOnly' => true],
            ['group_id, create_user_id, update_user_id', 'length', 'max' => 10],
            ['code', 'length', 'max' => 100],
            ['name, value, description', 'length', 'max' => 250],
            ['code', 'yupe\components\validators\YSLugValidator'],
            ['code', 'unique'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            [
                'id, group_id, code, name, description, create_time, update_time, create_user_id, update_user_id, status',
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
            'updateUser' => [self::BELONGS_TO, 'User', 'update_user_id'],
            'group'      => [self::BELONGS_TO, 'DictionaryGroup', 'group_id'],
            'createUser' => [self::BELONGS_TO, 'User', 'create_user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('DictionaryModule.dictionary', 'id'),
            'group_id'       => Yii::t('DictionaryModule.dictionary', 'Dictionary'),
            'code'           => Yii::t('DictionaryModule.dictionary', 'Code'),
            'name'           => Yii::t('DictionaryModule.dictionary', 'Title'),
            'value'          => Yii::t('DictionaryModule.dictionary', 'Item'),
            'description'    => Yii::t('DictionaryModule.dictionary', 'Description'),
            'create_time'  => Yii::t('DictionaryModule.dictionary', 'Created at'),
            'update_time'    => Yii::t('DictionaryModule.dictionary', 'Updated at.'),
            'create_user_id' => Yii::t('DictionaryModule.dictionary', 'Created by.'),
            'update_user_id' => Yii::t('DictionaryModule.dictionary', 'Updated by.'),
            'status'         => Yii::t('DictionaryModule.dictionary', 'Active'),
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
        $criteria->compare('group_id', $this->group_id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('status', $this->status);

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

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE  => Yii::t('DictionaryModule.dictionary', 'Yes'),
            self::STATUS_DELETED => Yii::t('DictionaryModule.dictionary', 'No'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('DictionaryModule.dictionary', '*unknown*');
    }

    public function getByCode($code)
    {
        return $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->find('code = :code', ['code' => $code]);
    }
}
