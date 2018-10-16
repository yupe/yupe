<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

/**
 * Class CKEditor
 * @package yupe\widgets\editors
 */
class CKEditor extends \CInputWidget
{
    /**
     * @var array
     */
    public $editorOptions = [];

    /**
     * @throws \Exception
     */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        $this->htmlOptions['id'] = $id;

        if($this->hasModel()){
            echo \CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        }else{
            echo \CHtml::textArea($name, $this->value, $this->htmlOptions);
        }

        $this->registerClientScript($id);
    }

    /**
     * @param $id
     */
    public function registerClientScript($id)
    {
        $options = [
            'language' => Yii::app()->getLanguage(),
            'filebrowserUploadUrl' => Yii::app()->createUrl('/yupe/backend/AjaxImageUploadCKE'),
            'extraPlugins' => 'table,tableresize,tabletools,stylesheetparser,embed,image,filetools,docprops,lineutils,liststyle,find,uploadwidget',
            'autoParagraph' => false
        ];

        $assets = Yii::app()->getAssetManager()->publish(
            Yii::getPathOfAlias('vendor').'/ckeditor/ckeditor/'
        );

        Yii::app()->getClientScript()->registerScriptFile($assets.'/ckeditor.js', \CClientScript::POS_HEAD);
        Yii::app()->getClientScript()->registerScriptFile($assets.'/lang/'.Yii::app()->getLanguage().'.js',
            \CClientScript::POS_HEAD);

        $options = \CJavaScript::encode(\CMap::mergeArray($options, $this->editorOptions));

        Yii::app()->getClientScript()->registerScript(__CLASS__, '
             $(document).off(\'click\', \'.cke_dialog_tabs a:eq(2)\').on(\'click\', \'.cke_dialog_tabs a:eq(2)\', function () {
                var $form = $(\'.cke_dialog_ui_input_file iframe\').contents().find(\'form\');
                if (!$form.find(\'input[name=\' + yupeTokenName + \']\').length) {
                    var csrfTokenInput = $(\'<input/>\').attr({
                        \'type\': \'hidden\',
                        \'name\': yupeTokenName
                    }).val(yupeToken);
                    $form.append(csrfTokenInput);
                }
            });
       ');

        Yii::app()->getClientScript()->registerScript(
            __CLASS__.'#'.$this->getId(),
            "CKEDITOR.replace( '$id', $options);"
        );
    }
}
