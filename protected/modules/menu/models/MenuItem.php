<?php

/**
 * This is the model class for table "menu_item".
 *
 * The followings are the available columns in table 'menu_item':
 * @property string $id
 * @property string $parent_id
 * @property string $menu_id
 * @property string $title
 * @property string $href
 * @property integer $type
 * @property string $condition_name
 * @property integer $condition_denial
 * @property integer $sort
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Menu $menu
 */
class MenuItem extends CActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MenuItem the static model class
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
        return 'menu_item';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //@formatter:off
            array('parent_id, menu_id, title', 'required'),
            array('type, sort, status, condition_denial', 'numerical', 'integerOnly' => true),
            array('parent_id, menu_id', 'length', 'max' => 10),
            array('title, href, condition_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, menu_id, title, href, type, sort, status, condition_name, condition_denial', 'safe', 'on' => 'search'),
            //@formatter:on
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
            //@formatter:off
            'menu' => array(self::BELONGS_TO, 'Menu', 'menu_id'),
            //@formatter:on
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('menu', 'Id'),
            'parent_id' => Yii::t('menu', 'Родитель'),
            'menu_id' => Yii::t('menu', 'Меню'),
            'title' => Yii::t('menu', 'Заголовок'),
            'href' => Yii::t('menu', 'Адрес'),
            'type' => Yii::t('menu', 'Тип'),
            'condition_name' => Yii::t('menu', 'Условие'),
            'condition_denial' => Yii::t('menu', 'Отрицание условия'),
            'sort' => Yii::t('menu', 'Сортировка'),
            'status' => Yii::t('menu', 'Статус'),
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
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('menu_id', $this->menu_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('href', $this->href, true);
        $criteria->compare('type', $this->type);
        if($this->condition_name)
        {
            $criteria->compare('condition_name', $this->condition_name, true);
            $criteria->compare('condition_denial', $this->condition_denial);
        }
        $criteria->compare('sort', $this->sort);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('menu', 'не активно'),
            self::STATUS_ACTIVE => Yii::t('menu', 'активно'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', '*неизвестно*');
    }

    public function getParentList()
    {
        return array_merge(array(0 => Yii::t('menu', 'Корень меню')), CHtml::listData($this->findAll(), 'id', 'title'));
    }

    public function getParent()
    {
        $data = $this->parentList;

        return isset($data[$this->parent_id]) ? $data[$this->parent_id] : Yii::t('menu', '*неизвестно*');
    }

    public function getConditionList($condition = false)
    {
        $conditions = array(0 => Yii::t('menu', 'Нет условия'));

        foreach (Yii::app()->modules as $key => $value)
        {
            $key = strtolower($key);
            $module = Yii::app()->getModule($key);

            if (!is_null($module))
            {
                if (is_a($module, 'YWebModule'))
                {
                    if ($module->getIsShowInAdminMenu() || $module->getEditableParams() || ($module->getIsShowInAdminMenu() == false && is_array($module->checkSelf())))
                    {
                        if (isset($module->conditions))
                        {
                            $conditionsList = array();
                            foreach ($module->conditions as $keyList => $valueList)
                                $conditionsList[$keyList] = (!$condition) ? $valueList['name'] : $valueList['condition'];

                            $conditions = array_merge($conditions, $conditionsList);
                        }
                    }
                }
            }
        }

        return $conditions;
    }

    public function getConditionVisible($name, $condition_denial)
    {
        if ($name === null)
            return true;

        $data = $this->getConditionList(true);

        return (isset($data[$name]) && (($data[$name] && $condition_denial == 0) || (!$data[$name] && $condition_denial == 1))) ? true : false;
    }

    public function getConditionName()
    {
        $data = $this->getConditionList();

        return (isset($data[$this->condition_name])) ? $data[$this->condition_name] . ' (' . $this->conditionDenial . ')' : $data[0];
    }

    public function getConditionDenialList()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('menu', 'нет'),
            self::STATUS_ACTIVE => Yii::t('menu', 'да'),
        );
    }

    public function getConditionDenial()
    {
        $data = $this->conditionDenialList;

        return isset($data[$this->condition_denial]) ? Yii::t('menu', 'отрицание').': '.$data[$this->condition_denial] : Yii::t('menu', '*неизвестно*');
    }

}
