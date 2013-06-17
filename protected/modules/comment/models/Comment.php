<?php
/**
 * file of Comment model class:
 *
 * @category YupeModels
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 **/

/**
 * Comment model class:
 *
 * This is the model class for table "Comment".
 *
 * @const    int STATUS_APPROVED    - Принят
 * @const    int STATUS_DELETED     - Удален
 * @const    int STATUS_NEED_CHECK  - Проверка
 * @const    int STATUS_SPAM        - Спам
 *
 * @var      public $verifyCode     - капча
 * @var      public $level          - уровень вложенности комментария
 *
 * @method   public static model    - Returns the static model of the specified AR class.
 * @method   public tableName       - Для получения имени таблицы
 * @method   public rulesСписок     - Правила для валидации полей модели
 * @method   public attributeLabels - Список атрибутов для меток формы
 * @method   public relations       - Список связей данной таблицы
 * @method   public scopes          - Получение группы условий
 * @method   public search          - Retrieves a list of models based on the current search/filter conditions.
 * @method   public beforeSave      - Событие выполняемое перед сохранением модели
 * @method   public afterSave       - Событие, которое вызывается после сохранения модели
 * @method   public afterValidate   - Событие, которое вызывается после валидации модели
 * @method   public newComment      - Добавляем новый комментарий
 * @method   public onNewComment    - Определяем событие на создание нового комментария
 * @method   public getStatusList   - Получение списка статусов
 * @method   public getStatus       - Получение статуса по заданному
 * @method   public getAuthor       - Получаем автора
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
 *
 * @category YupeModels
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 */
class Comment extends YModel
{

    const STATUS_NEED_CHECK = 0;
    const STATUS_APPROVED   = 1;
    const STATUS_SPAM       = 2;
    const STATUS_DELETED    = 3;

    public $verifyCode;
    public $level = 0;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className - инстанс модели
     *
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Имя таблицы в БД:
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{comment_comment}}';
    }

    /**
     * Список правил для валидации полей модели:
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        $module = Yii::app()->getModule('comment');
        return array(
            array('model, name, email, text, url', 'filter', 'filter' => 'trim'),
            array('model, name, email, text, url', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('model, model_id, name, email, text', 'required'),
            array('status, user_id, model_id, parent_id', 'numerical', 'integerOnly' => true),
            array('name, email, url', 'length', 'max' => 150),
            array('model', 'length', 'max' => 100),
            array('ip', 'length', 'max' => 20),
            array('email', 'email'),
            array('url', 'YUrlValidator'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('id, model, model_id, creation_date, name, email, url, text, status, ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Список атрибутов для меток формы:
     *
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

    /**
     * Список связей данной таблицы:
     *
     * @return mixed список связей
     **/
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Получение группы условий:
     *
     * @return mixed список условий
     **/
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
     *
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
        $criteria->compare('parent_id', $this->parent_id, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * Событие выполняемое перед сохранением модели
     *
     * @return parent::beforeSave()
     **/
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->creation_date = YDbMigration::expression('NOW()');
            $this->ip            = Yii::app()->request->userHostAddress;
        }

        
        return parent::beforeSave();
    }

    /**
     * Событие, которое вызывается после сохранения модели:
     *
     * @return parent::afterSave()
     **/
    public function afterSave()
    {
        if ($cache = Yii::app()->getCache())
            $cache->delete("Comment{$this->model}{$this->model_id}");

        return parent::afterSave();
    }

    /**
     * Событие, которое вызывается после валидации модели:
     *
     * @return parent::afterValidate()
     **/
    public function afterValidate()
    {
        return parent::afterValidate();
    }

    /**
     * Добавляем новый комментарий:
     *
     * @return null
     **/
    public function newComment()
    {
        if (($module = Yii::app()->getModule('comment')) && $module->email) {
            /** 
             * Объявляем новое событие
             * и заполняем нужными данными:
             **/
            $event = new NewCommentEvent($this);
            $event->module = $module;
            $event->comment = $this;
            $event->commentOwner = YModel::model($this->model)->findByPk($this->model_id);

            $this->onNewComment($event);
        }

        return $event->isValid;
    }

    /**
     * Определяем событие на создание нового комментария:
     *
     * @param CModelEvent $event - класс события
     *
     * @return null
     **/
    public function onNewComment($event)
    {
        $this->raiseEvent('onNewComment', $event);
    }

    /**
     * Получение списка статусов:
     *
     * @return mixed список статусов
     **/
    public function getStatusList()
    {
        return array(
            self::STATUS_APPROVED   => Yii::t('CommentModule.comment', 'Принят'),
            self::STATUS_DELETED    => Yii::t('CommentModule.comment', 'Удален'),
            self::STATUS_NEED_CHECK => Yii::t('CommentModule.comment', 'Проверка'),
            self::STATUS_SPAM       => Yii::t('CommentModule.comment', 'Спам'),
        );
    }

    /**
     * Получение статуса по заданному:
     *
     * @return string текст статуса
     **/
    public function getStatus()
    {
        $list = $this->statusList;
        return isset($list[$this->status]) ? $list[$this->status] : Yii::t('CommentModule.comment', 'Статус неизвестен');
    }

    /**
     * Получаем автора:
     *
     * @return Comment->author || bool false
     **/
    public function getAuthor()
    {
        return ($this->author) ? $this->author : $this->name;
    }
}