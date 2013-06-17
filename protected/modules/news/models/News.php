<?php

/**
 * This is the model class for table "News".
 *
 * The followings are the available columns in table 'News':
 * @property integer $id
 * @property string $creation_date
 * @property string $change_date
 * @property string $date
 * @property string $title
 * @property string $alias
 * @property string $short_text
 * @property string $full_text
 * @property integer $user_id
 * @property integer $status
 * @property integer $is_protected
 * @property string  $link
 * @property string  $image
 */
class News extends YModel
{

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO  = 0;
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
     * @param string $className
     * @return News the static model class
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
        return array(
            array('title, alias, short_text, full_text, keywords, description', 'filter', 'filter' => 'trim'),
            array('title, alias, keywords, description', 'filter', 'filter' => 'strip_tags'),
            array('date, title, alias, full_text', 'required', 'on' => array('update', 'insert')),
            array('status, is_protected, category_id', 'numerical', 'integerOnly' => true),
            array('title, alias, keywords', 'length', 'max' => 150),
            array('lang', 'length', 'max' => 2),
            array('lang', 'default', 'value' => Yii::app()->sourceLanguage),
            array('lang', 'in', 'range' => array_keys(Yii::app()->getModule('yupe')->getLanguagesList())),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('alias', 'YUniqueSlugValidator'),
            array('description', 'length', 'max' => 250),
            array('link', 'length', 'max' => 250),
            array('link', 'YUrlValidator'),
            array('alias', 'YSLugValidator', 'message' => Yii::t('NewsModule.news', 'Запрещенные символы в поле {attribute}')),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, keywords, description, creation_date, change_date, date, title, alias, short_text, full_text, user_id, status, is_protected, lang', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('news');
        return array(
            'imageUpload' => array(
                'class'         =>'application.modules.yupe.models.ImageUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,              
                'uploadPath'    => $module->getUploadPath(),
                'imageNameCallback' => array($this, 'generateFileName'),
                'resize' => array(
                    'quality' => 75,
                    'width' => 800,
                )
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->title . microtime(true));
    }
    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id'),
            'user'     => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array(':status'   => self::STATUS_PUBLISHED),
            ),
            'protected' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_prtected' => self::PROTECTED_YES),
            ),
            'public'    => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_NO),
            ),
            'recent'    => array(
                'order' => 'creation_date DESC',
                'limit' => 5,
            )
        );
    }

    public function last($num)
    {
        $this->getDbCriteria()->mergeWith(array(
            'order' => 'date DESC',
            'limit' => $num,
        ));
        return $this;
    }

    public function language($lang)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'lang = :lang',
            'params'    => array(':lang' => $lang),
        ));
        return $this;
    }

    public function category($category_id)
    {
        $this->getDbCriteria()->mergeWith(array(
            'condition' => 'category_id = :category_id',
            'params'    => array(':category_id' => $category_id),
        ));
        return $this;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('NewsModule.news', 'Id'),
            'category_id'   => Yii::t('NewsModule.news', 'Категория'),
            'creation_date' => Yii::t('NewsModule.news', 'Дата создания'),
            'change_date'   => Yii::t('NewsModule.news', 'Дата изменения'),
            'date'          => Yii::t('NewsModule.news', 'Дата'),
            'title'         => Yii::t('NewsModule.news', 'Заголовок'),
            'alias'         => Yii::t('NewsModule.news', 'Алиас'),
            'image'         => Yii::t('NewsModule.news', 'Изображение'),
            'link'          => Yii::t('NewsModule.news', 'Ссылка'),
            'lang'          => Yii::t('NewsModule.news', 'Язык'),
            'short_text'    => Yii::t('NewsModule.news', 'Короткий текст'),
            'full_text'     => Yii::t('NewsModule.news', 'Полный текст'),
            'user_id'       => Yii::t('NewsModule.news', 'Автор'),
            'status'        => Yii::t('NewsModule.news', 'Статус'),
            'is_protected'  => Yii::t('NewsModule.news', 'Доступ: * только для авторизованных пользователей'),
            'keywords'      => Yii::t('NewsModule.news', 'Ключевые слова (SEO)'),
            'description'   => Yii::t('NewsModule.news', 'Описание (SEO)'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->alias)
            $this->alias = YText::translit($this->title);

        if(!$this->lang)
            $this->lang = Yii::app()->language;

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->change_date = YDbMigration::expression('NOW()');
        $this->date        = date('Y-m-d', strtotime($this->date));

        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date;
            $this->user_id       = Yii::app()->user->getId();
        }

        return parent::beforeSave();
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->date = date('d.m.Y', strtotime($this->date));
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('t.alias', $this->alias, true);
        $criteria->compare('short_text', $this->short_text, true);
        $criteria->compare('full_text', $this->full_text, true);
        $criteria->compare('user_id', $this->user_id);
        if ($this->status != '')
            $criteria->compare('t.status', $this->status);
        if ($this->category_id != '')
            $criteria->compare('category_id', $this->category_id);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('t.lang', $this->lang);
        $criteria->with = array('category');
        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder' => 'date DESC'),
        ));
    }

    public function getPermaLink()
    {
        return Yii::app()->createAbsoluteUrl('/news/news/show/', array('title' => $this->alias));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('NewsModule.news', 'Черновик'),
            self::STATUS_PUBLISHED  => Yii::t('NewsModule.news', 'Опубликовано'),
            self::STATUS_MODERATION => Yii::t('NewsModule.news', 'На модерации'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('NewsModule.news', '*неизвестно*');
    }

    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('NewsModule.news', 'нет'),
            self::PROTECTED_YES => Yii::t('NewsModule.news', 'да'),
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();
        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('NewsModule.news', '*неизвестно*');
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }

    public function getImageUrl()
    {
        if($this->image)
            return Yii::app()->baseUrl . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' .
                   Yii::app()->getModule('news')->uploadPath . '/' . $this->image;
        return false;
    }
}