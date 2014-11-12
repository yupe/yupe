<?php
namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use CValidator;
use CUploadedFile;
use Yii;

/**
 * Class FileUploadBehavior
 * @package yupe.modules.yupe.components.behaviors
 */
class FileUploadBehavior extends CActiveRecordBehavior
{
    /**
     * @var string attribute to store name of the uploaded file.
     */
    public $attributeName = 'file';

    /**
     *
     * @var string the name of the file input field, used to get instance by name.
     * Optional. If not set get instance by model attribute will be used.
     */
    public $fileInstanceName;

    /**
     * @var int minimum file size.
     */
    public $minSize = 0;

    /**
     * @var int maximum file size.
     */
    public $maxSize = 5368709120;

    /**
     * @var string allowed file types.
     */
    public $types = 'jpg,jpeg,png,gif';

    /**
     *
     * @var array allowed scenarios when this behavior will be used.
     */
    public $scenarios = array('insert', 'update');

    /**
     * @var string scenarios when file upload is required.
     */
    public $requiredOn;

    /**
     * @var callable callback function to generate filename.
     * Optional. If not set, default implementation will be used.
     */
    public $fileName;

    /**
     * @var mixed path of the upload directory. Callback or string.
     */
    public $uploadPath;

    /**
     * @var CUploadedFile new uploaded file instance.
     */
    protected $_currentFile;

    /**
     * @var CUploadedFile previous uploaded file instance.
     */
    protected $_prevFile;

    /**
     * @param \CComponent $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->checkScenario()) {
            if ($this->requiredOn) {
                $requiredValidator = CValidator::createValidator(
                    'required',
                    $owner,
                    $this->attributeName,
                    array(
                        'on' => $this->requiredOn,
                    )
                );
                $owner->validatorList->add($requiredValidator);
            }

            $fileValidator = CValidator::createValidator(
                'file',
                $owner,
                $this->attributeName,
                array(
                    'types' => $this->types,
                    'minSize' => $this->minSize,
                    'maxSize' => $this->maxSize,
                    'allowEmpty' => true,
                )
            );

            $owner->validatorList->add($fileValidator);
        }
    }

    /**
     * @param \CEvent $event
     */
    public function afterFind($event)
    {
        $this->_prevFile = $this->getPrevFile();

        return parent::afterFind($event);
    }

    protected function getPrevFile()
    {
        return Yii::app()->uploadManager->getFilePath(
            $this->getOwner()->{$this->attributeName},
            $this->getUploadPath()
        );
    }


    /**
     * @param \CModelEvent $event
     */
    public function beforeValidate($event)
    {
        $this->_currentFile = $this->fileInstanceName === null
            ? CUploadedFile::getInstance($this->owner, $this->attributeName)
            : CUploadedFile::getInstanceByName($this->fileInstanceName);

        if ($this->checkScenario() && $this->_currentFile) {
            $this->owner->{$this->attributeName} = $this->_currentFile;
        }
    }

    /**
     * @param \CModelEvent $event
     * @return boolean
     */
    public function beforeSave($event)
    {
        if ($this->checkScenario() && $this->_currentFile instanceof CUploadedFile) {
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
     * Remove previous uploaded file.
     * @return void.
     */
    protected function removeFile()
    {
        if (@is_file($this->_prevFile)) {
            @unlink($this->_prevFile);
        }
    }

    /**
     * Checks whether there is a current scenario in allowed scenarios.
     * @return bool true if current scenario is allowed.
     */
    public function checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }

    /**
     * Save new uploaded file to disk and set model attribute.
     * @return void.
     */
    public function saveFile()
    {
        $newFileName = $this->getFileName();
        Yii::app()->uploadManager->save($this->_currentFile, $this->getUploadPath(), $newFileName);
        $this->owner->{$this->attributeName} = $newFileName;
        $this->_prevFile = $this->getPrevFile();
    }

    /**
     * @param $name string the name of the file input field.
     */
    public function addFileInstanceName($name)
    {
        $this->fileInstanceName = $name;
    }

    /**
     * @return string generated file name.
     */
    public function getFileName()
    {
        if (is_callable($this->fileName)) {
            $name = call_user_func($this->fileName);
        } else {
            $name = md5(uniqid($this->getOwner()->{$this->attributeName}));
        }
        $name .= '.' . $this->_currentFile->getExtensionName();

        return $name;
    }

    /**
     * @return string path of the upload directory.
     */
    public function getUploadPath()
    {
        return is_callable($this->uploadPath)
            ? call_user_func($this->uploadPath)
            : $this->uploadPath;
    }

    /**
     * @return string url to uploaded file.
     */
    public function getFileUrl()
    {
        return Yii::app()->uploadManager->getFileUrl($this->getOwner()->{$this->attributeName}, $this->uploadPath);
    }
}
