<?php

/**
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $is_main
 * @property string $name
 * @property string $title
 *
 * @property-read Product $product
 */
class ProductImage extends \yupe\models\YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_product_image}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Attribute the static model class
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id, is_main', 'numerical', 'integerOnly' => true),
            array('name, title', 'length', 'max' => 250),
        );
    }


    public function relations()
    {
        return array(
            'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('shop');

        return array(
            'imageUpload' => array(
                'class'         =>'yupe\components\behaviors\FileUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'name',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath . '/product',
            ),
            'imageThumb'  => array(
                'class'         => 'yupe\components\behaviors\ImageThumbBehavior',
                'uploadPath'    => $module->uploadPath . '/product',
                'attributeName' => 'name',
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->name . time());
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'is_main'       => Yii::t('ShopModule.product', 'Главное'),
            'title' => Yii::t('ShopModule.product', 'Заголовок'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'is_main'       => Yii::t('ShopModule.product', 'Главное'),
            'title' => Yii::t('ShopModule.product', 'Заголовок'),
        );
    }
}