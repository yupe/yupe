<?php
/**
 *
 * @package  yupe.modules.yupe.components.behaviors
 *
 */

namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use CValidator;
use CUploadedFile;
use Yii;

/**
 * Class FileUploadBehavior
 * @package yupe\components\behaviors
 */
class FileUploadBehavior extends CActiveRecordBehavior
{
    /**
     * Атрибут модели для хранения изображения
     * @var string
     */
    public $attributeName = 'file';


    /**
     * Атрибут для замены имени поля file если необходимо
     * @var string
     */
    public $fileInstanceName = '';

    /**
     * Загружаемое изображение
     * @var
     */
    public $image;

    /**
     * Минимальный размер загружаемого изображения
     * @var int
     */
    public $minSize = 0;

    /**
     * Максимальный размер загружаемого изображения
     * @var int
     */
    public $maxSize = 5368709120;

    /**
     * Допустимые типы изображений
     * @var string
     */
    public $types = 'jpg,jpeg,png,gif';

    /**
     * Список сценариев в которых будет использовано поведение
     * @var array
     */
    public $scenarios = array('insert', 'update');

    /**
     * Список сценариев в которых изображение обязательно, 'insert, update'
     * @var
     */
    public $requiredOn;

    /**
     * Callback для генерации имени загружаемого файла
     * @var
     */
    public $fileName;

    /**
     * Директория для загрузки изображений
     * @var
     */
    public $uploadPath;

    /**
     * @var CUploadedFile
     */
    private $_newFile;

    /**
     * @var CUploadedFile
     */
    private $_oldFile;

    /**
     * @param \CComponent $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->checkScenario()) {
            if ($this->requiredOn) {
                $requiredValidator = CValidator::createValidator('required', $owner, $this->attributeName, array(
                    'on' => $this->requiredOn,
                ));
                $owner->validatorList->add($requiredValidator);
            }

            $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array(
                'types' => $this->types,
                'minSize' => $this->minSize,
                'maxSize' => $this->maxSize,
                'allowEmpty' => true,
            ));

            $owner->validatorList->add($fileValidator);
        }
    }

    /**
     * @param \CEvent $event
     */
    public function afterFind($event)
    {
        $this->_oldFile = Yii::app()->uploadManager->getFilePath($this->owner{$this->attributeName}, $this->getUploadPath());

        return parent::beforeFind($event);
    }

    /**
     * @param \CModelEvent $event
     */
    public function beforeValidate($event)
    {
        if (empty($this->fileInstanceName)) {
            $this->_newFile = CUploadedFile::getInstance($this->owner, $this->attributeName);
        } else {
            $this->_newFile = CUploadedFile::getInstanceByName($this->fileInstanceName);
        }

        if ($this->checkScenario() && $this->_newFile) {
            $this->owner->{$this->attributeName} = $this->_newFile;
        }
    }

    /**
     * @param \CModelEvent $event
     */
    public function beforeSave($event)
    {
        if ($this->checkScenario() && $this->_newFile instanceof CUploadedFile) {      	
        	$this->removeFile();
            $this->saveFile();
        }

        return parent::beforeSave($event);
    }

    /**
     * @param \CEvent $event
     */
    public function beforeDelete($event)
    {
        $this->removeFile();

        return parent::beforeDelete($event);
    }

    /**
     *
     */
    public function removeFile()
    {
        if (@is_file($this->_oldFile)) {
            @unlink($this->_oldFile);
        }
    }

    /*
     * Проверяет допустимо ли использовать поведение в текущем сценарии
     */
    /**
     * @return bool
     */
    public function checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }

    /**
     *
     */
    public function saveFile()
    {
        $fileName = $this->getFileName() . '.' . $this->_newFile->getExtensionName();
        Yii::app()->uploadManager->save($this->_newFile, $this->getUploadPath(), $fileName);
        $this->owner->{$this->attributeName} = $fileName;
    }

    /**
     * @param $name
     */
    public function addFileInstanceName($name)
    {
        $this->fileInstanceName = $name;
    }

    /*
     * Получить имя файла
     * Свойство может быть задано как callback
     */
    /**
     *
     * @return mixed|string
     */
    public function getFileName()
    {
        return is_callable($this->fileName)
            ? call_user_func($this->fileName)
            : md5(microtime(true) . uniqid());
    }

    /**
     * Получить каталог для загрузки изображений
     * С версии 0.7 может быть задан как callback
     *
     * @since 0.7
     * @return string
     */
    public function getUploadPath()
    {
        return is_callable($this->uploadPath)
            ? call_user_func($this->uploadPath)
            : $this->uploadPath;
    }
}
