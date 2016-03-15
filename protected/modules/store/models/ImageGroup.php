<?php

use yupe\models\YModel;

/**
 * Class ImageGroup
 */
class ImageGroup extends YModel
{
    /**
     * @return string
     */
    public function tableName()
    {
        return '{{store_product_image_group}}';
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
            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'length', 'max' => 255],
            ['id, name', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'name' => Yii::t('StoreModule.store', 'Name'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'id'],
            ]
        );
    }
}