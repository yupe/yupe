<?php
use yupe\widgets\YPurifier;

/**
 * Gallery
 *
 * Модель для работы с галереями
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.gallery.models
 * @since 0.1
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property integer $preview_id
 * @property integer $category_id
 * @property integer $sort
 *
 * @property Image $preview
 */
class Gallery extends yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLIC = 1;
    const STATUS_PERSONAL = 2;
    const STATUS_PRIVATE = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className
     * @return Gallery the static model class
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
        return '{{gallery_gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, description', 'filter', 'filter' => [new YPurifier(), 'purify']],
            ['name, description, owner', 'required'],
            ['status, owner, preview_id, category_id, sort', 'numerical', 'integerOnly' => true],
            ['name', 'length', 'max' => 250],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['id, name, description, status, owner, sort', 'safe', 'on' => 'search'],
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
            'imagesRell' => [self::HAS_MANY, 'ImageToGallery', ['gallery_id' => 'id']],
            'images' => [self::HAS_MANY, 'Image', 'image_id', 'through' => 'imagesRell'],
            'imagesCount' => [self::STAT, 'ImageToGallery', 'gallery_id'],
            'user' => [self::BELONGS_TO, 'User', 'owner'],
            'lastUpdated' => [self::STAT, 'ImageToGallery', 'gallery_id', 'select' => 'max(create_time)'],
            'preview' => [self::BELONGS_TO, 'Image', 'preview_id'],
            'category' => [self::BELONGS_TO, 'Category', 'category_id'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort',
            ],
        ];
    }

    /**
     * beforeValidate
     *
     * @return parent::beforeValidate()
     **/
    public function beforeValidate()
    {
        // Проверяем наличие установленного хозяина галереи
        if (isset($this->owner) && empty($this->owner)) {
            $this->owner = Yii::app()->user->getId();
        }

        return parent::beforeValidate();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('GalleryModule.gallery', 'Id'),
            'name' => Yii::t('GalleryModule.gallery', 'Title'),
            'owner' => Yii::t('GalleryModule.gallery', 'Vendor'),
            'description' => Yii::t('GalleryModule.gallery', 'Description'),
            'status' => Yii::t('GalleryModule.gallery', 'Status'),
            'imagesCount' => Yii::t('GalleryModule.gallery', 'Images count'),
            'category_id' => Yii::t('GalleryModule.gallery', 'Category'),
            'sort' => Yii::t('GalleryModule.gallery', 'Sorting'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('owner', $this->owner);
        $criteria->compare('status', $this->status);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('t.sort', $this->sort);

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.sort'],
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => Yii::t('GalleryModule.gallery', 'hidden'),
            self::STATUS_PUBLIC => Yii::t('GalleryModule.gallery', 'public'),
            self::STATUS_PERSONAL => Yii::t('GalleryModule.gallery', 'my own'),
            self::STATUS_PRIVATE => Yii::t('GalleryModule.gallery', 'private'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('GalleryModule.gallery', '*неизвестно*');
    }

    public function addImage(Image $image)
    {
        $im2g = new ImageToGallery();

        $im2g->setAttributes(
            [
                'image_id' => $image->id,
                'gallery_id' => $this->id,
            ]
        );

        return $im2g->save();
    }

    /**
     * Получаем картинку для галереи:
     *
     * @param int $width - ширина
     * @param int $height - высота
     *
     * @return string image Url
     **/
    public function previewImage($width = 190, $height = 190)
    {
        $preview = Yii::app()->getTheme()->getAssetsUrl() . '/images/thumbnail.png';

        if (isset($this->preview)) {
            $preview = $this->preview->getImageUrl($width, $height);
        } elseif (!isset($this->preview) && $this->imagesCount > 0) {
            $preview = $this->images[0]->getImageUrl($width, $height);
        }

        return $preview;
    }

    /**
     * get owner name
     *
     * @return string owner name
     **/
    public function getOwnerName()
    {
        return $this->user instanceof User
            ? $this->user->getFullName()
            : '---';
    }

    /**
     *  can add photo
     *
     * @return boolean can add photo
     **/
    public function getCanAddPhoto()
    {
        return $this->status == Gallery::STATUS_PUBLIC
        || (
            ($this->status == Gallery::STATUS_PRIVATE
                || $this->status == Gallery::STATUS_PERSONAL
            ) && Yii::app()->user->getId() == $this->owner
        );
    }

    /**
     * Именованные условия
     *
     * @return array of scopes
     **/
    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status  = :status',
                'params' => [
                    ':status' => self::STATUS_PUBLIC
                ]
            ],
        ];
    }

    public function getCategoryName()
    {
        return ($this->category === null) ? '---' : $this->category->name;
    }
}
