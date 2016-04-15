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

/**
 * Class YAjaxImageUploadAction
 * @package yupe\components\actions
 */
class YAjaxImageUploadAction extends YAjaxFileUploadAction
{
    /**
     * @return bool
     */
    protected function uploadFile()
    {
        if (!$this->uploadedFile || !Yii::app()->hasModule('image')) {
            return false;
        }

        if (false === getimagesize($this->uploadedFile->getTempName())) {
            return false;
        }

        $image = new Image();
        $image->setScenario('insert');
        $image->addFileInstanceName('file');
        $image->setAttribute('name', $this->uploadedFile->getName());
        $image->setAttribute('alt', $this->uploadedFile->getName());
        $image->setAttribute('type', Image::TYPE_SIMPLE);

        if ($image->save()) {

            $this->fileLink = $image->getImageUrl();
            $this->fileName = $image->getName();

            return true;
        }

        return false;
    }
}
