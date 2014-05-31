<?php
namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use Imagine\Image\ImageInterface;
use Yii;
use application\modules\yupe\components\UploadManager;

class ImageThumbBehavior extends CActiveRecordBehavior
{
    public $attributeName;
    public $uploadPath;

    protected $_oldImage;

    private $_uploadManager;

    /**
     * Получаем URL к файлу:
     *
     * @param int $width - параметр ширины для изображения
     * @param int $height - параметр высоты для изображения
     * @param bool $adaptiveResize - обрезать ли фотографию для соблюдения пропорций
     *
     * @return string URL к файлу
     */
    public function getImageUrl($width = 0, $height = 0, $adaptiveResize = true)
    {
        if ($width || $height)
        {
            $width = $width === 0
                ? $height
                : $width;

            $height = $height === 0
                ? $width
                : $height;
            $url = Yii::app()->image->makeThumbnail($this->owner->{$this->attributeName}, $this->uploadPath, $width, $height, $adaptiveResize ? ImageInterface::THUMBNAIL_OUTBOUND: ImageInterface::THUMBNAIL_INSET);
        }
        else{
            $url = $this->getUploadManager()->getBaseUrl() . '/' . $this->uploadPath . '/' . $this->owner->{$this->attributeName};
        }
        return $url;
    }

    public function afterFind($event)
    {
        $this->_oldImage = $this->owner->{$this->attributeName};
    }

    public function afterSave($event)
    {
        if ($this->_oldImage != $this->owner->{$this->attributeName})
        {
            $this->deleteThumbs();
        }
    }

    public function beforeDelete($event)
    {
        $this->deleteThumbs();
    }

    public function deleteThumbs()
    {
        $fileName = pathinfo($this->_oldImage, PATHINFO_BASENAME);
        foreach ((array)glob($this->getUploadManager()->getBasePath() . '/' . Yii::app()->image->thumbDir . DIRECTORY_SEPARATOR . $this->uploadPath . DIRECTORY_SEPARATOR . '*_' . $fileName) as $file)
        {
            @unlink($file);
        }
    }

    /**
     * @return UploadManager
     */
    protected function getUploadManager()
    {
        if ($this->_uploadManager === null) {
            $this->_uploadManager = Yii::app()->getComponent('uploadManager');
        }

        return $this->_uploadManager;
    }
}