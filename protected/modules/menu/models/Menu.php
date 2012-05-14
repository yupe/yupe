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
    public static function model($className = __CLASS__)
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
            //@formatter:off
            array('name, code, description', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, code, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, description', 'length', 'max' => 300),
            array('code', 'length', 'max' => 100),
            array('code', 'match', 'pattern'=>'/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('menu', 'Запрещенные символы в поле {attribute}')),
            array('code', 'unique'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('id, name, code, description, status', 'safe', 'on' => 'search'),
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
            'menuItems' => array(self::HAS_MANY, 'MenuItem', 'menu_id'),
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
            'name' => Yii::t('menu', 'Название'),
            'code' => Yii::t('menu', 'Уникальный код'),
            'description' => Yii::t('menu', 'Описание'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
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
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', '*неизвестно*');
    }

    public function getItems($code, $parent_id = 0)
    {
        $results = $this->with(array('menuItems' => array(
                'on' => 'menuItems.parent_id=:parent_id AND menuItems.status = 1',
                'params' => array('parent_id' => (int)$parent_id),
                'order' => 'menuItems.id ASC, menuItems.sort ASC',
            )))->findAll(array(
            'select' => array(
                'id',
                'code'
            ),
            'condition' => 't.code=:code AND t.status = 1',
            'params' => array(':code' => $code),
        ));

        $items = array();

        if (empty($results))
            return $items;

        $resultItems = $results[0]->menuItems;

        foreach ($resultItems AS $result)
        {
            $childItems = $this->getItems($code, $result->id);
            $items[] = array(
                'label' => $result->title,
                'url' => array($result->href),
                'itemOptions' => array('class' => 'listItem'),
                'linkOptions' => array(
                    'class' => 'listItemLink',
                    'title' => $result->title,
                ),
                'submenuOptions' => array(),
                'items' => $childItems,
                'visible' => MenuItem::model()->getConditionVisible($result->condition_name, $result->condition_denial),
            );
        }
        return $items;
    }

}
