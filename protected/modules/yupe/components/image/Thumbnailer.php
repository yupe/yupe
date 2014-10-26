<?php
namespace yupe\components\image;

use Imagine\Image\ImageInterface;
use Yii;
use CHttpException;
use yupe\helpers\YFile;

class Thumbnailer extends \CApplicationComponent
{
    public $cachePrefix = 'thumbs::cache::';
    public $thumbDir = 'thumbs';

    private $_basePath;
    private $_baseUrl;

    /**
     * @param $file string Полный путь к исходному файлу в файловой системе
     * @param $uploadDir string Подпапка в папке с миниатюрами куда надо поместить изображение
     * @param $width
     * @param $height
     * @param string $mode
     * @param array $options
     * @return mixed|string
     * @throws CHttpException
     */
    public function thumbnail(
        $file,
        $uploadDir,
        $width,
        $height,
        $mode = ImageInterface::THUMBNAIL_OUTBOUND,
        $options = ['jpeg_quality' => 90, 'png_compression_level' => 8]
    ) {
        $name = $width . 'x' . $height . '_' . $mode . '_' . basename($file);
        $cacheId = $this->cachePrefix . '::' . $file . '::' . $name;

        $url = Yii::app()->cache->get($cacheId);

        if (false === $url) {

            $uploadPath = $this->getBasePath() . DIRECTORY_SEPARATOR . $uploadDir;

            if (false === YFile::checkPath($uploadPath)) {
                throw new CHttpException(
                    500,
                    Yii::t(
                        'YupeModule.yupe',
                        'Directory "{dir}" is not acceptable for write!',
                        array('{dir}' => $uploadPath)
                    )
                );
            }

            $thumbFile = $uploadPath . DIRECTORY_SEPARATOR . $name;

            if (!file_exists($thumbFile)) {
                Imagine::thumbnail(
                    $file,
                    $width,
                    $height,
                    $mode
                )->save($thumbFile, $options);
            }

            $url = $this->getBaseUrl() . '/' . $uploadDir . '/' . $name;
            Yii::app()->cache->set($cacheId, $url);
        }

        return $url;
    }

    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $this->_basePath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->thumbDir;
        }

        return $this->_basePath;
    }

    public function setBasePath($value)
    {
        $this->_basePath = rtrim($value, DIRECTORY_SEPARATOR);
    }

    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->_baseUrl = Yii::app()->uploadManager->getBaseUrl() . '/' . $this->thumbDir;
        }

        return $this->_baseUrl;
    }

    public function setBaseUrl($value)
    {
        $this->_baseUrl = rtrim($value, '/');
    }
}
