<?php
namespace yupe\models;

use CFormModel;

/**
 * Class UploadForm
 * @package yupe\models
 */
class UploadForm extends CFormModel
{
    /**
     * @var
     */
    public $file;

    /**
     * @var
     */
    public $maxSize;
    /**
     * @var
     */
    public $mimeTypes;
    /**
     * @var
     */
    public $types;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['file', 'file', 'maxSize' => $this->maxSize, 'mimeTypes' => $this->mimeTypes, 'types' => $this->types],
        ];
    }
}
