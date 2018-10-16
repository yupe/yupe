<?php

/**
 * @property integer $id
 * @property string $code
 * @property integer $title
 */
class ProductLinkType extends yupe\models\YModel
{
    /**
     * @return string
     */
    public function tableName()
    {
        return '{{store_product_link_type}}';
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
            ['code, title', 'filter', 'filter' => 'trim'],
            ['code, title', 'required'],
            ['code, title', 'length', 'max' => 255],
            ['code', 'unique'],
            ['title', 'unique'],
            ['id, code, title', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'code' => Yii::t('StoreModule.store', 'Code'),
            'title' => Yii::t('StoreModule.store', 'Title'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.title'],
            ]
        );
    }
}
