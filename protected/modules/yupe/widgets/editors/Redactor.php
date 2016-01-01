<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

/**
 * Class Redactor
 * @package yupe\widgets\editors
 */
class Redactor extends \CInputWidget
{
    /**
     * @var string
     */
    private $redactorWidgetClass = 'vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget';

    /**
     * @var array
     */
    public $options = [];

    /**
     * @throws \Exception
     */
    public function run()
    {
        $this->widget(
            $this->redactorWidgetClass,
            [
                'model' => $this->model,
                'attribute' => $this->attribute,
                'name' => $this->name,
                'value' => $this->value,
                'options' => \CMap::mergeArray($this->getOptions(), $this->options),
                'plugins' => $this->getPlugins(),
            ]
        );
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            'toolbarFixed' => true,
            'buttonSource' => true,
            'imageUpload' => Yii::app()->createUrl('/yupe/backend/AjaxImageUpload'),
            'fileUpload' => Yii::app()->createUrl('/yupe/backend/AjaxFileUpload'),
            'imageManagerJson' => Yii::app()->createUrl('/image/imageBackend/AjaxImageChoose'),
            'fileUploadErrorCallback' => 'js:function (data) {
                $(\'#notifications\').notify({
                    message: {text: data.error},
                    type: \'danger\',
                    fadeOut: {delay: 5000}
                }).show();
                }',
            'imageUploadErrorCallback' => 'js:function (data) {
                $(\'#notifications\').notify({
                    message: {text: data.error},
                    type: \'danger\',
                    fadeOut: {delay: 5000}
                }).show();
                }',
            'toolbarFixedTopOffset' => 53,
            'lang' => strtolower(substr(Yii::app()->getLanguage(), -2)),
            'minHeight' => 150,
            'uploadImageFields' => [
                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
            ],
            'uploadFileFields' => [
                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getPlugins()
    {
        return [
            'video' => [
                'js' => ['video.js'],
            ],
            'fullscreen' => [
                'js' => ['fullscreen.js'],
            ],
            'table' => [
                'js' => ['table.js'],
            ],
            'fontsize' => [
                'js' => ['fontsize.js'],
            ],
            'fontfamily' => [
                'js' => ['fontfamily.js'],
            ],
            'fontcolor' => [
                'js' => ['fontcolor.js'],
            ],
            'imagemanager' => [
                'js' => ['imagemanager.js'],

            ],
        ];
    }
}
