<?php

namespace yupe\components\behaviors;

use Yii;
use yupe\components\image\Imagine;
use yupe\helpers\YFile;

class ImageUploadBehavior extends FileUploadBehavior
{
    public $resize = array(
        'maxWidth' => 950,
        'maxHeight' => 950,
        'quality' => 90,
    );

    public function saveFile()
    {
        $quality   = isset($this->resize['quality']) ? $this->resize['quality'] : 90;
        $maxWidth  = isset($this->resize['maxWidth']) ? $this->resize['maxWidth'] : 950;
        $maxHeight = isset($this->resize['maxHeight']) ? $this->resize['maxHeight'] : 950;

        $tmpName = $this->_newFile->tempName;

        $imagine  = Imagine::getImagine();
        $fileName = $this->getFileName() . '.' . $this->_newFile->getExtensionName();
        $path     = Yii::app()->uploadManager->getFilePath($fileName, $this->getUploadPath());
        $image    = $imagine->open($tmpName);
        $size     = $image->getSize();
        $width    = $size->getWidth();
        $height   = $size->getHeight();
        if ($width > $maxWidth || $height > $maxHeight)
        {
            $ratio = $width / $height;
            if ($ratio > 1)
            {
                $width  = $maxWidth;
                $height = $width / $ratio;
            }
            else
            {
                $height = $maxHeight;
                $width  = $height * $ratio;
            }
            $image->resize(new \Imagine\Image\Box($width, $height));
        }

        YFile::checkPath(pathinfo($path, PATHINFO_DIRNAME));
        $image->save($path, array('jpeg_quality' => $quality, 'png_compression_level' => 7));

        $this->owner->{$this->attributeName} = $fileName;
    }
}
