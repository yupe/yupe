<?php
namespace application\modules\yupe\components;

use Yii;
use CUploadedFile;
use yupe\helpers\YFile;

class UploadManager extends \CApplicationComponent
{
    private $_basePath;
    private $_baseUrl;

    public function save(CUploadedFile $fileInstance, $uploadPath, $fileName)
    {
        $path = $this->getFilePath($fileName, $uploadPath);
        YFile::checkPath(pathinfo($path, PATHINFO_DIRNAME));

        return $fileInstance->saveAs($path);
    }

    public function getFilePath($name, $uploadPath)
    {
        return $this->basePath . DIRECTORY_SEPARATOR . $uploadPath . DIRECTORY_SEPARATOR . $name;
    }

    public function getFileUrl($name, $uploadPath)
    {
        return $this->getBaseUrl() . '/' . $uploadPath . '/' . $name;
    }

    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $this->setBasePath(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . Yii::app()->getModule('yupe')->uploadPath);
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
            $this->setBaseUrl(Yii::app()->request->getBaseUrl(true) . '/' . Yii::app()->getModule('yupe')->uploadPath);
        }

        return $this->_baseUrl;
    }

    public function setBaseUrl($value)
    {
        $this->_baseUrl = rtrim($value, '/');
    }
} 