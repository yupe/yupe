<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property string $description
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property MenuItem[] $menuItems
 */
class Menu extends CActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Menu the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'menu';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, code, description', 'required'),
            array('status', 'numerical', 'integerOnly'=>true),
            array('name, code, description', 'filter', 'filter'=>array($obj = new CHtmlPurifier(), 'purify')),
            array('name, description', 'length', 'max'=>300),
            array('code', 'length', 'max'=>100),
            array('code', 'match', 'pattern'=>'/^[a-zA-Z0-9_\-]+$/', 'message'=>Yii::t('menu', 'Запрещенные символы в поле {attribute}')),
            array('code', 'unique'),
            array('status', 'in', 'range'=>array_keys($this->getStatusList())),
            array('id, name, code, description, status', 'safe', 'on'=>'search'),
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
            'menuItems'=>array(self::HAS_MANY, 'MenuItem', 'menu_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'=>Yii::t('menu', 'Id'),
            'name'=>Yii::t('menu', 'Название'),
            'code'=>Yii::t('menu', 'Уникальный код'),
            'description'=>Yii::t('menu', 'Описание'),
            'status'=>Yii::t('menu', 'Статус'),
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

        $criteria=new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DISABLED=>Yii::t('menu', 'не активно'),
            self::STATUS_ACTIVE=>Yii::t('menu', 'активно'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status])
            ? $data[$this->status]
            : Yii::t('menu', '*неизвестно*');
    }
}