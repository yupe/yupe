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

use Yii;
use CAction;
use yupe\models\UploadForm;
use CUploadedFile;

/**
 * Class YAjaxFileUploadAction
 * @package yupe\components\actions
 */
class YAjaxFileUploadAction extends CAction
{
    /**
     * @var null
     */
    protected $fileLink = null;
    /**
     * @var null
     */
    protected $fileName = null;
    /**
     * @var null
     */
    protected $uploadedFile = null;

    /**
     * @var
     */
    protected $uploadPath;
    /**
     * @var
     */
    protected $rename;
    /**
     * @var
     */
    protected $webPath;

    /**
     * @var
     */
    public $maxSize;
    /**
     * @var
     */
    public $mimeTypes;
    /**
     * @var
     */
    public $types;

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
        if(empty($this->maxSize) || empty($this->mimeTypes) || empty($this->types)) {
            Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe','Please, proper config YAjaxFileUploadAction !'));
        }

        if (empty($_FILES['file']['name'])) {
            Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
        }

        $this->rename     = (bool) Yii::app()->getRequest()->getQuery('rename', true);
        $this->webPath    = '/' . $this->getController()->yupe->uploadPath . '/' . date('dmY') . '/';
        $this->uploadPath = Yii::getPathOfAlias('webroot') . $this->webPath;

        if (!is_dir($this->uploadPath)) {
            if (!@mkdir($this->uploadPath)) {
                Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'Can\'t create catalog "{dir}" for files!', array('{dir}' => $this->uploadPath)));
            }
        }

        $this->getController()->disableProfilers();

        $this->uploadedFile = CUploadedFile::getInstanceByName('file');

        $form = new UploadForm;
        $form->maxSize = $this->maxSize;
        $form->mimeTypes = $this->mimeTypes;
        $form->types = $this->types;
        $form->file  = $this->uploadedFile;

        if($form->validate() && $this->uploadFile() && ($this->fileLink !== null && $this->fileName !== null)) {
            Yii::app()->ajax->rawText(
                json_encode( array('filelink' => $this->fileLink, 'filename' => $this->fileName) )
            );
        }

        Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
    }

    /**
     * @return bool
     */
    protected function uploadFile()
    {
        if (!$this->uploadedFile) {
            return false;
        }

        //сгенерировать имя файла и сохранить его
        $newFileName = $this->rename ? md5(time() . uniqid() . $this->uploadedFile->name) . '.' . $this->uploadedFile->extensionName : $this->uploadedFile->name;

        if (!$this->uploadedFile->saveAs($this->uploadPath . $newFileName)) {
            Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
        }

        $this->fileLink = Yii::app()->getBaseUrl() . $this->webPath . $newFileName;
        $this->fileName = $this->uploadedFile->name;
        return true;
    }
} 