<?php

namespace yupe\components\behaviors;

use Yii;
use yupe\components\image\Imagine;
use Imagine\Image\ImageInterface;
use yupe\helpers\YFile;

class ImageUploadBehavior extends FileUploadBehavior
{
    public $resizeOnUpload = true;
    public $resizeOptions = [];

    protected $defaultResizeOptions = [
        'width' => 950,
        'height' => 950,
        'quality' => [
            'jpegQuality' => 75,
            'pngCompressionLevel' => 7
        ],
    ];

    /**
     * @var null|string Полный путь к изображению по умолчанию в публичной папке
     */
    public $defaultImage = null;

    public function attach($event)
    {
        parent::attach($event);

        if ($this->resizeOnUpload) {
            $this->resizeOptions = array_merge(
                $this->defaultResizeOptions,
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
        $filename = pathinfo($this->getFilePath(), PATHINFO_BASENAME);

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

        $newFileName = $this->generateFilename();
        $path = Yii::app()->uploadManager->getFilePath($newFileName, $this->getUploadPath());


        if (!YFile::checkPath(pathinfo($path, PATHINFO_DIRNAME))) {
            throw new \CHttpException(
                500,
                Yii::t(
                    'YupeModule.yupe',
                    'Directory "{dir}" is not acceptable for write!',
                    ['{dir}' => $path]
                )
            );
        }

        Imagine::resize(
            $this->getUploadedFileInstance()->getTempName(),
            $this->resizeOptions['width'],
            $this->resizeOptions['height']
        )->save(
                $path,
                $this->resizeOptions['quality']
            );

        $this->getOwner()->setAttribute($this->attributeName, $newFileName);
    }

    public function getImageUrl(
        $width = 0,
        $height = 0,
        $crop = true
    ) {
        $file = $this->getFilePath();
        $defaultImagePath = Yii::getPathOfAlias('webroot') . $this->defaultImage;
        $fileUploaded = is_file($file);

        if (!$fileUploaded) {
            if (is_file($defaultImagePath)) {
                $file = $defaultImagePath;
            } else {
                return null;
            }
        }

        if ($width || $height) {

            return Yii::app()->thumbnailer->thumbnail(
                $file,
                $this->uploadPath,
                $width,
                $height,
                $crop
            );

        }

        return $fileUploaded ? $this->getFileUrl() : $this->defaultImage;
    }
}
