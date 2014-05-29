<?php
namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use Imagine\Image\ImageInterface;
use Yii;
use application\modules\yupe\components\image\Imagine;

class ImageThumbBehavior extends CActiveRecordBehavior
{
    public $attributeName;
    public $moduleName;
    public $subFolder;
    public $uploadPath;
    public $sourceFolder;

    protected $_oldImage;
    /**
     * make thumbnail of image
     *
     * @param int $width - ширина
     * @param int $height - высота
     * @param bool $adaptiveResize - обрезать ли фотографию для соблюдения пропорций
     *
     * @return string filename
     **/
    public function makeThumbnail($width = 0, $height = 0, $adaptiveResize = true)
    {
        $width = $width === 0
            ? $height
            : $width;

        $height = $height === 0
            ? $width
            : $height;

        $ext = pathinfo($this->owner->{$this->attributeName}, PATHINFO_EXTENSION);
        $file = 'thumb_cache_' . $width . 'x' . $height . '_' . ($adaptiveResize ? 'ar_' : '') . pathinfo($this->owner->{$this->attributeName}, PATHINFO_FILENAME) . '.' . $ext;

        if (!file_exists($this->sourceFolder . '/' . $this->owner->{$this->attributeName}))
        {
            return null;
        }


        if (file_exists($this->uploadPath . '/' . $file) === false)
        {
            $thumb = Imagine::thumbnail($this->sourceFolder . '/' . $this->owner->{$this->attributeName}, $width, $height, $adaptiveResize ? ImageInterface::THUMBNAIL_OUTBOUND: ImageInterface::THUMBNAIL_INSET);

            if (!file_exists($this->uploadPath))
            {
                mkdir($this->uploadPath, 0755, true);
            }
            $thumb->save($this->uploadPath . '/' . $file);
        }

        return $file;
    }

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

        if (!$this->owner->{$this->attributeName})
        {
            return false;
        }

        if ($width || $height)
        {
            return str_replace(Yii::getPathOfAlias('webroot'), '', $this->uploadPath) . '/' .
            (($thumbnail = $this->makeThumbnail($width, $height, $adaptiveResize)) !== null
                ? $thumbnail
                : $this->owner->{$this->attributeName}
            );
        }
        else
        {
            return str_replace(array(Yii::getPathOfAlias('webroot')), '', $this->sourceFolder) . '/' . $this->owner->{$this->attributeName};
        }
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
        foreach ((array)glob($this->uploadPath . '/' . 'thumb_cache_*_' . $fileName) as $file)
        {
            @unlink($file);
        }
    }
}