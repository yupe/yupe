<?php
namespace yupe\widgets;

use Yii;

Yii::import('bootstrap.widgets.TbButtonColumn');

/**
 * Class CustomButtonColumn
 * @package yupe\widgets
 */
class CustomButtonColumn extends \TbButtonColumn
{
    /**
     * @var string
     */
    public $template = '{front_view} {view} {update} {delete}';
    /**
     * @var string the view button icon (defaults to 'eye-open').
     */
    public $viewButtonIcon = 'fa fa-fw fa-eye';

    /**
     * @var string the update button icon (defaults to 'pencil').
     */
    public $updateButtonIcon = 'fa fa-fw fa-pencil';

    /**
     * @var string the delete button icon (defaults to 'trash').
     */
    public $deleteButtonIcon = 'fa fa-fw fa-trash-o';

    /**
     * @var array
     */
    public $viewButtonOptions = ['class' => 'view btn btn-sm btn-default'];

    /**
     * @var array
     */
    public $deleteButtonOptions = ['class' => 'delete btn btn-sm btn-default'];

    /**
     * @var array
     */
    public $updateButtonOptions = ['class' => 'update btn btn-sm btn-default'];

    /**
     * @var array
     */
    public $htmlOptions = ['class' => 'grid-action-column'];

    /**
     * @var
     */
    public $frontViewButtonLabel;

    /**
     * @var string
     */
    public $frontViewButtonIcon = 'fa fa-fw fa-external-link-square';

    /**
     * @var
     */
    public $frontViewButtonUrl;

    /**
     * @var array
     */
    public $frontViewButtonOptions = ['class' => 'front-view btn btn-sm btn-default', 'target' => '_blank'];

    /**
     *
     */
    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();

        $this->template = '<div class="btn-group">'.$this->template.'</div>';

        if ($this->frontViewButtonUrl) {

            if ($this->frontViewButtonLabel === null) {
                $this->frontViewButtonLabel = Yii::t('zii', 'View');
            }

            $this->buttons['front_view'] = [
                'label' => $this->frontViewButtonLabel,
                'url' => $this->frontViewButtonUrl,
                'options' => $this->frontViewButtonOptions,
                'icon' => $this->frontViewButtonIcon,
                'visible' => isset($this->buttons['front_view']['visible'])
                    ? $this->buttons['front_view']['visible']
                    : function () { return true; },
            ];
        } else {
            $this->buttons['front_view'] = [
                'visible' => function () {
                    return false;
                },
            ];
        }

        if (is_string($this->deleteConfirmation)) {
            $confirmation = "if(!confirm(".\CJavaScript::encode($this->deleteConfirmation).")) return false;";
        } else {
            $confirmation = '';
        }

        if (Yii::app()->request->enableCsrfValidation) {
            $csrfTokenName = Yii::app()->getRequest()->csrfTokenName;
            $csrfToken = Yii::app()->getRequest()->csrfToken;
            $csrf = "\n\t\tdata:{ '$csrfTokenName':'$csrfToken' },";
        } else {
            $csrf = '';
        }

        if ($this->afterDelete === null) {
            $this->afterDelete = 'function(){}';
        }

        $this->buttons['delete']['click'] = <<<EOD
function() {
	$confirmation
	var th = this,
		afterDelete = $this->afterDelete;
	jQuery('#{$this->grid->id}').yiiGridView('update', {
		type: 'POST',
		url: jQuery(this).attr('href'),$csrf
		success: function(data) {
		    if(data.hasOwnProperty('result') && !data.result) {
		        var message = data.data ? data.data : 'Record not removed.';
		        alert(message);
		        afterDelete(th, false, data);
		    }
		    else {
                jQuery('#{$this->grid->id}').yiiGridView('update', {url: document.location.href });
                afterDelete(th, true, data);		    
		    }
		},
		error: function(XHR) {
			return afterDelete(th, false, XHR);
		}
	});
	return false;
}
EOD;
    }

}
