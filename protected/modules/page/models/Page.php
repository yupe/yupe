<?php

/**
 * This is the model class for table "Page".
 *
 * The followings are the available columns in table 'Page':
 * @property integer $id
 * @property string $parent_Id
 * @property string $creation_date
 * @property string $change_date
 * @property string $title
 * @property string $slug
 * @property string $lang
 * @property string $body
 * @property string $keywords
 * @property string $description
 * @property integer $status
 * @property integer $category_id
 */
class Page extends YModel
{

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO  = 0;
    const PROTECTED_YES = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return Page the static model class
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
        return '{{page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, title, slug, body, description, keywords, lang', 'required', 'on' => array('update', 'insert')),
            array('status, is_protected, parent_Id, menu_order, category_id', 'numerical', 'integerOnly' => true, 'on' => array('update', 'insert')),
            array('parent_Id', 'length', 'max' => 45),
            array('lang', 'length', 'max' => 2),
            array('lang', 'default', 'value' => Yii::app()->sourceLanguage),
            array('name, title, slug, keywords', 'length', 'max' => 150),
            array('description', 'length', 'max' => 150),
            array('slug', 'unique', 'criteria' => array(
                    'condition' => 'lang = :lang',
                    'params'    => array(':lang' => $this->lang),
                ), 'on' => array('insert')
            ),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('is_protected', 'in', 'range' => array_keys($this->protectedStatusList)),
            array('title, slug, body, description, keywords, name', 'filter', 'filter' => 'trim'),
            array('title, slug, description, keywords, name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('slug', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('page', 'Запрещенные символы в поле {attribute}')),
            array('lang', 'match', 'pattern' => '/^[a-z]{2}$/', 'message' => Yii::t('page', 'Запрещенные символы в поле {attribute}')),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('lang, id, parent_Id, creation_date, change_date, title, slug, body, keywords, description, status, menu_order', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'childPages'   => array(self::HAS_MANY, 'Page', 'parent_Id'),
            'parentPage'   => array(self::BELONGS_TO, 'Page', 'parent_Id'),
            'author'       => array(self::BELONGS_TO, 'User', 'user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'change_user_id'),
            'category'     => array(self::BELONGS_TO, 'Category', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('page', 'Id'),
            'parent_Id'      => Yii::t('page', 'Родитель'),
            'category_id'    => Yii::t('page', 'Категория'),
            'creation_date'  => Yii::t('page', 'Создано'),
            'change_date'    => Yii::t('page', 'Изменено'),
            'title'          => Yii::t('page', 'Заголовок'),
            'slug'           => Yii::t('page', 'Url'),
            'lang'           => Yii::t('page', 'Язык'),
            'body'           => Yii::t('page', 'Текст'),
            'keywords'       => Yii::t('page', 'Ключевые слова (SEO)'),
            'description'    => Yii::t('page', 'Описание (SEO)'),
            'status'         => Yii::t('page', 'Статус'),
            'is_protected'   => Yii::t('page', 'Доступ: * только для авторизованных пользователей'),
            'name'           => Yii::t('page', 'В меню'),
            'user_id'        => Yii::t('page', 'Создал'),
            'change_user_id' => Yii::t('page', 'Изменил'),
            'menu_order'     => Yii::t('page', 'Сортировка'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = YText::translit($this->title);

        if (!$this->lang)
            $this->lang = Yii::app()->language;

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression('now()');
        $this->user_id = Yii::app()->user->getId();

        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date;
            $this->change_user_id = $this->user_id;
        }

        return parent::beforeSave();
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array('status' => self::STATUS_PUBLISHED),
            ),
            'protected' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_YES),
            ),
            'public'    => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_NO),
            ),
        );
    }

    public function findBySlug($slug)
    {
        return $this->find('slug = :slug', array(':slug' => trim($slug)));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array( 'author', 'changeAuthor' );

        $criteria->compare('id', $this->id);
        $criteria->compare('parent_Id', $this->parent_Id);
        $criteria->compare('creation_date', $this->creation_date);
        $criteria->compare('change_date', $this->change_date);
        $criteria->compare('title', $this->title);
        $criteria->compare('slug', $this->slug);
        $criteria->compare('body', $this->body);
        $criteria->compare('keywords', $this->keywords);
        $criteria->compare('description', $this->description);

        if ($this->status != '')
            $criteria->compare('t.status', $this->status);
        if ($this->category_id != '')
            $criteria->compare('category_id', $this->category_id);

        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('is_protected', $this->is_protected);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'menu_order DESC'),
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED  => Yii::t('page', 'Опубликовано'),
            self::STATUS_DRAFT      => Yii::t('page', 'Черновик'),
            self::STATUS_MODERATION => Yii::t('page', 'На модерации'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('page', '*неизвестно*');
    }

    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('page', 'нет'),
            self::PROTECTED_YES => Yii::t('page', 'да'),
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->protectedStatusList;
        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('page', '*неизвестно*');
    }

    public function getAllPagesList($selfId = false)
    {
        $pages = $selfId
            ? $this->findAll(array(
                'condition' => 'id != :id',
                'params'    => array(':id' => $selfId),
                'order'     => 'menu_order DESC',
                'group'     => 'slug',
            ))
            : $this->findAll(array('order' => 'menu_order DESC'));

        return CHtml::listData($pages, 'id', 'name');
    }

    public function getAllPagesListBySlug($slug = false)
    {
        $pages = $slug
            ? $this->findAll(array(
                'condition' => 'slug != :slug',
                'params'    => array(':slug' => $slug),
                'order'     => 'menu_order DESC',
                'group'     => 'slug',
            ))
            : $this->findAll(array('order' => 'menu_order DESC'));

        return CHtml::listData($pages, 'id', 'name');
    }

    public function getCategoryName()
    {
        return ($this->category === NULL) ? '---' : $this->category->name;
    }

    public function getParentName()
    {
        return ($this->parentPage === NULL) ? '---' : $this->parentPage->name;
    }
}