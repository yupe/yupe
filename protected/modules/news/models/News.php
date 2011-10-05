<?php

/**
 * This is the model class for table "News".
 *
 * The followings are the available columns in table 'News':
 * @property integer $id
 * @property string $creationDate
 * @property string $changeDate
 * @property string $date
 * @property string $title
 * @property string $alias
 * @property string $shortText
 * @property string $fullText
 * @property integer $userId
 * @property integer $status
 * @property integer $isProtected
 */
class News extends CActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    const PROTECTED_NO = 0;
    const PROTECTED_YES = 1;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{news}}';
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT => Yii::t('news', 'Черновик'),
            self::STATUS_PUBLISHED => Yii::t('news', 'Опубликовано'),
            self::STATUS_MODERATION => Yii::t('news', 'На модерации')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status]
            : Yii::t('news', '*неизвестно*');
    }


    public function getProtectedStatusList()
    {
        return array(
            self::PROTECTED_NO => Yii::t('news', 'нет'),
            self::PROTECTED_YES => Yii::t('news', 'да')
        );
    }

    public function getProtectedStatus()
    {
        $data = $this->getProtectedStatusList();
        return array_key_exists($this->isProtected, $data)
            ? $data[$this->isProtected] : Yii::t('news', '*неизвестно*');
    }

    /**
     * Returns the static model of the specified AR class.
     * @return News the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('date, title, alias, shortText, fullText', 'required'),
            array('status, isProtected', 'numerical', 'integerOnly' => true),
            array('title, alias, keywords', 'length', 'max' => 150),
            array('alias', 'unique'),
            array('description', 'length', 'max' => 250),
            array('shortText', 'length', 'max' => 400),
            array('title, alias, shortText, fullText, keywords, description', 'filter', 'filter' => 'trim'),
            array('title, alias, keywords, description', 'filter', 'filter' => 'strip_tags'),
            array('alias', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => Yii::t('news', 'Запрещенные символы в поле {attribute}')),
            array('id, keywords, description, creationDate, changeDate, date, title, alias, shortText, fullText, userId, status, isProtected', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId')
        );
    }


    public function scopes()
    {
        return array(
            'published' => array('condition' => 'status = ' . self::STATUS_PUBLISHED),
            'protected' => array('condition' => 'isProtected = ' . self::PROTECTED_YES),
            'public' => array('condition' => 'isProtected = ' . self::PROTECTED_NO),
            'recent' => array('order' => 'creationDate DESC', 'limit' => 5)
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('news', 'Id'),
            'creationDate' => Yii::t('news', 'Дата создания'),
            'changeDate' => Yii::t('news', 'Дата изменения'),
            'date' => Yii::t('news', 'Дата'),
            'title' => Yii::t('news', 'Заголовок'),
            'alias' => Yii::t('news', 'Url'),
            'shortText' => Yii::t('news', 'Короткое описание'),
            'fullText' => Yii::t('news', 'Полный текст'),
            'userId' => Yii::t('news', 'Автор'),
            'status' => Yii::t('news', 'Статус'),
            'isProtected' => Yii::t('news', 'Доступ: * только для авторизованных пользователей'),
            'keywords' => Yii::t('news', 'Ключевые слова (SEO)'),
            'description' => Yii::t('news', 'Описание (SEO)'),
        );
    }


    public function beforeValidate()
    {
        if (parent::beforeValidate())
        {
            if ($this->scenario === 'update')
            {
                $this->alias = YText::translit($this->title);
            }
            else
            {
                if (!$this->alias)
                {
                    $this->alias = YText::translit($this->title);
                }
            }

            if (!$this->description)
            {
                $this->description = $this->shortText;
            }

            return true;
        }

        return false;
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->creationDate = $this->changeDate = new CDbExpression('NOW()');
                $this->userId = Yii::app()->user->getId();
            }
            else
            {
                $this->changeDate = new CDbExpression('NOW()');
            }

            $this->date = date('Y-m-d', strtotime($this->date));

            return true;
        }

        return false;
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->date = date('d.m.Y', strtotime($this->date));
    }

    public function getPermaLink()
    {
        return Yii::app()->createUrl('/news/news/show/', array('title' => $this->alias));
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

        $criteria->compare('id', $this->id);
        $criteria->compare('creationDate', $this->creationDate, true);
        $criteria->compare('changeDate', $this->changeDate, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('shortText', $this->shortText, true);
        $criteria->compare('fullText', $this->fullText, true);
        $criteria->compare('userId', $this->userId);
        $criteria->compare('status', $this->status);
        $criteria->compare('isProtected', $this->isProtected);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }
}
