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
 * @property string $class
 * @property string $title_attr
 * @property string $before_link
 * @property string $after_link
 * @property string $target
 * @property string $rel
 * @property string $condition_name
 * @property integer $condition_denial
 * @property integer $sort
 * @property integer $status
 * @property boolean $regular_link
 *
 * The followings are the available model relations:
 * @property Menu $menu
 */
class MenuItem extends YModel
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE   = 1;

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
        return '{{menu_menu_item}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('parent_id, menu_id, title, href', 'required', 'except' => 'search'),
            array('sort, status, condition_denial', 'numerical', 'integerOnly' => true),
            array('parent_id, menu_id, rel, target', 'length', 'max' => 10),
            array('title, href, condition_name, title_attr, before_link, after_link', 'length', 'max' => 255),
            array('class', 'length', 'max' => 50),
            array('regular_link', 'boolean'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, parent_id, menu_id, title, href, sort, status, condition_name, condition_denial', 'safe', 'on' => 'search'),
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
            'menu'   => array(self::BELONGS_TO, 'Menu', 'menu_id'),
            'parent' => array(self::BELONGS_TO, 'MenuItem', 'parent_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('MenuModule.menu', 'Id'),
            'parent_id'        => Yii::t('MenuModule.menu', 'Родитель'),
            'menu_id'          => Yii::t('MenuModule.menu', 'Меню'),
            'title'            => Yii::t('MenuModule.menu', 'Заголовок'),
            'href'             => Yii::t('MenuModule.menu', 'Адрес'),
            'title_attr'       => Yii::t('MenuModule.menu', 'Атрибут title'),
            'class'            => Yii::t('MenuModule.menu', 'Атрибут class'),
            'rel'              => Yii::t('MenuModule.menu', 'Атрибут rel'),
            'target'           => Yii::t('MenuModule.menu', 'Атрибут target'),
            'before_link'      => Yii::t('MenuModule.menu', 'Текст перед ссылкой'),
            'after_link'       => Yii::t('MenuModule.menu', 'Текст после ссылки'),
            'condition_name'   => Yii::t('MenuModule.menu', 'Условие'),
            'condition_denial' => Yii::t('MenuModule.menu', 'Отрицание условия'),
            'sort'             => Yii::t('MenuModule.menu', 'Сортировка'),
            'status'           => Yii::t('MenuModule.menu', 'Статус'),
            'regular_link'     => Yii::t('MenuModule.menu', 'Обычная ссылка'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'               => Yii::t('MenuModule.menu', 'Id пункта меню.'),
            'parent_id'        => Yii::t('MenuModule.menu', 'Родитель данного пункта меню. Если пункт необходимо указать в корне, выберите корень меню.'),
            'menu_id'          => Yii::t('MenuModule.menu', 'Укажите к какому меню относится данный пункт.'),
            'title'            => Yii::t('MenuModule.menu', 'Заголовок пункта меню.'),
            'href'             => Yii::t('MenuModule.menu', 'Адрес странице на сайте.'),
            'class'            => Yii::t('MenuModule.menu', 'Добавляет необходимые классы тегу &lt;li&gt;'),
            'title_attr'       => Yii::t('MenuModule.menu', 'Добавляет подсказку к ссылке'),
            'rel'              => Yii::t('MenuModule.menu', 'Используется для указания xfr'),
            'target'           => Yii::t('MenuModule.menu', 'Используется для указания открытия новой страницы в новом окне или вкладке, фрейме.'),
            'before_link'      => Yii::t('MenuModule.menu', 'Текст перед ссылкой'),
            'after_link'       => Yii::t('MenuModule.menu', 'Текст после ссылки'),
            'condition_name'   => Yii::t('MenuModule.menu', 'Если данный пункт меню, необходимо выводить только при определенном условии, укажите его.'),
            'condition_denial' => Yii::t('MenuModule.menu', 'Условие применяется при совпадении или отрацании.'),
            'sort'             => Yii::t('MenuModule.menu', 'Порядковый номер пункта в меню.'),
            'status'           => Yii::t('MenuModule.menu', 'Установите статус пункта меню: <br /><br /><span class="label label-success">активно</span> &ndash; пункт меню и все его потомки выводятся.<br /><br /><span class="label label-warning">не активно</span> &ndash; пункт меню и все его потомки выводиться не будут.'),
            'regular_link'     => Yii::t('MenuModule.menu', 'Не обрабатывать адрес роутером'),
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
        $criteria->compare('t.menu_id', $this->menu_id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('href', $this->href, true);

        if ($this->condition_name != '0') {
            $criteria->compare('t.condition_name', $this->condition_name, true);
            if ($this->condition_name != '')
                $criteria->compare('t.condition_denial', $this->condition_denial);
        } else
            $criteria->condition('t.condition_name', '');

        $criteria->compare('sort', $this->sort);
        $criteria->compare('status', $this->status);
        $criteria->with = array('menu','parent');

        return new CActiveDataProvider(
            get_class($this), array(
                'criteria' => $criteria,
                'sort'     => array('defaultOrder' => 't.sort')
            )
        );
    }

    protected function afterSave()
    {
        Yii::app()->cache->clear($this->menu->code);
    }

    protected function afterDelete()
    {
        Yii::app()->cache->clear($this->menu->code);
    }

    public function getMenuList()
    {
        return CHtml::listData(Menu::model()->findAll(array('select' => 'id, name')), 'id', 'name');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE   => Yii::t('MenuModule.menu', 'активно'),
            self::STATUS_DISABLED => Yii::t('MenuModule.menu', 'не активно'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('MenuModule.menu', '*неизвестно*');
    }

    public function getParentList()
    {
        return array(0 => Yii::t('MenuModule.menu', 'Корень меню')) + CHtml::listData($this->findAll(array('select' => 'id, title')), 'id', 'title');
    }

    public function getParentTree()
    {
        return array(0 => Yii::t('MenuModule.menu', 'Корень меню')) + $this->parentTreeIterator;
    }

    public function getParentTreeIterator($parent_id = 0, $level = 1)
    {
        $results = $this->findAll(array(
            'order'     => 'sort',
            'condition' => 'parent_id = :parent_id AND id <> :id AND menu_id = :menu_id',
            'params'    => array(
                'parent_id' => (int) $parent_id,
                'id'        => (int) $this->id,
                'menu_id'   => (int) $this->menu_id,
            ),
        ));

        $items = array();
        if (empty($results))
            return $items;

        foreach ($results as $result)
        {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += array($result->id => str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) . $result->title) + $childItems;
        }
        return $items;
    }

    public function getParent()
    {
        return empty($this->parent) ? '---' : $this->parent->title;
    }

    public function getConditionList($condition = false)
    {
        $conditions = array();

        foreach (Yii::app()->modules as $key => $value)
        {
            $key = strtolower($key);
            $module = Yii::app()->getModule($key);

            if (($module !== NULL) && is_a($module, 'YWebModule') && isset($module->conditions))
            {
                $conditionsList = array();
                foreach ($module->conditions as $keyList => $valueList)
                    $conditionsList[$keyList] = (!$condition) ? $valueList['name'] : $valueList['condition'];
                $conditions = array_merge($conditions, $conditionsList);
            }
        }
        return $conditions;
    }

    public function getConditionName()
    {
        $data = array('' => Yii::t('MenuModule.menu', 'Нет условия')) + $this->getConditionList();
        return (isset($data[$this->condition_name])) ? $data[$this->condition_name] . (($this->condition_name == '') ? '' : ' (' . $this->conditionDenial . ')') : Yii::t('MenuModule.menu', '*неизвестно*');
    }

    public function getConditionVisible($name, $condition_denial)
    {
        if ($name == '')
            return true;

        $data = $this->getConditionList(true);

        return (isset($data[$name]) && (($data[$name] && $condition_denial == 0) || (!$data[$name] && $condition_denial == 1))) ? true : false;
    }

    public function getConditionDenialList()
    {
        return array(
            self::STATUS_DISABLED => Yii::t('MenuModule.menu', 'нет'),
            self::STATUS_ACTIVE   => Yii::t('MenuModule.menu', 'да'),
        );
    }

    public function getConditionDenial()
    {
        $data = $this->getConditionDenialList();
        return isset($data[$this->condition_denial]) ? Yii::t('MenuModule.menu', 'отрицание') . ': ' . $data[$this->condition_denial] : Yii::t('MenuModule.menu', '*неизвестно*');
    }
}