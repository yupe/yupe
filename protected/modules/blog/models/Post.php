<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property string $blog_id
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property string $slug
 * @property string $publish_date
 * @property string $title
 * @property string $quote
 * @property string $content
 * @property string $link
 * @property integer $status
 * @property integer $comment_status
 * @property integer $access_type
 * @property string $keywords
 * @property string $description
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property User $updateUser
 * @property Blog $blog
 */
class Post extends YModel
{
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_SHEDULED  = 2;

    const ACCESS_PUBLIC  = 1;
    const ACCESS_PRIVATE = 2;

    public $create_date_old;

    /**
     * Returns the static model of the specified AR class.
     * @return Post the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{post}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('blog_id, slug, publish_date, title, content', 'required', 'except' => 'search'),
            array('blog_id, create_user_id, update_user_id, status, comment_status, access_type', 'numerical', 'integerOnly' => true),
            array('blog_id, create_user_id, update_user_id', 'length', 'max' => 10),
            array('slug, title, link, keywords', 'length', 'max' => 150),
            array('slug', 'unique'),
            array('quote, description', 'length', 'max' => 300),
            array('link', 'url'),
            array('comment_status', 'in', 'range' => array(0, 1)),
            array('access_type', 'in', 'range' => array_keys($this->getAccessTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('slug', 'unique'),
            array('title, slug, link, keywords, description, publish_date', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('id, blog_id, create_user_id, update_user_id, create_date, update_date, slug, publish_date, title, quote, content, link, status, comment_status, access_type, keywords, description', 'safe', 'on' => 'search'),
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
            'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'blog'       => array(self::BELONGS_TO, 'Blog', 'blog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('blog', 'id'),
            'blog_id'        => Yii::t('blog', 'Блог'),
            'create_user_id' => Yii::t('blog', 'Создал'),
            'update_user_id' => Yii::t('blog', 'Изменил'),
            'create_date'    => Yii::t('blog', 'Создано'),
            'update_date'    => Yii::t('blog', 'Изменено'),
            'slug'           => Yii::t('blog', 'Урл'),
            'publish_date'   => Yii::t('blog', 'Дата'),
            'title'          => Yii::t('blog', 'Заголовок'),
            'quote'          => Yii::t('blog', 'Цитата'),
            'content'        => Yii::t('blog', 'Содержание'),
            'link'           => Yii::t('blog', 'Ссылка'),
            'status'         => Yii::t('blog', 'Статус'),
            'comment_status' => Yii::t('blog', 'Комментарии'),
            'access_type'    => Yii::t('blog', 'Доступ'),
            'keywords'       => Yii::t('blog', 'Ключевые слова'),
            'description'    => Yii::t('blog', 'Описание'),
            'tags'           => Yii::t('blog', 'Теги'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'             => Yii::t('blog', 'Id записи.'),
            'blog_id'        => Yii::t('blog', 'Выберите блог, в который вы желаете поместить данную запись'),
            'slug'           => Yii::t('blog', 'Краткое название записи латинскими буквами, используется для формирования адреса записи.<br /><br /> Например (выделено темным фоном): <br /><br /><pre>http://site.ru/blogs/my/<br /><span class="label">my-na-more</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, названия записи будет достаточно.'),
            'publish_date'   => Yii::t('blog', 'Дата публикации поста'),
            'title'          => Yii::t('blog', 'Выберите заголовок для записи, например:<br /><span class="label">Как мы на море были!</span>'),
            'quote'          => Yii::t('blog', 'Опишите основную мысль записи или напишие некий вводный текст (анонс), пары предложений обычно достаточно. Данный текст используется при выводе списка записей, например, на главной странице.'),
            'content'        => Yii::t('blog', 'Полный текст записи отображается при переходе по ссылке &laquo;Подробнее&raquo; или иногда при клике на заголовке записи.'),
            'link'           => Yii::t('blog', 'Ссылка на текст, который использовалсь для написания данной записи.'),
            'status'         => Yii::t('blog', 'Установите статус записи:<br /><br /><span class="label label-success">опубликовано</span> &ndash; данная запись в блоге будет отображаться всем посетителям.<br /><br /><span class="label label-warning">черновик</span> &ndash; данная запись не публикуется на сайте, а видна только в административном интерфейсе.<br /><br /><span class="label label-info">по расписанию</span> &ndash; откладывает публикацию данной записи до момента наступления указанной даты.'),
            'comment_status' => Yii::t('blog', 'Если галочка установлена &ndash; пользователи получат возможность комментировать данную запись в блоге'),
            'access_type'    => Yii::t('blog', 'Доступ к записи<br /><br /><span class="label label-success">публичный</span> &ndash; запись видят все посетители сайта<br /><br /><span class="label label-warning">личный</span> &ndash; запись видит только автор'),
            'keywords'       => Yii::t('blog', 'Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из записи и напишите их здесь через запятую. К примеру, если запись &ndash; об отдыхе на море, логично использовать такие ключевые слова: <pre>море, приключения, солнце, акулы, челюсти</pre>'),
            'description'    => Yii::t('blog', 'Краткое описание данной записи, одно или два предложения. Обычно это самая главная мысль записи, к примеру: <pre>Рассказ о том, как нас на море чуть не сожрали акулы. Как наши отдыхают &ndash; так не отдыхает никто!</pre>Данный текст очень часто попадает в <a href="http://help.yandex.ru/webmaster/?id=111131">сниппет</a> поисковых систем.'),
            'tags'           => Yii::t('blog', 'Ключевые слова к которым требуется отнести данную запись, служат для категоризии записей, например:<br /><span class="label">море</span>'),
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
        $criteria->compare('blog_id', $this->blog_id, true);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('create_date', $this->create_date);
        $criteria->compare('update_date', $this->update_date);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('publish_date', $this->publish_date, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('quote', $this->quote, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('comment_status', $this->comment_status);
        $criteria->compare('access_type', $this->access_type);

        $criteria->with = array('createUser', 'updateUser', 'blog');

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_date',
                'updateAttribute'   => 'update_date',
            ),
            'tags' => array(
                'class'                => 'blog.extensions.taggable.ETaggableBehavior',
                'tagTable'             => 'tag',
                'tagBindingTable'      => 'post_to_tag',
                'modelTableFk'         => 'post_id',
                'tagBindingTableTagId' => 'tag_id',
                'cacheID'              => 'cache',
            ),
        );
    }

    public function afterFind()
    {
        $this->create_date_old = $this->create_date;
        /* Необходим корректный вывод даты публикации */
        $this->publish_date = date('Y-m-d', strtotime($this->publish_date));
        
