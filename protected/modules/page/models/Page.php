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
 * @property string $creation_date
 * @property string $change_date
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
     * @param  string $className
     * @return Page   the static model class
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
        return array(
            array('title, slug, body, lang', 'required', 'on' => array('update', 'insert')),
            array(
                'status, is_protected, parent_id, order, category_id',
                'numerical',
                'integerOnly' => true,
                'on'          => array('update', 'insert')
            ),
            array('parent_id', 'length', 'max' => 45),
            array('lang', 'length', 'max' => 2),
            array('lang', 'default', 'value' => Yii::app()->sourceLanguage),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('title, title_short, slug, keywords, description, layout, view', 'length', 'max' => 150),
            array('slug', 'yupe\components\validators\YUniqueSlugValidator'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('is_protected', 'in', 'range' => array_keys($this->getProtectedStatusList())),
            array('title, title_short, slug, body, description, keywords', 'filter', 'filter' => 'trim'),
            array(
                'title, title_short, slug, description, keywords',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array('slug', 'yupe\components\validators\YSLugValidator'),
            array(
                'lang',
                'match',
                'pattern' => '/^[a-z]{2}$/',
                'message' => Yii::t('PageModule.page', 'Bad characters in {attribute} field')
            ),
            array(
                'lang, id, parent_id, creation_date, change_date, title, title_short, slug, body, keywords, description, status, order, lang',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'childPages'   => array(self::HAS_MANY, 'Page', 'parent_id'),
            'parentPage'   => array(self::BELONGS_TO, 'Page', 'parent_id'),
            'author'       => array(self::BELONGS_TO, 'User', 'user_id'),
            'changeAuthor' => array(self::BELONGS_TO, 'User', 'change_user_id'),
            'category'     => array(self::BELONGS_TO, 'Category', 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'             => Yii::t('PageModule.page', 'Id'),
            'parent_id'      => Yii::t('PageModule.page', 'Parent'),
            'category_id'    => Yii::t('PageModule.page', 'Category'),
            'creation_date'  => Yii::t('PageModule.page', 'Created at'),
            'change_date'    => Yii::t('PageModule.page', 'Changed'),
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
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'             => Yii::t('PageModule.page', 'Page Id.'),
            'parent_id'      => Yii::t('PageModule.page', 'Parent page.'),
            'category_id'    => Yii::t('PageModule.page', 'Category which page connected'),
            'creation_date'  => Yii::t('PageModule.page', 'Created at'),
            'change_date'    => Yii::t('PageModule.page', 'Updated at'),
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
        );
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->title);
        }

        if (!$this->lang) {
            $this->lang = Yii::app()->language;
        }

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression('now()');
        $this->change_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord) {
            $this->creation_date = $this->change_date;
            $this->user_id = $this->change_user_id;
        }

        return parent::beforeSave();
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array('status' => self::STATUS_PUBLISHED),
            ),
            'protected' => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_YES),
            ),
            'public'    => array(
                'condition' => 'is_protected = :is_protected',
                'params'    => array(':is_protected' => self::PROTECTED_NO),
            ),
        );
    }

    public function findBySlug($slug)
    {
        return $this->find('slug = :slug', array(':slug' => trim($slug)));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->with = array('author', 'changeAuthor');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('creation_date', $this->creation_date);
        $criteria->compare('change_date', $this->change_date);
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
            get_class($this), array(
                'criteria' => $criteria,
                'sort'     => array('defaultOrder' => 't.order DESC, t.creation_date DESC'),
            )
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED  => Yii::t('PageModule.page', 'Published'),
            self::STATUS_DRAFT      => Yii::t('PageModule.page', 'Draft'),
            self::STATUS_MODERATION => Yii::t('PageModule.page', 'On moderation'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('PageModule.page', '*unknown*');
    }

    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('PageModule.page', 'no'),
            self::PROTECTED_YES => Yii::t('PageModule.page', 'yes'),
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();

        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('PageModule.page', '*unknown*');
    }

    public function getAllPagesList($selfId = false)
    {
        $criteria = new CDbCriteria();
        $criteria->order = "{$this->tableAlias}.order DESC, {$this->tableAlias}.creation_date DESC";
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
        $params = array('order' => 't.order DESC, t.creation_date DESC');
        if ($slug) {
            $params += array(
                'condition' => 'slug != :slug',
                'params'    => array(':slug' => $slug),
                'group'     => 'slug',
            );
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
        return $this->is_protected == self::PROTECTED_YES;
    }

    /**
     * @param bool $absolute
     * @return string
     */
    public function getUrl($absolute = false)
    {
        return $absolute ? Yii::app()->createAbsoluteUrl('/page/page/show/', array('slug' => $this->slug)) : Yii::app()->createUrl('/page/page/show/', array('slug' => $this->slug));
    }
}
