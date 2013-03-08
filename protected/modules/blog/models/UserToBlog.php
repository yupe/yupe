<?php

/**
 * This is the model class for table "user_to_blog".
 *
 * The followings are the available columns in table 'user_to_blog':
 * @property string $id
 * @property string $user_id
 * @property string $blog_id
 * @property string $create_date
 * @property string $update_date
 * @property integer $role
 * @property integer $status
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Blog $blog
 * @property User $user
 */
class UserToBlog extends YModel
{
    const ROLE_USER      = 1;
    const ROLE_MODERATOR = 2;
    const ROLE_ADMIN     = 3;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK  = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
        return array(
            array('user_id, blog_id', 'required', 'except' => 'search'),
            array('role, status, user_id, blog_id, create_date, update_date', 'numerical', 'integerOnly' => true),
            array('user_id, blog_id, create_date, update_date, role, status', 'length', 'max' => 11),
            array('note', 'length', 'max' => 250),
            array('role', 'in', 'range' => array_keys($this->roleList)),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('note', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('id, user_id, blog_id, create_date, update_date, role, status, note', 'safe', 'on' => 'search'),
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
            'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('BlogModule.blog', 'id'),
            'user_id'     => Yii::t('BlogModule.blog', 'Пользователь'),
            'blog_id'     => Yii::t('BlogModule.blog', 'Блог'),
            'create_date' => Yii::t('BlogModule.blog', 'Дата создания'),
            'update_date' => Yii::t('BlogModule.blog', 'Дата обновления'),
            'role'        => Yii::t('BlogModule.blog', 'Роль'),
            'status'      => Yii::t('BlogModule.blog', 'Статус'),
            'note'        => Yii::t('BlogModule.blog', 'Примечание'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'      => Yii::t('BlogModule.blog', 'Id участника.'),
            'user_id' => Yii::t('BlogModule.blog', 'Выберите пользователя системы, который станет участником блога.'),
            'blog_id' => Yii::t('BlogModule.blog', 'Выберите необходимый блог сайта.'),
            'role'    => Yii::t('BlogModule.blog', 'Установите роль участника блога:<br /><br /><span class="label label-success">Пользователь</span> &ndash; имеет возможность писать записи в блоге и комментировать их.<br /><br /><span class="label label-warning">Модератор</span> &ndash; к правам пользователя добавляется возможность модерировать (удалять, править, блокировать) записи и комментарии, (блокировать, добавлять, удалять) пользователей.<br /><br /><span class="label label-important">Администратор</span> &ndash; к правам модератора добавляется возможность (блокировать, добавлять, удалять) блоги и пользоватилей.'),
            'status'  => Yii::t('BlogModule.blog', 'Установите статус участника блога:<br /><br /><span class="label label-success">Активен</span> &ndash; данный пользователь будет активным участиком.<br /><br /><span class="label label-warning">заблокирован</span> &ndash; данный участнику не будут доступны функции блога.'),
            'note'    => Yii::t('BlogModule.blog', 'Небольшая информация о участнике блога.'),
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('blog_id', $this->blog_id, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('role', $this->role);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('note', $this->note, true);

        $criteria->with = array('user', 'blog');

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
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
        );
    }

    public function getRoleList()
    {
        return array(
            self::ROLE_USER      => Yii::t('BlogModule.blog', 'Пользователь'),
            self::ROLE_MODERATOR => Yii::t('BlogModule.blog', 'Модератор'),
            self::ROLE_ADMIN     => Yii::t('BlogModule.blog', 'Администратор'),
        );
    }

    public function getRole()
    {
        $data = $this->roleList;
        return isset($data[$this->role]) ? $data[$this->role] : Yii::t('BlogModule.blog', '*неизвестно*');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t('BlogModule.blog', 'Активен'),
            self::STATUS_BLOCK  => Yii::t('BlogModule.blog', 'Заблокирован'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('BlogModule.blog', '*неизвестно*');
    }
}