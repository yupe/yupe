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
class News extends CActiveRecord
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
        return '{{news}}';
    }

    /**
     * Returns the static model of the specified AR class.
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
            array( 'title, alias, short_text, full_text, keywords, description', 'filter', 'filter' => 'trim' ),
            array( 'title, alias, keywords, description', 'filter', 'filter' => 'strip_tags' ),
            array( 'date, title, alias, full_text', 'required', 'on' => array( 'update', 'insert' ) ),
            array( 'status, is_protected, category_id', 'numerical', 'integerOnly' => true ),
            array( 'title, alias, keywords', 'length', 'max' => 150 ),
            array( 'lang', 'length', 'max' => 2 ),
            array( 'lang', 'default', 'value' => Yii::app()->sourceLanguage ),
            array( 'status', 'in', 'range' => array_keys( $this->getStatusList()) ),
            array( 'alias', 'unique', 'criteria' => array(
                    'condition' => 'lang = :lang',
                    'params'    => array( ':lang' => $this->lang ),
                ),
             'on' => 'insert'
            ),
            array( 'description', 'length', 'max' => 250 ),            
            array( 'image, link', 'length', 'max' => 300 ),
            array( 'link', 'url'),
            array( 'alias', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('news', 'Запрещенные символы в поле {attribute}') ),
            array( 'category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array( 'id, keywords, description, creation_date, change_date, date, title, alias, short_text, full_text, user_id, status, is_protected', 'safe', 'on' => 'search' ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'category' => array( self::BELONGS_TO, 'Category', 'category_id' ),
            'user'     => array( self::BELONGS_TO, 'User', 'user_id' ),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array( ':status'   => self::STATUS_PUBLISHED ),
            ),
            'protected' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array( ':is_prtected' => self::PROTECTED_YES ),
            ),
            'public' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array( ':is_protected' => self::PROTECTED_NO ),
            ),
            'recent' => array(
                'order' => 'creation_date DESC',
                'limit' => 5,
            )
        );
    }

    public function language($lang)
    {
        $this->getDbCriteria()->mergeWith(array('condition' => "lang = '$lang'"));
        return $this;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('news', 'Id'),
            'category_id'   => Yii::t('news', 'Категория'),
            'creation_date' => Yii::t('news', 'Дата создания'),
            'change_date'   => Yii::t('news', 'Дата изменения'),
            'date'          => Yii::t('news', 'Дата'),
            'title'         => Yii::t('news', 'Заголовок'),
            'alias'         => Yii::t('news', 'Алиас'),
            'image'         => Yii::t('news', 'Изображение'),
            'link'          => Yii::t('news', 'Ссылка'),
            'lang'          => Yii::t('news', 'Язык'),
            'short_text'    => Yii::t('news', 'Короткий текст'),
            'full_text'     => Yii::t('news', 'Полный текст'),
            'user_id'       => Yii::t('news', 'Автор'),
            'status'        => Yii::t('news', 'Статус'),
            'is_protected'  => Yii::t('news', 'Доступ: * только для авторизованных пользователей'),
            'keywords'      => Yii::t('news', 'Ключевые слова (SEO)'),
            'description'   => Yii::t('news', 'Описание (SEO)'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->alias)
            $this->alias = YText::translit($this->title);

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date = new CDbExpression('NOW()');

            $this->user_id = Yii::app()->user->getId();
        }
        else
            $this->change_date = new CDbExpression('NOW()');

        $this->date = date('Y-m-d', strtotime($this->date));

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

        $criteria->compare('id', $this->id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('short_text', $this->short_text, true);
        $criteria->compare('full_text', $this->full_text, true);
        $criteria->compare('user_id', $this->user_id);
        if($this->status != '')
            $criteria->compare('status', $this->status);
        if($this->category_id != '')
            $criteria->compare('category_id', $this->category_id);
        $criteria->compare('is_protected', $this->is_protected);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getPermaLink()
    {
        return Yii::app()->createAbsoluteUrl('/news/news/show/', array( 'title' => $this->alias ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('news', 'Черновик'),
            self::STATUS_PUBLISHED  => Yii::t('news', 'Опубликовано'),
            self::STATUS_MODERATION => Yii::t('news', 'На модерации')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status] : Yii::t('news', '*неизвестно*');
    }

    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('news', 'нет'),
            self::PROTECTED_YES => Yii::t('news', 'да')
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();
        return array_key_exists($this->is_protected, $data) ? $data[$this->is_protected] : Yii::t('news', '*неизвестно*');
    }
    

    public function getCategoryName()
    {
        return is_null($this->category) ? '---' : $this->category->name;
    }

    public function getImageUrl()
    {
        if($this->image)
            return  Yii::app()->baseUrl . '/' . 
                    Yii::app()->getModule('yupe')->uploadPath . '/' . 
                    Yii::app()->getModule('news')->uploadPath . '/' . 
                    $this->image;

        return false;
    }
}