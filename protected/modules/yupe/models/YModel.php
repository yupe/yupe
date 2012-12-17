<?php
/**
 * YModel - базовый класс для всех моделей Юпи!
 *
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @package yupe.core.components
 * @abstract
 * @author yupe team
 * @version 0.0.3
 * @link http://yupe.ru - основной сайт
 * 
 */
 
abstract class YModel extends Model
{
    public function attributeDescriptions()
    {
        return array();
    }

    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();
        return (isset($descriptions[$attribute])) ? $descriptions[$attribute] : '';
    }

    public function saveWithImage($fileName, $uploadPath, $oldFile = false)
    {
        if (($this->$fileName = CUploadedFile::getInstance($this, $fileName))                              &&
            ($newFile = YFile::pathIsWritable($this->alias, $this->$fileName->extensionName, $uploadPath)) &&
            $this->$fileName->saveAs($newFile)
        )
        {
            if ($oldFile)
                @unlink($uploadPath . $oldFile);
            $this->$fileName = basename($newFile);
            $this->update(array($fileName));
        }
        else if($oldFile)
        {
            $this->$fileName = $oldFile;
            $this->update(array($fileName));
        }
        return $this;
    }
}