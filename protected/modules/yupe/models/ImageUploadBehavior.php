<?php
class ImageUploadBehavior extends CActiveRecordBehavior{
    public $attributeName;
    public $uploadPath;
    public $scenarios;
    public $types;
    public $minSize;
    public $maxSize;
    public $maxFiles;
    public $allowEmpty;

    public function attach($owner)
    {
        parent::attach($owner);

        if (in_array($owner->scenario, $this->scenarios))
        {
            $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array(
                'types'      => $this->types,
                'allowEmpty' => $this->allowEmpty,
                'minSize'    => $this->minSize,
                'maxSize'    => $this->maxSize,
                'maxFiles'   => $this->maxFiles,
            ));
            $owner->validatorList->add($fileValidator);
        }
    }

//    public function beforeSave($event)
//    {
//        if (in_array($this->owner->scenario, $this->scenarios) &&
//            ($file = CUploadedFile::getInstance($this->owner, $this->attributeName)))
//        {
//            $this->deleteFile();
//            $this->owner->setAttribute($this->attributeName, $file->name);
//            $file->saveAs($this->uploadPath . $file->name);
//        }
//        return true;
//    }


}
