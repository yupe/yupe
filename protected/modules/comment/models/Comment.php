<?php

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
 * @property integer $parent_id
 *
 * @category YupeModels
 * @package  yupe.modules.comment.model
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 */

use application\modules\comment\components\NewCommentEvent;

class Comment extends yupe\models\YModel
{
    const STATUS_NEED_CHECK = 0;

    const STATUS_APPROVED   = 1;

    const STATUS_SPAM    = 2;

    const STATUS_DELETED = 3;

    public $verifyCode;

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
            array('url', 'yupe\components\validators\YUrlValidator'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('verifyCode', 'yupe\components\validators\YRequiredValidator', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => !$module->showCaptcha || Yii::app()->user->isAuthenticated()),
            array('id, model, model_id, creation_date, name, email, url, text, status, ip, parent_id', 'safe', 'on' => 'search'),
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
            'id' => Yii::t('CommentModule.comment', 'ID'),
            'model' => Yii::t('CommentModule.comment', 'Model type'),
            'model_id' => Yii::t('CommentModule.comment', 'Model'),
            'creation_date' => Yii::t('CommentModule.comment', 'Created at'),
            'name' => Yii::t('CommentModule.comment', 'Name'),
            'email' => Yii::t('CommentModule.comment', 'Email'),
            'url' => Yii::t('CommentModule.comment', 'Site'),
            'text' => Yii::t('CommentModule.comment', 'Comment'),
            'status' => Yii::t('CommentModule.comment', 'Status'),
            'verifyCode' => Yii::t('CommentModule.comment', 'Verification code'),
            'ip' => Yii::t('CommentModule.comment', 'IP address'),
            'parent_id' => Yii::t('CommentModule.comment', 'Parent'),
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
            'new' => array(
                'condition' => 't.status = :status',
                'params' => array(':status' => self::STATUS_NEED_CHECK),
            ),
            'approved' => array(
                'condition' => 't.status = :status',
                'params' => array(':status' => self::STATUS_APPROVED),
                'order' => 't.creation_date DESC',
            ),
            'authored' => array(
                'condition' => 't.user_id is not null',
            ),
        );
    }

    public function behaviors()
    {
        return array(
            'NestedSetBehavior'=>array(
                'class'=>'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
                'hasManyRoots'=>true,
            ));
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
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder'=>'id DESC',
             )
        ));
    }

    /**
     * Событие выполняемое перед сохранением модели
     *
     * @return parent::beforeSave()
     **/
    public function beforeSave()
    {
        if ($this->isNewRecord) {            
            $this->creation_date = new CDbExpression('NOW()');
            $this->ip = Yii::app()->getRequest()->userHostAddress;
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
        if ($cache = Yii::app()->getCache()) {
            $cache->delete("Comment{$this->model}{$this->model_id}");
        }
        
        if ($this->isNewRecord) {
            $module = Yii::app()->getModule('comment');
            $notifierComponent = $module->notifier;
            if ($this->level != 1 && $module->notify && ($notifier = new $notifierComponent()) !== false && $notifier instanceof application\modules\comment\components\INotifier) {                 
                $this->onNewComment = array($notifier, 'newComment');
                $this->newComment();
            }
        }

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
            $event->commentOwner = yupe\models\YModel::model($this->model)->findByPk($this->model_id);

            $this->onNewComment($event);

            return $event->isValid;
        }

        return true;
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
            self::STATUS_APPROVED => Yii::t('CommentModule.comment', 'Accepted'),
            self::STATUS_DELETED => Yii::t('CommentModule.comment', 'Deleted'),
            self::STATUS_NEED_CHECK => Yii::t('CommentModule.comment', 'Check'),
            self::STATUS_SPAM => Yii::t('CommentModule.comment', 'Spam'),
        );
    }

    /**
     * Получение статуса по заданному:
     *
     * @return string текст статуса
     **/
    public function getStatus()
    {
        $list = $this->getStatusList();
        return isset($list[$this->status]) ? $list[$this->status] : Yii::t('CommentModule.comment', 'Unknown status');
    }

    /**
     * Получаем автора:
     *
     * @return Comment->author || bool false
     **/
    public function getAuthorName()
    {
        return ($this->author) ? $this->author->nick_name : $this->name;
    }


    public function getAuthorAvatar($size = 32, array $params = array('width' => 32, 'height' => 32))
    {
        if ($this->author) {
            return CHtml::image($this->author->getAvatar((int)$size), $this->author->nick_name, $params);
        }

        return CHtml::image(User::model()->getAvatar((int)$size), $this->name, $params);
    }

    public function getAuthorLink(array $params = array('rel' => 'nofollow'))
    {
        if ($this->author) {
            return CHtml::link($this->name, array('/user/people/userInfo/', 'username' => $this->author->nick_name), $params);
        }

        if ($this->url) {
            return CHtml::link($this->name, $this->url, $params);
        }

        return $this->name;
    }

    public function getAuthorUrl(array $params = array('rel' => 'nofollow'))
    {
        if ($this->author) {
            return Yii::app()->createUrl('/user/people/userInfo/', array('username' => $this->author->nick_name), $params);
        }

        if ($this->url) {
            return Yii::app()->createUrl($this->url, $params);
        }

        return $this->name;
    }

    public function getText()
    {
        return strip_tags($this->text, Yii::app()->getModule('comment')->allowedTags);
    }

    /**
     * Метод проверяет есть ли у данного поста "корень" для комментариев.
     * @param $model
     * @param $model_id
     * @return CActiveRecord Комментарий являющийся корнем дерева комментариев.
     */
    public function getRootOfCommentsTree($model, $model_id)
    {
        return self::model()->findByAttributes(
                    array(
                        "model" => $model,
                        "model_id" => $model_id,
                    ),
                    "id=root"
                );
    }

    public function createRootOfCommentsIfNotExists($model, $model_id)
    {
        $rootNode = $this->getRootOfCommentsTree($model, $model_id);

        if ($rootNode === null){

            $rootAttributes = array(
                "user_id" => Yii::app()->user->getId(),
                "model" => $model,
                "model_id" => $model_id,
                "url" => "",
                "name" => "",
                "email" => "",
                "text" => "",
                "status" => self::STATUS_APPROVED,
                "ip" => Yii::app()->getRequest()->userHostAddress
            );

            $rootNode = new Comment();
            $rootNode->setAttributes($rootAttributes);
            if($rootNode->saveNode(false)){
                return $rootNode;
            }
        }else{
            return $rootNode;
        }

        return false;
    }

    public function getLevel()
    {
        $level = $this->level < 10 ? $this->level - 2 : 10;

        return $level > 0 ? $level : 0;
    }
}
