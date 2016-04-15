<?php

/**
 * Модель ContentBlock
 *
 * @category YupeMigration
 * @package  yupe.modules.contentblock.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * This is the model class for table "ContentBlock".
 *
 * The followings are the available columns in table 'ContentBlock':
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property string $content
 * @property string $description
 * @property string $code
 * @property integer $category_id
 * @property integer $status
 *
 * @property Category|null $category
 *
 * @method ContentBlock active()
 */
class ContentBlock extends yupe\models\YModel
{
    const SIMPLE_TEXT = 1;
    const HTML_TEXT = 3;
    const RAW_TEXT = 4;

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return ContentBlock the static model class
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
        return '{{contentblock_content_block}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, code, content, type', 'filter', 'filter' => 'trim'],
            ['name, code', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['name, code, type, status', 'required'],
            ['type, category_id, status', 'numerical', 'integerOnly' => true],
            ['type', 'length', 'max' => 11],
            ['type', 'in', 'range' => array_keys($this->types)],
            ['name', 'length', 'max' => 250],
            ['code', 'length', 'max' => 100],
            ['description', 'length', 'max' => 255],
            [
                'code',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t(
                    'ContentBlockModule.contentblock',
                    'Unknown field format "{attribute}" only alphas, digits and _, from 2 to 50 characters'
                )
            ],
            ['code', 'unique'],
            ['id, name, code, type, content, description, category_id, status', 'safe', 'on' => 'search'],
        ];
    }

    public function scopes()
    {
        return [
            'active' => [
                'condition' => $this->tableAlias . '.status = :status',
                'params'    => [':status' => self::STATUS_ACTIVE],
            ],
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
            'category' => [self::BELONGS_TO, 'Category', 'category_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('ContentBlockModule.contentblock', 'id'),
            'name'        => Yii::t('ContentBlockModule.contentblock', 'Title'),
            'code'        => Yii::t('ContentBlockModule.contentblock', 'Code'),
            'type'        => Yii::t('ContentBlockModule.contentblock', 'Type'),
            'content'     => Yii::t('ContentBlockModule.contentblock', 'Content'),
            'description' => Yii::t('ContentBlockModule.contentblock', 'Description'),
            'category_id' => Yii::t('ContentBlockModule.contentblock', 'Category'),
            'status'      => Yii::t('ContentBlockModule.contentblock', 'Status'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following name to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();
        $criteria->compare($this->tableAlias . '.id', $this->id);
        $criteria->compare($this->tableAlias . '.name', $this->name, true);
        $criteria->compare($this->tableAlias . '.code', $this->code, true);
        $criteria->compare($this->tableAlias . '.type', $this->type);
        $criteria->compare($this->tableAlias . '.content', $this->content, true);
        $criteria->compare($this->tableAlias . '.description', $this->description, true);
        $criteria->compare($this->tableAlias . '.category_id', $this->category_id);
        $criteria->compare($this->tableAlias . '.status', $this->status);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    public function getTypes()
    {
        return [
            self::SIMPLE_TEXT => Yii::t('ContentBlockModule.contentblock', 'Simple text'),
            self::HTML_TEXT   => Yii::t('ContentBlockModule.contentblock', 'HTML code'),
            self::RAW_TEXT    => Yii::t('ContentBlockModule.contentblock', 'Raw text'),
        ];
    }

    public function getType()
    {
        $data = $this->getTypes();

        return isset($data[$this->type]) ? $data[$this->type] : Yii::t(
            'ContentBlockModule.contentblock',
            '*unknown type*'
        );
    }

    public function getContent()
    {
        $content = '';
        switch ($this->type) {

            case ContentBlock::SIMPLE_TEXT:
                $content = CHtml::encode($this->content);
                break;
            case ContentBlock::HTML_TEXT:
            case ContentBlock::RAW_TEXT:
                $content = $this->content;
                break;
        }

        return $content;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            Yii::app()->cache->delete("ContentBlock{$this->code}" . Yii::app()->language);

            return true;
        }

        return false;
    }

    public function getCategoryName()
    {
        return empty($this->category) ? Yii::t('ContentBlockModule.contentblock', '--not selected--') : $this->category->name;
    }

    public function getCategoryAlias()
    {
        return empty($this->category) ? '<code_category>' : $this->category->slug;
    }

    public function getStatusList()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('ContentBlockModule.contentblock', 'Disabled'),
            self::STATUS_ACTIVE     => Yii::t('ContentBlockModule.contentblock', 'Enabled'),
        ];
    }
}