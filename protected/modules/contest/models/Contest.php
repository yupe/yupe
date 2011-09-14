<?php

/**
 * This is the model class for table "Contest".
 *
 * The followings are the available columns in table 'Contest':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $startAddImage
 * @property string $stopAddImage
 * @property string $startVote
 * @property string $stopVote
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
        return 'Contest';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, startAddImage, stopAddImage, startVote, stopVote', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 150),
            array('description', 'length', 'max' => 300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, startAddImage, stopAddImage, startVote, stopVote, status', 'safe', 'on' => 'search'),
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
            'imagesRell' => array(self::HAS_MANY, 'ImageToContest', 'contestId'),
            'images' => array(self::HAS_MANY, 'Images', 'imageId', 'through' => 'imagesRell'),
            'imagesCount' => array(self::STAT, 'ImageToContest', 'contestId')
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
            'startAddImage' => Yii::t('contest', 'Начало'),
            'stopAddImage' => Yii::t('contest', 'Завершение'),
            'startVote' => Yii::t('contest', 'Начало голосования'),
            'stopVote' => Yii::t('contest', 'Завершение голосования'),
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
        $criteria->compare('startAddImage', $this->startAddImage, true);
        $criteria->compare('stopAddImage', $this->stopAddImage, true);
        $criteria->compare('startVote', $this->startVote, true);
        $criteria->compare('stopVote', $this->stopVote, true);
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
        $im2c = new ImageToContest();

        $im2c->setAttributes(array(
                                  'imageId' => $image->id,
                                  'contestId' => $this->id
                             ));

        return $im2c->save() ? true : false;
    }
}