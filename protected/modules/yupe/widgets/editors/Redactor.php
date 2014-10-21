<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

class Redactor extends \CInputWidget
{
    private $redactorWidgetClass = 'vendor.yiiext.imperavi-redactor-widget.ImperaviRedactorWidget';

    public $options = array();

    public function run()
    {
        $this->widget(
            $this->redactorWidgetClass,
            [
                'model'     => $this->model,
                'attribute' => $this->attribute,
                'name'      => $this->name,
                'options'   => \CMap::mergeArray($this->getOptions(), $this->options),
                'plugins'   => [
                    'video' => [
                        'js' => ['video.js']
                    ],
                    'fullscreen' => [
                        'js' => ['fullscreen.js']
                    ],
                    'table' => [
                        'js' => ['table.js']
                    ],
                    'fontsize' => [
                        'js' => ['fontsize.js']
                    ],
                    'fontfamily' => [
                        'js' => ['fontfamily.js']
                    ],
                    'fontcolor' => [
                        'js' => ['fontcolor.js']
                    ],
                    'imagemanager' => [
                        'js' => ['imagemanager.js'],

                    ]
                ]
            ]
        );
    }

    public function getOptions()
    {
        return array(
            'buttonSource'            => true,
            'imageUpload'             => Yii::app()->createUrl('/yupe/backend/AjaxImageUpload'),
            'fileUpload'              => Yii::app()->createUrl('/yupe/backend/AjaxFileUpload'),
            'imageManagerJson'        => Yii::app()->createUrl('/image/imageBackend/AjaxImageChoose'),
            'fileUploadErrorCallback' => 'js:function (data) {
                $(\'#notifications\').notify({
                    message: {text: data.error},
                    type: \'danger\',
                    fadeOut: {delay: 5000}
                }).show();
                }',
            'toolbarFixedTopOffset' => 53
        );
    }
}
