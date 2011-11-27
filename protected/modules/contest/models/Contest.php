<?php

/**
 * This is the model class for table "Contest".
 *
 * The followings are the available columns in table 'Contest':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $start_add_image
 * @property string $stop_add_image
 * @property string $start_vote
 * @property string $stop_vote

 * @property integer $status
 */
class Contest extends CActiveRecord
{

    const STATUS_DRAFT = 0;

    const STATUS_PUBLISHED = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return Contest the static model class
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
        return '{{contest}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, start_add_image, stop_add_image, start_vote, stop_vote', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 150),
            array('description', 'length', 'max' => 300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, start_add_image, stop_add_image, start_vote, stop_vote, status', 'safe', 'on' => 'search'),
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
            'imagesRell' => array(self::HAS_MANY, 'ImageToContest', 'contest_id'),
            'images' => array(self::HAS_MANY, 'Images', 'image_id', 'through' => 'imagesRell'),
            'imagesCount' => array(self::STAT, 'ImageToContest', 'contest_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('contest', 'id'),
            'name' => Yii::t('contest', 'Название'),
            'description' => Yii::t('contest', 'Описание'),
            'start_add_image' => Yii::t('contest', 'Начало'),
            'stop_add_image' => Yii::t('contest', 'Завершение'),
            'start_vote' => Yii::t('contest', 'Начало голосования'),
            'stop_vote' => Yii::t('contest', 'Завершение голосования'),
            'status' => Yii::t('contest', 'Статус'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('start_add_image', $this->start_add_image, true);
        $criteria->compare('stop_add_image', $this->stop_add_image, true);
        $criteria->compare('start_vote', $this->start_vote, true);
        $criteria->compare('stop_vote', $this->stop_vote, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT => Yii::t('contest', 'Черновик'),
            self::STATUS_PUBLISHED => Yii::t('contest', 'Опубликовано'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status]
            : Yii::t('contest', '*неизвестно*');
    }

    public function addImage(Image $image)
    {
        $im2c = new ImageToContest;

        $im2c->setAttributes(array(
                                  'image_id' => $image->id,
                                  'contest_id' => $this->id
                             ));

        return $im2c->save() ? true : false;
    }
}