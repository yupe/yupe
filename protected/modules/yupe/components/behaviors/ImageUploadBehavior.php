<?php

namespace yupe\components\behaviors;

use Yii;
use yupe\components\image\Imagine;
use yupe\helpers\YFile;

/**
 * Class ImageUploadBehavior
 * @package yupe\components\behaviors
 */
class ImageUploadBehavior extends FileUploadBehavior
{
    /**
     * @var bool
     */
    public $resizeOnUpload = true;
    /**
     * @var array
     */
    public $resizeOptions = [];

    /**
     * @var array
     */
    protected $defaultResizeOptions = [
        'width' => 950,
        'height' => 950,
        'quality' => [
            'jpegQuality' => 75,
            'pngCompressionLevel' => 7,
        ],
    ];

    /**
     * @var null|string Полный путь к изображению по умолчанию в публичной папке
     */
    public $defaultImage = null;

    /**
     * @param \CComponent $event
     */
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

    /**
     *
     */
    protected function removeFile()
    {
        parent::removeFile();
        $this->removeThumbs();
    }

    /**
     *
     */
    protected function removeThumbs()
    {
        $filename = pathinfo($this->getFilePath(), PATHINFO_BASENAME);

        $iterator = new \GlobIterator(
            Yii::app()->thumbnailer->getBasePath().'/'.$this->uploadPath.'/'.'*_'.$filename
        );

        foreach ($iterator as $file) {
            @unlink($file->getRealPath());
        }
    }

    /**
     * @throws \CHttpException
     */
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

    /**
     * @param int $width
     * @param int $height
     * @param bool|true $crop
     * @param null $defaultImage
     * @return null|string
     */
    public function getImageUrl($width = 0, $height = 0, $crop = true, $defaultImage = null)
    {
        $file = $this->getFilePath();
        $webRoot = Yii::getPathOfAlias('webroot');
        $defaultImage = $defaultImage ?: $this->defaultImage;

        if (null === $file && (null === $defaultImage || !is_file($webRoot . $defaultImage))) {
            return null;
        }

        if ($width || $height) {
            return Yii::app()->thumbnailer->thumbnail(
                $file ?: $webRoot . $defaultImage,
                $this->uploadPath,
                $width,
                $height,
                $crop
            );
        }

        return $file ? $this->getFileUrl() : $defaultImage;
    }
}
