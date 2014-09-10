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
 */
class ContentBlock extends yupe\models\YModel
{
    const SIMPLE_TEXT = 1;
    const HTML_TEXT = 3;
    const RAW_TEXT = 4;

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
        return array(
            array('name, code, content, type', 'filter', 'filter' => 'trim'),
            array('name, code', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, code, content, type', 'required'),
            array('type, category_id', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 11),
            array('type', 'in', 'range' => array_keys($this->types)),
            array('name', 'length', 'max' => 250),
            array('code', 'length', 'max' => 100),
            array('description', 'length', 'max' => 255),
            array(
                'code',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t(
                        'ContentBlockModule.contentblock',
                        'Unknown field format "{attribute}" only alphas, digits and _, from 2 to 50 characters'
                    )
            ),
            array('code', 'unique'),
            array('id, name, code, type, content, description, category_id', 'safe', 'on' => 'search'),
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
            'category' => array(self::BELONGS_TO, 'Category', 'category_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('ContentBlockModule.contentblock', 'id'),
            'name'        => Yii::t('ContentBlockModule.contentblock', 'Title'),
            'code'        => Yii::t('ContentBlockModule.contentblock', 'Code'),
            'type'        => Yii::t('ContentBlockModule.contentblock', 'Type'),
            'content'     => Yii::t('ContentBlockModule.contentblock', 'Content'),
            'description' => Yii::t('ContentBlockModule.contentblock', 'Description'),
            'category_id' => Yii::t('ContentBlockModule.contentblock', 'Category'),
        );
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('category_id', $this->category_id);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getTypes()
    {
        return array(
            self::SIMPLE_TEXT => Yii::t('ContentBlockModule.contentblock', 'Simple text'),
            self::HTML_TEXT   => Yii::t('ContentBlockModule.contentblock', 'HTML code'),
            self::RAW_TEXT    => Yii::t('ContentBlockModule.contentblock', 'Raw text'),
        );
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

    public function getCategory()
    {
        return empty($this->category) ? false : $this->category;
    }

    public function getCategoryName()
    {
        return empty($this->category) ? Yii::t('ContentBlockModule.contentblock', '--not selected--') : $this->category->name;
    }

    public function getCategoryAlias()
    {
        return empty($this->category) ? '<code_category>' : $this->category->alias;
    }
}