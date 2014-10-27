<?php
Yii::import('zii.behaviors.CTimestampBehavior');
Yii::import('application.modules.store.components.behaviors.EEavBehavior');
Yii::import('application.modules.comment.components.ICommentable');

/**
 * @property string $id
 * @property integer $type_id
 * @property integer $producer_id
 * @property integer $category_id
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
 * @property string $image
 *
 * @method getImageUrl($width = 0, $height = 0, $adaptiveResize = true, $options = [])
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property Producer $producer
 * @property StoreCategory $mainCategory
 * @property ProductImage $mainImage
 * @property ProductImage[] $images
 * @property ProductVariant[] $variants
 * @property Comment[] $comments
 *
 */
class Product extends yupe\models\YModel implements ICommentable
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
    private $_variants = array();
    private $_eavAttributes = null;

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
        return '{{store_product}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, alias', 'required', 'except' => 'search'),
            array('name, description, short_description, alias, price, discount_price, discount, data, status, is_special', 'filter', 'filter' => 'trim'),
            array('status, is_special, producer_id, type_id, quantity, in_stock, category_id', 'numerical', 'integerOnly' => true),
            array('price, discount_price, discount, length, height, width, weight', 'store\components\validators\NumberValidator'),
            array('name, meta_keywords, meta_title, meta_description, image', 'length', 'max' => 250),
            array('sku', 'length', 'max' => 100),
            array('alias', 'length', 'max' => 150),
            array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('StoreModule.store', 'Illegal characters in {attribute}')),
            array('alias', 'unique'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('is_special', 'in', 'range' => array(0, 1)),
            array(
                'id, type_id, producer_id, sku, name, alias, price, discount_price, discount, short_description, description, data, is_special, length, height, width, weight, quantity, in_stock, status, create_time, update_time, meta_title, meta_description, meta_keywords, category',
                'safe',
                'on' => 'search'
            ),
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
            'categories' => array(self::HAS_MANY, 'StoreCategory', array('category_id' => 'id'), 'through' => 'categoryRelation'),
            'mainCategory' => array(self::BELONGS_TO, 'StoreCategory', array('category_id' => 'id')),
            'images' => array(self::HAS_MANY, 'ProductImage', 'product_id'),
            'variants' => array(self::HAS_MANY, 'ProductVariant', array('product_id'), 'with' => array('attribute'), 'order' => 'variants.attribute_id, variants.id'),
            'comments' => array(
                self::HAS_MANY,
                'Comment',
                'model_id',
                'on' => 'model = :model AND comments.status = :status',
                'params' => array(
                    ':model' => __CLASS__,
                    ':status' => Comment::STATUS_APPROVED
                ),
                'order' => 'comments.lft'
            ),
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
            'id' => Yii::t('StoreModule.store', 'ID'),
            'category_id' => Yii::t('StoreModule.store', 'Category'),
            'type_id' => Yii::t('StoreModule.store', 'Type'),
            'name' => Yii::t('StoreModule.store', 'Title'),
            'price' => Yii::t('StoreModule.store', 'Price'),
            'discount_price' => Yii::t('StoreModule.store', 'Discount price'),
            'discount' => Yii::t('StoreModule.store', 'Discount, %'),
            'sku' => Yii::t('StoreModule.store', 'SKU'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'alias' => Yii::t('StoreModule.store', 'Alias'),
            'data' => Yii::t('StoreModule.store', 'Data'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'create_time' => Yii::t('StoreModule.store', 'Added'),
            'update_time' => Yii::t('StoreModule.store', 'Updated'),
            'user_id' => Yii::t('StoreModule.store', 'User'),
            'change_user_id' => Yii::t('StoreModule.store', 'Editor'),
            'is_special' => Yii::t('StoreModule.store', 'Special'),
            'length' => Yii::t('StoreModule.store', 'Length, m.'),
            'height' => Yii::t('StoreModule.store', 'Height, m.'),
            'width' => Yii::t('StoreModule.store', 'Width, m.'),
            'weight' => Yii::t('StoreModule.store', 'Weight, kg.'),
            'quantity' => Yii::t('StoreModule.store', 'Quantity'),
            'producer_id' => Yii::t('StoreModule.store', 'Producer'),
            'in_stock' => Yii::t('StoreModule.store', 'Stock status'),
            'category' => Yii::t('StoreModule.store', 'Category'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('StoreModule.store', 'ID'),
            'category_id' => Yii::t('StoreModule.store', 'Category'),
            'name' => Yii::t('StoreModule.store', 'Title'),
            'price' => Yii::t('StoreModule.store', 'Price'),
            'sku' => Yii::t('StoreModule.store', 'SKU'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'alias' => Yii::t('StoreModule.store', 'Alias'),
            'data' => Yii::t('StoreModule.store', 'Data'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'create_time' => Yii::t('StoreModule.store', 'Added'),
            'update_time' => Yii::t('StoreModule.store', 'Edited'),
            'user_id' => Yii::t('StoreModule.store', 'User'),
            'change_user_id' => Yii::t('StoreModule.store', 'Editor'),
            'is_special' => Yii::t('StoreModule.store', 'Special'),
            'length' => Yii::t('StoreModule.store', 'Length, m.'),
            'height' => Yii::t('StoreModule.store', 'Height, m.'),
            'width' => Yii::t('StoreModule.store', 'Width, m.'),
            'weight' => Yii::t('StoreModule.store', 'Weight, kg.'),
            'quantity' => Yii::t('StoreModule.store', 'Quantity'),
            'producer_id' => Yii::t('StoreModule.store', 'Producer'),
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
        $criteria->compare('category_id', $this->category_id);

        if ($this->category) {
            $criteria->with = array('categoryRelation' => array('together' => true));
            $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
            $criteria->params = CMap::mergeArray($criteria->params, [':category_id' => $this->category]);
        }

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('store');

        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ),
            'eavAttr' => array(
                'class' => 'application.modules.store.components.behaviors.EEavBehavior',
                'tableName' => '{{store_product_attribute_eav}}',
                'entityField' => 'product_id',
            ),
            'imageUpload' => array(
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios' => array('insert', 'update'),
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module->uploadPath . '/product',
                'resizeOnUpload' => true,
                'resizeOptions' => array(
                    'maxWidth' => 900,
                    'maxHeight' => 900,
                ),
                'defaultImage' => $module->getAssetsUrl() . '/img/nophoto.jpg',
            ),
        );
    }

    public function beforeValidate()
    {
        if (!$this->alias) {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        foreach ((array)$this->_eavAttributes as $name => $value) {
            $model = Attribute::model()->getAttributeByName($name);
            if ($model->required && !$value) {
                $this->addError('eav.' . $name, Yii::t("StoreModule.store", "Атрибут \"title\" обязателен", array('title' => $model->title)));
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
            self::STATUS_ZERO => Yii::t('StoreModule.store', 'Not available'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('StoreModule.store', 'Not active'),
        );
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    public function getSpecialList()
    {
        return array(
            self::SPECIAL_NOT_ACTIVE => Yii::t('StoreModule.store', 'No'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Yes'),
        );
    }

    public function getSpecial()
    {
        $data = $this->getSpecialList();
        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('StoreModule.store', '*unknown*');
    }

    public function getInStockList()
    {
        return array(
            self::STATUS_IN_STOCK => Yii::t('StoreModule.store', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('StoreModule.store', 'Not in stock'),
        );
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->mainCategory instanceof StoreCategory
            ? CHtml::link($this->mainCategory->name, array("/store/categoryBackend/view", "id" => $this->mainCategory->id))
            : '---';
    }

    public function getProducerLink()
    {
        return $this->producer instanceof Producer
            ? CHtml::link($this->producer->name_short, array("/store/producerBackend/view", "id" => $this->producer_id))
            : '---';
    }

    /**
     * Устанавливает дополнительные категории товара
     * @param $categories - список id категорий
     * @return bool
     */
    public function setProductCategories($categories)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        $categories = is_array($categories) ? $categories : (array)$categories;
        $categories = array_diff($categories, (array)$this->category_id);

        try
        {
            foreach ($categories as $category_id) {
                $model = ProductCategory::model()->findByAttributes(array('product_id' => $this->id, 'category_id' => $category_id));
                if (!$model) {
                    $model = new ProductCategory();
                    $model->category_id = $category_id;
                    $model->product_id = $this->id;
                }
                $model->save();
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('product_id = :product_id');
            $criteria->params = array(':product_id' => $this->id);
            $criteria->addNotInCondition('category_id', $categories);
            ProductCategory::model()->deleteAll($criteria);
            $transaction->commit();
            return true;
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public function getCategoriesIdList()
    {
        $cats = ProductCategory::model()->findAllByAttributes(array('product_id' => $this->id));
        $list = array();
        foreach ($cats as $key => $cat) {
            $list[] = $cat->category_id;
        }
        return $list;
    }

    public function setTypeAttributes($attributes)
    {
        $this->_eavAttributes = $attributes;
    }

    /**
     * @param $attributes
     */
    public function updateEavAttributes($attributes)
    {
        if (!is_array($attributes)) {
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

    public function beforeDelete()
    {
        // чтобы удалились файлики
        foreach ((array)$this->images as $image) {
            $image->delete();
        }
        return parent::beforeDelete();
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->updateEavAttributes($this->_eavAttributes);
        $this->updateVariants($this->_variants);
    }

    public function setProductVariants($variants)
    {
        if (is_array($variants)) {
            $this->_variants = $variants;
        }
    }

    private function updateVariants($variants)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try
        {
            $productVariants = array();
            foreach ($variants as $var) {
                $variant = null;
                if (isset($var['id'])) {
                    $variant = ProductVariant::model()->findByPk($var['id']);
                }
                $variant = $variant ?: new ProductVariant();
                $variant->attributes = $var;
                $variant->product_id = $this->id;
                if ($variant->save()) {
                    $productVariants[] = $variant->id;
                }
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('product_id = :product_id');
            $criteria->params = array(':product_id' => $this->id);
            $criteria->addNotInCondition('id', $productVariants);
            ProductVariant::model()->deleteAll($criteria);
            $transaction->commit();
            return true;
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public function getBasePrice()
    {
        return $this->price;
    }

    public function getResultPrice()
    {
        return (float)$this->discount_price ?: (float)$this->price * (1 - ((float)$this->discount ?: 0) / 100);
    }

    /**
     * @return mixed id
     */
    public function getId()
    {
        $variantIds = array_map(
            function ($var) {
                return $var->id;
            },
            $this->selectedVariants
        );
        sort($variantIds);
        return 'product_' . $this->id . '_' . join('_', $variantIds);
    }

    /**
     * @param array $variantsIds
     * @return float|mixed
     */
    public function getPrice($variantsIds = array())
    {
        $variants = array();
        $variantsIds = (array)$variantsIds;
        if ($variantsIds) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition("id", $variantsIds);
            $variants = ProductVariant::model()->findAll($criteria);
        } else {
            $variants = $this->selectedVariants;
        }
        $basePrice = $this->getResultPrice();
        /* выбираем вариант, который меняет базовую цену максимально */
        /* @var $variants ProductVariant[] */

        $hasBasePriceVariant = false;
        foreach ($variants as $variant) {
            if ($variant->type == ProductVariant::TYPE_BASE_PRICE) {
                if (!$hasBasePriceVariant) {
                    $hasBasePriceVariant = true;
                    $basePrice = $variant->amount;
                } else {
                    if ($basePrice < $variant->amount) {
                        $basePrice = $variant->amount;
                    }
                }
            }
        }
        $newPrice = $basePrice;
        foreach ($variants as $variant) {
            switch ($variant->type) {
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

    public function getTitle()
    {
        return $this->name;
    }

    public function getLink()
    {
        return Yii::app()->createUrl('/store/catalog/show', array('name' => $this->alias));
    }

    public function getMainCategoryId()
    {
        return is_object($this->mainCategory) ? $this->mainCategory->id : null;
    }

    public function getTypeAttributes()
    {
        if (empty($this->type)) {
            return [];
        }

        return (array)$this->type->typeAttributes;
    }

    public function getProducerName()
    {
        if (empty($this->producer)) {
            return null;
        }

        return $this->producer->name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isInStock()
    {
        return $this->in_stock;
    }

    public function getMetaTitle()
    {
        return $this->meta_title ?: $this->name;
    }

    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    public function getImages()
    {
        return $this->images;
    }

    public function getAttributeGroups()
    {
        $attributeGroups = [];

        foreach ($this->getTypeAttributes() as $attribute) {
            if ($attribute->group) {
                $attributeGroups[$attribute->group->name][] = $attribute;
            } else {
                $attributeGroups[Yii::t('StoreModule.attribute', 'Без группы')][] = $attribute;
            }
        }

        return $attributeGroups;
    }


    public function getVariantsGroup()
    {
        $variantsGroups = [];

        foreach ((array)$this->variants as $variant) {
            $variantsGroups[$variant->attribute->title][] = $variant;
        }

        return $variantsGroups;
    }


    public function getDiscountPrice()
    {
        return $this->discount_price;
    }

}
