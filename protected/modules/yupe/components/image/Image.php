<?php
namespace application\modules\yupe\components\image;

use Imagine\Image\ImageInterface;
use Yii;
use CHttpException;
use yupe\helpers\YFile;
use yupe\components\UploadManager;

class Image extends \CApplicationComponent
{
    public $cachePrefix = 'thumbs::cache::';
    public $thumbDir = 'thumbs';

    private $_uploadManager;

    public function makeThumbnail(
        $file,
        $uploadDir,
        $width,
        $height,
        $mode = ImageInterface::THUMBNAIL_OUTBOUND,
        $saveOptions = array()
    ) {
        $name = $width . 'x' . $height . '_' . $mode . '_' . $file;
        $cacheId = $this->cachePrefix . $name;

        $url = Yii::app()->cache->get($cacheId);

        if (false === $url) {

            try {
                $path = $this->getUploadManager()->getBasePath() .
                    DIRECTORY_SEPARATOR . $uploadDir .
                    DIRECTORY_SEPARATOR . $this->thumbDir;

                if (false === YFile::checkPath($path)) {
                    throw new CHttpException(
                        500,
                        Yii::t(
                            'YupeModule.yupe',
                            'Directory "{dir}" is not acceptable for write!',
                            array('{dir}' => $path)
                        )
                    );
                }

                if (!file_exists($path . DIRECTORY_SEPARATOR . $name)) {
                    Imagine::thumbnail(
                        $this->getUploadManager()->getFilePath($file, $uploadDir),
                        $width,
                        $height,
                        $mode
                    )
                        ->save($path . DIRECTORY_SEPARATOR . $name, $saveOptions);
                }

                $url = $this->getUploadManager()->getBaseUrl() . '/' . $uploadDir . '/' . $this->thumbDir . '/' . $name;

                Yii::app()->cache->set($cacheId, $url);
            } catch (\Exception $e) {
                Yii::log($e->__toString(), \CLogger::LEVEL_ERROR);
                return null;
            }
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