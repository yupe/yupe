<?php
class ImageUploadBehavior extends CActiveRecordBehavior
{
    /*
     * Атрибут модели для хранения изображения
     */
    public $attributeName = 'image';

    /*
     * Минимальный размер загружаемого изображения
     */
    public $minSize = 0;

    /*
     * Максимальный размер загружаемого изображения
     */
    public $maxSize = 5368709120;

    /*
     * Допустимые типы изображений
     */
    public $types = 'jpg,jpeg,png,gif';
    /*
     * Список сценариев в которых будет использовано поведение
     */
    public $scenarios = array('insert', 'update');
    /*
     * Директория для загрузки изображений
     */
    public $uploadPath;
    /*
     * Список сценариев в которых изображение обязательно, 'insert, update'
     */
    public $requiredOn;

    /*
     * Callback для генерации имени загружаемого файла
     */
    public $nameGenerator;

    protected $_oldFile;

    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->_checkScenario())
        {
            if ($this->requiredOn)
            {
                $requiredValidator = CValidator::createValidator('required', $owner, $this->attributeName, array(
                    'on' => $this->requiredOn,
                ));
                $owner->validatorList->add($requiredValidator);
            }
            $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array(
                'types'      => $this->types,
                'minSize'    => $this->minSize,
                'maxSize'    => $this->maxSize,
                'allowEmpty' => true,
                'safe' => true,
            ));
            $owner->validatorList->add($fileValidator);
        }
    }

    public function afterFind($event)
    {
        $this->_oldFile = $this->uploadPath . $this->owner{$this->attributeName};
    }

    public function beforeValidate($event)
    {
        if ($this->_checkScenario() && ($file = CUploadedFile::getInstance($this->owner, $this->attributeName)))
            $this->owner->{$this->attributeName} = $file;

        return true;
    }

    public function beforeSave($event)
    {
        if ($this->_checkScenario() && $this->owner{$this->attributeName} instanceof CUploadedFile)
        {
            $file = $this->owner{$this->attributeName};
            $fileName = $this->_generateFileName();
            if (($newFile = YFile::pathIsWritable($fileName, $file->extensionName, $this->uploadPath)) &&
                $file->saveAs($newFile))
            {
                $this->deleteFile();
                $this->owner->{$this->attributeName} = $fileName . '.' . $file->extensionName;
                $this->_resizeImage($newFile);
            }
        }
        return true;
    }

    public function beforeDelete($event)
    {
        $this->deleteFile();
    }

    public function deleteFile()
    {
        // не удаляем файл если сценарий altlang, используется модулями news, category
        if ($this->owner->scenario !== 'altlang' && @is_file($this->_oldFile))
            @unlink($this->_oldFile);
    }

    /*
     * Проверяет допустимо ли использовать поведение в текущем сценарии
     */
    protected function _checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }

    /*
     * Генерирует имя файла с использованием callback функции если возможно
     */
    protected function _generateFileName()
    {
        return (is_callable($this->nameGenerator))
            ? (call_user_func($this->nameGenerator))
            : md5(time());
    }

}
