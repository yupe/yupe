<?php

/**
 * UserToBlog
 *
 * Модель для работы с участниками блога
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "user_to_blog".
 *
 * The followings are the available columns in table 'user_to_blog':
 * @property string $id
 * @property string $user_id
 * @property string $blog_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $role
 * @property integer $status
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Blog $blog
 * @property User $user
 */
class UserToBlog extends yupe\models\YModel
{
    const ROLE_USER = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 2;
    const STATUS_DELETED = 3;
    const STATUS_CONFIRMATION = 4;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return UserToBlog the static model class
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
        return '{{blog_user_to_blog}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['user_id, blog_id', 'required', 'except' => 'search'],
            ['role, status, user_id, blog_id, create_time, update_time', 'numerical', 'integerOnly' => true],
            ['user_id, blog_id, create_time, update_time, role, status', 'length', 'max' => 11],
            ['note', 'length', 'max' => 250],
            ['role', 'in', 'range' => array_keys($this->getRoleList())],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['note', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['id, user_id, blog_id, create_time, update_time, role, status, note', 'safe', 'on' => 'search'],
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
            'blog' => [self::BELONGS_TO, 'Blog', 'blog_id'],
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    public function afterSave()
    {
        Yii::app()->cache->delete("Blog::Blog::members::{$this->user_id}");

        return parent::afterSave();
    }

    public function beforeDelete()
    {
        Yii::app()->cache->delete("Blog::Blog::members::{$this->user_id}");

        return parent::beforeDelete();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('BlogModule.blog', 'id'),
            'user_id'     => Yii::t('BlogModule.blog', 'User'),
            'blog_id'     => Yii::t('BlogModule.blog', 'Blog'),
            'create_time' => Yii::t('BlogModule.blog', 'Created at'),
            'update_time' => Yii::t('BlogModule.blog', 'Updated at'),
            'role'        => Yii::t('BlogModule.blog', 'Role'),
            'status'      => Yii::t('BlogModule.blog', 'Status'),
            'note'        => Yii::t('BlogModule.blog', 'Notice'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'      => Yii::t('BlogModule.blog', 'Member Id.'),
            'user_id' => Yii::t('BlogModule.blog', 'Please choose a user which will become the member of the blog'),
            'blog_id' => Yii::t('BlogModule.blog', 'Please choose id of the blog.'),
            'role'    => Yii::t(
                    'BlogModule.blog',
                    'Please choose user role:<br /><br /><span class="label label-success">User</span> &ndash; Can write and comment blog posts.<br /><br /><span class="label label-warning">Moderator</span> &ndash; Can delete, edit or block posts and comments. Can ban, add or remove members.<br /><br /><span class="label label-danger">Administrator</span> &ndash; Can block, add or remove blogs and members.'
                ),
            'status'  => Yii::t(
                    'BlogModule.blog',
                    'Please choose status of the member:<br /><br /><span class="label label-success">Active</span> &ndash; Active member of the blog.<br /><br /><span class="label label-warning">blocked</span> &ndash; Cannot access the blog.'
                ),
            'note'    => Yii::t('BlogModule.blog', 'Short note about the blog member.'),
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('blog_id', $this->blog_id);
        if ($this->create_time) {
            $criteria->compare('DATE(from_unixtime(t.create_time))', date('Y-m-d', strtotime($this->create_time)));
        }
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('role', $this->role);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('note', $this->note);

        $criteria->with = ['user', 'blog'];

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => [
                'defaultOrder' => 't.id DESC'
            ]
        ]);
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
            ],
        ];
    }

    public function getRoleList()
    {
        return [
            self::ROLE_USER      => Yii::t('BlogModule.blog', 'User'),
            self::ROLE_MODERATOR => Yii::t('BlogModule.blog', 'Moderator'),
            self::ROLE_ADMIN     => Yii::t('BlogModule.blog', 'Administrator'),
        ];
    }

    public function getRole()
    {
        $data = $this->getRoleList();

        return isset($data[$this->role]) ? $data[$this->role] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE       => Yii::t('BlogModule.blog', 'Active'),
            self::STATUS_BLOCK        => Yii::t('BlogModule.blog', 'Blocked'),
            self::STATUS_DELETED      => Yii::t('BlogModule.blog', 'Deleted'),
            self::STATUS_CONFIRMATION => Yii::t('BlogModule.blog', 'Confirmation')
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*unknown*');
    }

    public function isDeleted()
    {
        return $this->status == self::STATUS_DELETED;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isConfirmation()
    {
        return $this->status === self::STATUS_CONFIRMATION;
    }

    public function activate()
    {
        $this->status = self::STATUS_ACTIVE;

        return $this;
    }

}
