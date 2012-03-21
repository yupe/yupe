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
 * @property string $body
 * @property string $keywords
 * @property string $description
 * @property integer $status
 */
class Page extends CActiveRecord
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO  = 0;
    const PROTECTED_YES = 1;

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED => Yii::t('page', 'Опубликовано'),
            self::STATUS_DRAFT => Yii::t('page', 'Черновик'),
            self::STATUS_MODERATION => Yii::t('page', 'На модерации')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status]
            : Yii::t('page', '*неизвестно*');
    }


    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO => Yii::t('page', 'нет'),
            self::PROTECTED_YES => Yii::t('page', 'да')
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();
        return array_key_exists($this->is_protected, $data)
            ? $data[$this->is_protected] : Yii::t('page', '*неизвестно*');
    }


    public function getAllPagesList($selfId = false)
    {
        $pages = $selfId
            ? $this->findAll('id != :id', array(':id' => $selfId))
            : $this->findAll();
        $pages = CHtml::listData($pages, 'id', 'name');
        $pages[0] = Yii::t('page', '--нет--');
        return $pages;
    }
    
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
            array('name, title, slug, body, description, keywords', 'required'),
            array('status, is_protected, parent_Id, menu_order', 'numerical', 'integerOnly' => true),
            array('parent_Id', 'length', 'max' => 45),
            array('name, title, slug, keywords', 'length', 'max' => 150),
            array('description', 'length', 'max' => 150),
            array('slug', 'unique'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('is_protected', 'in', 'range' => array_keys($this->getProtectedStatusList())),
            array('title, slug, body, description, keywords, name', 'filter', 'filter' => 'trim'),
            array('title, slug, description, keywords, name', 'filter', 'filter' => array($obj = new CHtmlPurifier(),'purify')),
            array('slug', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('page', 'Запрещенные символы в поле {attribute}')),            
            array('id, parent_Id, creation_date, change_date, title, slug, body, keywords, description, status, menu_order', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'childPages' => array(self::HAS_MANY, 'Page', 'parent_Id'),
            'parentPage' => array(self::BELONGS_TO, 'Page', 'parent_Id'),
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'change_user_id')
        );
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('page', 'Id'),
            'parent_Id' => Yii::t('page', 'Родительская страница'),
            'creation_date' => Yii::t('page', 'Дата создания'),
            'change_date' => Yii::t('page', 'Дата изменения'),
            'title' => Yii::t('page', 'Заголовок'),
            'slug' => Yii::t('page', 'Url'),
            'body' => Yii::t('page', 'Текст'),
            'keywords' => Yii::t('page', 'Ключевые слова (SEO)'),
            'description' => Yii::t('page', 'Описание (SEO)'),
            'status' => Yii::t('page', 'Статус'),
            'is_protected' => Yii::t('page', 'Доступ: * только для авторизованных пользователей'),
            'name' => Yii::t('page', 'Название в меню'),
            'user_id' => Yii::t('page', 'Создал'),
            'change_user_id' => Yii::t('page', 'Изменил'),
            'menu_order' => Yii::t('page', 'Порядок в меню'),
        );
    }


    public function beforeValidate()
    {        
        if (!$this->slug)            
            $this->slug = YText::translit($this->title);            

        return parent::beforeValidate();        
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->change_date = $this->creation_date = new CDbExpression('NOW()');

            $this->user_id = $this->change_user_id = Yii::app()->user->getId();
        }
        else
        {
            $this->change_date = new CDbExpression('now()');
            
            $this->user_id = Yii::app()->user->getId();
        }

        return parent::beforeSave();        
    }


    public function scopes()
    {
        return array(
            'published' => array('condition' => 'status = ' . self::STATUS_PUBLISHED),
            'protected' => array('condition' => 'is_protected = ' . self::PROTECTED_YES),
            'public' => array('condition' => 'is_protected = ' . self::PROTECTED_NO),
        );
    }


    public function findBySlug($slug)
    {
        $slug = trim($slug);
        return $this->find('slug = :slug', array(':slug' => $slug));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('author', 'changeAuthor');

        $criteria->compare('id', $this->id);

        $criteria->compare('parent_Id', $this->parent_Id);

        $criteria->compare('creation_date', $this->creation_date);

        $criteria->compare('change_date', $this->change_date);

        $criteria->compare('title', $this->title);

        $criteria->compare('slug', $this->slug);

        $criteria->compare('body', $this->body);

        $criteria->compare('keywords', $this->keywords);

        $criteria->compare('description', $this->description);

        $criteria->compare('status', $this->status);

        $criteria->compare('is_protected', $this->is_protected);

        $sort = new CSort();

        $sort->defaultOrder = 'parent_Id DESC';

        return new CActiveDataProvider('Page', array(
                                                    'criteria' => $criteria,
                                                    'sort' => $sort
                                               ));
    }
}