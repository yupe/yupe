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
     * @var string
     */
    private $editorWidgetClass = 'bootstrap.widgets.TbCKEditor';

    /**
     * @var array
     */
    public $options = [];

    /**
     * @throws \Exception
     */
    public function run()
    {
        Yii::app()->getClientScript()->registerScript(__CLASS__,'
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

        $this->widget(
            $this->editorWidgetClass,
            [
                'model' => $this->model,
                'attribute' => $this->attribute,
                'name' => $this->name,
                'editorOptions' => \CMap::mergeArray(
                    $this->getOptions(),
                    [
                        'filebrowserUploadUrl' => Yii::app()->createUrl('/yupe/backend/AjaxImageUploadCKE')
                    ]
                ),
            ]
        );
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [];
    }
}
