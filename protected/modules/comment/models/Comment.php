<?php
/**
 * This is the model class for table "Comment".
 *
 * The followings are the available columns in table 'Comment':
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property string $creation_date
 * @property string $name
 * @property string $email
 * @property string $url
 * @property string $text
 * @property integer $status
 * @property string $ip
 * @property string $user_id
 */
class Comment extends YModel
{

    const STATUS_NEED_CHECK = 0;
    const STATUS_APPROVED   = 1;
    const STATUS_SPAM       = 2;
    const STATUS_DELETED    = 3;

    public $verifyCode;

    /**
     * Модель-владелец комментария
     *
     * @var YModel
     */
    protected $ownerModel = null;

    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
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
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {        
        return array(
            array('model, name, email, text, url', 'filter', 'filter' => 'trim'),
            array('model, name, email, text, url', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('model, model_id, name, email, text', 'required'),
            array('status, user_id, model_id, parrent_id', 'numerical', 'integerOnly' => true),
            array('name, email, url', 'length', 'max' => 150),
            array('model', 'length', 'max' => 50),
            array('ip', 'length', 'max' => 20),
            array('email', 'email'),
            array('url', 'url'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => Yii::app()->user->isAuthenticated()),
            array('id, model, model_id, creation_date, name, email, url, text, status, ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('CommentModule.comment', 'ID'),
            'model'         => Yii::t('CommentModule.comment', 'Тип модели'),
            'model_id'      => Yii::t('CommentModule.comment', 'Модель'),
            'creation_date' => Yii::t('CommentModule.comment', 'Дата создания'),
            'name'          => Yii::t('CommentModule.comment', 'Имя'),
            'email'         => Yii::t('CommentModule.comment', 'Email'),
            'url'           => Yii::t('CommentModule.comment', 'Сайт'),
            'text'          => Yii::t('CommentModule.comment', 'Текст'),
            'status'        => Yii::t('CommentModule.comment', 'Статус'),
            'verifyCode'    => Yii::t('CommentModule.comment', 'Код проверки'),
            'ip'            => Yii::t('CommentModule.comment', 'IP адрес'),
        );
    }

    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function scopes()
    {
        return array(
            'new'      => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_NEED_CHECK),
            ),
            'approved' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_APPROVED),
                'order'     => 'creation_date DESC',
            ),
            'authored' => array(
                'condition' => 'user_id is not null',
            ),
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
        $criteria->compare('model', $this->model, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('parrent_id', $this->parrent_id, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');
            $this->ip            = Yii::app()->request->userHostAddress;
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($cache = Yii::app()->getCache())
            $cache->delete("Comment{$this->model}{$this->model_id}");

        return parent::afterSave();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_APPROVED   => Yii::t('CommentModule.comment', 'Принят'),
            self::STATUS_DELETED    => Yii::t('CommentModule.comment', 'Удален'),
            self::STATUS_NEED_CHECK => Yii::t('CommentModule.comment', 'Проверка'),
            self::STATUS_SPAM       => Yii::t('CommentModule.comment', 'Спам'),
        );
    }

    public function getStatus()
    {
        $list = $this->statusList;
        return isset($list[$this->status]) ? $list[$this->status] : Yii::t('CommentModule.comment', 'Статус неизвестен');
    }

    public function getAuthor()
    {
        return ($this->author) ? $this->author : false;
    }

    /**
     * Загрузка модели к которой прикреплен комментарий
     *
     * return YModel
     */
    public function getOwnerModel()
    {
        if( empty($this->ownerModel) )
        {
            $this->loadExtraModels();

            $className = $this->model;
            $this->ownerModel = $className::model()->findByPk($this->model_id);
        }

        return $this->ownerModel;
    }

    /**
     * Загрузка дополнительных моделей для получения владельца комментария
     */
    protected function loadExtraModels()
    {
        Yii::import('application.modules.blog.models.*');
    }
}