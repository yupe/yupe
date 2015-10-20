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
 * @property integer $create_time
 * @property integer $update_time
 * @property string $slug
 * @property string $publish_time
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
Yii::import('application.modules.blog.events.*');
Yii::import('application.modules.blog.listeners.*');
Yii::import('application.modules.comment.components.ICommentable');

/**
 * Class Post
 */
class Post extends yupe\models\YModel implements ICommentable
{
    /**
     *
     */
    const STATUS_DRAFT = 0;
    /**
     *
     */
    const STATUS_PUBLISHED = 1;
    /**
     *
     */
    const STATUS_SCHEDULED = 2;
    /**
     *
     */
    const STATUS_MODERATED = 3;

    /**
     *
     */
    const STATUS_DELETED = 4;

    /**
     *
     */
    const ACCESS_PUBLIC = 1;
    /**
     *
     */
    const ACCESS_PRIVATE = 2;

    /**
     *
     */
    const COMMENT_YES = 1;
    /**
     *
     */
    const COMMENT_NO = 0;

    /**
     * @var  string|array tags list
     */
    public $tags;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return Post   the static model class
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
        return [
            ['blog_id, slug,  title, content, status, publish_time', 'required', 'except' => 'search'],
            [
                'blog_id, create_user_id, update_user_id, status, comment_status, access_type, create_time, update_time, category_id',
                'numerical',
                'integerOnly' => true
            ],
            [
                'blog_id, create_user_id, update_user_id, create_time, update_time, status, comment_status, access_type',
                'length',
                'max' => 11
            ],
            ['lang', 'length', 'max' => 2],
            ['publish_time', 'length', 'max' => 20],
            ['slug', 'length', 'max' => 150],
            ['image', 'length', 'max' => 300],
            ['create_user_ip', 'length', 'max' => 20],
            ['description, title, link, keywords', 'length', 'max' => 250],
            ['quote', 'filter', 'filter' => 'trim'],
            ['link', 'yupe\components\validators\YUrlValidator'],
            ['comment_status', 'in', 'range' => array_keys($this->getCommentStatusList())],
            ['access_type', 'in', 'range' => array_keys($this->getAccessTypeList())],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('BlogModule.blog', 'Forbidden symbols in {attribute}')
            ],
            [
                'title, slug, link, keywords, description, publish_time',
                'filter',
                'filter' => [$obj = new CHtmlPurifier(), 'purify']
            ],
            ['slug', 'unique'],
            ['tags', 'safe'],
            ['tags', 'default', 'value' => []],
            [
                'id, blog_id, create_user_id, update_user_id, create_time, update_time, slug, publish_time, title, quote, content, link, status, comment_status, access_type, keywords, description, lang',
                'safe',
                'on' => 'search'
            ],
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
            'createUser'    => [self::BELONGS_TO, 'User', 'create_user_id'],
            'updateUser'    => [self::BELONGS_TO, 'User', 'update_user_id'],
            'blog'          => [self::BELONGS_TO, 'Blog', 'blog_id'],
            'comments'      => [
                self::HAS_MANY,
                'Comment',
                'model_id',
                'on'     => 'model = :model AND comments.status = :status and level > 1',
                'params' => [
                    ':model'  => 'Post',
                    ':status' => Comment::STATUS_APPROVED
                ],
                'order'  => 'comments.id'
            ],
            'commentsCount' => [
                self::STAT,
                'Comment',
                'model_id',
                'condition' => 'model = :model AND status = :status AND level > 1',
                'params'    => [
                    ':model'  => 'Post',
                    ':status' => Comment::STATUS_APPROVED
                ]
            ],
            'category'      => [self::BELONGS_TO, 'Category', 'category_id']
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.status = :status',
                'params'    => [':status' => self::STATUS_PUBLISHED],
            ],
            'public'    => [
                'condition' => 't.access_type = :access_type',
                'params'    => [':access_type' => self::ACCESS_PUBLIC],
            ],
            'moderated' => [
                'condition' => 't.status = :status',
                'params'    => [':status' => self::STATUS_MODERATED]
            ],
            'recent'    => [
                'order' => 'publish_time DESC'
            ]
        ];
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
            [
                'limit' => $count,
            ]
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
            [
                'order' => $this->getTableAlias() . '.publish_time ' . $typeSort,
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
            'id'             => Yii::t('BlogModule.blog', 'id'),
            'blog_id'        => Yii::t('BlogModule.blog', 'Blog'),
            'create_user_id' => Yii::t('BlogModule.blog', 'Created'),
            'update_user_id' => Yii::t('BlogModule.blog', 'Update user'),
            'create_time'    => Yii::t('BlogModule.blog', 'Created at'),
            'update_time'    => Yii::t('BlogModule.blog', 'Updated at'),
            'publish_time'   => Yii::t('BlogModule.blog', 'Date'),
            'slug'           => Yii::t('BlogModule.blog', 'Url'),
            'title'          => Yii::t('BlogModule.blog', 'Title'),
            'quote'          => Yii::t('BlogModule.blog', 'Quote'),
            'content'        => Yii::t('BlogModule.blog', 'Content'),
            'link'           => Yii::t('BlogModule.blog', 'Link'),
            'status'         => Yii::t('BlogModule.blog', 'Status'),
            'comment_status' => Yii::t('BlogModule.blog', 'Comments'),
            'access_type'    => Yii::t('BlogModule.blog', 'Access'),
            'keywords'       => Yii::t('BlogModule.blog', 'Keywords'),
            'description'    => Yii::t('BlogModule.blog', 'description'),
            'tags'           => Yii::t('BlogModule.blog', 'Tags'),
            'image'          => Yii::t('BlogModule.blog', 'Image'),
            'category_id'    => Yii::t('BlogModule.blog', 'Category')
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

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('blog_id', $this->blog_id);
        $criteria->compare('t.create_user_id', $this->create_user_id, true);
        $criteria->compare('t.update_user_id', $this->update_user_id, true);
        $criteria->compare('t.create_time', $this->create_time);
        $criteria->compare('t.update_time', $this->update_time);
        $criteria->compare('t.slug', $this->slug, true);
        if ($this->publish_time) {
            $criteria->compare('DATE(from_unixtime(publish_time))', date('Y-m-d', strtotime($this->publish_time)));
        }
        $criteria->compare('title', $this->title, true);
        $criteria->compare('quote', $this->quote, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('comment_status', $this->comment_status);
        $criteria->compare('access_type', $this->access_type);
        $criteria->compare('t.category_id', $this->category_id, true);

        $criteria->with = ['createUser', 'updateUser', 'blog'];

        return new CActiveDataProvider(
            'Post', [
                'criteria' => $criteria,
                'sort'     => [
                    'defaultOrder' => 't.publish_time DESC, t.id DESC',
                ]
            ]
        );
    }

    /**
     * @return CActiveDataProvider
     */
    public function allPosts()
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition('t.status = :status');
        $criteria->addCondition('t.access_type = :access_type');
        $criteria->params = [
            ':status'      => self::STATUS_PUBLISHED,
            ':access_type' => self::ACCESS_PUBLIC
        ];
        $criteria->with = ['blog', 'createUser', 'commentsCount'];
        $criteria->order = 'publish_time DESC';

        return new CActiveDataProvider(
            'Post', ['criteria' => $criteria]
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $module = Yii::app()->getModule('blog');

        return [
            'CTimestampBehavior' => [
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
            ],
            'tags'               => [
                'class'                => 'vendor.yiiext.taggable-behavior.EARTaggableBehavior',
                'tagTable'             => Yii::app()->db->tablePrefix . 'blog_tag',
                'tagBindingTable'      => Yii::app()->db->tablePrefix . 'blog_post_to_tag',
                'tagModel'             => 'Tag',
                'modelTableFk'         => 'post_id',
                'tagBindingTableTagId' => 'tag_id',
                'cacheID'              => 'cache',
            ],
            'imageUpload'        => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
            ],
            'seo'                => [
                'class'  => 'vendor.chemezov.yii-seo.behaviors.SeoActiveRecordBehavior',
                'route'  => '/blog/post/view',
                'params' => [
                    'slug' => function ($data) {
                        return $data->slug;
                    }
                ],
            ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->publish_time = strtotime($this->publish_time);

        $this->update_user_id = Yii::app()->user->getId();

        if ($this->getIsNewRecord()) {
            $this->create_user_id = $this->update_user_id;
            $this->create_user_ip = Yii::app()->getRequest()->userHostAddress;
        }

        $this->setTags($this->tags);

        return parent::beforeSave();
    }

    /**
     *
     */
    public function afterDelete()
    {
        Comment::model()->deleteAll(
            'model = :model AND model_id = :model_id',
            [
                ':model'    => 'Post',
                ':model_id' => $this->id
            ]
        );

        parent::afterDelete();
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->title);
        }

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT     => Yii::t('BlogModule.blog', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('BlogModule.blog', 'Published'),
            self::STATUS_SCHEDULED => Yii::t('BlogModule.blog', 'Scheduled'),
            self::STATUS_MODERATED => Yii::t('BlogModule.blog', 'Moderated'),
            self::STATUS_DELETED   => Yii::t('BlogModule.blog', 'Deleted')
        ];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*unknown*');
    }

    /**
     * @return array
     */
    public function getAccessTypeList()
    {
        return [
            self::ACCESS_PRIVATE => Yii::t('BlogModule.blog', 'Private'),
            self::ACCESS_PUBLIC  => Yii::t('BlogModule.blog', 'Public'),
        ];
    }

    /**
     * @return string
     */
    public function getAccessType()
    {
        $data = $this->getAccessTypeList();

        return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('BlogModule.blog', '*unknown*');
    }

    /**
     * @return string
     */
    public function getCommentStatus()
    {
        $data = $this->getCommentStatusList();

        return isset($data[$this->comment_status]) ? $data[$this->comment_status] : Yii::t(
            'BlogModule.blog',
            '*unknown*'
        );
    }

    /**
     * @return array
     */
    public function getCommentStatusList()
    {
        return [
            self::COMMENT_NO  => Yii::t('BlogModule.blog', 'Forbidden'),
            self::COMMENT_YES => Yii::t('BlogModule.blog', 'Allowed'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $this->tags = $this->getTags();
        $this->publish_time = date('d-m-Y H:i', $this->publish_time);

        parent::afterFind();
    }

    /**
     * @param int $limit
     * @return string
     */
    public function getQuote($limit = 500)
    {
        return $this->quote
            ?: yupe\helpers\YText::characterLimiter(
                $this->content,
                (int)$limit
            );
    }

    /**
     * @param null $blogId
     * @param int $cache
     * @return mixed
     */
    public function getArchive($blogId = null, $cache = 3600)
    {
        $data = Yii::app()->getCache()->get("Blog::Post::archive::{$blogId}");

        if (false === $data) {

            $criteria = new CDbCriteria();

            if ($blogId) {
                $criteria->condition = 'blog_id = :blog_id';
                $criteria->params = [
                    ':blog_id' => (int)$blogId
                ];
            }

            $models = $this->public()->published()->recent()->findAll($criteria);

            if (!empty($models)) {

                foreach ($models as $model) {

                    list($day, $month, $year) = explode('-', date('d-m-Y', strtotime($model->publish_time)));

                    $data[$year][$month][] = [
                        'title'        => $model->title,
                        'slug'         => $model->slug,
                        'publish_time' => $model->publish_time,
                        'quote'        => $model->getQuote()
                    ];
                }
            } else {
                $data = [];
            }

            Yii::app()->getCache()->set("Blog::Post::archive::{$blogId}", $data, (int)$cache);
        }

        return $data;
    }

    /**
     * @param int $limit
     * @param $cacheTime
     * @return mixed
     */
    public function getStream($limit = 10, $cacheTime)
    {
        $data = Yii::app()->cache->get('Blog::Post::Stream');

        if (false === $data) {
            $data = Yii::app()->db->createCommand()
                ->select('p.title, p.slug, max(c.create_time) comment_date, count(c.id) as commentsCount')
                ->from('{{comment_comment}} c')
                ->join('{{blog_post}} p', 'c.model_id = p.id')
                ->where(
                    'c.model = :model AND p.status = :status AND c.status = :commentstatus AND c.id <> c.root',
                    [
                        ':model'         => 'Post',
                        ':status'        => Post::STATUS_PUBLISHED,
                        ':commentstatus' => Comment::STATUS_APPROVED
                    ]
                )
                ->group('c.model, c.model_id, p.title, p.slug')
                ->order('comment_date DESC')
                ->having('count(c.id) > 0')
                ->limit((int)$limit)
                ->queryAll();

            Yii::app()->cache->set('Blog::Post::Stream', $data, (int)$cacheTime);
        }

        return $data;
    }

    /**
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function get($id, array $with = [])
    {
        if (is_int($id)) {
            return Post::model()->public()->published()->with($with)->findByPk($id);
        }

        return Post::model()->public()->published()->with($with)->find(
            't.slug = :slug',
            [
                ':slug' => $id
            ]
        );
    }

    /**
     * @param $tag
     * @param array $with
     * @return mixed
     */
    public function getByTag($tag, array $with = ['blog', 'createUser', 'commentsCount'])
    {
        return Post::model()->with($with)
            ->published()
            ->public()
            ->sortByPubDate('DESC')
            ->taggedWith($tag)->findAll();
    }

    /**
     * @param $blogId
     * @return Post
     */
    public function getForBlog($blogId)
    {
        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->blog_id = (int)$blogId;
        $posts->status = Post::STATUS_PUBLISHED;
        $posts->access_type = Post::ACCESS_PUBLIC;

        return $posts;
    }

    /**
     * @param $categoryId
     * @return Post
     */
    public function getForCategory($categoryId)
    {
        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->category_id = (int)$categoryId;
        $posts->status = Post::STATUS_PUBLISHED;
        $posts->access_type = Post::ACCESS_PUBLIC;

        return $posts;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return Yii::app()->db->createCommand()
            ->select('cc.name, bp.category_id, count(bp.id) cnt, cc.slug, cc.description')
            ->from('yupe_blog_post bp')
            ->join('yupe_category_category cc', 'bp.category_id = cc.id')
            ->where('bp.category_id IS NOT NULL')
            ->group('bp.category_id')
            ->having('cnt > 0')
            ->order('cnt DESC')
            ->queryAll();
    }

    /**
     * @return int|mixed
     */
    public function getCommentCount()
    {
        return $this->commentsCount > 0 ? $this->commentsCount : 0;
    }

    /**
     * @param array $post
     * @param $tags
     * @return bool
     */
    public function createPublicPost(array $post)
    {
        if (empty($post['blog_id']) || empty($post['user_id'])) {
            $this->addError('blog_id', Yii::t('BlogModule.blog', "Blog is empty!"));

            return false;
        }

        $blog = Blog::model()->get((int)$post['blog_id'], []);

        if (null === $blog) {
            $this->addError('blog_id', Yii::t('BlogModule.blog', "You can't write in this blog!"));

            return false;
        }

        if ($blog->isPrivate() && !$blog->isOwner($post['user_id'])) {
            $this->addError('blog_id', Yii::t('BlogModule.blog', "You can't write in this blog!"));

            return false;
        }

        if (!$blog->isPrivate() && !$blog->userIn($post['user_id'])) {
            $this->addError('blog_id', Yii::t('BlogModule.blog', "You can't write in this blog!"));

            return false;
        }

        $this->setAttributes($post);
        $this->setTags($post['tags']);
        $this->publish_time = date('d-m-Y h:i');
        $this->status = $post['status'] == self::STATUS_DRAFT ? self::STATUS_DRAFT : $blog->post_status;

        return $this->save();
    }

    /**
     * @param $user
     * @return Post
     */
    public function getForUser($user)
    {
        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->create_user_id = (int)$user;

        return $posts;
    }

    /**
     * @param $postId
     * @param $userId
     * @return int
     */
    public function deleteUserPost($postId, $userId)
    {
        return $this->updateAll(
            ['status' => self::STATUS_DELETED],
            'create_user_id = :userId AND id = :id AND status != :status',
            [
                ':userId' => (int)$userId,
                ':id'     => (int)$postId,
                ':status' => self::STATUS_PUBLISHED
            ]
        );
    }

    /**
     * @param $postId
     * @param $userId
     * @return CActiveRecord
     */
    public function findUserPost($postId, $userId)
    {
        return $this->find(
            'id = :id AND create_user_id = :userId AND status != :status',
            [
                ':userId' => (int)$userId,
                ':id'     => (int)$postId,
                ':status' => self::STATUS_PUBLISHED
            ]
        );
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return Yii::app()->createAbsoluteUrl('/blog/post/view/', ['slug' => $this->slug]);
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }

    /**
     * @return bool
     */
    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    /**
     * @return bool
     */
    public function publish()
    {
        $transaction = Yii::app()->db->beginTransaction();

        try {
            $this->status = self::STATUS_PUBLISHED;
            $this->publish_time = date('d-m-Y h:i');
            if ($this->save()) {
                Yii::app()->eventManager->fire(
                    BlogEvents::POST_PUBLISH,
                    new PostPublishEvent($this, Yii::app()->getUser())
                );
            }
            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);

            return true;
        }
    }

}
