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
 * @var      public $verifyCode - капча
 * @var      public $level - уровень вложенности комментария
 *
 * The followings are the available columns in table 'Comment':
 * @property string $id
 * @property string $model
 * @property string $model_id
 * @property string $create_time
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
class Comment extends yupe\models\YModel
{
    const STATUS_NEED_CHECK = 0;

    const STATUS_APPROVED = 1;

    const STATUS_SPAM = 2;

    const STATUS_DELETED = 3;

    public $verifyCode;

    public $spamField;

    public $comment;

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

        return [
            ['model, name, email, text, url', 'filter', 'filter' => 'trim'],
            ['model, name, email, url', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['text', 'purifyText'],
            ['model, model_id, name, email, text', 'required'],
            ['status, user_id, model_id, parent_id', 'numerical', 'integerOnly' => true],
            ['name, email, url, comment', 'length', 'max' => 150],
            ['model', 'length', 'max' => 100],
            ['ip', 'length', 'max' => 20],
            ['email', 'email'],
            ['url', 'yupe\components\validators\YUrlValidator'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            [
                'verifyCode',
                'yupe\components\validators\YRequiredValidator',
                'allowEmpty' => !$module->showCaptcha || Yii::app()->getUser()->isAuthenticated()
            ],
            [
                'verifyCode',
                'captcha',
                'allowEmpty' => !$module->showCaptcha || Yii::app()->getUser()->isAuthenticated(),
                'captchaAction' => '/comment/comment/captcha',
            ],
            [
                'id, model, model_id, create_time, name, email, url, text, status, ip, parent_id',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function purifyText($attribute, $params)
    {
        $module = Yii::app()->getModule('comment');
        $p = new CHtmlPurifier();
        $p->options = [
            'HTML.Allowed' => $module->allowedTags,
        ];
        $this->$attribute = $p->purify($this->$attribute);
    }

    /**
     * Список атрибутов для меток формы:
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('CommentModule.comment', 'ID'),
            'model' => Yii::t('CommentModule.comment', 'Model type'),
            'model_id' => Yii::t('CommentModule.comment', 'Model'),
            'create_time' => Yii::t('CommentModule.comment', 'Created at'),
            'name' => Yii::t('CommentModule.comment', 'Name'),
            'email' => Yii::t('CommentModule.comment', 'Email'),
            'url' => Yii::t('CommentModule.comment', 'Site'),
            'text' => Yii::t('CommentModule.comment', 'Comment'),
            'status' => Yii::t('CommentModule.comment', 'Status'),
            'verifyCode' => Yii::t('CommentModule.comment', 'Verification code'),
            'ip' => Yii::t('CommentModule.comment', 'IP address'),
            'parent_id' => Yii::t('CommentModule.comment', 'Parent'),
        ];
    }

    /**
     * Список связей данной таблицы:
     *
     * @return mixed список связей
     **/
    public function relations()
    {
        return [
            'author' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * Получение группы условий:
     *
     * @return mixed список условий
     **/
    public function scopes()
    {
        return [
            'new' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_NEED_CHECK],
            ],
            'approved' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_APPROVED],
                'order' => 't.create_time DESC',
            ],
            'authored' => [
                'condition' => 't.user_id is not null',
            ],
            'all' => [
                'condition' => 'level <> 1'
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'NestedSetBehavior' => [
                'class' => 'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
                'hasManyRoots' => true,
            ]
        ];
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

        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('model_id', $this->model_id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);
        $criteria->addCondition('level <> 1');

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'id DESC',
            ]
        ]);
    }

    /**
     * Событие выполняемое перед сохранением модели
     *
     * @return parent::beforeSave()
     **/
    public function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->create_time = new CDbExpression('NOW()');
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
        Yii::app()->eventManager->fire(
            CommentEvents::AFTER_SAVE_COMMENT,
            new CommentEvent($this, Yii::app()->getUser(), Yii::app()->getModule('comment'))
        );

