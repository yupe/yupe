<?php
class ImageUploadBehavior extends CActiveRecordBehavior
{
    public $attributeName = 'image';
    public $minSize = 0;
    public $maxSize = 5368709120;
    public $types = 'jpg,jpeg,png,gif';
    public $scenarios = array('insert', 'update');
    public $uploadPath;
    public $requiredOn;

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
            $uniqueName = md5(time());

            if (($newFile = YFile::pathIsWritable($uniqueName, $file->extensionName, $this->uploadPath)) &&
                $file->saveAs($newFile))
            {
                $this->deleteFile();
                $this->owner->{$this->attributeName} = $uniqueName . '.' . $file->extensionName;
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
        if ($this->owner->scenario !== 'altlang' && @is_file($this->_oldFile))
            @unlink($this->_oldFile);
    }

    private function _checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }
}
