<?php

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
 */

class Page extends YModel
{

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO  = 0;
    const PROTECTED_YES = 1;

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
        return array(
            array('title, slug, body, lang', 'required', 'on' => array('update', 'insert')),
            array('status, is_protected, parent_id, order, category_id', 'numerical', 'integerOnly' => true, 'on' => array('update', 'insert')),
            array('parent_id', 'length', 'max' => 45),
            array('lang', 'length', 'max' => 2),
            array('lang', 'default', 'value' => Yii::app()->sourceLanguage),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('title, title_short, slug, keywords, description', 'length', 'max' => 150),
            array('slug', 'YUniqueSlugValidator'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('is_protected', 'in', 'range' => array_keys($this->protectedStatusList)),
            array('title, title_short, slug, body, description, keywords', 'filter', 'filter' => 'trim'),
            array('title, title_short, slug, description, keywords', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('slug', 'YSLugValidator'),
            array('lang', 'match', 'pattern' => '/^[a-z]{2}$/', 'message' => Yii::t('PageModule.page', 'Запрещенные символы в поле {attribute}')),
            array('lang, id, parent_id, creation_date, change_date, title, title_short, slug, body, keywords, description, status, order, lang', 'safe', 'on' => 'search'),
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
            'parent_id'      => Yii::t('PageModule.page', 'Родитель'),
            'category_id'    => Yii::t('PageModule.page', 'Категория'),
            'creation_date'  => Yii::t('PageModule.page', 'Создано'),
            'change_date'    => Yii::t('PageModule.page', 'Изменено'),
            'title'          => Yii::t('PageModule.page', 'Заголовок'),
            'title_short'    => Yii::t('PageModule.page', 'Короткий заголовок'),
            'slug'           => Yii::t('PageModule.page', 'Url'),
            'lang'           => Yii::t('PageModule.page', 'Язык'),
            'body'           => Yii::t('PageModule.page', 'Текст'),
            'keywords'       => Yii::t('PageModule.page', 'Ключевые слова (SEO)'),
            'description'    => Yii::t('PageModule.page', 'Описание (SEO)'),
            'status'         => Yii::t('PageModule.page', 'Статус'),
            'is_protected'   => Yii::t('PageModule.page', 'Доступ: * только для авторизованных пользователей'),
            'user_id'        => Yii::t('PageModule.page', 'Создал'),
            'change_user_id' => Yii::t('PageModule.page', 'Изменил'),
            'order'          => Yii::t('PageModule.page', 'Сортировка'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'             => Yii::t('PageModule.page', 'Id страницы.'),
            'parent_id'      => Yii::t('PageModule.page', 'Родительская страница.'),
            'category_id'    => Yii::t('PageModule.page', 'Категория к которой привязана страница.'),
            'creation_date'  => Yii::t('PageModule.page', 'Дата создания страницы.'),
            'change_date'    => Yii::t('PageModule.page', 'Дата изменения страницы.'),
            'title'          => Yii::t('PageModule.page', 'Укажите полное название данной страницы для отображения в заголовке при полном просмотре.<br/><br />Например:<pre>Контактная информация и карта проезда.</pre>'),
            'title_short'    => Yii::t('PageModule.page', 'Укажите краткое название данной страницы для отображения её в виджетах и меню.<br/><br />Например:<pre>Контакты</pre>'),
            'slug'           => Yii::t('PageModule.page', "Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/page/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно."),
            'lang'           => Yii::t('PageModule.page', 'Язык страницы.'),
            'body'           => Yii::t('PageModule.page', 'Основной текст страницы.'),
            'keywords'       => Yii::t('PageModule.page', 'Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из страницы и напишите их здесь через запятую. К примеру, если страница содержит контактную информацию, логично использовать такие ключевые слова: <pre>адрес, карта проезда, контакты, реквизиты.</pre>'),
            'description'    => Yii::t('PageModule.page', 'Краткое описание данной страницы, одно или два предложений. Обычно это самая главная мысль, к примеру: <pre>Контактная информация, реквизиты и карта проезда компании ОАО &laquo;Рога-унд-Копыта индастриз&raquo;</pre>Данный текст очень часто попадает в <a href="http://help.yandex.ru/webmaster/?id=1111310">сниппет</a> поисковых систем.'),
            'status'         => Yii::t('PageModule.page', "<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться."),
            'is_protected'   => Yii::t('PageModule.page', 'Доступ: * только для авторизованных пользователей.'),
            'user_id'        => Yii::t('PageModule.page', 'Пользователь, который добавил страницу.'),
            'change_user_id' => Yii::t('PageModule.page', 'Пользователь, который последний изменил страницу.'),
            'order'          => Yii::t('PageModule.page', 'Чем большее числовое значение вы укажете в этом поле, тем выше будет позиция данной страницы в виджетах и меню.'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = YText::translit($this->title);
        if (!$this->lang)
            $this->lang = Yii::app()->language;
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression('now()');
        $this->user_id     = Yii::app()->user->getId();

        if ($this->isNewRecord)
        {
            $this->creation_date  = $this->change_date;
            $this->change_user_id = $this->user_id;
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

        $criteria->with = array( 'author', 'changeAuthor' );

        $criteria->compare('id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('creation_date', $this->creation_date);
        $criteria->compare('change_date', $this->change_date);
        $criteria->compare('title', $this->title);
        $criteria->compare('slug', $this->slug);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('body', $this->body);
        $criteria->compare('keywords', $this->keywords);
        $criteria->compare('description', $this->description);

        if ($this->status != '')
            $criteria->compare('t.status', $this->status);
        if ($this->category_id != '')
            $criteria->compare('category_id', $this->category_id);

        $criteria->compare('is_protected', $this->is_protected);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 't.order DESC, t.creation_date DESC'),
        ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED  => Yii::t('PageModule.page', 'Опубликовано'),
            self::STATUS_DRAFT      => Yii::t('PageModule.page', 'Черновик'),
            self::STATUS_MODERATION => Yii::t('PageModule.page', 'На модерации'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('PageModule.page', '*неизвестно*');
    }

    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO  => Yii::t('PageModule.page', 'нет'),
            self::PROTECTED_YES => Yii::t('PageModule.page', 'да'),
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->protectedStatusList;
        return isset($data[$this->is_protected]) ? $data[$this->is_protected] : Yii::t('PageModule.page', '*неизвестно*');
    }

    public function getAllPagesList($selfId = false)
    {
        $criteria = new CDbCriteria;
        $criteria->order = "{$this->tableAlias}.order DESC, {$this->tableAlias}.creation_date DESC";
        if ($selfId) {
            $otherCriteria = new CDbCriteria;
            $otherCriteria->addNotInCondition('id', (array)$selfId);
            $otherCriteria->group = "{$this->tableAlias}.slug, {$this->tableAlias}.id";
            $criteria->mergeWith($otherCriteria);
        }
        return CHtml::listData($this->findAll($criteria), 'id', 'title');
    }

    public function getAllPagesListBySlug($slug = false)
    {
        $params = array('order' => 't.order DESC, t.creation_date DESC');
        if ($slug)
            $params += array(
                'condition' => 'slug != :slug',
                'params'    => array(':slug' => $slug),
                'group'     => 'slug',
            );
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

    public function getPermaLink()
    {
        return Yii::app()->createAbsoluteUrl('/page/page/show/', array('slug' => $this->slug));
    }
}
