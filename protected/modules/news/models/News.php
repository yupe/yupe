<?php
/**
 * News основная моделька для новостей
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.news.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "News".
 *
 * The followings are the available columns in table 'News':
 * @property integer $id
 * @property string $create_time
 * @property string $update_time
 * @property string $date
 * @property string $title
 * @property string $slug
 * @property string $short_text
 * @property string $full_text
 * @property integer $user_id
 * @property integer $status
 * @property integer $is_protected
 * @property string  $link
 * @property string  $image
 * @property string $description
 * @property string $keywords
 */
class News extends yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO = 0;
    const PROTECTED_YES = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{news_news}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return News   the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, slug, short_text, full_text, keywords, description', 'filter', 'filter' => 'trim'],
            ['title, slug, keywords, description', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['date, title, slug, full_text', 'required', 'on' => ['update', 'insert']],
            ['status, is_protected, category_id', 'numerical', 'integerOnly' => true],
            ['title, slug, keywords', 'length', 'max' => 150],
            ['lang', 'length', 'max' => 2],
            ['lang', 'default', 'value' => Yii::app()->sourceLanguage],
            ['lang', 'in', 'range' => array_keys(Yii::app()->getModule('yupe')->getLanguagesList())],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['slug', 'yupe\components\validators\YUniqueSlugValidator'],
            ['description', 'length', 'max' => 250],
            ['link', 'length', 'max' => 250],
            ['link', 'yupe\components\validators\YUrlValidator'],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('NewsModule.news', 'Bad characters in {attribute} field')
            ],
            ['category_id', 'default', 'setOnEmpty' => true, 'value' => null],
            [
                'id, keywords, description, create_time, update_time, date, title, slug, short_text, full_text, user_id, status, is_protected, lang',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('news');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
            ],
            'seo'         => [
                'class'  => 'vendor.chemezov.yii-seo.behaviors.SeoActiveRecordBehavior',
                'route'  => '/news/news/view',
                'params' => [
                    'slug' => function ($data) {
                        return $data->slug;
                    }
                ],
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'category' => [self::BELONGS_TO, 'Category', 'category_id'],
            'user'     => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.status = :status',
                'params'    => [':status' => self::STATUS_PUBLISHED],
            ],
            'protected' => [
                'condition' => 't.is_protected = :is_protected',
                'params'    => [':is_protected' => self::PROTECTED_YES],
            ],
            'public'    => [
                'condition' => 't.is_protected = :is_protected',
                'params'    => [':is_protected' => self::PROTECTED_NO],
            ],
            'recent'    => [
                'order' => 'create_time DESC',
                'limit' => 5,
            ]
        ];
    }

    public function last($num)
    {
        $this->getDbCriteria()->mergeWith(
            [
                'order' => 'date DESC',
                'limit' => $num,
            ]
        );

        return $this;
    }

    public function language($lang)
    {
        $this->getDbCriteria()->mergeWith(
            [
                'condition' => 'lang = :lang',
                'params'    => [':lang' => $lang],
            ]
        );

        return $this;
    }

    public function category($category_id)
    {
        $this->getDbCriteria()->mergeWith(
            [
                'condition' => 'category_id = :category_id',
                'params'    => [':category_id' => $category_id],
            ]
        );

        return $this;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('NewsModule.news', 'Id'),
            'category_id'   => Yii::t('NewsModule.news', 'Category'),
            'create_time' => Yii::t('NewsModule.news', 'Created at'),
            'update_time'   => Yii::t('NewsModule.news', 'Updated at'),
            'date'          => Yii::t('NewsModule.news', 'Date'),
            'title'         => Yii::t('NewsModule.news', 'Title'),
            'slug'         => Yii::t('NewsModule.news', 'Alias'),
            'image'         => Yii::t('NewsModule.news', 'Image'),
            'link'          => Yii::t('NewsModule.news', 'Link'),
            'lang'          => Yii::t('NewsModule.news', 'Language'),
            'short_text'    => Yii::t('NewsModule.news', 'Short text'),
            'full_text'     => Yii::t('NewsModule.news', 'Full text'),
            'user_id'       => Yii::t('NewsModule.news', 'Author'),
            'status'        => Yii::t('NewsModule.news', 'Status'),
            'is_protected'  => Yii::t('NewsModule.news', 'Access only for authorized'),
            'keywords'      => Yii::t('NewsModule.news', 'Keywords (SEO)'),
            'description'   => Yii::t('NewsModule.news', 'Description (SEO)'),
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->title);
        }

        if (!$this->lang) {
            $this->lang = Yii::app()->getLanguage();
        }

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->update_time = new CDbExpression('NOW()');
        $this->date = date('Y-m-d', strtotime($this->date));

        if ($this->isNewRecord) {
            $this->create_time = $this->update_time;
            $this->user_id = Yii::app()->getUser()->getId();
        }

        return parent::beforeSave();
    }

    public function afterFind()
    {
        $this->date = date('d-m-Y', strtotime($this->date));

        return parent::afterFind();
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        if ($this->date) {
            $criteria->compare('date', date('Y-m-d', strtotime($this->date)));
        }
        $criteria->compare('title', $this->title, true);
        $criteria->compare('t.slug', $this->slug, true);
        $criteria->compare('short_text', $this->short_text, true);
        $criteria->compare('full_text', $this->full_text, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('t.lang', $this->lang);
        $criteria->with = ['category'];

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 'date DESC'],
        ]);
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT      => Yii::t('NewsModule.news', 'Draft'),
            self::STATUS_PUBLISHED  => Yii::t('NewsModule.news', 'Published'),
            self::STATUS_MODERATION => Yii::t('NewsModule.news', 'On moderation'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('NewsModule.news', '*unknown*');
    }

    public function getProtectedStatusList()
    {
        return [
            self::PROTECTED_NO  => Yii::t('NewsModule.news', 'no'),
            self::PROTECTED_YES => Yii::t('NewsModule.news', 'yes'),
        ];
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();

        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('NewsModule.news', '*unknown*');
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }

    public function getFlag()
    {
        return yupe\helpers\YText::langToflag($this->lang);
    }

    /**
     * @deprecated
     * @return mixed
     */
    public function getPermaLink()
    {
        return $this->getUrl();
    }
}
