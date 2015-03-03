<?php
/**
 * Menu основная модель для menu
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu.models
 * @since 0.1
 *
 */

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
 *
 * @method Menu active()
 */
class Menu extends yupe\models\YModel
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return Menu   the static model class
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
        return '{{menu_menu}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, code, description', 'required', 'except' => 'search'],
            ['status', 'numerical', 'integerOnly' => true],
            ['name, code, description', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['name, description', 'length', 'max' => 255],
            ['code', 'length', 'max' => 100],
            ['code', 'yupe\components\validators\YSLugValidator'],
            ['code', 'unique'],
            ['status', 'in', 'range' => array_keys($this->statusList)],
            ['id, name, code, description, status', 'safe', 'on' => 'search'],
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
            'menuItems' => [self::HAS_MANY, 'MenuItem', 'menu_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('MenuModule.menu', 'Id'),
            'name'        => Yii::t('MenuModule.menu', 'Name'),
            'code'        => Yii::t('MenuModule.menu', 'Unified code'),
            'description' => Yii::t('MenuModule.menu', 'Description'),
            'status'      => Yii::t('MenuModule.menu', 'Status'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'          => Yii::t('MenuModule.menu', 'Menu Id'),
            'name'        => Yii::t('MenuModule.menu', 'Menu name'),
            'code'        => Yii::t(
                'MenuModule.menu',
                'Unified code is using in widget, as identifier for menu printing.'
            ),
            'description' => Yii::t('MenuModule.menu', 'Short description'),
            'status'      => Yii::t(
                'MenuModule.menu',
                'Choose menu status: <br /><br /><span class="label label-success">active</span> &ndash; Will be visible on site.<br /><br /><span class="label label-warning">not active</span> &ndash; Will be hidden.'
            ),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort'     => ['defaultOrder' => 'status DESC, id'],
            ]
        );
    }

    public function scopes()
    {
        return [
            'active' => [
                'condition' => 'status = :status',
                'params'    => [
                    ':status' => self::STATUS_ACTIVE
                ]
            ]
        ];
    }

    protected function afterSave()
    {
        Yii::app()->cache->clear($this->code);

        return parent::afterSave();
    }

    protected function afterDelete()
    {
        Yii::app()->cache->clear($this->code);

        return parent::afterDelete();
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('MenuModule.menu', 'not active'),
            self::STATUS_ACTIVE   => Yii::t('MenuModule.menu', 'active'),
        ];
    }

    public function getStatus()
    {
        $data = $this->statusList;

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('MenuModule.menu', '*unknown*');
    }

    // @todo добавить кэширование
    public function getItems($code, $parent_id = 0)
    {
        $userId = Yii::app()->user->getId();
        $items = Yii::app()->cache->get("Menu::{$code}{$parent_id}::user_{$userId}" . Yii::app()->language);

        if ($items === false) {
            $alias = $this->getDbConnection()->getSchema()->quoteTableName('menuItems');
            $results = self::model()->with(
                [
                    'menuItems' => [
                        'on'     => $alias . '.parent_id = :parent_id AND ' . $alias . '.status = 1',
                        'params' => ['parent_id' => (int)$parent_id],
                        'order'  => $alias . '.sort ASC, ' . $alias . '.id ASC',
                    ]
                ]
            )->findByAttributes(
                [
                    'code' => $code
                ]
            );

            $items = [];

            if (empty($results)) {
                return $items;
            }

            $resultItems = $results->menuItems;

            foreach ($resultItems as $result) {
                $childItems = $this->getItems($code, $result->id);

                // @TODO Если не ставить url и присутствует items, пункт не выводится, возможно баг yii
                if ($result->href) {
                    // если адрес надо параметризовать через роутер
                    if (!$result->regular_link) {
                        $url = $result->href;
                        $param = [];
                        strstr($url, '?') ? list($url, $param) = explode("?", $url) : $param = [];
                        if ($param) {
                            parse_str($param, $param);
                        }
                        $url = ['url' => (array)$url + $param, 'items' => $childItems];
                    } else {
                        // если обычная ссылка
                        $url = ['url' => $result->href, 'items' => $childItems];
                    }
                } elseif ($childItems) {
                    $url = ['url' => ['#'], 'items' => $childItems];
                } else {
                    $url = [];
                }

                $class = (($childItems) ? ' submenuItem' : '') . (($result->class) ? ' ' . $result->class : '');
                $title_attr = ($result->title_attr) ? ['title' => $result->title_attr] : [];
                $target = ($result->target && $url) ? ['target' => $result->target] : [];
                $rel = ($result->rel && $url) ? ['rel' => $result->rel] : [];

                $items[] = [
                        'label'       => $result->title,
                        'template'    => $result->before_link . '{menu}' . $result->after_link,
                        'itemOptions' => ['class' => 'listItem' . $class],
                        'linkOptions' => [
                                'class' => 'listItemLink',
                            ] + $title_attr + $target + $rel,
                        'visible'     => MenuItem::model()->getConditionVisible(
                            $result->condition_name,
                            $result->condition_denial
                        ),
                    ] + $url;
            }

            Yii::app()->cache->set(
                "Menu::{$code}{$parent_id}::user_{$userId}" . Yii::app()->language,
                $items,
                0,
                new TagsCache('menu', $code, 'loggedIn' . $userId)
            );
        }

        return $items;
    }

    /**
     * Добавляет новый пункт меню в меню
     * @param $title string - Заголовок
     * @param $href string - Ссылка
     * @param $parentId int - Родитель
     * @param bool $regularLink - Обычная ссылка
     * @return bool
     */
    public function addItem($title, $href, $parentId, $regularLink = false)
    {
        $menuItem = new MenuItem();
        $menuItem->parent_id = (int)$parentId;
        $menuItem->menu_id = $this->id;
        $menuItem->title = $title;
        $menuItem->href = $href;
        $menuItem->condition_name = '';
        $menuItem->class = '';
        $menuItem->title_attr = '';
        $menuItem->before_link = '';
        $menuItem->after_link = '';
        $menuItem->target = '';
        $menuItem->rel = '';
        $menuItem->regular_link = $regularLink;
        if ($menuItem->save()) {
            Yii::app()->cache->clear(['menu', $this->code]);

            return true;
        }

        return false;
    }

    /**
     * Метод изменения пункта меню.
     * @param $oldTitle string Старое название элемента (по нему осуществяется поиск)
     * @param $newTitle string Новое название
     * @param $href string Новая ссылка
     * @param $parentId int id меню
     * @param $regularLink bool Обычная ссылка
     * @return bool статус выполнения
     */
    public function changeItem($oldTitle, $newTitle, $href, $parentId, $regularLink = false)
    {
        $menuItem = MenuItem::model()->findByAttributes(["title" => $oldTitle]);

        if ($menuItem === null) {
            return $this->addItem($newTitle, $href, $parentId, $regularLink);
        }

        $menuItem->parent_id = (int)$parentId;
        $menuItem->menu_id = $this->id;
        $menuItem->title = $newTitle;
        $menuItem->href = $href;
        $menuItem->regular_link = $regularLink;

        if ($menuItem->save()) {
            Yii::app()->cache->clear(['menu', $this->code]);

            return true;
        }

        return false;
    }
}
