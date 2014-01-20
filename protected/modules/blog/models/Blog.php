<?php

/**
 * Blog
 *
 * Модель для работы с блогами
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "blog".
 *
 * The followings are the available columns in table 'blog':
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $slug
 * @property integer $type
 * @property integer $status
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property integer $category_id
 * @property string  $lang
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property User $updateUser
 * @property Post[] $posts
 */
class Blog extends yupe\models\YModel
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE  = 1;
    const STATUS_DELETED = 2;

    const TYPE_PUBLIC  = 1;
    const TYPE_PRIVATE = 2;
    

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Blog the static model class
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
        return '{{blog_blog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, description, slug', 'required', 'except' => 'search'),
            array('name, description, slug', 'required', 'on' => array('update', 'insert')),
            array('type, status, create_user_id, update_user_id, create_date, update_date, category_id', 'numerical', 'integerOnly' => true),
            array('name, icon', 'length', 'max' => 250),
            array('slug', 'length', 'max' => 150),
            array('lang', 'length', 'max' => 2),
            array('create_user_id, update_user_id, create_date, update_date, status', 'length', 'max' => 11),
            array('slug', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('BlogModule.blog', 'Illegal characters in {attribute}')),
            array('type', 'in', 'range' => array_keys($this->typeList)),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('name, slug, description', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('slug', 'unique'),
            array('id, name, description, slug, type, status, create_user_id, update_user_id, create_date, update_date, lang, category_id', 'safe', 'on' => 'search'),
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
            'createUser'   => array(self::BELONGS_TO, 'User', 'create_user_id'),
            'updateUser'   => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'posts'        => array(self::HAS_MANY, 'Post', 'blog_id'),
            'userToBlog'   => array(self::HAS_MANY, 'UserToBlog', 'blog_id'),
            'members'      => array(self::HAS_MANY, 'User', array('user_id' => 'id'), 'through' => 'userToBlog'),
            'postsCount'   => array(self::STAT, 'Post', 'blog_id', 'condition' => 'status = :status', 'params' => array(':status' => Post::STATUS_PUBLISHED)),
            'membersCount' => array(self::STAT, 'UserToBlog', 'blog_id', 'condition' => 'status = :status', 'params' => array(':status' => UserToBlog::STATUS_ACTIVE)),
            'category'     => array(self::BELONGS_TO,'Category','category_id')
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 't.status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE),
            ),
            'public' => array(
                'condition' => 'type = :type',
                'params'    => array(':type' => self::TYPE_PUBLIC),
            ),
        );
    }

    /**
     * Условие для получения блога по url
     * 
     * @param string $url - url данного блога
     * 
     * @return self
     */
    public function getByUrl($url = null)
    {
        $this->getDbCriteria()->mergeWith(
            array(
                'condition' => $this->getTableAlias() . '.slug = :slug',
                'params' => array(
                    ':slug' => $url,
                ),
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
            'id'             => Yii::t('BlogModule.blog', 'id'),
            'name'           => Yii::t('BlogModule.blog', 'Title'),
            'description'    => Yii::t('BlogModule.blog', 'Description'),
            'icon'           => Yii::t('BlogModule.blog', 'Icon'),
            'slug'           => Yii::t('BlogModule.blog', 'URL'),
            'type'           => Yii::t('BlogModule.blog', 'Type'),
            'status'         => Yii::t('BlogModule.blog', 'Status'),
            'create_user_id' => Yii::t('BlogModule.blog', 'Created'),
            'update_user_id' => Yii::t('BlogModule.blog', 'Updated'),
            'create_date'    => Yii::t('BlogModule.blog', 'Created at'),
            'update_date'    => Yii::t('BlogModule.blog', 'Updated at'),
            'category_id'    => Yii::t('BlogModule.blog', 'Category')
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'          => Yii::t('BlogModule.blog', 'Post id.'),
            'name'        => Yii::t('BlogModule.blog', 'Please enter a title of the blog. For example: <span class="label">My travel notes</span>.'),
            'description' => Yii::t('BlogModule.blog', 'Please enter a short description of the blog. For example:<br /><br /> <pre>Notes on my travel there and back again. Illustrated.</pre>'),
            'icon'        => Yii::t('BlogModule.blog', 'Please choose an icon for the blog.'),
            'slug'        => Yii::t('BlogModule.blog', 'Please enter an URL-friendly name for the blog.<br /><br /> For example: <pre>http://site.ru/blogs/<span class="label">travel-notes</span>/</pre> If you don\'t know how to fill this field you can leave it empty.'),
            'type'        => Yii::t('BlogModule.blog', 'Please choose a type of the blog:<br /><br /><span class="label label-success">public</span> &ndash; anyone can create posts<br /><br /><span class="label label-info">private</span> &ndash; only you can create posts'),
            'status'      => Yii::t('BlogModule.blog', 'Please choose a status of the blog:<br /><br /><span class="label label-success">active</span> &ndash; The blog will be visible and it will be possible to create new records<br /><br /><span class="label label-warning">blocked</span> &ndash; The blog will be visible but it would not be possible to create new records<br /><br /><span class="label label-important">removed</span> &ndash; The blog will be invisible'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('create_user_id', $this->create_user_id, true);
        $criteria->compare('update_user_id', $this->update_user_id, true);
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('create_date', $this->create_date);
        $criteria->compare('update_date', $this->update_date);

        $criteria->with = array('createUser', 'updateUser', 'postsCount', 'membersCount');

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
            'sort' => array(
                'defaultOrder' => 'name ASC',
            )
        ));
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('blog');
        return array(
            'imageUpload' => array(
                'class'         =>'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'icon',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,              
                'uploadPath'    => $module->getUploadPath(),
                'imageNameCallback' => array($this, 'generateFileName'),
                'resize' => array(
                    'quality' => 75,
                    'width' => 64,
                )
            ),
            'CTimestampBehavior' => array(
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_date',
                'updateAttribute'   => 'update_date',
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->name . microtime(true));
    }

    public function beforeSave()
    {
        $this->update_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord) {
            $this->create_user_id = $this->update_user_id;
        }

        return parent::beforeSave();
    }

    public function afterSave()
    {
        /**
         * Если это новая запись - добавляем пользователя
         * который создал блог в его участники
         */
        if ($this->isNewRecord) {
            $this->join();
        }

        return parent::afterSave();
    }

    public function afterDelete()
    {
        Comment::model()->deleteAll(
            'model = :model AND model_id = :model_id', array(
                ':model' => 'Blog',
                ':model_id' => $this->id
            )
        );

        return parent::afterDelete();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_BLOCKED => Yii::t('BlogModule.blog', 'Blocked'),
            self::STATUS_ACTIVE  => Yii::t('BlogModule.blog', 'Active'),
            self::STATUS_DELETED => Yii::t('BlogModule.blog', 'Removed'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_PUBLIC  => Yii::t('BlogModule.blog', 'Public'),
            self::TYPE_PRIVATE => Yii::t('BlogModule.blog', 'Private'),
        );
    }

    public function getType()
    {
        $data = $this->typeList;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function userInBlog($userId = null)
    {
        if (!Yii::app()->user->isAuthenticated()) {
            return false;
        }

        $params = array(
            'user_id' => $userId !== null
                ? $userId
                : Yii::app()->user->getId(),
            'blog_id' => $this->id,
        );

        return ($userToBlog = UserToBlog::model()->find('user_id = :user_id AND blog_id = :blog_id', $params)) !== null
            ? $userToBlog
            : false;
    }

    public function join($userId = null)
    {
        $params = array(
            'user_id' => $userId ? $userId : Yii::app()->user->getId(),
            'blog_id' => $this->id,
        );

        $userToBlog = new UserToBlog;

        if (!$userToBlog->find('user_id = :user_id AND blog_id = :blog_id', $params)) {
            $userToBlog->setAttributes($params);
            return $userToBlog->save();
        }

        return false;
    }

    public function getMembers()
    {
        return UserToBlog::model()->with('user')->findAll(
            'blog_id = :blog_id', array(
                ':blog_id' => $this->id
            )
        );
    }

    public function getImageUrl()
    {
        if ($this->icon) {
            $icon = Yii::app()->baseUrl.'/'. Yii::app()->getModule('yupe')->uploadPath . '/' .
                Yii::app()->getModule('blog')->uploadPath . '/' . $this->icon;
        } else {
            $iconPath = Yii::app()->theme->basePath . '/web/images/blog-default.jpg';
            $icon = Yii::app()->getAssetManager()->publish($iconPath);
        }
        return $icon;
    }

    public function getPosts()
    {
        $posts = new Post('search');
        $posts->unsetAttributes();
        $posts->blog_id = $this->id;
        $posts->status  = Post::STATUS_PUBLISHED;
        $posts->access_type = Post::ACCESS_PUBLIC;
        return $posts;
    }

    public function getList()
    {
        return Blog::model()->published()->findAll(array('order' => 'name ASC'));        
    }
}