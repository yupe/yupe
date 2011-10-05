<?php
/**
 * This is the model class for table "Page".
 *
 * The followings are the available columns in table 'Page':
 * @property integer $id
 * @property string $parentId
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
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO = 0;
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
        return array_key_exists($this->isProtected, $data)
            ? $data[$this->isProtected] : Yii::t('page', '*неизвестно*');
    }


    public function getAllPagesList($selfId = false)
    {
        $pages = $selfId
            ? $this->findAll('id != :id AND (parentId = null || parentId = 0)', array(':id' => $selfId))
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
            array('status, isProtected, parentId, menuOrder', 'numerical', 'integerOnly' => true),
            array('parentId', 'length', 'max' => 45),
            array('name, title, slug, keywords', 'length', 'max' => 150),
            array('description', 'length', 'max' => 150),
            array('slug', 'unique'),
            array('status', 'in', 'range' => array(0, 1, 2)),
            array('title, slug, body, description, keywords, name', 'filter', 'filter' => 'trim'),
            array('title, slug, description, keywords, name', 'filter', 'filter' => 'strip_tags'),
            array('slug', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('page', 'Запрещенные символы в поле {attribute}')),
            array('isProtected', 'in', 'range' => array(0, 1)),
            array('id, parentId, creation_date, change_date, title, slug, body, keywords, description, status, menuOrder', 'safe', 'on' => 'search'),
        );
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'childPages' => array(self::HAS_MANY, 'Page', 'parentId'),
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'changeUserId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('page', 'Id'),
            'parentId' => Yii::t('page', 'Родительская страница'),
            'creation_date' => Yii::t('page', 'Дата создания'),
            'change_date' => Yii::t('page', 'Дата изменения'),
            'title' => Yii::t('page', 'Заголовок'),
            'slug' => Yii::t('page', 'Url'),
            'body' => Yii::t('page', 'Текст'),
            'keywords' => Yii::t('page', 'Ключевые слова (SEO)'),
            'description' => Yii::t('page', 'Описание (SEO)'),
            'status' => Yii::t('page', 'Статус'),
            'isProtected' => Yii::t('page', 'Доступ: * только для авторизованных пользователей'),
            'name' => Yii::t('page', 'Название в меню'),
            'user_id' => Yii::t('page', 'Создал'),
            'changeUserId' => Yii::t('page', 'Изменил'),
            'menuOrder' => Yii::t('page', 'Порядок в меню'),
        );
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            if ($this->scenario === 'update')
            {
                $this->slug = YText::translit($this->title);
            }
            else
            {
                if (!$this->slug)
                {
                    $this->slug = YText::translit($this->title);
                }
            }

            return true;
        }

        return false;
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->change_date = $this->creation_date = new CDbExpression('NOW()');
                $this->user_id = $this->changeUserId = Yii::app()->user->getId();
            }
            else
            {
                $this->change_date = new CDbExpression('now()');
                $this->user_id = Yii::app()->user->getId();
            }
            return true;
        }
        return false;
    }


    public function scopes()
    {
        return array(
            'published' => array('condition' => 'status = ' . self::STATUS_PUBLISHED),
            'protected' => array('condition' => 'isProtected = ' . self::PROTECTED_YES),
            'public' => array('condition' => 'isProtected = ' . self::PROTECTED_NO),
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

        $criteria->compare('parentId', $this->parentId);

        $criteria->compare('creation_date', $this->creation_date);

        $criteria->compare('change_date', $this->change_date);

        $criteria->compare('title', $this->title);

        $criteria->compare('slug', $this->slug);

        $criteria->compare('body', $this->body);

        $criteria->compare('keywords', $this->keywords);

        $criteria->compare('description', $this->description);

        $criteria->compare('status', $this->status);

        $criteria->compare('isProtected', $this->isProtected);

        $sort = new CSort();

        $sort->defaultOrder = 'parentId DESC';

        return new CActiveDataProvider('Page', array(
                                                    'criteria' => $criteria,
                                                    'sort' => $sort
                                               ));
    }
}
