<?php
namespace application\modules\yupe\components\image;

use Imagine\Image\ImageInterface;
use Yii;
use CHttpException;
use yupe\helpers\YFile;
use application\modules\yupe\components\UploadManager;
use application\modules\yupe\components\image\Imagine;

class Image extends \CApplicationComponent
{
    public $cachePrefix = 'thumbs_cache::';
    public $thumbDir = 'thumbs';

    private $_uploadManager;

    public function makeThumbnail($file, $uploadDir, $width, $height, $mode = ImageInterface::THUMBNAIL_OUTBOUND, $saveOptions = array())
    {
        $name = $width . 'x' . $height . '_' . $mode . '_' . $file;
        $cacheId = $this->cachePrefix . $name;

        $url = Yii::app()->cache->get($cacheId);

        if (false === $url) {
            $path = $this->getUploadManager()->getBasePath() .
                DIRECTORY_SEPARATOR . $uploadDir .
                DIRECTORY_SEPARATOR . $this->thumbDir;

            if (false === YFile::checkPath($path)) {
                throw new CHttpException(
                    500,
                    Yii::t('YupeModule.yupe', 'Directory "{dir}" is not acceptable for write!', array('{dir}' => $path))
                );
            }

            Imagine::thumbnail($this->getUploadManager()->getFilePath($file, $uploadDir), $width, $height, $mode)
                ->save($path . DIRECTORY_SEPARATOR . $name, $saveOptions);

            $url = $this->getUploadManager()->getBaseUrl() . '/' . $uploadDir . '/' . $this->thumbDir . '/' . $name;
            Yii::app()->cache->set($cacheId, $url);
        }

        return $url;
    }

    public function getImagine()
    {
        return Imagine::getImagine();
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