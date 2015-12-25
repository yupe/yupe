<?php
/**
 * Page модель
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.models
 * @since 1.0
 *
 */

/**
 * This is the model class for table "Page".
 *
 * The followings are the available columns in table 'Page':
 * @property integer $id
 * @property string $parent_id
 * @property integer $category_id
 * @property string $create_time
 * @property string $update_time
 * @property string $title
 * @property string $title_short
 * @property string $slug
 * @property string $lang
 * @property string $body
 * @property string $keywords
 * @property string $description
 * @property integer $status
 * @property integer $is_protected
 * @property integer $user_id
 * @property integer $change_user_id
 * @property integer $order
 * @property string  $layout
 * @property string  $view
 */
class Page extends yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO = false;
    const PROTECTED_YES = true;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Page the static model class
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
        return '{{page_page}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, slug, body, lang', 'required', 'on' => ['update', 'insert']],
            ['status, is_protected, order', 'numerical', 'integerOnly' => true, 'on' => ['update', 'insert']],
            ['parent_id, category_id', 'numerical', 'integerOnly' => true, 'allowEmpty' => true],
            ['parent_id, category_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['lang', 'length', 'max' => 2],
            ['lang', 'default', 'value' => Yii::app()->sourceLanguage],
            ['title_short, slug', 'length', 'max' => 150],
            ['title, keywords, description, layout, view', 'length', 'max' => 250],
            ['slug', 'yupe\components\validators\YUniqueSlugValidator'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['is_protected', 'in', 'range' => array_keys($this->getProtectedStatusList())],
            ['title, title_short, slug, body, description, keywords', 'filter', 'filter' => 'trim'],
            ['title, title_short, slug, description, keywords', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['slug', 'yupe\components\validators\YSLugValidator'],
            [
                'lang',
                'match',
                'pattern' => '/^[a-z]{2}$/',
                'message' => Yii::t('PageModule.page', 'Bad characters in {attribute} field')
            ],
            [
                'lang, id, parent_id, create_time, update_time, title, title_short, slug, body, keywords, description, status, order, lang',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
            ],
            'seo' => [
                'class' => 'vendor.chemezov.yii-seo.behaviors.SeoActiveRecordBehavior',
                'route' => '/page/page/view',
                'params' => [
                    'slug' => function ($data) {
                        return $data->slug;
                    }
                ],
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'childPages'   => [self::HAS_MANY, 'Page', 'parent_id'],
            'parentPage'   => [self::BELONGS_TO, 'Page', 'parent_id'],
            'author'       => [self::BELONGS_TO, 'User', 'user_id'],
            'changeAuthor' => [self::BELONGS_TO, 'User', 'change_user_id'],
            'category'     => [self::BELONGS_TO, 'Category', 'category_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('PageModule.page', 'Id'),
            'parent_id'      => Yii::t('PageModule.page', 'Parent'),
            'category_id'    => Yii::t('PageModule.page', 'Category'),
            'create_time'  => Yii::t('PageModule.page', 'Created at'),
            'update_time'    => Yii::t('PageModule.page', 'Changed'),
            'title'          => Yii::t('PageModule.page', 'Title'),
            'title_short'    => Yii::t('PageModule.page', 'Short title'),
            'slug'           => Yii::t('PageModule.page', 'Url'),
            'lang'           => Yii::t('PageModule.page', 'Language'),
            'body'           => Yii::t('PageModule.page', 'Text'),
            'keywords'       => Yii::t('PageModule.page', 'Keywords (SEO)'),
            'description'    => Yii::t('PageModule.page', 'Description (SEO)'),
            'status'         => Yii::t('PageModule.page', 'Status'),
            'is_protected'   => Yii::t('PageModule.page', 'Access: * Only for authorized members'),
            'user_id'        => Yii::t('PageModule.page', 'Created by'),
            'change_user_id' => Yii::t('PageModule.page', 'Changed by'),
            'order'          => Yii::t('PageModule.page', 'Sorting'),
            'layout'         => Yii::t('PageModule.page', 'Layout'),
            'view'           => Yii::t('PageModule.page', 'View')
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'             => Yii::t('PageModule.page', 'Page Id.'),
            'parent_id'      => Yii::t('PageModule.page', 'Parent page.'),
            'category_id'    => Yii::t('PageModule.page', 'Category which page connected'),
            'create_time'  => Yii::t('PageModule.page', 'Created at'),
            'update_time'    => Yii::t('PageModule.page', 'Updated at'),
            'title'          => Yii::t(
                'PageModule.page',
                'Full page title which will be displayed in page header.<br/><br />For example:<pre>Contact information and road map.</pre>'
            ),
            'title_short'    => Yii::t(
                'PageModule.page',
                'Short page title which wil be displayed in widgets and menus<br/><br />For example:<pre>Contacts</pre>'
            ),
            'slug'           => Yii::t(
                'PageModule.page',
                'Short page title for URL generation<br /><br /> For example: <pre>http://site.ru/page/<span class=\'label\'>contacts</span>/</pre> You can leave it empty for automatic generation.'
            ),
            'lang'           => Yii::t('PageModule.page', 'Page language'),
            'body'           => Yii::t('PageModule.page', 'Page text'),
            'keywords'       => Yii::t(
                'PageModule.page',
                'Keywords for SEO optimization. Insert a few words which have sense in article context. For example: <pre>address, road map, contacts.</pre>'
            ),
            'description'    => Yii::t(
                'PageModule.page',
                'Short page description. About one or two sentences. Usually this is the main idea. For example: <pre>Contact information about my company</pre>This text very frequently falls in <a href="http://help.yandex.ru/webmaster/?id=111131">snippet</a>of search engines.'
            ),
            'status'         => Yii::t(
                'PageModule.page',
                '<span class=\'label label-success\'>Published</span> &ndash; Page is visible for all users by default.<br /><br /><span class=\'label label-default\'>Draft</span> &ndash; Page will be invisible for users.<br /><br /><span class=\'label label-info\'>On moderation</span> &ndash; Page is not checked and it will be invisible for users.'
            ),
            'is_protected'   => Yii::t('PageModule.page', 'Access: * Only for authorized members'),
            'user_id'        => Yii::t('PageModule.page', 'Page creator'),
            'change_user_id' => Yii::t('PageModule.page', 'Page editor'),
            'order'          => Yii::t('PageModule.page', 'Page priority in widgets and menu.'),
            'layout'         => Yii::t('PageModule.page', 'Page layout'),
            'view'           => Yii::t('PageModule.page', 'Page view')
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->title);
        }

        if (!$this->lang) {
            $this->lang = Yii::app()->getLanguage();
        }

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->change_user_id = Yii::app()->getUser()->getId();

        if ($this->getIsNewRecord()) {
            $this->user_id = $this->change_user_id;
        }

        return parent::beforeSave();
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params'    => ['status' => self::STATUS_PUBLISHED],
            ],
            'protected' => [
                'condition' => 'is_protected = :is_protected',
                'params'    => [':is_protected' => self::PROTECTED_YES],
            ],
            'public'    => [
                'condition' => 'is_protected = :is_protected',
                'params'    => [':is_protected' => self::PROTECTED_NO],
            ],
        ];
    }

    public function findBySlug($slug)
    {
        return $this->find('slug = :slug', [':slug' => trim($slug)]);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = ['author', 'changeAuthor'];

        $criteria->compare('t.id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('create_time', $this->create_time);
        $criteria->compare('update_time', $this->update_time);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_short', $this->title_short, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('body', $this->body);
        $criteria->compare('keywords', $this->keywords);
        $criteria->compare('description', $this->description);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('is_protected', $this->is_protected);
        $criteria->compare('layout', $this->layout);

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort'     => ['defaultOrder' => 't.order DESC, t.create_time DESC'],
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_PUBLISHED  => Yii::t('PageModule.page', 'Published'),
            self::STATUS_DRAFT      => Yii::t('PageModule.page', 'Draft'),
            self::STATUS_MODERATION => Yii::t('PageModule.page', 'On moderation'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('PageModule.page', '*unknown*');
    }

    public function getProtectedStatusList()
    {
        return [
            self::PROTECTED_NO  => Yii::t('PageModule.page', 'no'),
            self::PROTECTED_YES => Yii::t('PageModule.page', 'yes'),
        ];
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();

        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('PageModule.page', '*unknown*');
    }

    public function getAllPagesList($selfId = false)
    {
        $criteria = new CDbCriteria();
        $criteria->order = "{$this->tableAlias}.order DESC, {$this->tableAlias}.create_time DESC";
        if ($selfId) {
            $otherCriteria = new CDbCriteria();
            $otherCriteria->addNotInCondition('id', (array)$selfId);
            $otherCriteria->group = "{$this->tableAlias}.slug, {$this->tableAlias}.id";
            $criteria->mergeWith($otherCriteria);
        }

        return CHtml::listData($this->findAll($criteria), 'id', 'title');
    }

    public function getAllPagesListBySlug($slug = false)
    {
        $params = ['order' => 't.order DESC, t.create_time DESC'];
        if ($slug) {
            $params += [
                'condition' => 'slug != :slug',
                'params'    => [':slug' => $slug],
                'group'     => 'slug',
            ];
        }

        return CHtml::listData($this->findAll($params), 'id', 'title');
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }

    public function getParentName()
    {
        return ($this->parentPage === null) ? '---' : $this->parentPage->title;
    }

    public function isProtected()
    {
        return (bool)$this->is_protected === self::PROTECTED_YES;
    }

    /**
     * Возвращает отформатированный список в соответствии со вложенность страниц.
     *
     * @param null|int $parentId
     * @param int $level
     * @param null|array|CDbCriteria $criteria
     * @return array
     */
    public function getFormattedList($parentId = null, $level = 0, $criteria = null)
    {
        if (empty($parentId)) {
            $parentId = null;
        }

        $models = $this->findAllByAttributes(['parent_id' => $parentId], $criteria);

        $list = [];

        foreach ($models as $model) {

            $model->title = str_repeat('&emsp;', $level) . $model->title;

            $list[$model->id] = $model->title;

            $list = CMap::mergeArray($list, $this->getFormattedList($model->id, $level + 1, $criteria));
        }

        return $list;
    }
}
