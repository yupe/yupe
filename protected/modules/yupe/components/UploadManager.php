<?php
namespace yupe\components;

use Yii;
use CUploadedFile;
use yupe\helpers\YFile;

class UploadManager extends \CApplicationComponent
{
    /**
     * @var
     */
    private $_basePath;
    /**
     * @var
     */
    private $_baseUrl;

    /**
     * @param  CUploadedFile $fileInstance
     * @param  string $uploadPath - file path
     * @param  string $fileName - file name
     * @return bool
     *
     * Сохранение загруженного файла
     */
    public function save(CUploadedFile $fileInstance, $uploadPath, $fileName)
    {
        $path = $this->getFilePath($fileName, $uploadPath);

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

        return $fileInstance->saveAs($path);
    }

    /**
     * @param $name
     * @param $uploadPath
     * @return string
     */
    public function getFilePath($name, $uploadPath)
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR . $name;
    }

    /**
     * @param $name
     * @param $uploadPath
     * @return string
     */
    public function getFileUrl($name, $uploadPath)
    {
        return $this->getBaseUrl() . '/' . $uploadPath . '/' . $name;
    }

    /**
     * @return null
     */
    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $this->setBasePath(
                Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath
            );
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
     * @return null
     */
    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $this->setBaseUrl(
                Yii::app()->getRequest()->getBaseUrl(true) . '/' . Yii::app()->getModule('yupe')->uploadPath
            );
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
