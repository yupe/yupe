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
use yupe\helpers\YText;
use yupe\models\UploadForm;
use CUploadedFile;

/**
 * Class YAjaxFileUploadAction
 * @package yupe\components\actions
 */
class YAjaxFileUploadAction extends CAction
{
    /**
     * @var string
     */
    protected $fileLink = null;
    /**
     * @var string
     */
    protected $fileName = null;
    /**
     * @var CUploadedFile
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
        if (empty($_FILES['file']['name'])) {
            Yii::app()->ajax->raw(
                ['error' => Yii::t('YupeModule.yupe', 'There is an error when downloading!')]
            );
        }

        // по умолчанию не переименовываем файл
        $this->rename = (bool)Yii::app()->getRequest()->getQuery('rename', false);
        $this->webPath = '/' . $this->getController()->yupe->uploadPath . '/files/' . date('Y/m/d') . '/';
        $this->uploadPath = Yii::getPathOfAlias('webroot') . $this->webPath;

        if (!is_dir($this->uploadPath)) {
            if (!@mkdir($this->uploadPath, 0755, true)) {
                Yii::app()->ajax->raw(
                    [
                        'error' => Yii::t(
                            'YupeModule.yupe',
                            'Can\'t create catalog "{dir}" for files!',
                            array('{dir}' => $this->uploadPath)
                        )
                    ]
                );
            }
        }

        $this->getController()->disableProfilers();

        $this->uploadedFile = CUploadedFile::getInstanceByName('file');

        $form = new UploadForm();
        $form->maxSize = $this->maxSize ?: null;
        $form->mimeTypes = $this->mimeTypes ?: null;
        $form->types = $this->types ?: null;
        $form->file = $this->uploadedFile;

        if ($form->validate() && $this->uploadFile() && ($this->fileLink !== null && $this->fileName !== null)) {
            Yii::app()->ajax->raw(
                ['filelink' => $this->fileLink, 'filename' => $this->fileName]
            );
        } else {
            Yii::app()->ajax->raw(['error' => join("\n", $form->getErrors("file"))]);
        }
    }

    /**
     * @return bool
     */
    protected function uploadFile()
    {
        if (!$this->uploadedFile) {
            return false;
        }
        // сгенерировать имя файла и сохранить его,
        // если не включено переименование, то все равно имя переводится в транслит, чтобы не было проблем
        $newFileName = $this->rename ?
            md5(time() . uniqid() . $this->uploadedFile->name) . '.' . $this->uploadedFile->extensionName :
            YText::translit(
                basename($this->uploadedFile->name, $this->uploadedFile->extensionName)
            ) . '.' . $this->uploadedFile->extensionName;

        if (!$this->uploadedFile->saveAs($this->uploadPath . $newFileName)) {
            Yii::app()->ajax->raw(
                ['error' => Yii::t('YupeModule.yupe', 'There is an error when downloading!')]
            );
        }

        $this->fileLink = Yii::app()->getBaseUrl() . $this->webPath . $newFileName;
        $this->fileName = $this->uploadedFile->name;

        return true;
    }
}
