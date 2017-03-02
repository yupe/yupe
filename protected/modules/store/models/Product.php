<?php
use yupe\widgets\YPurifier;

Yii::import('zii.behaviors.CTimestampBehavior');
Yii::import('application.modules.comment.components.ICommentable');

/**
 * @property string $id
 * @property integer $type_id
 * @property integer $producer_id
 * @property integer $category_id
 * @property string $sku
 * @property string $name
 * @property string $slug
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
 * @property double $average_price
 * @property double $purchase_price
 * @property double $recommended_price
 * @property integer $position
 * @property string $external_id
 * @property string $title
 * @property string $meta_canonical
 * @property string $image_alt
 * @property string $image_title
 * @property string $view
 *
 * @method getImageUrl
 *
 * The followings are the available model relations:
 * @property Type $type
 * @property Producer $producer
 * @property StoreCategory $category
 * @property ProductImage $mainImage
 * @property ProductImage[] $images
 * @property ProductVariant[] $variants
 * @property Comment[] $comments
 * @property StoreCategory[] $categories
 *
 */
class Product extends yupe\models\YModel implements ICommentable
{
    /**
     *
     */
    const SPECIAL_NOT_ACTIVE = 0;
    /**
     *
     */
    const SPECIAL_ACTIVE = 1;

    /**
     *
     */
    const STATUS_NOT_ACTIVE = 0;
    /**
     *
     */
    const STATUS_ACTIVE = 1;

    /**
     *
     */
    const STATUS_NOT_IN_STOCK = 0;
    /**
     *
     */
    const STATUS_IN_STOCK = 1;

    /**
     * @var array
     */
    public $selectedVariants = [];

    /**
     * @var
     */
    protected $_typeAttributes;

    /**
     * @var array кеш getVariantsOptions
     */
    protected $_variantsOptions = false;

