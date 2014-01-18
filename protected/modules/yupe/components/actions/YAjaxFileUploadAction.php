<?php
/**
* YAjaxFileUploadAction.php file.
*
* @author Anton Kucherov <idexter.ru@gmail.com>
* @link http://idexter.ru/
* @copyright 2014 idexter.ru
*/

namespace yupe\components\actions;

use Yii, CAction, CUploadedFile;

class YAjaxFileUploadAction extends CAction
{
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
            $rename     = (bool) Yii::app()->getRequest()->getQuery('rename', true);
            $webPath    = '/' . $controller->yupe->uploadPath . '/' . date('dmY') . '/';
            $uploadPath = Yii::getPathOfAlias('webroot') . $webPath;

            if (!is_dir($uploadPath)) {
                if (!@mkdir($uploadPath)) {
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'Can\'t create catalog "{dir}" for files!', array('{dir}' => $uploadPath)));
                }
            }

            $controller->disableProfilers();

            $file = CUploadedFile::getInstanceByName('file');

            if ($file) {
                //сгенерировать имя файла и сохранить его
                $newFileName = $rename ? md5(time() . uniqid() . $file->name) . '.' . $file->extensionName : $file->name;

                if (!$file->saveAs($uploadPath . $newFileName)) {
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
                }

                Yii::app()->ajax->rawText(
                    json_encode(
                        array(
                            'filelink' => Yii::app()->baseUrl . $webPath . $newFileName,
                            'filename' => $file->name
                        )
                    )
                );
            }
        }

        Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'There is an error when downloading!'));
    }
} 