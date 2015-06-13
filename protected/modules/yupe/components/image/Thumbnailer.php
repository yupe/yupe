<?php
namespace yupe\components\image;

use Imagine\Image\ImageInterface;
use Yii;
use CException;
use yupe\helpers\YFile;
use Imagine\Image\Box;
use Imagine\Image\ImagineInterface;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;

/**
 * Class Thumbnailer
 * @package yupe\components\image
 */
class Thumbnailer extends \CApplicationComponent
{
    /**
     * @var string
     */
    public $thumbDir = 'thumbs';

    /**
     * @var
     */
    private $_basePath;
    /**
     * @var
     */
    private $_baseUrl;

    /**
     * @param string $file Полный путь к исходному файлу в файловой системе
     * @param string $uploadDir Подпапка в папке с миниатюрами куда надо поместить изображение
     * @param float $width Ширина изображения. Если не указана - будет вычислена из высоты
     * @param float $height Высота изображения. Если не указана - будет вычислена из ширины
     * @param array $options
     * @return string
     * @throws CException
     */
    public function thumbnail(
        $file,
        $uploadDir,
        $width = 0,
        $height = 0,
        array $options = ['jpeg_quality' => 90, 'png_compression_level' => 8]
    ) {
        if (!$width && !$height) {
            throw new CException("Incorrect width/height");
        }

        $name = $width . 'x' . $height . '_' . basename($file);
        $uploadPath = $this->getBasePath() . DIRECTORY_SEPARATOR . $uploadDir;
        $thumbFile = $uploadPath . DIRECTORY_SEPARATOR . $name;

        if (!file_exists($thumbFile)) {

            if (false === YFile::checkPath($uploadPath)) {
                throw new CException(
                    Yii::t(
                        'YupeModule.yupe',
                        'Directory "{dir}" is not acceptable for write!',
                        ['{dir}' => $uploadPath]
                    )
                );
            }

            $img = Imagine::getImagine()->open($file);

            $originalWidth = $img->getSize()->getWidth();
            $originalHeight = $img->getSize()->getHeight();

            if (!$width) {
                $width = $height / $originalHeight * $originalWidth;
            }

            if (!$height) {
                $height = $width / $originalWidth * $originalHeight;
            }

            if ($width / $originalWidth > $height / $originalHeight) {
                $box = new Box($width, $originalHeight * $width / $originalWidth);
            } else {
                $box = new Box($originalWidth * $height / $originalHeight, $height);
            }

            $img->resize($box)->crop(
                new Point(max(0, round(($box->getWidth() - $width) / 2)), max(
                    0,
                    round(($box->getHeight() - $height) / 2)
                )),
                new Box($width, $height)
            )->save($thumbFile, $options);
        }

        $url = $this->getBaseUrl() . '/' . $uploadDir . '/' . $name;

        return $url;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $this->_basePath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->thumbDir;
        }

        return $this->_basePath;
    }

    /**
     * @param $value
     */
    public function setBasePath($value)
    {
        $this->_basePath = rtrim($value, DIRECTORY_SEPARATOR);
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = Yii::app()->uploadManager->getBaseUrl() . '/' . $this->thumbDir;
        }

        return $this->_baseUrl;
    }

    /**
     * @param $value
     */
    public function setBaseUrl($value)
    {
        $this->_baseUrl = rtrim($value, '/');
    }
}
