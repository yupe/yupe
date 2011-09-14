<?php

/**
 * This is the model class for table "Image".
 *
 * The followings are the available columns in table 'Image':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $file
 * @property string $creationDate
 * @property string $userId
 * @property string $alt
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Image extends CActiveRecord
{
    const STATUS_CHECKED = 1;
    const STATUS_NEED_CHECK = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return Image the static model class
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
        return 'Image';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, description, alt', 'required'),
            array('file', 'required', 'on' => 'insert'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 300),
            array('file', 'length', 'max' => 500),
            array('userId', 'length', 'max' => 10),
            array('alt', 'length', 'max' => 150),
            array('file', 'file', 'maxSize' => Yii::app()->getModule('image')->maxSize, 'types' => Yii::app()->getModule('image')->allowedExtensions, 'allowEmpty' => true),
            array('id, name, description, file, creationDate, userId, alt, status', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('image', 'id'),
            'name' => Yii::t('image', 'Название'),
            'description' => Yii::t('image', 'Описание'),
            'file' => Yii::t('image', 'Файл'),
            'creationDate' => Yii::t('image', 'Дата создания'),
            'userId' => Yii::t('image', 'Добавил'),
            'alt' => Yii::t('image', 'Альтернативный текст'),
            'status' => Yii::t('image', 'Статус'),
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
        $criteria->compare('file', $this->file, true);
        $criteria->compare('creationDate', $this->creationDate, true);
        $criteria->compare('userId', $this->userId, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
                                                   'criteria' => $criteria,
                                              ));
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                $this->creationDate = new CDbExpression('NOW()');
                $this->userId = Yii::app()->user->getId();
            }

            return true;
        }

        return false;
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_CHECKED => Yii::t('image', 'доступно'),
            self::STATUS_NEED_CHECK => Yii::t('image', 'требуется проверка')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('image', '*неизвестно*');
    }

    public function getExtension($file)
    {
        return substr($file, -3);
    }

    public function create(array $param)
    {
        $this->setAttributes($param);

        $this->file = CUploadedFile::getInstance($this, 'file');

        if ($dir = Yii::app()->getModule('image')->createUploadDir()) {
            if ($this->save()) {
                $fileName = $this->id . '.' . $this->getExtension($this->file->name);

                $fullFileName = Yii::app()->getModule('image')->getUploadPath() . $dir . DIRECTORY_SEPARATOR . $fileName;

                $this->file->saveAs($fullFileName);

                $this->file = Yii::app()->request->baseUrl . DIRECTORY_SEPARATOR . Yii::app()->getModule('image')->uploadDir . $dir . DIRECTORY_SEPARATOR . $fileName;

                $this->update(array('file'));
            }
        }

        return $this;
    }


    public function delete()
    {
        $file = Yii::app()->getModule('image')->documentRoot . $this->file;

        if (file_exists($file)) {
            //удалить файл картинки
            if (unlink($file)) {
                return parent::delete();
            }
            else
            {
                throw new CDbException(Yii::t('image', 'При удалении файла произошла ошибка!'));
            }
        }
        else
        {
            return parent::delete();
        }
    }


}