        $this->create_date = Yii::app()->getDateFormatter()->formatDateTime($this->create_date, "short", "short");
        $this->update_date = Yii::app()->getDateFormatter()->formatDateTime($this->update_date, "short", "short");
        //$this->publish_date = Yii::app()->getDateFormatter()->formatDateTime(strtotime($this->publish_date), "short", "short");

        return parent::afterFind();
    }

    public function beforeSave()
    {
        $this->update_user_id = Yii::app()->user->getId();

        if($this->isNewRecord)
            $this->create_user_id = $this->update_user_id;
        else
            $this->create_date = $this->create_date_old;

        return parent::beforeSave();
    }

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = YText::translit($this->title);

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_SHEDULED  => Yii::t('blog', 'По расписанию'),
            self::STATUS_DRAFT     => Yii::t('blog', 'Черновик'),
            self::STATUS_PUBLISHED => Yii::t('blog', 'Опубликовано'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('blog', '*неизвестно*');
    }

    public function getAccessTypeList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('blog', 'Личный'),
            self::ACCESS_PUBLIC  => Yii::t('blog', 'Публичный')
        );
    }

    public function getAccessType()
    {
        $data = $this->getAccessTypeList();

        return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('blog', '*неизвестно*');
    }

    public function getCommentStatus()
    {
        return $this->comment_status ? Yii::t('blog', 'Да') : Yii::t('blog', 'Нет');
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => self::STATUS_PUBLISHED),
            ),
            'public' => array(
                'condition' => 't.access_type = :access_type',
                'params'    => array(':access_type' => self::ACCESS_PUBLIC),
            ),
        );
    }
}