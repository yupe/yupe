<?php
/**
 *
 * @package  yupe.modules.yupe.components.behaviors
 *
 */

namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use CValidator;
use CUploadedFile;
use Yii;
use yupe\helpers\YFile;

class ImageUploadBehavior extends CActiveRecordBehavior
{
    /*
     * Атрибут модели для хранения изображения
     */
    public $attributeName = 'image';

    /*
     * Атрибут для замены имени поля file если необходимо
     */
    public $fileInstanceName = '';

    /*
     * Загружаемое изображение
     */
    public $image;
    /*
     * Минимальный размер загружаемого изображения
     */
    public $minSize = 0;

    /*
     * Максимальный размер загружаемого изображения
     */
    public $maxSize = 5368709120;

    /*
     * Допустимые типы изображений
     */
    public $types = 'jpg,jpeg,png,gif';
    /*
     * Список сценариев в которых будет использовано поведение
     */
    public $scenarios = array('insert', 'update');
    /*
     * Директория для загрузки изображений
     */
    public $uploadPath;
    /*
     * Список сценариев в которых изображение обязательно, 'insert, update'
     */
    public $requiredOn;

    /*
     * Callback функция для генерации имени загружаемого файла
     */
    public $imageNameCallback;
    /*
     * Параметры для ресайза изображения
     */
    public $resize = array('quality' => 100);

    protected $_newImage;
    protected $_oldImage;

    public function attach($owner)
    {
        parent::attach($owner);

        if ($this->checkScenario()) {
            if ($this->requiredOn) {
                $requiredValidator = CValidator::createValidator('required', $owner, $this->attributeName, array(
                    'on' => $this->requiredOn,
                ));
                $owner->validatorList->add($requiredValidator);
            }

            $fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array(
                'types' => $this->types,
                'minSize' => $this->minSize,
                'maxSize' => $this->maxSize,
                'allowEmpty' => true,
            ));

            $owner->validatorList->add($fileValidator);
        }
    }

    public function afterFind($event)
    {
        $this->_oldImage = $this->getUploadPath() . $this->owner{$this->attributeName};
    }

    public function beforeValidate($event)
    {
        if (empty($this->fileInstanceName)) {
            $this->_newImage = CUploadedFile::getInstance($this->owner, $this->attributeName);
        } else {
            $this->_newImage = CUploadedFile::getInstanceByName($this->fileInstanceName);
        }

        if ($this->checkScenario() && $this->_newImage) {
            $this->owner->{$this->attributeName} = $this->_newImage;
        }
    }

    public function beforeSave($event)
    {
        if ($this->checkScenario() && $this->_newImage instanceof CUploadedFile) {
            $this->saveImage();
            $this->deleteImage();
        }
    }

    public function beforeDelete($event)
    {
        $this->deleteImage();
    }

    public function deleteImage()
    {
        if (@is_file($this->_oldImage)) {
            // Удаляем связанные с данным изображением превьюшки:
            $fileName = pathinfo($this->_oldImage, PATHINFO_BASENAME);

            foreach (glob($this->getUploadPath() . 'thumb_cache_*_' . $fileName) as $file) {
                @unlink($file);
            }

            @unlink($this->_oldImage);
        }
    }

    /*
     * Проверяет допустимо ли использовать поведение в текущем сценарии
     */
    public function checkScenario()
    {
        return in_array($this->owner->scenario, $this->scenarios);
    }

    /*
     * Генерирует имя файла с использованием callback функции если возможно
     */
    protected function _getImageName()
    {
        return (is_callable($this->imageNameCallback))
            ? (call_user_func($this->imageNameCallback))
            : md5(microtime(true) . rand() . rand());

    }

    public function saveImage()
    {
        $quality = isset($this->resize['quality']) ? $this->resize['quality'] : 100;
        $width = isset($this->resize['width']) ? $this->resize['width'] : null;
        $height = isset($this->resize['height']) ? $this->resize['height'] : null;

        $tmpName = $this->_newImage->tempName;
        $imageName = $this->_getImageName();
        $image = Yii::app()->image->load($tmpName)->quality($quality);

        if (!$newFile = YFile::pathIsWritable($imageName, $image->ext, $this->getUploadPath())) {
            throw new CHttpException(500, Yii::t('YupeModule.yupe', 'Directory "{dir}" is not acceptable for write!', array('{dir}' => $this->uploadPath)));
        }

        if (($width !== null && $image->width > $width) || ($height !== null && $image->height > $height)) {
            $image->resize($width, $height);
        }

        if ($image->save($newFile)) {
            $this->owner->{$this->attributeName} = pathinfo($newFile, PATHINFO_BASENAME);
        }
    }

    public function addFileInstanceName($name)
    {
        $this->fileInstanceName = $name;
    }

    /**
     * Получить каталог для загрузки изображений
     * С версии 0.7 может быть задан как callback
     *
     * @since 0.7
     * @return string
     */
    public function getUploadPath()
    {
        if (is_callable($this->uploadPath)) {
            return call_user_func($this->uploadPath);
        }

        return $this->uploadPath;
    }
}