        return parent::afterSave();
    }

    /**
     * Получение списка статусов:
     *
     * @return mixed список статусов
     **/
    public function getStatusList()
    {
        return [
            self::STATUS_APPROVED => Yii::t('CommentModule.comment', 'Accepted'),
            self::STATUS_DELETED => Yii::t('CommentModule.comment', 'Deleted'),
            self::STATUS_NEED_CHECK => Yii::t('CommentModule.comment', 'Check'),
            self::STATUS_SPAM => Yii::t('CommentModule.comment', 'Spam'),
        ];
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

    public function getAuthorAvatar($size = 32, array $params = ['width' => 32, 'height' => 32])
    {
        if ($this->author) {
            return CHtml::image($this->author->getAvatar((int)$size), $this->author->nick_name, $params);
        }

        return CHtml::image(Yii::app()->getModule('user')->defaultAvatar, $this->name, $params);
    }

    public function getAuthorLink(array $params = ['rel' => 'nofollow'])
    {
        if ($this->author) {
            return CHtml::link(
                $this->name,
                ['/user/people/userInfo/', 'username' => $this->author->nick_name],
                $params
            );
        }

        if ($this->url) {
            return CHtml::link($this->name, $this->url, $params);
        }

        return $this->name;
    }

    public function getAuthorUrl(array $params = ['rel' => 'nofollow'])
    {
        if ($this->author) {
            return Yii::app()->createUrl(
                '/user/people/userInfo/',
                ['username' => $this->author->nick_name],
                $params
            );
        }

        if ($this->url) {
            return Yii::app()->createUrl($this->url, $params);
        }

        return null;
    }

    public function getText()
    {
        return (Yii::app()->getModule('comment')->stripTags)
            ? strip_tags($this->text)
            : $this->text;
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
            [
                "model" => $model,
                "model_id" => $model_id,
            ],
            "id=root"
        );
    }

    public function createRootOfCommentsIfNotExists($model, $model_id)
    {
        $rootNode = $this->getRootOfCommentsTree($model, $model_id);

        if ($rootNode === null) {

            $rootAttributes = [
                "user_id" => Yii::app()->getUser()->getId(),
                "model" => $model,
                "model_id" => $model_id,
                "url" => "",
                "name" => "",
                "email" => "",
                "text" => "",
                "status" => self::STATUS_APPROVED,
                "ip" => Yii::app()->getRequest()->userHostAddress
            ];

            $rootNode = new Comment();
            $rootNode->setAttributes($rootAttributes);
            if ($rootNode->saveNode(false)) {
                return $rootNode;
            }
        } else {
            return $rootNode;
        }

        return false;
    }

    public function getLevel()
    {
        $level = $this->level < 10 ? $this->level - 2 : 10;

        return $level > 0 ? $level : 0;
    }

    public function getTarget(array $with = [])
    {
        if (!class_exists($this->model)) {
            return $this->model;
        }

        $model = CActiveRecord::model($this->model);

        if ($model instanceof ICommentable) {

            $model = $model->with($with)->findByPk($this->model_id);

            if (null === $model) {
                return $this->model;
            }

            return $model;
        }

        return $this->model;
    }

    public function getTargetTitle()
    {
        $target = $this->getTarget();

        if (is_object($target)) {
            return $target->getTitle();
        }

        return $this->model;
    }

    public function getTargetTitleLink(array $options = null)
    {
        $target = $this->getTarget();

        if (is_object($target)) {
            return CHtml::link($target->getTitle(), $target->getLink(), $options);
        }

        return $target;
    }

    public function isApproved()
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function hasParent()
    {
        return $this->parent_id;
    }

    public function getParent($cache = 3600)
    {
        return $this->cache((int)$cache)->findByPk($this->parent_id);
    }

    public function multiDelete(array $items)
    {
        $count = 0;

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $items = array_filter($items, 'intval');

            $models = $this->findAllByPk($items);

            foreach ($models as $model) {

                Yii::app()->eventManager->fire(
                    CommentEvents::AFTER_DELETE_COMMENT,
                    new CommentEvent($model, Yii::app()->getUser(), Yii::app()->getModule('comment'))
                );

                if(!$model->getIsDeletedRecord()) {
                    $count += (int)$model->deleteNode();
                }
            }

            $transaction->commit();

        } catch (Exception $e) {
            $transaction->rollback();
            Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
        }

        return $count;
    }

    public function approve()
    {
        $this->status = self::STATUS_APPROVED;
        return $this->saveNode();
    }
}
