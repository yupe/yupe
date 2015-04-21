<?php
namespace yupe\widgets;

use Yii;

Yii::import('bootstrap.widgets.TbButtonColumn');

class CustomButtonColumn extends \TbButtonColumn
{
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

    public $frontViewGetUrlMethodName = 'getUrl';

    public $frontViewButtonLabel;

    public $frontViewButtonIcon = 'fa fa-fw fa-external-link-square';

    public $frontViewButtonUrl;

    public $frontViewButtonOptions = ['class' => 'front-view', 'target' => '_blank'];

    protected function initDefaultButtons()
    {
        parent::initDefaultButtons();


        /* Кнопка просмотра на фронте */

        if ($this->frontViewButtonLabel === null) {
            $this->frontViewButtonLabel = Yii::t('zii', 'View');
        }

        $button = array(
            'label' => $this->frontViewButtonLabel,
            'url' => $this->frontViewButtonUrl ?: function ($data) {
                try {
                    return $data->{$this->frontViewGetUrlMethodName}();
                } catch (\Exception $e) {
                    return null;
                }
            },
            'options' => $this->frontViewButtonOptions,
            'icon' => $this->frontViewButtonIcon,
        );

        if (isset($this->buttons['front_view'])) {
            $this->buttons['front_view'] = array_merge($button, $this->buttons['front_view']);
        } else {
            /* показывать кнопку только если задали ей свой url, или модель имеет метод для получения url*/
            $button['visible'] = function ($row, $data) {
                // todo: найти нормальный способ узнавания есть ли у модели метод
                try {
                    return $this->frontViewButtonUrl || method_exists($data, $this->frontViewGetUrlMethodName) || (bool)$data->{$this->frontViewGetUrlMethodName}();
                } catch (\Exception $e) {
                    return false;
                }
            };
            $this->buttons['front_view'] = $button;
        }
    }
}
