<?php

/**
 * 
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[] $authItemchildren
 * @property AuthItemChild[] $authItemchildren1
 */
class AuthItem extends CActiveRecord
{
    const TYPE_OPERATION = 0;

    const TYPE_TASK = 1;

    const TYPE_ROLE = 2;

    public function getTypeList()
    {
        return array(
            self::TYPE_OPERATION => Yii::t('RbacModule.rbac', 'Действие'),
            self::TYPE_TASK      => Yii::t('RbacModule.rbac', 'Задача'),
            self::TYPE_ROLE      => Yii::t('RbacModule.rbac', 'Роль'),
        );
    }

    public function getType()
    {
        $data = $this->getTypeList();

        return isset($data[$this->type]) ? $data[$this->type] : '---';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AuthItem the static model class
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
        return '{{user_user_auth_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type, description', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 64),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('name', 'unique'),
            array('name', 'match', 'pattern' => '/^[A-Za-z0-9_-]{2,50}$/'),
            array('description, bizrule, data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name, type, description, bizrule, data', 'safe', 'on' => 'search'),
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
            'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'itemname'),
            'parents' => array(self::HAS_MANY, 'AuthItemChild', 'parent'),
            'childs' => array(self::HAS_MANY, 'AuthItemChild', 'child'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('RbacModule.rbac','Название'),
            'type' => Yii::t('RbacModule.rbac','Тип') ,
            'description' => Yii::t('RbacModule.rbac','Описание'),
            'bizrule' => Yii::t('RbacModule.rbac','Правило'),
            'data'    => Yii::t('RbacModule.rbac','Данные'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('name', $this->name,true);
        $criteria->compare('type', $this->type);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('bizrule', $this->bizrule);
        $criteria->compare('data', $this->data);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 'name ASC'
            ),
            'pagination'=> array(
                'pageSize' => 30
            ),
        ));
    }
}