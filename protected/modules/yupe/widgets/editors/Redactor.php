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
        Yii::app()->getClientScript()->registerCss(
            'redactor-toolbar-fixed',
            ".toolbar_fixed_box {
                top: 53px !important;
            }"
        );

        $this->widget(
            $this->redactorWidgetClass,
            [
                'model'     => $this->model,
                'attribute' => $this->attribute,
                'name'      => $this->name,
                'options'   => \CMap::mergeArray($this->getOptions(), $this->options),
            ]
        );
    }

    public function getOptions()
    {
        return array(
            'imageUpload'             => Yii::app()->createUrl('/yupe/backend/AjaxFileUpload'),
            'fileUpload'              => Yii::app()->createUrl('/yupe/backend/AjaxFileUpload'),
            'imageGetJson'            => Yii::app()->createUrl('/image/imageBackend/AjaxImageChoose'),
            'fileUploadErrorCallback' => 'js:function (data) {
                $(\'#notifications\').notify({
                    message: {text: data.error},
                    type: \'danger\',
                    fadeOut: {delay: 5000}
                }).show();
                }',
            'toolbarFixedBox'         => true,
        );
    }
}
