<?php

/**
 * This is the model class for table "store_attribute_group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $position
 *
 * @property Attribute[] groupAttributes
 */
class AttributeGroup extends yupe\models\YModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_attribute_group}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name', 'required'),
            array('name', 'filter', 'filter' => 'trim'),
            array('name', 'length', 'max' => 255),
            array('id, name, position', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'groupAttributes' => array(self::HAS_MANY, 'Attribute', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('StoreModule.attribute', 'ID'),
            'name' => Yii::t('StoreModule.attribute', 'Название группы'),
            'position' => Yii::t('StoreModule.attribute', 'Позиция'),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider(
            $this, array(
                'criteria' => $criteria,
                'sort' => array('defaultOrder' => 't.position')
            )
        );
    }

    public function sort(array $items)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($items as $id => $priority) {
                $model = $this->findByPk($id);
                if (null === $model) {
                    continue;
                }
                $model->position = (int)$priority;

                if (!$model->update('sort')) {
                    throw new CDbException('Error sort menu items!');
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    public function getFormattedList()
    {
        $groups = $this->findAll(array('order' => 'name ASC'));
        $list = array();
        foreach ($groups as $key => $group) {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
}
