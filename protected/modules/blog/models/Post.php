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
 * @property string $lang
 * @property string $create_user_ip
 * @property string $image
 * @property integer $category_id
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

    public $publish_date_tmp;
    public $publish_time_tmp;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Post the static model class
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
        return '{{blog_post}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('blog_id, slug, publish_date_tmp, publish_time_tmp, title, content', 'required', 'except' => 'search'),
            array('blog_id, create_user_id, update_user_id, status, comment_status, access_type, create_date, update_date, category_id', 'numerical', 'integerOnly' => true),
            array('blog_id, create_user_id, update_user_id, create_date, update_date, publish_date, status, comment_status, access_type', 'length', 'max' => 11),
            array('lang', 'length', 'max' => 2),
            array('slug', 'length', 'max' => 150),
            array('image', 'length', 'max' => 300),
            array('create_user_ip', 'length', 'max' => 20),
            array('quote, description, title, link, keywords', 'length', 'max' => 250),
            array('publish_date_tmp', 'type', 'type' => 'date', 'dateFormat' => 'dd-mm-yyyy'),
            array('publish_time_tmp', 'type', 'type' => 'time', 'timeFormat' => 'hh:mm'),
            array('link', 'YUrlValidator'),
            array('comment_status', 'in', 'range' => array(0, 1)),
            array('access_type', 'in', 'range' => array_keys($this->getAccessTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('slug', 'YSLugValidator', 'message' => Yii::t('BlogModule.blog', 'Запрещенные символы в поле {attribute}')),
            array('title, slug, link, keywords, description, publish_date', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('slug', 'unique'),
            array('id, blog_id, create_user_id, update_user_id, create_date, update_date, slug, publish_date, title, quote, content, link, status, comment_status, access_type, keywords, description, lang', 'safe', 'on' => 'search'),
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
            'comments'   => array(self::HAS_MANY,'Comment','model_id',
                'on' => 'model = :model AND comments.status = :status','params' => array(
                    ':model' => 'Post',
                    ':status' => Comment::STATUS_APPROVED
                ),
                'order' => 'comments.id'
            ),
            'commentsCount' => array(self::STAT,'Comment','model_id',
                'condition' => 'model = :model AND status = :status','params' => array(
                    ':model' => 'Post',
                    ':status' => Comment::STATUS_APPROVED
                )
            ),
            'category' => array(self::BELONGS_TO,'Category','category_id')
        );
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

    /**
     * Условие для получения определённого количества записей:
     * 
     * @param integer $count - количество записей
     * 
     * @return self
     */
    public function limit($count = null)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'limit' => $count,
            )
        );
        return $this;
    }

    /**
     * Условие для сортировки по дате
     *
     * @param string $typeSort - типо сортировки
     *
     * @return self
     **/
    public function sortByPubDate($typeSort = 'ASC')
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'order' => $this->getTableAlias() . '.publish_date ' . $typeSort,
            )
        );
        return $this;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'               => Yii::t('BlogModule.blog', 'id'),
            'blog_id'          => Yii::t('BlogModule.blog', 'Блог'),
            'create_user_id'   => Yii::t('BlogModule.blog', 'Создал'),
            'update_user_id'   => Yii::t('BlogModule.blog', 'Изменил'),
            'create_date'      => Yii::t('BlogModule.blog', 'Создано'),
            'update_date'      => Yii::t('BlogModule.blog', 'Изменено'),
            'publish_date'     => Yii::t('BlogModule.blog', 'Дата'),
            'publish_date_tmp' => Yii::t('BlogModule.blog', 'Дата публикации'),
            'publish_time_tmp' => Yii::t('BlogModule.blog', 'Время публикации'),
            'slug'             => Yii::t('BlogModule.blog', 'Урл'),
            'title'            => Yii::t('BlogModule.blog', 'Заголовок'),
            'quote'            => Yii::t('BlogModule.blog', 'Цитата'),
            'content'          => Yii::t('BlogModule.blog', 'Содержание'),
            'link'             => Yii::t('BlogModule.blog', 'Ссылка'),
            'status'           => Yii::t('BlogModule.blog', 'Статус'),
            'comment_status'   => Yii::t('BlogModule.blog', 'Комментарии'),
            'access_type'      => Yii::t('BlogModule.blog', 'Доступ'),
            'keywords'         => Yii::t('BlogModule.blog', 'Ключевые слова'),
            'description'      => Yii::t('BlogModule.blog', 'Описание'),
            'tags'             => Yii::t('BlogModule.blog', 'Теги'),
            'image'            => Yii::t('BlogModule.blog', 'Изображение'),
            'category_id'      => Yii::t('BlogModule.blog', 'Категория')
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'               => Yii::t('BlogModule.blog', 'Id записи.'),
            'blog_id'          => Yii::t('BlogModule.blog', 'Выберите блог, в который вы желаете поместить данную запись'),
            'slug'             => Yii::t('BlogModule.blog', 'Краткое название записи латинскими буквами, используется для формирования адреса записи.<br /><br /> Например (выделено темным фоном): <br /><br /><pre>http://site.ru/blogs/my/<br /><span class="label">my-na-more</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, названия записи будет достаточно.'),
            'publish_date'     => Yii::t('BlogModule.blog', 'Дата публикации поста'),
            'publish_date_tmp' => Yii::t('BlogModule.blog', 'Дата публикации, формат:<br /><span class="label">05-09-2012</span>'),
            'publish_time_tmp' => Yii::t('BlogModule.blog', 'Время публикации, формат:<br /><span class="label">12:00</span>'),
            'title'            => Yii::t('BlogModule.blog', 'Выберите заголовок для записи, например:<br /><span class="label">Как мы на море были!</span>'),
            'quote'            => Yii::t('BlogModule.blog', 'Опишите основную мысль записи или напишие некий вводный текст (анонс), пары предложений обычно достаточно. Данный текст используется при выводе списка записей, например, на главной странице.'),
            'content'          => Yii::t('BlogModule.blog', 'Полный текст записи отображается при переходе по ссылке &laquo;Подробнее&raquo; или иногда при клике на заголовке записи.'),
            'link'             => Yii::t('BlogModule.blog', 'Ссылка на текст, который использовалсь для написания данной записи.'),
            'status'           => Yii::t('BlogModule.blog', 'Установите статус записи:<br /><br /><span class="label label-success">опубликовано</span> &ndash; данная запись в блоге будет отображаться всем посетителям.<br /><br /><span class="label label-warning">черновик</span> &ndash; данная запись не публикуется на сайте, а видна только в административном интерфейсе.<br /><br /><span class="label label-info">по расписанию</span> &ndash; откладывает публикацию данной записи до момента наступления указанной даты.'),
            'comment_status'   => Yii::t('BlogModule.blog', 'Если галочка установлена &ndash; пользователи получат возможность комментировать данную запись в блоге'),
            'access_type'      => Yii::t('BlogModule.blog', 'Доступ к записи<br /><br /><span class="label label-success">публичный</span> &ndash; запись видят все посетители сайта<br /><br /><span class="label label-warning">личный</span> &ndash; запись видит только автор'),
            'keywords'         => Yii::t('BlogModule.blog', 'Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из записи и напишите их здесь через запятую. К примеру, если запись &ndash; об отдыхе на море, логично использовать такие ключевые слова: <pre>море, приключения, солнце, акулы, челюсти</pre>'),
            'description'      => Yii::t('BlogModule.blog', 'Краткое описание данной записи, одно или два предложения. Обычно это самая главная мысль записи, к примеру: <pre>Рассказ о том, как нас на море чуть не сожрали акулы. Как наши отдыхают &ndash; так не отдыхает никто!</pre>Данный текст очень часто попадает в <a href="http://help.yandex.ru/webmaster/?id=111131">сниппет</a> поисковых систем.'),
            'tags'             => Yii::t('BlogModule.blog', 'Ключевые слова к которым требуется отнести данную запись, служат для категоризии записей, например:<br /><span class="label">море</span>'),
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
        $criteria->compare('t.status', $this->status);
        $criteria->compare('comment_status', $this->comment_status);
        $criteria->compare('access_type', $this->access_type);
        $criteria->compare('t.category_id', $this->category_id, true);

        $criteria->with = array('createUser', 'updateUser', 'blog');

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('blog');
        return array(
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_date',
                'updateAttribute'   => 'update_date',
            ),
            'tags' => array(
                'class'                => 'application.modules.yupe.extensions.taggable.ETaggableBehavior',
                'tagTable'             => Yii::app()->db->tablePrefix . 'blog_tag',
                'tagBindingTable'      => Yii::app()->db->tablePrefix . 'blog_post_to_tag',
                'modelTableFk'         => 'post_id',
                'tagBindingTableTagId' => 'tag_id',
                'cacheID'              => 'cache',
            ),
            'imageUpload' => array(
                'class'             =>'application.modules.yupe.models.ImageUploadBehavior',
                'scenarios'         => array('insert','update'),
                'attributeName'     => 'image',
                'minSize'           => $module->minSize,
                'maxSize'           => $module->maxSize,
                'types'             => $module->allowedExtensions,
                'uploadPath'        => $module->getUploadPath(),
                'imageNameCallback' => array($this, 'generateFileName'),
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->slug . microtime(true) . rand());
    }

    public function getImageUrl()
    {
        if($this->image)
            return Yii::app()->baseUrl . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' .
                Yii::app()->getModule('blog')->uploadPath . '/' . $this->image;
        return false;
    }

    public function beforeSave()
    {
        $this->publish_date   = strtotime($this->publish_date_tmp . ' ' . $this->publish_time_tmp);
        $this->update_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord) {
            $this->create_user_id = $this->update_user_id;
            $this->create_user_ip = Yii::app()->request->userHostAddress;
        }

        return parent::beforeSave();
    }

    public function afterDelete()
    {
        Comment::model()->deleteAll(
            'model = :model AND model_id = :model_id', array(
                ':model' => 'Post',
                ':model_id' => $this->id
            )
        );

        return parent::afterDelete();
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
            self::STATUS_DRAFT     => Yii::t('BlogModule.blog', 'Черновик'),
            self::STATUS_PUBLISHED => Yii::t('BlogModule.blog', 'Опубликовано'),
            self::STATUS_SHEDULED  => Yii::t('BlogModule.blog', 'По расписанию'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function getAccessTypeList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('BlogModule.blog', 'Личный'),
            self::ACCESS_PUBLIC  => Yii::t('BlogModule.blog', 'Публичный'),
        );
    }

    public function getAccessType()
    {
        $data = $this->accessTypeList;
        return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function getCommentStatus()
    {
        $data = $this->commentStatusList;
        return isset($data[$this->comment_status]) ? $data[$this->comment_status] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function getCommentStatusList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('BlogModule.blog', 'Запрещены'),
            self::ACCESS_PUBLIC  => Yii::t('BlogModule.blog', 'Разрешены'),
        );
    }

    /**
     * after find event:
     *
     * @return parent::afterFind()
     **/
    public function afterFind()
    {

        /**
         * Fixing publish date for UI:
         **/
        $this->publish_date_tmp = date('d-m-Y', $this->publish_date);
        $this->publish_time_tmp = date('h:i', $this->publish_date);

        return parent::afterFind();
    }
}