<?php

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
class Image extends YModel
{
    const STATUS_CHECKED    = 1;
    const STATUS_NEED_CHECK = 0;

    const TYPE_SIMPLE  = 0;
    const TYPE_PREVIEW = 1;

    private $_url;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return Image the static model class
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
        return '{{image_image}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, alt, type', 'required'),
            array('name, description, alt', 'filter', 'filter' => 'trim'),
            array('name, description, alt', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('status, parent_id, type, category_id', 'numerical', 'integerOnly' => true),           
            array('user_id, parent_id, category_id, type, status', 'length', 'max' => 11),
            array('alt, name, file', 'length', 'max' => 250),
            array('type', 'in', 'range' => array_keys($this->typeList)),
            array('category_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, name, description, creation_date, user_id, alt, status', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('image');
        return array(
            'imageUpload' => array(
                'class'         =>'application.modules.yupe.models.ImageUploadBehavior',
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
        return md5($this->name . time());
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category'    => array(self::BELONGS_TO, 'Category', 'category_id'),
            'user'        => array(self::BELONGS_TO, 'User', 'user_id'),
            'galleryRell' => array(self::HAS_MANY, 'ImageToGallery', array('image_id' => 'id')),
            'gallery'     => array(self::HAS_MANY, 'Gallery', 'gallery_id', 'through' => 'galleryRell'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('ImageModule.image', 'id'),
            'category_id'   => Yii::t('ImageModule.image', 'Категория'),
            'name'          => Yii::t('ImageModule.image', 'Название'),
            'description'   => Yii::t('ImageModule.image', 'Описание'),
            'file'          => Yii::t('ImageModule.image', 'Файл'),
            'creation_date' => Yii::t('ImageModule.image', 'Дата создания'),
            'user_id'       => Yii::t('ImageModule.image', 'Добавил'),
            'alt'           => Yii::t('ImageModule.image', 'Альтернативный текст'),
            'status'        => Yii::t('ImageModule.image', 'Статус'),
            'parent_id'     => Yii::t('ImageModule.image', 'Родитель'),
            'type'          => Yii::t('ImageModule.image', 'Тип картинки'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('file', $this->file, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = YDbMigration::expression('NOW()');
            $this->user_id       = Yii::app()->user->getId();
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_CHECKED    => Yii::t('ImageModule.image', 'доступно'),
            self::STATUS_NEED_CHECK => Yii::t('ImageModule.image', 'требуется проверка')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ImageModule.image', '*неизвестно*');
    }

    public function getTypeList()
    {
        $list = array(
            self::TYPE_PREVIEW => Yii::t('ImageModule.image', 'Превью'),
            self::TYPE_SIMPLE  => Yii::t('ImageModule.image', 'Картинка'),
        );

        $types = Yii::app()->getModule('image')->types;

        return count($types) ? CMap::mergeArray($list, $types) : $list;
    }

    public function getType()
    {
        $data = $this->getTypeList();

        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('ImageModule.image', '*неизвестно*');
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
        $ext = pathinfo($this->file, PATHINFO_EXTENSION);
        $hash = md5($this->file . $width . 'x' . $height) . '.' . $ext;
        $image = Yii::app()->getModule('image');
        
        if (($file = Yii::app()->cache->get($hash)) === false) {
            $thumb = Yii::app()->thumbs->create($image->getUploadPath() . $this->file);
            $thumb->adaptiveResize($width, $height);
            $file = 'thumbs_cache_yupe_' . md5($hash . microtime(true)) . '.' . $ext;
            $thumb->save($image->getUploadPath() . $file);
            Yii::app()->cache->set($hash, $file, 0, new CFileCacheDependency($image->getUploadPath() . $file));
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
        if ($this->_url)
            return $this->_url.'/'.$this->file;
        $yupe = Yii::app()->getModule('yupe');
        $image = Yii::app()->getModule('image');

        return Yii::app()->baseUrl . '/' . $yupe->uploadPath . '/' . $image->uploadPath . '/' . (
            $width > 0 || $height > 0
                ? $this->makeThumbnail($width, $height)
                : $this->file            
        );
    }

    /**
     * Проверка на возможность редактировать/удалять изображения
     *
     * @return boolean can change
     **/
    public function canChange()
    {
        return Yii::app()->user->isSuperUser() || Yii::app()->user->id == $this->user_id;
    }
}