<?php

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
class Blog extends YModel
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
            array('slug', 'YSLugValidator', 'message' => Yii::t('BlogModule.blog', 'Запрещенные символы в поле {attribute}')),
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
                'condition' => 'status = :status',
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
            'name'           => Yii::t('BlogModule.blog', 'Название'),
            'description'    => Yii::t('BlogModule.blog', 'Описание'),
            'icon'           => Yii::t('BlogModule.blog', 'Иконка'),
            'slug'           => Yii::t('BlogModule.blog', 'Урл'),
            'type'           => Yii::t('BlogModule.blog', 'Тип'),
            'status'         => Yii::t('BlogModule.blog', 'Статус'),
            'create_user_id' => Yii::t('BlogModule.blog', 'Создал'),
            'update_user_id' => Yii::t('BlogModule.blog', 'Обновил'),
            'create_date'    => Yii::t('BlogModule.blog', 'Создан'),
            'update_date'    => Yii::t('BlogModule.blog', 'Обновлен'),
            'category_id'    => Yii::t('BlogModule.blog', 'Категория')
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'          => Yii::t('BlogModule.blog', 'Id записи.'),
            'name'        => Yii::t('BlogModule.blog', 'Введите в это поле название блога, например <span class="label">Заметки путешественника</span>.'),
            'description' => Yii::t('BlogModule.blog', 'Кратко опишите блог, о чем вы будете в нем писать? Например:<br /><br /> <pre>Заметки о путешествиях туда и обратно. Фотографии новых мест и описание приключений.</pre>'),
            'icon'        => Yii::t('BlogModule.blog', 'Выберите файл с иконкой, которая будет отображаться рядом с названием блога.'),
            'slug'        => Yii::t('BlogModule.blog', 'Краткое название блога латинскими буквами, используется для формирования адреса блога.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/blogs/<span class="label">zametky-putnika</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, названия блога будет достаточно.'),
            'type'        => Yii::t('BlogModule.blog', 'Выберите тип блога:<br /><br /><span class="label label-success">публиничный</span> &ndash; любой пользователь может создавать посты в этом блоге.<br /><br /><span class="label label-info">личный</span> &ndash; только Вы, как создатель блога, можете создавать посты.'),
            'status'      => Yii::t('BlogModule.blog', 'Установите статус блога:<br /><br /><span class="label label-success">активен</span> &ndash; блог будет отображаться в списке блогов и будет доступен для создания постов.<br /><br /><span class="label label-warning">заблокирован</span> &ndash; блог будет отображаться в списках, но создавать в нем посты будет запрещено.<br /><br /><span class="label label-important">удален</span> &ndash; блог пропадет из списков и будет недоступен.'),
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

        $criteria->compare('id', $this->id, true);
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

        $criteria->with = array('createUser', 'updateUser');

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 10),
        ));
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('blog');
        return array(
            'imageUpload' => array(
                'class'         =>'application.modules.yupe.models.ImageUploadBehavior',
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

        if ($this->isNewRecord)
            $this->create_user_id = $this->update_user_id;

        return parent::beforeSave();
    }

    public function afterSave()
    {
        /**
         * Если это новая запись - добавляем пользователя
         * который создал блог в его участники
         */
        if ($this->isNewRecord)
            $this->join();

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
            self::STATUS_BLOCKED => Yii::t('BlogModule.blog', 'Заблокирован'),
            self::STATUS_ACTIVE  => Yii::t('BlogModule.blog', 'Активен'),
            self::STATUS_DELETED => Yii::t('BlogModule.blog', 'Удален'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_PUBLIC  => Yii::t('BlogModule.blog', 'Публичный'),
            self::TYPE_PRIVATE => Yii::t('BlogModule.blog', 'Личный'),
        );
    }

    public function getType()
    {
        $data = $this->typeList;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function userInBlog($userId = null)
    {
        if (!Yii::app()->user->isAuthenticated())
            return false;

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
        // fix for get default image
        Yii::app()->theme = empty(Yii::app()->theme)
            ? 'default'
            : Yii::app()->theme;

        return $this->icon
            ? Yii::app()->baseUrl . '/' . Yii::app()->getModule('yupe')->uploadPath . '/' .
                   Yii::app()->getModule('blog')->uploadPath . '/' . $this->icon
            : Yii::app()->theme->baseUrl . '/web/images/blog-icon.png';
    }
}