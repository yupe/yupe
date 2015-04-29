<?php
/**
 * Menu основная модель для пунктов меню
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu.models
 * @since 0.1
 *
 */

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
class MenuItem extends yupe\models\YModel
{
    public $regular_link = true;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
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
        return [
            ['parent_id, menu_id, title, href', 'required', 'except' => 'search'],
            ['sort, status, condition_denial', 'numerical', 'integerOnly' => true],
            ['parent_id, menu_id, rel, target', 'length', 'max' => 10],
            ['title, href, condition_name, title_attr, before_link, after_link', 'length', 'max' => 255],
            ['class', 'length', 'max' => 50],
            ['regular_link', 'boolean'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            [
                'id, parent_id, menu_id, title, href, sort, status, condition_name, condition_denial',
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
            'menu'   => [self::BELONGS_TO, 'Menu', 'menu_id'],
            'parent' => [self::BELONGS_TO, 'MenuItem', 'parent_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('MenuModule.menu', 'Id'),
            'parent_id'        => Yii::t('MenuModule.menu', 'Parent'),
            'menu_id'          => Yii::t('MenuModule.menu', 'Menu'),
            'title'            => Yii::t('MenuModule.menu', 'Title'),
            'href'             => Yii::t('MenuModule.menu', 'Address'),
            'title_attr'       => Yii::t('MenuModule.menu', 'Attribute title'),
            'class'            => Yii::t('MenuModule.menu', 'Attribute class'),
            'rel'              => Yii::t('MenuModule.menu', 'Attribute rel'),
            'target'           => Yii::t('MenuModule.menu', 'Attribute target'),
            'before_link'      => Yii::t('MenuModule.menu', 'Text before link'),
            'after_link'       => Yii::t('MenuModule.menu', 'Text after link'),
            'condition_name'   => Yii::t('MenuModule.menu', 'Condition'),
            'condition_denial' => Yii::t('MenuModule.menu', 'False condition'),
            'sort'             => Yii::t('MenuModule.menu', 'Sorting'),
            'status'           => Yii::t('MenuModule.menu', 'Status'),
            'regular_link'     => Yii::t('MenuModule.menu', 'Regular link'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'               => Yii::t('MenuModule.menu', 'Menu item Id'),
            'parent_id'        => Yii::t('MenuModule.menu', 'Item parent. Check root if it is in root menu'),
            'menu_id'          => Yii::t('MenuModule.menu', 'For which one this item is attitude'),
            'title'            => Yii::t('MenuModule.menu', 'Item title'),
            'href'             => Yii::t('MenuModule.menu', 'Page address'),
            'class'            => Yii::t('MenuModule.menu', 'Add necessary classes to &lt;li&gt; tag'),
            'title_attr'       => Yii::t('MenuModule.menu', 'Add notice to link'),
            'rel'              => Yii::t('MenuModule.menu', 'Using for xfr'),
            'target'           => Yii::t('MenuModule.menu', 'Using for open new page in new window or frame'),
            'before_link'      => Yii::t('MenuModule.menu', 'Text before link'),
            'after_link'       => Yii::t('MenuModule.menu', 'Text after link'),
            'condition_name'   => Yii::t('MenuModule.menu', 'Select condition for menu item visibility'),
            'condition_denial' => Yii::t('MenuModule.menu', 'Condition use in conjuction or negation'),
            'sort'             => Yii::t('MenuModule.menu', 'Item order number in menu'),
            'status'           => Yii::t(
                    'MenuModule.menu',
                    'Choose menu item status: <br /><br /><span class="label label-success">activ</span> &ndash; Item and it descendants will be visible.<br /><br /><span class="label label-warning">not active</span> &ndash; Item and it descendants will be hidden.'
                ),
            'regular_link'     => Yii::t('MenuModule.menu', 'Don\'t handle address to router'),
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

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('t.parent_id', $this->parent_id, true);
        $criteria->compare('t.menu_id', $this->menu_id, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.href', $this->href, true);

        if ($this->condition_name != '0') {
            $criteria->compare('t.condition_name', $this->condition_name, true);

            if ($this->condition_name != '') {
                $criteria->compare('t.condition_denial', $this->condition_denial);
            }
        } else {
            $criteria->condition('t.condition_name', '');
        }

        $criteria->compare('t.sort', $this->sort);
        $criteria->compare('t.status', $this->status);
        $criteria->with = ['menu', 'parent'];

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort'     => ['defaultOrder' => 't.sort']
            ]
        );
    }

    public function scopes()
    {
        return [
            'public' => [
                'condition' => 'status = :status',
                'params'    => [
                    ':status' => self::STATUS_ACTIVE
                ]
            ]
        ];
    }

    protected function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->sort = Yii::app()->db->createCommand()
                ->select('MAX(sort) + 1')
                ->from($this->tableName())
                ->queryScalar();
        }

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        Yii::app()->getCache()->clear($this->menu->code);

        return parent::afterSave();
    }

    protected function afterDelete()
    {
        Yii::app()->getCache()->clear($this->menu->code);

        return parent::afterDelete();
    }

    public function getMenuList()
    {
        return CHtml::listData(Menu::model()->findAll(['select' => 'id, name']), 'id', 'name');
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE   => Yii::t('MenuModule.menu', 'active'),
            self::STATUS_DISABLED => Yii::t('MenuModule.menu', 'not active'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('MenuModule.menu', '*unknown*');
    }

    public function getParentList()
    {
        return [0 => Yii::t('MenuModule.menu', 'Menu root')] + CHtml::listData(
            $this->findAll(['select' => 'id, title']),
            'id',
            'title'
        );
    }

    public function getParentTree()
    {
        return [0 => Yii::t('MenuModule.menu', 'Menu root')] + $this->parentTreeIterator;
    }

    public function getParentTreeIterator($parent_id = 0, $level = 1)
    {
        $results = $this->findAll(
            [
                'order'     => 'sort',
                'condition' => 'parent_id = :parent_id AND id <> :id AND menu_id = :menu_id',
                'params'    => [
                    'parent_id' => (int)$parent_id,
                    'id'        => (int)$this->id,
                    'menu_id'   => (int)$this->menu_id,
                ],
            ]
        );

        $items = [];
        if (empty($results)) {
            return $items;
        }

        foreach ($results as $result) {
            $childItems = $this->getParentTreeIterator($result->id, ($level + 1));
            $items += [
                    $result->id => str_repeat(
                            '&nbsp;&nbsp;&nbsp;&nbsp;',
                            $level
                        ) . $result->title
                ] + $childItems;
        }

        return $items;
    }

    public function getParent()
    {
        return empty($this->parent) ? '---' : $this->parent->title;
    }

    public function getConditionList($condition = false)
    {
        $conditions = [];

        foreach (Yii::app()->getModules() as $key => $value) {
            $key = strtolower($key);
            $module = Yii::app()->getModule($key);

            if (($module !== null) && ($module instanceof yupe\components\WebModule) && isset($module->conditions)) {
                $conditionsList = [];
                foreach ($module->conditions as $keyList => $valueList) {
                    $conditionsList[$keyList] = (!$condition) ? $valueList['name'] : $valueList['condition'];
                }
                $conditions = array_merge($conditions, $conditionsList);
            }
        }

        return $conditions;
    }

    public function getConditionName()
    {
        $data = ['' => Yii::t('MenuModule.menu', 'Condition is not set')] + $this->getConditionList();

        return (isset($data[$this->condition_name])) ? $data[$this->condition_name] . (($this->condition_name == '') ? '' : ' (' . $this->conditionDenial . ')') : Yii::t(
            'MenuModule.menu',
            '*неизвестно*'
        );
    }

    public function getConditionVisible($name, $condition_denial)
    {
        if (empty($name)) {
            return true;
        }

        $data = $this->getConditionList(true);

        return (isset($data[$name]) && (($data[$name] && $condition_denial == 0) || (!$data[$name] && $condition_denial == 1))) ? true : false;
    }

    public function getConditionDenialList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('MenuModule.menu', 'no'),
            self::STATUS_ACTIVE   => Yii::t('MenuModule.menu', 'yes'),
        ];
    }

    public function getConditionDenial()
    {
        $data = $this->getConditionDenialList();

        return isset($data[$this->condition_denial]) ? Yii::t(
                'MenuModule.menu',
                'negation'
            ) . ': ' . $data[$this->condition_denial] : Yii::t('MenuModule.menu', '*unknown*');
    }

    public function deleteWithChild()
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $this->deleteAll('parent_id = :id', [':id' => $this->id]);
            $this->delete();
            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
            return false;
        }
    }
}
