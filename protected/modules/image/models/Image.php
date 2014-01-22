<?php

/**
 * Image основная модель для работы с изображениями
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.image.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "Image".
 *
 * The followings are the available columns in table 'Image':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $file
 * @property string $creation_date
 * @property string $user_id
 * @property string $alt
 * @property integer $status
 * @property integer $category_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Image extends yupe\models\YModel
{
    const STATUS_CHECKED    = 1;
    const STATUS_NEED_CHECK = 0;

    const TYPE_SIMPLE  = 0;
    const TYPE_PREVIEW = 1;

    public $galleryId;

    private $_url;
    private $_galleryId = null;

    /**
     * Returns the static model of the specified AR class.
     * 
     * @param string $className - class name
     * 
     * @return Image the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * table name
     * 
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{image_image}}';
    }

    /**
     * validation rules
     * 
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name , alt, type', 'required'),
            array('galleryId', 'numerical'),
            array('name, description, alt', 'filter', 'filter' => 'trim'),
            array('name, description, alt', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('status, parent_id, type, category_id', 'numerical', 'integerOnly' => true),           
            array('user_id, parent_id, category_id, type, status', 'length', 'max' => 11),
            array('alt, name, file', 'length', 'max' => 250),
            array('type', 'in', 'range' => array_keys($this->typeList)),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, name, description, creation_date, user_id, alt, status, galleryId', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('image');
        return array(
            'imageUpload' => array(
                'class'         =>'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'file',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'requiredOn'    => 'insert',
                'uploadPath'    => $module->getUploadPath(),
                'imageNameCallback' => array($this, 'generateFileName'),
                'resize' => array(
                    'quality' => 70,
                    'width' => 1024,
                )
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->name . microtime(true) . rand());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(
            array(
                'image'       => array(self::BELONGS_TO, 'Image', 'id'),
                'category'    => array(self::BELONGS_TO, 'Category', 'category_id'),
                'user'        => array(self::BELONGS_TO, 'User', 'user_id'),
            ), Yii::app()->hasModule('gallery')
            ? array(
                'galleryRell' => array(self::HAS_ONE, 'ImageToGallery', array('image_id' => 'id')),
                'gallery'     => array(self::HAS_ONE, 'Gallery', 'gallery_id', 'through' => 'galleryRell'),
            )
            : array()
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('ImageModule.image', 'id'),
            'category_id'   => Yii::t('ImageModule.image', 'Category'),
            'name'          => Yii::t('ImageModule.image', 'Title'),
            'description'   => Yii::t('ImageModule.image', 'Description'),
            'file'          => Yii::t('ImageModule.image', 'File'),
            'creation_date' => Yii::t('ImageModule.image', 'Created at'),
            'user_id'       => Yii::t('ImageModule.image', 'Creator'),
            'alt'           => Yii::t('ImageModule.image', 'Alternative text'),
            'status'        => Yii::t('ImageModule.image', 'Status'),
            'parent_id'     => Yii::t('ImageModule.image', 'Parent'),
            'type'          => Yii::t('ImageModule.image', 'Image type'),
            'galleryId'     => Yii::t('ImageModule.image', 'Gallery'),
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

        $criteria->compare($this->tableAlias . '.id', $this->id);
        $criteria->compare($this->tableAlias . '.name', $this->name, true);
        $criteria->compare($this->tableAlias . '.description', $this->description, true);
        $criteria->compare($this->tableAlias . '.file', $this->file, true);
        $criteria->compare($this->tableAlias . '.creation_date', $this->creation_date, true);
        $criteria->compare($this->tableAlias . '.user_id', $this->user_id, true);
        $criteria->compare($this->tableAlias . '.alt', $this->alt, true);
        $criteria->compare($this->tableAlias . '.status', $this->status);
        
        if (Yii::app()->hasModule('gallery')) {
            $criteria->with = array('gallery', 'image');
            $criteria->compare('gallery_id', $this->galleryId);
            $criteria->together = true;
        }

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');
            $this->user_id       = Yii::app()->user->getId();
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_CHECKED    => Yii::t('ImageModule.image', 'allowed'),
            self::STATUS_NEED_CHECK => Yii::t('ImageModule.image', 'need to be checked')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ImageModule.image', '*unknown*');
    }

    public function getTypeList()
    {
        $list = array(
            self::TYPE_PREVIEW => Yii::t('ImageModule.image', 'Preview'),
            self::TYPE_SIMPLE  => Yii::t('ImageModule.image', 'Picture'),
        );

        $types = Yii::app()->getModule('image')->types;

        return count($types) ? CMap::mergeArray($list, $types) : $list;
    }

    public function getType()
    {
        $data = $this->getTypeList();

        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('ImageModule.image', '*unknown*');
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }

    /**
     * make thumbnail of image
     *
     * @param int $width  - ширина
     * @param int $height - высота
     *
     * @return string filename
     **/
    public function makeThumbnail($width = 0, $height = 0)
    {
        $width = $width === 0
            ? $height
            : $width;

        $height = $height === 0
            ? $width
            : $height;

        $ext = pathinfo($this->file, PATHINFO_EXTENSION);
        $file = 'thumb_cache_' . $width . 'x' . $height . '_' . pathinfo($this->file, PATHINFO_FILENAME) . '.' . $ext;
        $image = Yii::app()->getModule('image');
        
        if (!file_exists($image->getUploadPath() . $this->file))
            return null;

        if (file_exists($image->getUploadPath() . $file) === false) {
            $thumb = Yii::app()->thumbs->create($image->getUploadPath() . $this->file);
            $thumb->adaptiveResize($width, $height);
            $thumb->save($image->getUploadPath() . $file);
        }

        return $file;
    }

    /**
     * Получаем URL к файлу:
     * 
     * @param int $width  - параметр ширины для изображения
     * @param int $height - параметр высоты для изображения
     * 
     * @return string URL к файлу
     */
    public function getUrl($width = 0, $height = 0)
    {
        if ($this->_url) {
            return $this->_url.'/'.$this->file;
        }

        $yupe = Yii::app()->getModule('yupe');
        $image = Yii::app()->getModule('image');

        return Yii::app()->baseUrl . '/' . $yupe->uploadPath . '/' . $image->uploadPath . '/' . (
            ($width > 0 || $height > 0) && (
                $thumbnail = $this->makeThumbnail($width, $height)
            ) !== null
                ? $thumbnail
                : $this->file
        );
    }

    public function getRawUrl()
    {
        $yupe = Yii::app()->getModule('yupe');

        $image = Yii::app()->getModule('image');

        return Yii::app()->createAbsoluteUrl('/').'/' . $yupe->uploadPath . '/' . $image->uploadPath . '/' . $this->file;      
    }

    /**
     * Проверка на возможность редактировать/удалять изображения
     *
     * @return boolean can change
     **/
    public function canChange()
    {
        return Yii::app()->user->isSuperUser() || Yii::app()->user->getId() == $this->user_id;
    }

    /**
     * Определяем галерею:
     *
     * @param boolean $withlink - для возврата линка на галерею:
     *
     * @return string gallery name
     **/
    public function getGalleryName()
    {
        return Yii::app()->hasModule('gallery') && $this->gallery instanceof Gallery
            ? $this->gallery->name
            : null;
    }

    /**
     * Список галерей:
     * 
     * @return array list of galleries
     **/
    public function galleryList()
    {
        return Yii::app()->hasModule('gallery')
            ? CHtml::listData(
                Gallery::model()->cache(
                    100, new CDbCacheDependency('SELECT MAX(id) FROM {{gallery_gallery}}')
                )->findAll(), 'id', 'name'
            )
            : array(
                Yii::t('ImageModule.image', 'Gallery module is not installed'),
            );
    }

    /**
     * Получаем имя того, кто загрузил картинку:
     *
     * @return string user full name
     **/
    public function getUserName()
    {
        return $this->user instanceof User
            ? $this->user->getFullName()
            : '---';
    }

    /**
     * get gallery id
     *
     * @return gallery id of image
     **/
    public function getGalleryId()
    {
        return Yii::app()->hasModule('gallery') && $this->gallery instanceof Gallery && empty($this->_galleryId)
            ? $this->gallery->id
            : $this->_galleryId;
    }

    /**
     * set gallery id
     *
     * @param mixed $value - value for setter
     *
     * @return bool
     **/
    public function setGalleryId($value = null)
    {
        if ($this->scenario === 'search' || !Yii::app()->hasModule('gallery')){
            return ($this->_galleryId = $value);
        }

        if ($this->gallery instanceof Gallery) {
            $this->galleryRell->delete();
        }

        if (($gallery = Gallery::model()->loadModel($value)) === null){
            return $value;
        }

        return $gallery->addImage($this);
    }

    public function getName()
    {
        return $this->name ? $this->name : $this->alt;
    }
}