    /**
     * @var array
     */
    protected $_attributesValues;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product Static model class
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
        return [
            [
                'name, title, description, short_description, slug, price, discount_price, discount, data, status, is_special',
                'filter',
                'filter' => 'trim',
            ],
            [
                'name, title, description, short_description, slug, price, discount_price, discount, data, status, is_special',
                'filter',
                'filter' => [$obj = new YPurifier(), 'purify'],
            ],
            ['name, slug', 'required'],
            [
                'status, is_special, producer_id, type_id, quantity, in_stock, category_id',
                'numerical',
                'integerOnly' => true,
            ],
            [
                'price, average_price, purchase_price, recommended_price, discount_price, discount, length, height, width, weight',
                'store\components\validators\NumberValidator',
            ],
            [
                'name, title, meta_keywords, meta_title, meta_description, meta_canonical, image, image_alt, image_title',
                'length',
                'max' => 250,
            ],
            ['discount_price, discount, average_price, purchase_price, recommended_price', 'default', 'value' => null],
            ['sku, view', 'length', 'max' => 100],
            ['slug', 'length', 'max' => 150],
            ['external_id', 'length', 'max' => 100],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('StoreModule.store', 'Illegal characters in {attribute}'),
            ],
            ['slug', 'unique'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['is_special', 'boolean'],
            ['length, height, width, weight', 'default', 'setOnEmpty' => true, 'value' => null],
            ['meta_canonical', 'url'],
            [
                'id, type_id, producer_id, sku, name, slug, price, discount_price, discount, short_description, description, data, is_special, length, height, width, weight, quantity, in_stock, status, create_time, update_time, meta_title, meta_description, meta_keywords, category_id',
                'safe',
                'on' => 'search',
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'type' => [self::BELONGS_TO, 'Type', 'type_id'],
            'producer' => [self::BELONGS_TO, 'Producer', 'producer_id'],
            'categoryRelation' => [self::HAS_MANY, 'ProductCategory', 'product_id'],
            'categories' => [self::HAS_MANY, 'StoreCategory', ['category_id' => 'id'], 'through' => 'categoryRelation'],
            'category' => [self::BELONGS_TO, 'StoreCategory', ['category_id' => 'id']],
            'images' => [self::HAS_MANY, 'ProductImage', 'product_id'],
            'variants' => [
                self::HAS_MANY,
                'ProductVariant',
                ['product_id'],
                'with' => ['attribute'],
                'order' => 'variants.position ASC',
            ],
            'comments' => [
                self::HAS_MANY,
                'Comment',
                'model_id',
                'on' => 'model = :model AND comments.status = :status',
                'params' => [
                    ':model' => __CLASS__,
                    ':status' => Comment::STATUS_APPROVED,
                ],
                'order' => 'comments.lft',
            ],
            'linkedProductsRelation' => [self::HAS_MANY, 'ProductLink', 'product_id', 'joinType' => 'INNER JOIN'],
            'linkedProducts' => [
                self::HAS_MANY,
                'Product',
                ['linked_product_id' => 'id'],
                'through' => 'linkedProductsRelation',
                'joinType' => 'INNER JOIN',
            ],
            'attributesValues' => [
                self::HAS_MANY,
                'AttributeValue',
                'product_id',
                'with' => ['attribute' => ['alias' => 'attr']],
            ],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
            ],
            'specialOffer' => [
                'condition' => 't.is_special = :is_special',
                'params' => [':is_special' => self::SPECIAL_ACTIVE],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
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
            'slug' => Yii::t('StoreModule.store', 'Alias'),
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
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'purchase_price' => Yii::t('StoreModule.store', 'Purchase price'),
            'average_price' => Yii::t('StoreModule.store', 'Average price'),
            'recommended_price' => Yii::t('StoreModule.store', 'Recommended price'),
            'position' => Yii::t('StoreModule.store', 'Position'),
            'external_id' => Yii::t('StoreModule.store', 'External id'),
            'title' => Yii::t('StoreModule.store', 'SEO_Title'),
            'meta_canonical' => Yii::t('StoreModule.store', 'Canonical'),
            'image_alt' => Yii::t('StoreModule.store', 'Image alt'),
            'image_title' => Yii::t('StoreModule.store', 'Image title'),
            'view' => Yii::t('StoreModule.store', 'Template'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'category_id' => Yii::t('StoreModule.store', 'Category'),
            'name' => Yii::t('StoreModule.store', 'Title'),
            'price' => Yii::t('StoreModule.store', 'Price'),
            'sku' => Yii::t('StoreModule.store', 'SKU'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'slug' => Yii::t('StoreModule.store', 'Alias'),
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
            'purchase_price' => Yii::t('StoreModule.store', 'Purchase price'),
            'average_price' => Yii::t('StoreModule.store', 'Average price'),
            'recommended_price' => Yii::t('StoreModule.store', 'Recommended price'),
            'title' => Yii::t('StoreModule.store', 'SEO_Title'),
            'meta_canonical' => Yii::t('StoreModule.store', 'Canonical'),
            'image_alt' => Yii::t('StoreModule.store', 'Image alt'),
            'image_title' => Yii::t('StoreModule.store', 'Image title'),
            'view' => Yii::t('StoreModule.store', 'Template'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = ['category', 'categories'];

        $criteria->compare('id', $this->id);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.price', $this->price);
        $criteria->compare('t.discount_price', $this->discount_price);
        $criteria->compare('t.sku', $this->sku, true);
        $criteria->compare('t.short_description', $this->short_description, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.slug', $this->slug, true);
        $criteria->compare('t.data', $this->data, true);
        $criteria->compare('t.is_special', $this->is_special);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.create_time', $this->create_time, true);
        $criteria->compare('t.update_time', $this->update_time, true);
        $criteria->compare('t.producer_id', $this->producer_id);
        $criteria->compare('t.purchase_price', $this->purchase_price);
        $criteria->compare('t.average_price', $this->average_price);
        $criteria->compare('t.recommended_price', $this->recommended_price);
        $criteria->compare('t.in_stock', $this->in_stock);
        $criteria->compare('t.quantity', $this->quantity);

        if ($this->category_id) {
            $categoryCriteria = new CDbCriteria();
            $categoryCriteria->compare('t.category_id', $this->category_id);
            $categoryCriteria->addCondition(sprintf('t.id IN (SELECT product_id FROM {{store_product_category}} WHERE category_id = :category_id)'),
                'OR');
            $categoryCriteria->params = CMap::mergeArray($categoryCriteria->params,
                [':category_id' => $this->category_id]);
            $criteria->mergeWith($categoryCriteria);
        }

        return new CActiveDataProvider(
            'Product', [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.update_time DESC, t.create_time DESC'],
            ]
        );
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $module = Yii::app()->getModule('store');

        return [
            'time' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ],
            'upload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module->uploadPath.'/product',
                'resizeOnUpload' => true,
                'resizeOptions' => [
                    'maxWidth' => 900,
                    'maxHeight' => 900,
                ],
            ],
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior',
            ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        foreach ($this->getTypeAttributes() as $attribute) {

            if ($attribute->isType(Attribute::TYPE_CHECKBOX)) {
                continue;
            }

            if ($attribute->isRequired() && (!isset($this->_typeAttributes[$attribute->id]) || '' === $this->_typeAttributes[$attribute->id])
            ) {
                $this->addError(
                    $attribute->title,
                    Yii::t("StoreModule.store", "{title} attribute is required", ['title' => $attribute->title])
                );
            }
        }

        if (!$this->isInStock()) {
            $this->setEmptyQuantity();
        }

        return parent::beforeValidate();
    }

    /**
     * @return $this
     */
    public function setEmptyQuantity()
    {
        $this->quantity = 0;

        return $this;
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('StoreModule.store', 'Not active'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    /**
     * @return array
     */
    public function getSpecialList()
    {
        return [
            self::SPECIAL_NOT_ACTIVE => Yii::t('StoreModule.store', 'No'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Yes'),
        ];
    }

    /**
     * @return int
     */
    public function isSpecial()
    {
        return $this->is_special;
    }

    /**
     * @return string
     */
    public function getSpecial()
    {
        $data = $this->getSpecialList();

        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('StoreModule.store', '*unknown*');
    }

    /**
     * @return array
     */
    public function getInStockList()
    {
        return [
            self::STATUS_IN_STOCK => Yii::t('StoreModule.store', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('StoreModule.store', 'Not in stock'),
        ];
    }

    /**
     * Устанавливает дополнительные категории товара
     *
     * @param array $categoriesId - список id категорий
     * @return bool
     *
     */
    public function saveCategories(array $categoriesId)
    {
        $categoriesId = array_diff($categoriesId, (array)$this->category_id);

        $currentCategories = Yii::app()->getDb()->createCommand()
            ->select('category_id')
            ->from('{{store_product_category}}')
            ->where('product_id = :id', [':id' => $this->id])
            ->queryColumn();

        if ($categoriesId == $currentCategories) {
            return true;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            Yii::app()->getDb()->createCommand()
                ->delete('{{store_product_category}}', 'product_id = :id', [':id' => $this->id]);

            if (!empty($categoriesId)) {

                $data = [];

                foreach ($categoriesId as $id) {
                    $data[] = [
                        'product_id' => $this->id,
                        'category_id' => (int)$id,
                    ];
                }

                Yii::app()->getDb()->getCommandBuilder()
                    ->createMultipleInsertCommand('{{store_product_category}}', $data)
                    ->execute();
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getCategoriesId()
    {
        return Yii::app()->getDb()->createCommand()
            ->select('category_id')
            ->from('{{store_product_category}}')
            ->where('product_id = :id', [':id' => $this->id])
            ->queryColumn();
    }

    /**
     * @param array $attributes
     * @return bool
     */
    public function saveTypeAttributes(array $attributes)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            foreach ($attributes as $attribute => $value) {

                if (null === $value) {
                    continue;
                }

                $model = AttributeValue::model()->find('product_id = :product AND attribute_id = :attribute', [
                    ':product' => $this->id,
                    ':attribute' => $attribute,
                ]);

                //множественные значения
                if (is_array($value)) {

                    AttributeValue::model()->deleteAll('product_id = :product AND attribute_id = :attribute', [
                        ':product' => $this->id,
                        ':attribute' => $attribute,
                    ]);

                    foreach ($value as $val) {
                        $model = new AttributeValue();
                        if (false === $model->store($attribute, $val, $this)) {
                            throw new InvalidArgumentException('Error store attribute!');
                        }
                    }

                } else {

                    $model = $model ?: new AttributeValue();

                    if (false === $model->store($attribute, $value, $this)) {
                        throw new InvalidArgumentException('Error store attribute!');
                    }
                }
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }


    /**
     * @param $attribute
     * @return string
     */
    public function attributeFile($attribute)
    {
        $value = $this->attribute($attribute);

        if (null === $value) {
            return null;
        }

        return Yii::app()->getRequest()->getBaseUrl(true).'/'.Yii::app()->getModule('yupe')->uploadPath.'/'.Yii::app()->getModule('store')->uploadPath.'/product/'.$value;
    }

    /**
     * @param $attribute
     * @param null $default
     * @return bool|float|int|null|string|array
     */
    public function attribute($attribute, $default = null)
    {
        if ($this->getIsNewRecord()) {
            return null;
        }

        $this->loadAttributes();

        $attributeName = $attribute instanceof Attribute ? $attribute->name : $attribute;

        if (!array_key_exists($attributeName, $this->_attributesValues)) {
            return $default;
        }

        //если атрибут имеет множество значений - вернем их массив
        if (is_array($this->_attributesValues[$attributeName])) {
            $values = [];
            foreach ($this->_attributesValues[$attributeName] as $attribute) {
                $value = $attribute->value($default);

                if (is_null($value)) {
                    continue;
                }

                $values[] = $value;
            }

            return $values;
        }

        return $this->_attributesValues[$attributeName]->value($default);
    }

    /**
     *
     */
    protected function loadAttributes()
    {
        if (null === $this->_attributesValues) {

            $this->_attributesValues = [];

            foreach ($this->attributesValues as $attribute) {

                //собираем массив multiple values attributes
                if ($attribute->attribute->isMultipleValues()) {
                    $this->_attributesValues[$attribute->attribute->name][] = $attribute;
                } else {
                    $this->_attributesValues[$attribute->attribute->name] = $attribute;
                }
            }
        }
    }


    /**
     *
     */
    public function attributes()
    {
        return $this->attributesValues;
    }


    /**
     * @return array
     */
    public function getTypesAttributesValues()
    {
        $data = [];

        foreach ($this->attributesValues as $attribute) {
            $data[$attribute->attribute_id] = $attribute->value();
        }

        return $data;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        // чтобы удалились файлики
        foreach ((array)$this->images as $image) {
            $image->delete();
        }

        return parent::beforeDelete();
    }

    /**
     * @param array $attributes
     * @param array $typeAttributes
     * @param array $variants
     * @param array $categories
     * @return bool
     */
    public function saveData(array $attributes, array $typeAttributes, array $variants, array $categories = [])
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            $this->setAttributes($attributes);
            $this->setTypeAttributes($typeAttributes);

            if ($this->save()) {

                $this->saveVariants($variants);
                $this->saveCategories($categories);
                $this->saveTypeAttributes($typeAttributes);

                $transaction->commit();

                return true;
            }

            return false;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @param array $variants
     * @return bool
     */
    private function saveVariants(array $variants)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $productVariants = [];
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
            $criteria->params = [':product_id' => $this->id];
            $criteria->addCondition('product_id = :product_id');
            $criteria->addNotInCondition('id', $productVariants);
            ProductVariant::model()->deleteAll($criteria);
            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @return float
     */
    public function getBasePrice()
    {
        return (float)$this->price;
    }

    /**
     * @return float
     */
    public function getResultPrice()
    {
        return (float)$this->getDiscountPrice() ?: (float)$this->price * (1 - ((float)$this->discount ?: 0) / 100);
    }

    /**
     * @return float
     */
    public function getDiscountPrice()
    {
        return $this->discount_price;
    }

    /**
     * @return bool
     */
    public function hasDiscount()
    {
        if ($this->discount_price || $this->discount) {
            return true;
        }

        return false;
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

        return 'product_'.$this->id.'_'.implode('_', $variantIds);
    }

    /**
     * @param array $variantsIds
     * @return float|mixed
     */
    public function getPrice(array $variantsIds = [])
    {
        $variants = [];
        if (!empty($variantsIds)) {
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

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title ?: $this->name;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return ProductHelper::getUrl($this);
    }

    /**
     * @return null|string
     */
    public function getCategoryId()
    {
        return is_object($this->category) ? $this->category->id : null;
    }

    /**
     * @return array
     */
    public function getTypeAttributes()
    {
        if (empty($this->type)) {
            return [];
        }

        return (array)$this->type->typeAttributes;
    }

    /**
     * @return null|string
     */
    public function getProducerName()
    {
        if (empty($this->producer)) {
            return null;
        }

        return $this->producer->name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function isInStock()
    {
        return $this->in_stock;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title ?: $this->name;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * Get canonical url
     *
     * @return string
     */
    public function getMetaCanonical()
    {
        return $this->meta_canonical;
    }

    /**
     * @return ProductImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return array
     */
    public function getAttributeGroups()
    {
        if (empty($this->type)) {
            return [];
        }

        return $this->type->getAttributeGroups();
    }

    /**
     * @return ProductVariant[]
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @return array
     */
    public function getVariantsGroup()
    {
        $variantsGroups = [];

        foreach ((array)$this->variants as $variant) {
            $variantsGroups[$variant->attribute->title][] = $variant;
        }

        return $variantsGroups;
    }

    /**
     * Функция для подготовки специфичных настроек элементов option в select при выводе вариантов, которые будут использоваться в js при работе с вариантами
     * @return array
     */
    public function getVariantsOptions()
    {
        if ($this->_variantsOptions !== false) {
            return $this->_variantsOptions;
        }
        $options = [];

        foreach ((array)$this->variants as $variant) {
            $options[$variant->id] = ['data-type' => $variant->type, 'data-amount' => $variant->amount];
        }
        $this->_variantsOptions = $options;

        return $this->_variantsOptions;
    }

    /**
     * @return null|Product
     * @throws CDbException
     */
    public function copy()
    {
        $transaction = Yii::app()->getDb()->beginTransaction();
        $model = new Product();
        try {
            $model->setAttributes($this->getAttributes());
            $model->slug = null;

            $similarNamesCount = Yii::app()->getDb()->createCommand()
                ->select('count(*)')
                ->from($this->tableName())
                ->where("name like :name", [':name' => $this->name.' [%]'])
                ->queryScalar();

            $model->name = $this->name.' ['.($similarNamesCount + 1).']';
            $model->slug = \yupe\helpers\YText::translit($model->name);
            $model->image = $this->image;

            $attributes = $model->attributes;
            $typeAttributes = $this->getTypesAttributesValues();
            $variantAttributes = $categoriesIds = [];

            if ($variants = $this->variants) {
                foreach ($variants as $variant) {
                    $variantAttributes[] = $variant->getAttributes(
                        ['attribute_id', 'attribute_value', 'amount', 'type', 'sku']
                    );
                }
            }

            if ($categories = $this->categories) {
                foreach ($categories as $category) {
                    $categoriesIds[] = $category->id;
                }
            }

            if (!$model->saveData($attributes, $typeAttributes, $variantAttributes, $categoriesIds)) {
                throw new CDbException('Error copy product!');
            }

            $transaction->commit();

            return $model;
        } catch (Exception $e) {
            $transaction->rollback();
        }

        return null;
    }


    /**
     * @param $product
     * @param null $typeId
     * @return bool
     */
    public function link($product, $typeId = null)
    {
        $link = new ProductLink();

        $link->setAttributes([
            'product_id' => $this->id,
            'linked_product_id' => ($product instanceof Product ? $product->id : $product),
            'type_id' => $typeId,
        ]);

        return $link->save();
    }


    /**
     * @param array $attributes
     */
    public function setTypeAttributes(array $attributes)
    {
        $this->_typeAttributes = $attributes;
    }

    /**
     * Get image alt tag text
     *
     * @return string
     */
    public function getImageAlt()
    {
        return $this->image_alt ?: $this->getTitle();
    }

    /**
     * Get image title tag text
     *
     * @return string
     */
    public function getImageTitle()
    {
        return $this->image_title ?: $this->getTitle();
    }
}
