<?php
/**
* YAjaxFileUploadAction.php file.
*
* @category YupeComponents
* @package  yupe.modules.yupe.components.actions
* @author   Anton Kucherov <idexter.ru@gmail.com>
* @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
* @version  0.1
* @link     http://yupe.ru
*/

namespace yupe\components\actions;

use Yii, CAction, CUploadedFile;

class YAjaxFileUploadAction extends CAction
{

    protected $fileLink = null;
    protected $fileName = null;
    protected $uploadedFile = null;

    protected $uploadPath;
    protected $rename;
    protected $webPath;

    /**
     * Метод для загрузки файлов из редактора при создании контента
     *
     * @since 0.4
     *
     * Подробнее http://imperavi.com/redactor/docs/images/
     *
     * @return void
     */
    public function run()
    {
        if (!empty($_FILES['file']['name'])) {
            $controller = $this->getController();
            $this->rename     = (bool) Yii::app()->getRequest()->getQuery('rename', true);
            $this->webPath    = '/' . $controller->yupe->uploadPath . '/' . date('dmY') . '/';
            $this->uploadPath = Yii::getPathOfAlias('webroot') . $this->webPath;

            if (!is_dir($this->uploadPath)) {
                if (!@mkdir($this->uploadPath)) {
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'Can\'t create catalog "{dir}" for files!', array('{dir}' => $this->uploadPath)));
                }
            }

            $controller->disableProfilers();

            $this->uploadedFile = CUploadedFile::getInstanceByName('file');
            $this->fileLink = $this->fileName = null;

            $this->uploadFile();

            if($this->fileLink !== null && $this->fileName !== null) {
                Yii::app()->ajax->rawText(
                    json_encode( array('filelink' => $this->fileLink, 'filename' => $this->fileName) )
                );
            }
        }

        Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
    }

    protected function uploadFile()
    {
        if ($this->uploadedFile) {
            //сгенерировать имя файла и сохранить его
            $newFileName = $this->rename ? md5(time() . uniqid() . $this->uploadedFile->name) . '.' . $this->uploadedFile->extensionName : $this->uploadedFile->name;

            if (!$this->uploadedFile->saveAs($this->uploadPath . $newFileName)) {
                Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
            }

            $this->fileLink = Yii::app()->baseUrl . $this->webPath . $newFileName;
            $this->fileName = $this->uploadedFile->name;

            return true;

        }
        return false;
    }
} 