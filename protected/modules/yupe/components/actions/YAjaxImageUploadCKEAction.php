<?php

namespace yupe\components\actions;

use Yii;
use CAction;
use yupe\models\UploadForm;
use CUploadedFile;
use Image;

/**
 * Class YAjaxImageUploadCKEAction
 * @package yupe\components\actions
 */
class YAjaxImageUploadCKEAction extends YAjaxImageUploadAction
{
    /**
     *
     */
    public function run()
    {
        $message = null;

        if (empty($_FILES['upload']['name'])) {
            $message = Yii::t('YupeModule.yupe', 'There is an error when downloading!');
        }

        // по умолчанию не переименовываем файл
        $this->rename = (bool)Yii::app()->getRequest()->getQuery('rename', false);
        $this->webPath = '/'.$this->getController()->yupe->uploadPath.'/files/'.date('Y/m/d').'/';
        $this->uploadPath = Yii::getPathOfAlias('webroot').$this->webPath;

        if (!is_dir($this->uploadPath)) {
            if (!@mkdir($this->uploadPath, 0755, true)) {
                $message = Yii::t(
                    'YupeModule.yupe',
                    'Can\'t create catalog "{dir}" for files!',
                    array('{dir}' => $this->uploadPath)
                );
            }
        }

        $this->getController()->disableProfilers();

        $this->uploadedFile = CUploadedFile::getInstanceByName('upload');

        $form = new UploadForm();
        $form->maxSize = $this->maxSize ?: null;
        $form->mimeTypes = $this->mimeTypes ?: null;
        $form->types = $this->types ?: null;
        $form->file = $this->uploadedFile;

        if ($form->validate() && $this->uploadFile() && ($this->fileLink !== null && $this->fileName !== null)) {
            $fullPath = $this->fileLink; //'filename' => $this->fileName;
        } else {
            $message = implode("\n", $form->getErrors("file"));
        }

        $callback = Yii::app()->getRequest()->getParam('CKEditorFuncNum');
        echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$fullPath.'", "'.$message.'" );</script>';
        Yii::app()->end();

    }

    /**
     * @return bool
     */
    protected function uploadFile()
    {
        if (!Yii::app()->hasModule('image')) {
            return false;
        }

        if (false === getimagesize($this->uploadedFile->getTempName())) {
            return false;
        }

        $image = new Image();
        $image->setScenario('insert');
        $image->addFileInstanceName('upload');
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
