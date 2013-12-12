<?php
/**
 * Post
 *
 * Модель для работы с постами
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.models
 * @since 0.1
 *
 */

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
Yii::import('application.modules.blog.models.Blog');
 
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
            array('slug', 'YSLugValidator', 'message' => Yii::t('BlogModule.blog', 'Forbidden symbols in {attribute}')),
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
            'blog_id'          => Yii::t('BlogModule.blog', 'Blog'),
            'create_user_id'   => Yii::t('BlogModule.blog', 'Create user'),
            'update_user_id'   => Yii::t('BlogModule.blog', 'Update user'),
            'create_date'      => Yii::t('BlogModule.blog', 'Created at'),
            'update_date'      => Yii::t('BlogModule.blog', 'Updated at'),
            'publish_date'     => Yii::t('BlogModule.blog', 'Date'),
            'publish_date_tmp' => Yii::t('BlogModule.blog', 'Publish date'),
            'publish_time_tmp' => Yii::t('BlogModule.blog', 'Publish time'),
            'slug'             => Yii::t('BlogModule.blog', 'Url'),
            'title'            => Yii::t('BlogModule.blog', 'Title'),
            'quote'            => Yii::t('BlogModule.blog', 'Quote'),
            'content'          => Yii::t('BlogModule.blog', 'Content'),
            'link'             => Yii::t('BlogModule.blog', 'Link'),
            'status'           => Yii::t('BlogModule.blog', 'Status'),
            'comment_status'   => Yii::t('BlogModule.blog', 'Comments'),
            'access_type'      => Yii::t('BlogModule.blog', 'Access'),
            'keywords'         => Yii::t('BlogModule.blog', 'Keywords'),
            'description'      => Yii::t('BlogModule.blog', 'description'),
            'tags'             => Yii::t('BlogModule.blog', 'Tags'),
            'image'            => Yii::t('BlogModule.blog', 'Image'),
            'category_id'      => Yii::t('BlogModule.blog', 'Category')
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'               => Yii::t('BlogModule.blog', 'Post id.'),
            'blog_id'          => Yii::t('BlogModule.blog', 'Choose a blog you want to add the record to'),
            'slug'             => Yii::t('BlogModule.blog', 'URL-friendly name of the blog.<br /><br /> For example: <br /><br /><pre>http://site.ru/blogs/my/<br /><span class="label">my-na-more</span>/</pre> It you don\'t know what is it you can leave this field empty.'),
            'publish_date'     => Yii::t('BlogModule.blog', 'Publish date'),
            'publish_date_tmp' => Yii::t('BlogModule.blog', 'Publish date, formatted as:<br /><span class="label">05-09-2012</span>'),
            'publish_time_tmp' => Yii::t('BlogModule.blog', 'Publish time, formatted as:<br /><span class="label">12:00</span>'),
            'title'            => Yii::t('BlogModule.blog', 'Post title, for example:<br /><span class="label">Our seaside vacation.</span>'),
            'quote'            => Yii::t('BlogModule.blog', 'Please enter announcement text. A couple of sentences is enough. The text will be used, for example, at the main page or in the posts list.'),
            'content'          => Yii::t('BlogModule.blog', 'Full text of the post which is displayed when you click on &laquo;More&raquo; link'),
            'link'             => Yii::t('BlogModule.blog', 'Source link of the post. Source website or an article which you have used to write the post.'),
            'status'           => Yii::t('BlogModule.blog', 'Post status:<br /><br /><span class="label label-success">published</span> &ndash;Visible for everyone.<br /><br /><span class="label label-warning">draft</span> &ndash; Visible for admins.<br /><br /><span class="label label-info">scheduled</span> &ndash; Will be published at a publish date.'),
            'comment_status'   => Yii::t('BlogModule.blog', 'If checked &ndash; Users are able to leave comments on the post'),
            'access_type'      => Yii::t('BlogModule.blog', 'Post access<br /><br /><span class="label label-success">public</span> &ndash; Everyone can read this post<br /><br /><span class="label label-warning">private</span> &ndash; only you can read this post'),
            'keywords'         => Yii::t('BlogModule.blog', 'SEO keywords separated by comma. For example, if your post is about your seaside vacation keyword would be: <pre>sea, travel, sun, etc.</pre>'),
            'description'      => Yii::t('BlogModule.blog', 'Short post description. Should not be more than one or two sentences. Should reflect the main points of the post. For example: <pre>The story of how we were almost eaten by sharks.</pre>This text is often used in search engine <a href="http://help.yandex.ru/webmaster/?id=111131">snippet</a>.'),
            'tags'             => Yii::t('BlogModule.blog', 'Keywords for post categorization, for example:<br /><span class="label">sea</span>'),
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

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('blog_id', $this->blog_id);
        $criteria->compare('t.create_user_id', $this->create_user_id, true);
        $criteria->compare('t.update_user_id', $this->update_user_id, true);
        $criteria->compare('t.create_date', $this->create_date);
        $criteria->compare('t.update_date', $this->update_date);
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

        $criteria->order = 'publish_date DESC';
        $criteria->with  = array('createUser', 'updateUser', 'blog');

        return new CActiveDataProvider('Post', array('criteria' => $criteria));
    }

    public function allPosts()
    {
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.status = :status');
        $criteria->addCondition('t.access_type = :access_type');
        $criteria->params = array(
            ':status'      => self::STATUS_PUBLISHED,
            ':access_type' => self::ACCESS_PUBLIC
        );
        $criteria->with  = array('blog', 'createUser');
        $criteria->order = 'publish_date DESC';

        return new CActiveDataProvider(
            'Post', array('criteria' => $criteria)
        );
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
                'class'                => 'application.modules.yupe.extensions.taggable.EARTaggableBehavior',
                'tagTable'             => Yii::app()->db->tablePrefix . 'blog_tag',
                'tagBindingTable'      => Yii::app()->db->tablePrefix . 'blog_post_to_tag',
                'tagModel'             => 'Tag',
                'modelTableFk'         => 'post_id',
                'tagBindingTableTagId' => 'tag_id',
                'cacheID'              => 'cache',
            ),
            'imageUpload' => array(
                'class'             =>'application.modules.yupe.components.behaviors.ImageUploadBehavior',
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
            $this->create_user_ip = Yii::app()->getRequest()->userHostAddress;
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
        if (!$this->slug) {
            $this->slug = YText::translit($this->title);
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT     => Yii::t('BlogModule.blog', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('BlogModule.blog', 'Published'),
            self::STATUS_SHEDULED  => Yii::t('BlogModule.blog', 'Scheduled'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function getAccessTypeList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('BlogModule.blog', 'Private'),
            self::ACCESS_PUBLIC  => Yii::t('BlogModule.blog', 'Public'),
        );
    }

    public function getAccessType()
    {
        $data = $this->getAccessTypeList();
        return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function getCommentStatus()
    {
        $data = $this->getCommentStatusList();
        return isset($data[$this->comment_status]) ? $data[$this->comment_status] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function getCommentStatusList()
    {
        return array(
            self::ACCESS_PRIVATE => Yii::t('BlogModule.blog', 'Forbidden'),
            self::ACCESS_PUBLIC  => Yii::t('BlogModule.blog', 'Allowed'),
        );
    }

    /**
     * after find event:
     *
     * @return parent::afterFind()
     **/
    public function afterFind()
    {
        $this->publish_date_tmp = date('d-m-Y', $this->publish_date);
        $this->publish_time_tmp = date('h:i', $this->publish_date);

        return parent::afterFind();
    }

    public function getQuote($limit = 500)
    {
        return $this->quote
            ?: YText::characterLimiter(
                $this->content, (int) $limit
            );
    }
}