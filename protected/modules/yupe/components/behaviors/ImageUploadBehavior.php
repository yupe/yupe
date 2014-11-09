<?php

namespace yupe\components\behaviors;

use Yii;
use yupe\components\image\Imagine;
use yupe\helpers\YFile;
use Imagine\Image\ImageInterface;

class ImageUploadBehavior extends FileUploadBehavior
{
    public $resizeOnUpload = true;
    public $resizeOptions = array();

    /**
     * @var null|string Полный путь к изображению по умолчанию в публичной папке
     */
    public $defaultImage = null;

    public function attach($event)
    {
        parent::attach($event);

        if ($this->resizeOnUpload) {
            $this->resizeOptions = array_merge(
                array(
                    'width' => 950,
                    'height' => 950,
                    'quality' => array(
                        'jpegQuality' => 75,
                        'pngCompressionLevel' => 7
                    ),
                ),
                $this->resizeOptions
            );
        }
    }

    protected function removeFile()
    {
        parent::removeFile();
        $this->removeThumbs();
    }

    protected function removeThumbs()
    {
        $filename = pathinfo($this->_prevFile, PATHINFO_BASENAME);

        $iterator = new \GlobIterator(
            Yii::app()->thumbnailer->getBasePath() . '/' . $this->uploadPath . '/' . '*_' . $filename
        );

        foreach ($iterator as $file) {
            @unlink($file->getRealPath());
        }
    }

    public function saveFile()
    {
        if (!$this->resizeOnUpload) {
            parent::saveFile();
            return;
        }

        $newFileName = $this->getFileName();
        $path = Yii::app()->uploadManager->getFilePath($newFileName, $this->getUploadPath());


        if (!YFile::checkPath(pathinfo($path, PATHINFO_DIRNAME))) {
            throw new \CHttpException(
                500,
                Yii::t(
                    'YupeModule.yupe',
                    'Directory "{dir}" is not acceptable for write!',
                    array('{dir}' => $path)
                )
            );
        }

        $image = Imagine::resize(
            $this->_currentFile->getTempName(),
            $this->resizeOptions['width'],
            $this->resizeOptions['height']
        );

        $image->save(
            $path,
            $this->resizeOptions['quality']
        );

        $this->getOwner()->{$this->attributeName} = $newFileName;
        $this->_prevFile = $this->getPrevFile();
    }

    public function getImageUrl($width = 0, $height = 0, $isAdaptive = true, $options = [])
    {
        $file = $this->_prevFile;
        $defaultImagePath = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $this->defaultImage;
        $fileUploaded = is_file($this->_prevFile);

        if (!$fileUploaded) {
            if (is_file($defaultImagePath)) {
                $file = $defaultImagePath;
            } else {
                return null;
            }
        }

        if ($width || $height) {
            $width = $width === 0 ? $height : $width;
            $height = $height === 0 ? $width : $height;

            return Yii::app()->thumbnailer->thumbnail(
                $file,
                $this->uploadPath,
                $width,
                $height,
                $isAdaptive ? ImageInterface::THUMBNAIL_OUTBOUND : ImageInterface::THUMBNAIL_INSET,
                $options
            );

        }

        return $fileUploaded ? $this->getFileUrl() : $this->defaultImage;
    }
}
