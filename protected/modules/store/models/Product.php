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
 * @property StoreCategory[] $categories
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
    public $selectedVariants = [];
    private $_variants = [];
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
        return [
            ['name, alias', 'required', 'except' => 'search'],
            [
                'name, description, short_description, alias, price, discount_price, discount, data, status, is_special',
                'filter',
                'filter' => 'trim'
            ],
            [
                'status, is_special, producer_id, type_id, quantity, in_stock, category_id',
                'numerical',
                'integerOnly' => true
            ],
            [
                'price, discount_price, discount, length, height, width, weight',
                'store\components\validators\NumberValidator'
            ],
            ['name, meta_keywords, meta_title, meta_description, image', 'length', 'max' => 250],
            ['discount_price, discount', 'default', 'value' => null],
            ['sku', 'length', 'max' => 100],
            ['alias', 'length', 'max' => 150],
            [
                'alias',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('StoreModule.store', 'Illegal characters in {attribute}')
            ],
            ['alias', 'unique'],
            ['status', 'in', 'range' => array_keys($this->statusList)],
            ['is_special', 'in', 'range' => [0, 1]],
            [
                'id, type_id, producer_id, sku, name, alias, price, discount_price, discount, short_description, description, data, is_special, length, height, width, weight, quantity, in_stock, status, create_time, update_time, meta_title, meta_description, meta_keywords, category',
                'safe',
                'on' => 'search'
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
            'type' => [self::BELONGS_TO, 'Type', 'type_id'],
            'producer' => [self::BELONGS_TO, 'Producer', 'producer_id'],
            'categoryRelation' => [self::HAS_MANY, 'ProductCategory', 'product_id'],
            'categories' => [self::HAS_MANY, 'StoreCategory', ['category_id' => 'id'], 'through' => 'categoryRelation'],
            'mainCategory' => [self::BELONGS_TO, 'StoreCategory', ['category_id' => 'id']],
            'images' => [self::HAS_MANY, 'ProductImage', 'product_id'],
            'variants' => [
                self::HAS_MANY,
                'ProductVariant',
                ['product_id'],
                'with' => ['attribute'],
                'order' => 'variants.attribute_id, variants.id'
            ],
            'comments' => [
                self::HAS_MANY,
                'Comment',
                'model_id',
                'on' => 'model = :model AND comments.status = :status',
                'params' => [
                    ':model' => __CLASS__,
                    ':status' => Comment::STATUS_APPROVED
                ],
                'order' => 'comments.lft'
            ],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
            ],
            'specialOffer' => [
                'condition' => 'is_special = :is_special',
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
            $criteria->with = ['categoryRelation' => ['together' => true]];
            $criteria->addCondition('categoryRelation.category_id = :category_id OR t.category_id = :category_id');
            $criteria->params = CMap::mergeArray($criteria->params, [':category_id' => $this->category]);
        }

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('store');

        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute' => 'create_time',
                'updateAttribute' => 'update_time',
            ],
            'eavAttr' => [
                'class' => 'application.modules.store.components.behaviors.EEavBehavior',
                'tableName' => '{{store_product_attribute_eav}}',
                'entityField' => 'product_id',
            ],
            'imageUpload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios' => ['insert', 'update'],
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module->uploadPath . '/product',
                'resizeOnUpload' => true,
                'resizeOptions' => [
                    'maxWidth' => 900,
                    'maxHeight' => 900,
                ],
                //@TODO убрать
                'defaultImage' => $module->getAssetsUrl() . '/img/nophoto.jpg',
            ],
        ];
    }

    public function beforeValidate()
    {
        if (!$this->alias) {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        foreach ((array)$this->_eavAttributes as $name => $value) {
            $model = Attribute::model()->getAttributeByName($name);
            if ($model->required && !$value) {
                $this->addError(
                    'eav.' . $name,
                    Yii::t("StoreModule.store", "Атрибут \"title\" обязателен", ['title' => $model->title])
                );
            }
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ZERO => Yii::t('StoreModule.store', 'Not available'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('StoreModule.store', 'Not active'),
        ];
    }

    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    public function getSpecialList()
    {
        return [
            self::SPECIAL_NOT_ACTIVE => Yii::t('StoreModule.store', 'No'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Yes'),
        ];
    }

    public function getSpecial()
    {
        $data = $this->getSpecialList();

        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('StoreModule.store', '*unknown*');
    }

    public function getInStockList()
    {
        return [
            self::STATUS_IN_STOCK => Yii::t('StoreModule.store', 'In stock'),
            self::STATUS_NOT_IN_STOCK => Yii::t('StoreModule.store', 'Not in stock'),
        ];
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->mainCategory instanceof StoreCategory
            ? CHtml::link($this->mainCategory->name, ["/store/categoryBackend/view", "id" => $this->mainCategory->id])
            : '---';
    }

    public function getProducerLink()
    {
        return $this->producer instanceof Producer
            ? CHtml::link($this->producer->name_short, ["/store/producerBackend/view", "id" => $this->producer_id])
            : '---';
    }

    /**
     * Устанавливает дополнительные категории товара
     * @param $categories - список id категорий
     * @return bool
     */
    public function saveCategories($categories)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        $categories = is_array($categories) ? $categories : (array)$categories;
        $categories = array_diff($categories, (array)$this->category_id);

        try {
            foreach ($categories as $category_id) {
                $model = ProductCategory::model()->findByAttributes(
                    ['product_id' => $this->id, 'category_id' => $category_id]
                );
                if (!$model) {
                    $model = new ProductCategory();
                    $model->category_id = $category_id;
                    $model->product_id = $this->id;
                }
                $model->save();
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('product_id = :product_id');
            $criteria->params = [':product_id' => $this->id];
            $criteria->addNotInCondition('category_id', $categories);
            ProductCategory::model()->deleteAll($criteria);
            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public function getCategoriesIdList()
    {
        $cats = ProductCategory::model()->findAllByAttributes(['product_id' => $this->id]);
        $list = [];
        foreach ($cats as $key => $cat) {
            $list[] = $cat->category_id;
        }

        return $list;
    }

    public function setTypeAttributes(array $attributes)
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
        $this->deleteEavAttributes([], true);

        $attributes = array_filter($attributes, 'strlen');
        $this->setEavAttributes($attributes, true);
    }

    public function attr($attribute)
    {
        return isset($this->_eavAttributes[$attribute]) ? $this->_eavAttributes[$attribute] : $this->getEavAttribute(
            $attribute
        );
    }

    public function beforeDelete()
    {
        // чтобы удалились файлики
        foreach ((array)$this->images as $image) {
            $image->delete();
        }

        return parent::beforeDelete();
    }

    public function saveData(array $attributes, array $typeAttributes, array $variants, array $categories = [])
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try
        {
            $this->setAttributes($attributes);
            $this->setTypeAttributes($typeAttributes);
            $this->setProductVariants($variants);

            if($this->save()) {

                $this->updateEavAttributes($this->_eavAttributes);
                $this->updateVariants($this->_variants);

                if(!empty($categories)) {
                    $this->saveCategories($categories);
                }

                $transaction->commit();
                return true;
            }

            return false;
        }
        catch(Exception $e)
        {
            $transaction->rollback();
            return false;
        }
    }

    public function setProductVariants(array $variants)
    {
        $this->_variants = $variants;
    }

    private function updateVariants(array $variants)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            $productVariants = [];
            foreach ($variants as $var) {
                $variant = null;
                if (isset($var['id'])) {
                    $variant = ProductVariant::model()->findByPk($var['id']);
                }
                $variant = $variant ? : new ProductVariant();
                $variant->attributes = $var;
                $variant->product_id = $this->id;
                if ($variant->save()) {
                    $productVariants[] = $variant->id;
                }
            }

            $criteria = new CDbCriteria();
            $criteria->addCondition('product_id = :product_id');
            $criteria->params = [':product_id' => $this->id];
            $criteria->addNotInCondition('id', $productVariants);
            ProductVariant::model()->deleteAll($criteria);
            $transaction->commit();
            return true;
        } catch (Exception $e) {
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
        return (float)$this->discount_price ? : (float)$this->price * (1 - ((float)$this->discount ? : 0) / 100);
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

    public function getTitle()
    {
        return $this->name;
    }

    public function getLink()
    {
        return Yii::app()->createUrl('/store/catalog/show', ['name' => $this->alias]);
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
        return $this->meta_title ? : $this->name;
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

    /**
     * @var array кеш getVariantsOptions
     */
    private $_variantsOptions = false;

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
            $options[$variant->id] = array('data-type' => $variant->type, 'data-amount' => $variant->amount);
        }
        $this->_variantsOptions = $options;

        return $this->_variantsOptions;
    }

    public function getDiscountPrice()
    {
        return $this->discount_price;
    }

    /**
     * @return null|Product
     * @throws CDbException
     */
    public function copy()
    {
        $transaction = Yii::app()->db->beginTransaction();
        $model = new Product();
        try {
            $model->attributes = $this->attributes;
            $model->image = null;
            $model->alias = null;

            $similarNamesCount = Yii::app()->db->createCommand()
                ->select('count(*)')
                ->from($this->tableName())
                ->where("name like :name", [':name' => $this->name . ' [%]'])
                ->queryScalar();

            $model->name = $this->name . ' [' . ($similarNamesCount + 1) . ']';

            if ($eavAttributes = $this->getEavAttributes()) {
                $model->setTypeAttributes($eavAttributes);
            }

            if ($variants = $this->variants) {
                $variantAttributes = [];
                foreach ($variants as $variant) {
                    $variantAttributes[] = $variant->getAttributes(
                        ['attribute_id', 'attribute_value', 'amount', 'type', 'sku']
                    );
                }
                $model->setProductVariants($variantAttributes);
            }

            if ($model->save()) {
                if ($categories = $this->categories) {
                    $categoriesIds = [];
                    foreach ($categories as $category) {
                        $categoriesIds[] = $category->id;
                    }
                    $model->saveCategories($categoriesIds);
                }
            }

            $transaction->commit();

            return $model;
        } catch (Exception $e) {
            $transaction->rollback();
        }

        return null;
    }

    public function getUrl($absolute = false)
    {
        return $absolute ?
            Yii::app()->createAbsoluteUrl('/store/catalog/show', ['name' => $this->alias]) :
            Yii::app()->createUrl('/store/catalog/show', ['name' => $this->alias]);
    }
}
