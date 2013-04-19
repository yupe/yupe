<?php
/*## EditableDetailView class file.
 * @see <https://github.com/vitalets/x-editable-yii>
 *
 * @author Vitaliy Potapov <noginsk@rambler.ru>
 * @copyright Copyright &copy; Vitaliy Potapov 2012
 * @package bootstrap.widgets
 * @version 1.0.0
*/

Yii::import('bootstrap.widgets.TbEditableField');
Yii::import('bootstrap.widgets.TbDetailView');

/**
* EditableDetailView widget makes editable CDetailView (several attributes of single model shown as name-value table).
*/
class TbEditableDetailView extends TbDetailView
{
    /**
    * @var string submit url for all editables in detailview
    */
    public $url = null;

    /**
    * @var array additional params to send on server
    */
    public $params = null;

  /**
   *### .init()
   *
   * Widget initialization
   */
    public function init()
    {
        if (!$this->data instanceof CModel) {
            throw new CException('Property "data" should be of CModel class.');
        }
        parent::init();
    }

  /**
   *### .renderItem()
   */
    protected function renderItem($options, $templateData)
    {
        //apply editable if not set 'editable' params or set and not false
        $apply = !empty($options['name']) && (!isset($options['editable']) || $options['editable'] !== false);

        if ($apply) {
            //ensure $options['editable'] is array
            if (!isset($options['editable'])) $options['editable'] = array();

            //take common url if not defined for particular item and not related model
            if (!isset($options['editable']['url']) && strpos($options['name'], '.') === false) {
                $options['editable']['url'] = $this->url;
            }

            //take common params if not defined for particular item
            if (!isset($options['editable']['params'])) {
                $options['editable']['params'] = $this->params;
            }

            $editableOptions = CMap::mergeArray($options['editable'], array(
                'model'     => $this->data,
                'attribute' => $options['name'],
                'emptytext' => ($this->nullDisplay === null) ? Yii::t('zii', 'Not set') : strip_tags($this->nullDisplay),
            ));

            //if value in detailview options provided, set text directly (as value means text)
            if (isset($options['value']) && $options['value'] !== null) {
                $editableOptions['text'] = $templateData['{value}'];
                $editableOptions['encode'] = false;
            }
            /** @var $widget TbEditableField */
            $widget = $this->controller->createWidget('TbEditableField', $editableOptions);

            //'apply' can be changed during init of widget (e.g. if related model and unsafe attribute)
            if ($widget->apply) {
                ob_start();
                $widget->run();
                $templateData['{value}'] = ob_get_clean();
            }
        }
        parent::renderItem($options, $templateData);
    }
}
