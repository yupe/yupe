<?php

/**
 * @property integer $id
 * @property integer $type_id
 * @property integer $product_id
 * @property integer $linked_product_id
 *
 * @property Product $product
 * @property Product $linkedProduct
 * @property ProductLinkType $type
 */
class ProductLink extends yupe\models\YModel
{
    /**
     * @return string
     */
    public function tableName()
    {
        return '{{store_product_link}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['product_id, linked_product_id, type_id', 'required'],
            ['product_id, linked_product_id, ', 'numerical', 'integerOnly' => true],
            [
                'product_id',
                'unique',
                'criteria' => [
                    'condition' => 'linked_product_id = :linked_product_id',
                    'params' => [
                        ':linked_product_id' => $this->linked_product_id,
                    ],
                ],
            ],
            ['id, type_id, product_id, linked_product_id', 'safe', 'on' => 'search'],
        ];
    }


    /**
     * @return array
     */
    public function relations()
    {
        return [
            'product' => [self::BELONGS_TO, 'Product', 'product_id'],
            'linkedProduct' => [self::BELONGS_TO, 'Product', 'linked_product_id'],
            'type' => [self::BELONGS_TO, 'ProductLinkType', 'type_id'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'product_id' => Yii::t('StoreModule.store', 'Product'),
            'linked_product_id' => Yii::t('StoreModule.store', 'Linked product'),
            'type_id' => Yii::t('StoreModule.store', 'Link type'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('linked_product_id', $this->linked_product_id);
        $criteria->compare('type_id', $this->type_id);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
            ]
        );
    }
}
