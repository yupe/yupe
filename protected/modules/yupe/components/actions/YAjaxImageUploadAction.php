<?php
/**
* YAjaxImageUploadAction.php file.
*
* @category YupeComponents
* @package  yupe.modules.yupe.components.actions
* @author   Anton Kucherov <idexter.ru@gmail.com>
* @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
* @version  0.1
* @link     http://yupe.ru
*/

namespace yupe\components\actions;

use Yii;
use Image;

class YAjaxImageUploadAction extends YAjaxFileUploadAction
{
    protected function uploadFile()
    {
        if(Yii::app()->hasModule("image") &&
            Yii::app()->getModule('image')->getIsActive() &&
            false !== getimagesize($this->uploadedFile->getTempName()))
        {
            $data["Image"]["category_id"] = "";
            $data["Image"]["gallery_id"] = "";
            $data["Image"]["type"] = Image::TYPE_SIMPLE;
            $data["Image"]["status"] = Image::STATUS_CHECKED;

            $image = new Image();
            $image->setScenario('insert');
            $image->addFileInstanceName('file');


            $image->setAttribute('name',$this->uploadedFile->getName());
            $image->setAttribute('alt',$this->uploadedFile->getName());
            $image->setAttribute('file',$_FILES['file']);
            $image->setAttributes($data);

            $transaction = Yii::app()->db->beginTransaction();

            try {
                if ($image->save()) {
                    $transaction->commit();

                    $this->fileLink = $image->getUrl();
                    $this->fileName = $image->getName();

                    return true;
                }
            } catch(Exception $e) {
                $transaction->rollback();
                Yii::app()->ajax->rawText($e->getMessage());
            }
        }else{
            parent::uploadFile();
        }
        return false;
    }

} 