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
            array('type, sort, status', 'numerical', 'integerOnly' => true),
            array('parent_id, menu_id', 'length', 'max' => 10),
            array('title, href', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, menu_id, title, href, type, sort, status', 'safe', 'on' => 'search'),
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
            'parent' => array(self::BELONGS_TO, 'MenuItem', 'id'),
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
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('menu', '*неизвестно*');
    }

    public function getParentName()
    {
        return ($this->parent_id == 0) ? Yii::t('menu', 'Корень меню') : $this->parent->title;
    }
}
