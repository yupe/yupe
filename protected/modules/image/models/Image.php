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
 * @property string $create_time
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
    const STATUS_CHECKED = 1;
    const STATUS_NEED_CHECK = 0;

    const TYPE_SIMPLE = 0;
    const TYPE_PREVIEW = 1;

    public $galleryId;

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
        return [
            ['name, description, alt', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['name , alt, type', 'required'],
            ['galleryId', 'numerical'],
            ['name, description, alt', 'filter', 'filter' => 'trim'],
            ['status, parent_id, type, category_id', 'numerical', 'integerOnly' => true],
            ['user_id, parent_id, category_id, type, status', 'length', 'max' => 11],
            ['alt, name, file', 'length', 'max' => 250],
            ['type', 'in', 'range' => array_keys($this->getTypeList())],
            ['category_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['id, name, description, create_time, user_id, alt, status, galleryId', 'safe', 'on' => 'search'],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('image');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'file',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'requiredOn'    => 'insert',
                'uploadPath'    => $module->uploadPath,
                'resizeOptions' => [
                    'width'  => $module->width,
                    'height' => $module->height
                ]
            ],
            'sortable'    => [
                'class'         => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort'
            ],
            'seo'         => [
                'class'  => 'vendor.chemezov.yii-seo.behaviors.SeoActiveRecordBehavior',
                'route'  => '/gallery/gallery/image',
                'params' => [
                    'id' => function ($data) {
                        return $data->id;
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
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(
            [
                'image'    => [self::BELONGS_TO, 'Image', 'id'],
                'category' => [self::BELONGS_TO, 'Category', 'category_id'],
                'user'     => [self::BELONGS_TO, 'User', 'user_id'],
            ],
            Yii::app()->hasModule('gallery')
                ? [
                'galleryRell' => [self::HAS_ONE, 'ImageToGallery', ['image_id' => 'id']],
                'gallery'     => [self::HAS_ONE, 'Gallery', 'gallery_id', 'through' => 'galleryRell'],
            ]
                : []
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('ImageModule.image', 'id'),
            'category_id'   => Yii::t('ImageModule.image', 'Category'),
            'name'          => Yii::t('ImageModule.image', 'Title'),
            'description'   => Yii::t('ImageModule.image', 'Description'),
            'file'          => Yii::t('ImageModule.image', 'File'),
            'create_time' => Yii::t('ImageModule.image', 'Created at'),
            'user_id'       => Yii::t('ImageModule.image', 'Creator'),
            'alt'           => Yii::t('ImageModule.image', 'Alternative text'),
            'status'        => Yii::t('ImageModule.image', 'Status'),
            'parent_id'     => Yii::t('ImageModule.image', 'Parent'),
            'type'          => Yii::t('ImageModule.image', 'Image type'),
            'galleryId'     => Yii::t('ImageModule.image', 'Gallery'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.file', $this->file, true);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.user_id', $this->user_id, true);
        $criteria->compare('t.alt', $this->alt, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.category_id', $this->category_id);

        if (Yii::app()->hasModule('gallery')) {
            $criteria->with = ['gallery', 'image'];
            $criteria->compare('gallery_id', $this->galleryId);
            $criteria->together = true;
        }

        return new CActiveDataProvider(get_class($this), [
            'criteria' => $criteria,
            'sort'     => ['defaultOrder' => 't.sort']
        ]);
    }

    public function beforeValidate()
    {
        if ($this->getIsNewRecord()) {
            $this->create_time = new CDbExpression('NOW()');
            $this->user_id = Yii::app()->user->getId();
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return [
            self::STATUS_CHECKED    => Yii::t('ImageModule.image', 'allowed'),
            self::STATUS_NEED_CHECK => Yii::t('ImageModule.image', 'need to be checked')
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ImageModule.image', '*unknown*');
    }

    public function getTypeList()
    {
        $list = [
            self::TYPE_PREVIEW => Yii::t('ImageModule.image', 'Preview'),
            self::TYPE_SIMPLE  => Yii::t('ImageModule.image', 'Picture'),
        ];

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
     * Проверка на возможность редактировать/удалять изображения
     *
     * @return boolean can change
     **/
    public function canChange()
    {
        return Yii::app()->getUser()->isSuperUser() || Yii::app()->getUser()->getId() == $this->user_id;
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
                    100,
                    new CDbCacheDependency('SELECT MAX(id) FROM {{gallery_gallery}}')
                )->findAll(),
                'id',
                'name'
            )
            : [
                Yii::t('ImageModule.image', 'Gallery module is not installed'),
            ];
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
        if ($this->scenario === 'search' || !Yii::app()->hasModule('gallery')) {
            return ($this->_galleryId = $value);
        }

        if ($this->gallery instanceof Gallery) {
            $this->galleryRell->delete();
        }

        if (($gallery = Gallery::model()->loadModel($value)) === null) {
            return $value;
        }

        return $gallery->addImage($this);
    }

    public function getName()
    {
        return $this->name ? $this->name : $this->alt;
    }
}
