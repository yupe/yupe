<?php

/**
 * This is the model class for table "Image".
 *
 * The followings are the available columns in table 'Image':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $file
 * @property string $creation_date
 * @property string $user_id
 * @property string $alt
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Image extends CActiveRecord
{
    const STATUS_CHECKED    = 1;
    const STATUS_NEED_CHECK = 0;

    const TYPE_SIMPLE  = 0;
    const TYPE_PREVIEW = 1;

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
        return '{{image}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, description, alt','filter','filter' => 'trim'),
            array('name, description, alt','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array('name, alt, type', 'required'),
            array('file', 'required', 'on' => 'insert'),
            array('status, parent_id, type', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 300),
            array('file', 'length', 'max' => 500),
            array('user_id', 'length', 'max' => 10),
            array('alt', 'length', 'max' => 150),
            array('file', 'file', 'maxSize' => Yii::app()->getModule('image')->maxSize, 'types' => Yii::app()->getModule('image')->allowedExtensions, 'allowEmpty' => true),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('id, name, description, file, creation_date, user_id, alt, status', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
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
            'creation_date' => Yii::t('image', 'Дата создания'),
            'user_id' => Yii::t('image', 'Добавил'),
            'alt' => Yii::t('image', 'Альтернативный текст'),
            'status'    => Yii::t('image', 'Статус'),
            'parent_id' => Yii::t('image','Родитель'),
            'type'      => Yii::t('image','Тип картинки')
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
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('alt', $this->alt, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
                                                   'criteria' => $criteria,
                                              ));
    }

    public function beforeValidate()
    {        
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');

            $this->user_id = Yii::app()->user->getId();
        }

        return parent::beforeValidate();        
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

        return isset($data[$this->status]) ? $data[$this->status]
            : Yii::t('image', '*неизвестно*');
    }

    public function create(array $param, $file = 'file')
    {
        $this->setAttributes($param);

        $this->file = CUploadedFile::getInstance($this, $file);                

        $module = Yii::app()->getModule('image');

        $dir = $module->createUploadDir();

        if ($dir)
        {
            if ($this->save())
            {
                $fileName = $this->id . '.' . CFileHelper::getExtension($this->file->name);

                $fullFileName = $module->getUploadPath() . $dir . DIRECTORY_SEPARATOR . $fileName;

                $this->file->saveAs($fullFileName);

                $this->file = Yii::app()->request->baseUrl . DIRECTORY_SEPARATOR . $module->uploadDir . $dir . DIRECTORY_SEPARATOR . $fileName;

                return $this->update(array('file'));
            }              
        }        
        
        return false;
    }


    public function delete()
    {
        $file = Yii::app()->getModule('image')->documentRoot . $this->file;

        if (file_exists($file))
        {
            //удалить файл картинки
            if (@unlink($file))            
                return parent::delete();            
            else            
                throw new CException(Yii::t('image', 'При удалении файла произошла ошибка!'));            
        }
        else        
            return parent::delete();        
    }

    public function getTypeList()
    {
        $list = array(
            self::TYPE_PREVIEW => Yii::t('image','Превью'),
            self::TYPE_SIMPLE  => Yii::t('image','Картинка'),
        );
        
        $types = Yii::app()->getModule('image')->types;

        return count($types) ? CMap::mergeArray($list,$types) : $list;
    }

    public function getType()
    {
        $data = $this->getTypeList();

        return isset($data[$this->type]) ?  $data[$this->type] : Yii::t('image','*неизвестно*');
    }
}