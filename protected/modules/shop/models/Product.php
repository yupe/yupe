<?php

/**
 * @property string $id
 * @property integer $type_id
 * @property integer $producer_id
 * @property string $sku
 * @property string $name
 * @property string $alias
 * @property double $price
 * @property double $discount_price
 * @property double $discount
 * @property string $short_description
 * @property string $description
 * @property string $data
 * @property integer $is_special
 * @property double $length
 * @property double $height
 * @property double $width
 * @property double $weight
 * @property integer $quantity
 * @property integer $in_stock
 * @property integer $status
 * @property datetime $create_time
 * @property datetime $update_time
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property Producer $producer
 * @property Category $mainCategory
 * @property ProductImage $mainImage
 * @property ProductImage[] $images
 * @property ProductImage[] $imageNotMain
 * @property ProductVariant[] $variants
 *
 */
Yii::import('zii.behaviors.CTimestampBehavior');
Yii::import('application.modules.shop.components.behaviors.EEavBehavior');
Yii::import('application.modules.shop.extensions.shopping-cart.*');

class Product extends yupe\models\YModel implements IECartPosition
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE = 1;

    const STATUS_ZERO = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    const STATUS_NOT_IN_STOCK = 0;
    const STATUS_IN_STOCK = 1;

    public $category;
    public $selectedVariants = array();

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Good the static model class
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
        return '{{shop_product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, alias', 'required', 'except' => 'search'),
            array('name, description, short_description, alias, price, discount_price, discount, data, status, is_special', 'filter', 'filter' => 'trim'),
            array('status, is_special, producer_id, type_id, quantity, in_stock', 'numerical', 'integerOnly' => true),
            array('status, is_special', 'length', 'max' => 11),
            array('price, discount_price, discount, length, height, width, weight', 'shop\components\validators\NumberValidator'),
            array('name, meta_keywords, meta_title, meta_description', 'length', 'max' => 250),
            array('sku', 'length', 'max' => 100),
            array('alias', 'length', 'max' => 150),
            array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('ShopModule.product', 'Illegal characters in {attribute}')),
            array('alias', 'unique'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('is_special', 'in', 'range' => array(0, 1)),
            array('id, type_id, producer_id, sku, name, alias, price, discount_price, discount, short_description, description, data, is_special, length, height, width, weight, quantity, in_stock, status, create_time, update_time, meta_title, meta_description, meta_keywords, category', 'safe', 'on' => 'search'),
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
            'type' => array(self::BELONGS_TO, 'Type', 'type_id'),
            'producer' => array(self::BELONGS_TO, 'Producer', 'producer_id'),
            'categoryRelation' => array(self::HAS_MANY, 'ProductCategory', 'product_id'),
            'categories' => array(self::HAS_MANY, 'Category', array('category_id' => 'id'), 'through' => 'categoryRelation'),
            'mainCategory' => array(self::HAS_ONE, 'Category', array('category_id' => 'id'), 'through' => 'categoryRelation', 'condition' => 'categoryRelation.is_main = 1'),
            'images' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
            'mainImage' => array(self::HAS_ONE, 'ProductImage', 'product_id', 'condition' => 'is_main = 1'),
            'imagesNotMain' => array(self::HAS_MANY, 'ProductImage', 'product_id', 'condition' => 'is_main = 0'),
            'variants' => array(self::HAS_MANY, 'ProductVariant', array('product_id'), 'with' => array('attribute', 'option'), 'order' => 'variants.id'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_ACTIVE),
            ),
            'specialOffer' => array(
                'condition' => 'is_special = :is_special',
                'params' => array(':is_special' => self::SPECIAL_ACTIVE),
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('ShopModule.product', 'ID'),
            'category_id' => Yii::t('ShopModule.product', 'Category'),
            'type_id' => Yii::t('ShopModule.product', 'Type'),
            'name' => Yii::t('ShopModule.product', 'Title'),
            'price' => Yii::t('ShopModule.product', 'Price'),
            'discount_price' => Yii::t('ShopModule.product', 'Discount price'),
            'discount' => Yii::t('ShopModule.product', 'Discount, %'),
            'sku' => Yii::t('ShopModule.product', 'SKU'),
            'image' => Yii::t('ShopModule.product', 'Image'),
            'short_description' => Yii::t('ShopModule.product', 'Short description'),
            'description' => Yii::t('ShopModule.product', 'Description'),
            'alias' => Yii::t('ShopModule.product', 'Alias'),
            'data' => Yii::t('ShopModule.product', 'Data'),
            'status' => Yii::t('ShopModule.product', 'Status'),
            'create_time' => Yii::t('ShopModule.product', 'Added'),
            'update_time' => Yii::t('ShopModule.product', 'Updated'),
            'user_id' => Yii::t('ShopModule.product', 'User'),
            'change_user_id' => Yii::t('ShopModule.product', 'Editor'),
            'is_special' => Yii::t('ShopModule.product', 'Special'),
            'length' => Yii::t('ShopModule.product', 'Length, m.'),
            'height' => Yii::t('ShopModule.product', 'Height, m.'),
            'width' => Yii::t('ShopModule.product', 'Width, m.'),
            'weight' => Yii::t('ShopModule.product', 'Weight, kg.'),
            'quantity' => Yii::t('ShopModule.product', 'Quantity'),
            'producer_id' => Yii::t('ShopModule.product', 'Producer'),
            'in_stock' => Yii::t('ShopModule.product', 'Stock status'),
            'category' => Yii::t('ShopModule.product', 'Category'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('ShopModule.product', 'ID'),
            'category_id' => Yii::t('ShopModule.product', 'Category'),
            'name' => Yii::t('ShopModule.product', 'Title'),
            'price' => Yii::t('ShopModule.product', 'Price'),
            'sku' => Yii::t('ShopModule.product', 'SKU'),
            'image' => Yii::t('ShopModule.product', 'Image'),
            'short_description' => Yii::t('ShopModule.product', 'Short description'),
            'description' => Yii::t('ShopModule.product', 'Description'),
            'alias' => Yii::t('ShopModule.product', 'Alias'),
            'data' => Yii::t('ShopModule.product', 'Data'),
            'status' => Yii::t('ShopModule.product', 'Status'),
            'create_time' => Yii::t('ShopModule.product', 'Added'),
            'update_time' => Yii::t('ShopModule.product', 'Edited'),
            'user_id' => Yii::t('ShopModule.product', 'User'),
            'change_user_id' => Yii::t('ShopModule.product', 'Editor'),
            'is_special' => Yii::t('ShopModule.product', 'Special'),
            'length' => Yii::t('ShopModule.product', 'Length, m.'),
            'height' => Yii::t('ShopModule.product', 'Height, m.'),
            'width' => Yii::t('ShopModule.product', 'Width, m.'),
            'weight' => Yii::t('ShopModule.product', 'Weight, kg.'),
            'quantity' => Yii::t('ShopModule.product', 'Quantity'),
            'producer_id' => Yii::t('ShopModule.product', 'Producer'),
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
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('sku', $this->sku, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('is_special', $this->is_special, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('producer_id', $this->producer_id);

        if ($this->category)
        {
            $criteria->with = array('categoryRelation' => array('together' => true));
            $criteria->compare('categoryRelation.category_id', $this->category);
        }

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ),
            'eavAttr' => array(
                'class' => 'application.modules.shop.components.behaviors.EEavBehavior',
                'tableName' => '{{shop_product_attribute_eav}}',
                'entityField' => 'product_id',
            )
        );
    }

    public function beforeValidate()
    {
        if (!$this->alias)
        {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        foreach ((array)$this->_eavAttributes as $name => $value)
        {
            $model = Attribute::model()->getAttributeByName($name);
            if ($model->required && !$value)
            {
                $this->addError('eav.' . $name, Yii::t("ShopModule.product", "Атрибут \"title\" обязателен", array('title' => $model->title)));
            }
        }

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ZERO => Yii::t('ShopModule.product', 'Not available'),
            self::STATUS_ACTIVE => Yii::t('ShopModule.product', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('ShopModule.product', 'Not active'),
        );
    }

    public function getStatusTitle()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ShopModule.product', '*unknown*');
    }

    public function getSpecialList()
    {
        return array(
            self::SPECIAL_NOT_ACTIVE => Yii::t('ShopModule.product', 'No'),
            self::STATUS_ACTIVE => Yii::t('ShopModule.product', 'Yes'),
        );
    }

    public function getSpecial()
    {
        $data = $this->specialList;
        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('ShopModule.product', '*unknown*');
    }

    public function getInStockList()
    {
        return array(
            self::STATUS_IN_STOCK => Yii::t('ShopModule.product', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('ShopModule.product', 'Not in stock'),
        );
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->mainCategory instanceof Category
            ? CHtml::link($this->mainCategory->name, array("/shop/categoryBackend/view", "id" => $this->mainCategory->id))
            : '---';
    }

    public function getProducerLink()
    {
        return $this->producer instanceof Producer
            ? CHtml::link($this->producer->name_short, array("/shop/producerBackend/view", "id" => $this->producer_id))
            : '---';
    }

    public function setProductCategories($categories, $mainCategory)
    {
        $categories   = is_array($categories) ? $categories : (array)$categories;
        $mainCategory = $mainCategory ? : $categories[0];
        if (!in_array($mainCategory, $categories))
        {
            array_push($categories, $mainCategory);
        }

        foreach ($categories as $category_id)
        {
            $model = ProductCategory::model()->findByAttributes(array('product_id' => $this->id, 'category_id' => $category_id));
            if (!$model)
            {
                $model              = new ProductCategory();
                $model->category_id = $category_id;
                $model->product_id  = $this->id;
            }

            $model->is_main = ($category_id == $mainCategory) ? 1 : 0;
            $model->save();
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('product_id = :product_id');
        $criteria->params = array(':product_id' => $this->id);
        $criteria->addNotInCondition('category_id', $categories);
        ProductCategory::model()->deleteAll($criteria);
    }

    public function getCategoriesIdList()
    {
        $cats = ProductCategory::model()->findAllByAttributes(array('product_id' => $this->id), 'is_main = 0');
        $list = array();
        foreach ($cats as $key => $cat)
        {
            $list[] = $cat->category_id;
        }
        return $list;
    }

    private $_eavAttributes = null;

    public function setTypeAttributes($attributes)
    {
        $this->_eavAttributes = $attributes;
    }

    /**
     * @param $attributes
     */
    public function updateEavAttributes($attributes)
    {
        if (!is_array($attributes))
        {
            return;
        }
        $this->deleteEavAttributes(array(), true);

        $attributes = array_filter($attributes, 'strlen');
        $this->setEavAttributes($attributes, true);
    }

    public function attr($attribute)
    {
        return isset($this->_eavAttributes[$attribute]) ? $this->_eavAttributes[$attribute] : $this->getEavAttribute($attribute);
    }

    public function afterDelete()
    {
        foreach ((array)$this->images as $image)
        {
            $image->delete();
        }
        foreach ((array)$this->variants as $variant)
        {
            $variant->delete();
        }
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->updateEavAttributes($this->_eavAttributes);
        $this->updateVariants($this->_variants);
    }

    private $_variants = array();

    public function setProductVariants($variants)
    {
        if (is_array($variants))
        {
            $this->_variants = $variants;
        }
    }

    private function updateVariants($variants)
    {
        $productVariants = array();
        foreach ($variants as $var)
        {
            $variant = null;
            if (isset($var['id']))
            {
                $variant = ProductVariant::model()->findByPk($var['id']);
            }
            $variant             = $variant ? : new ProductVariant();
            $variant->attributes = $var;
            $variant->product_id = $this->id;
            if ($variant->save())
            {
                $productVariants[] = $variant->id;
            }

        }
        //var_dump($variants);
        //die();
        $criteria = new CDbCriteria();
        $criteria->addCondition('product_id = :product_id');
        $criteria->params = array(':product_id' => $this->id);
        $criteria->addNotInCondition('id', $productVariants);
        ProductVariant::model()->deleteAll($criteria);
    }

    public function getBasePrice()
    {
        return $this->price;
    }

    public function getResultPrice()
    {
        return (float)$this->discount_price ? : (float)$this->price * (1 - ((float)$this->discount ? : 0) / 100);
    }

    /**
     * @return mixed id
     */
    public function getId()
    {
        $variantIds = array_map(function ($var)
            {
                return $var->id;
            },
            $this->selectedVariants);
        sort($variantIds);
        return 'product_' . $this->id . '_' . join('_', $variantIds);
    }

    /**
     * @param array $variantsIds
     * @return float|mixed
     */
    public function getPrice($variantsIds = array())
    {
        $basePrice = $this->getResultPrice();
        $newPrice  = $basePrice;
        $variants  = array();
        $variantsIds = (array)$variantsIds;
        if ($variantsIds)
        {
            $criteria = new CDbCriteria();
            $criteria->addInCondition("id", $variantsIds);
            $variants = ProductVariant::model()->findAll($criteria);
        }
        else
        {
            $variants = $this->selectedVariants;
        }
        foreach ($variants as $variant)
        {
            switch ($variant->type)
            {
                case ProductVariant::TYPE_SUM:
                    $newPrice += $variant->amount;
                    break;
                case ProductVariant::TYPE_PERCENT:
                    $newPrice += $basePrice * ($variant->amount / 100);
                    break;
            }
        }
        return $newPrice;
    }
}