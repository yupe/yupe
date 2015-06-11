<?php

/**
 * @property integer $id
 * @property string $code
 * @property integer $title
 */
class ProductLinkType extends yupe\models\YModel
{
    public function tableName()
    {
        return '{{store_product_link_type}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

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

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'code' => Yii::t('StoreModule.store', 'Code'),
            'title' => Yii::t('StoreModule.store', 'Title'),
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.title']
            ]
        );
    }

    public static function getFormattedList()
    {
        return CHtml::listData(self::model()->findAll(['order' => 'title ASC']), 'id', 'title');
    }
}
