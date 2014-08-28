<?php
namespace yupe\models;

use CFormModel;

class UploadForm extends CFormModel
{
    public $file;

    public $maxSize;
    public $mimeTypes;
    public $types;

    public function rules()
    {
        return array(
            array('file', 'file', 'maxSize' => $this->maxSize, 'mimeTypes' => $this->mimeTypes, 'types' => $this->types)
        );
    }
}
