<?php
/**
 *## TbBulkActions class file
 *
 * @author Antonio Ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.grid.CCheckBoxColumn');
Yii::import('bootstrap.widgets.TbButton');

/**
 * Bulk actions widget.
 *
 * @package booster.widgets.grids.columns
 */
class TbBulkActions extends CComponent
{
    /**
     * @var TbGridView The grid view object that owns this column.
     */
    public $grid;

    /**
     * @var array the configuration for action displays.
     * Each array element specifies a single button
     * which has the following format:
     * <pre>
     * 'actions' => array(
     *      array(
     *          'type'=> 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
     *          'size'=> 'large', // '', 'large', 'small', 'mini'
     *          'label'=>'...',     // text label of the button or dropdown label
     *          'click'=> // the js function that will be called
     *      )
     * ),
     * </pre>
     * For more configuration options please @see TbButton
     *
     * Note that in order to display these additional buttons, the {@link template} property needs to
     * be configured so that the corresponding button IDs appear as tokens in the template.
     */
    public $actionButtons = array();

    /**
     * @var array the checkbox column configuration
     */
    public $checkBoxColumnConfig = array();
    
    /**
     * @var bool
     */
    public $selectableRows;
	
	/**
	 * @var string
	 */
    public $noCheckedMessage = 'No items are checked';

    /**
     * @var string
     */
    public $align = 'right';

    /**
     * @var integer the counter for generating implicit IDs.
     */
    private static $_counter = 0;

    /**
     * @var string id of the widget.
     */
    private $_id;

    /**
     *### .getId()
     *
     * Returns the ID of the widget or generates a new one if requested.
     *
     * @param boolean $autoGenerate whether to generate an ID if it is not set previously
     *
     * @return string id of the widget.
     */
    public function getId($autoGenerate = true)
    {
        if ($this->_id !== null) {
            return $this->_id;
        } else if ($autoGenerate) {
            return $this->_id = 'egw' . self::$_counter++;
        } else {
	        return ''; // FIXME: why getId can sometimes return nothing?!
        }
    }

    /**
     * @var string the column name of the checkbox column
     */
    protected $columnName;

    /**
     * @var array the bulk action buttons
     */
    protected $buttons = array();

    /**
     * @var array the life events to attach the buttons to
     */
    protected $events = array();

    /**
     *### .__construct()
     *
     * Constructor.
     *
     * @param CGridView $grid the grid view that owns this column.
     */
    public function __construct($grid)
    {
        $this->grid = $grid;
    }

    /**
     *### .init()
     *
     * Component's initialization method
     */
    public function init()
    {
        $this->align = $this->align == 'left' ? 'pull-left' : 'pull-right';
        $this->initColumn();
        $this->initButtons();
    }

    /**
     *### .initColumn()
     *
     * @return bool checks whether they are
     */
    public function initColumn()
    {
        if (!is_array($this->checkBoxColumnConfig)) {
            $this->checkBoxColumnConfig = array();
        }

        if (empty($this->grid->columns)) {
            return false;
        }

        $columns = $this->grid->columns;

        foreach ($columns as $idx => $column) {
            if (!is_array($column) || !isset($column['class'])) {
                continue;
            }
            if (preg_match('/ccheckboxcolumn/i', $column['class'])) {
                if (isset($column['checkBoxHtmlOptions']) && isset($column['checkBoxHtmlOptions']['name'])) {
                    $this->columnName = strtr(
                        $column['checkBoxHtmlOptions']['name'],
                        array('[' => "\\[", ']' => "\\]")
                    );
                } else {
                    $this->columnName = $this->grid->id . '_c' . $idx . '\[\]';
                }
                return true; // it has already a CCheckBoxColumn
            }
        }
        // not CCheckBoxColumn, attach one
        $this->attachCheckBoxColumn();
        return true;
    }

    /**
     *### .initButtons()
     *
     * initializes the buttons to be render
     */
    public function initButtons()
    {
        if (empty($this->columnName) || empty($this->actionButtons))
            return;

	    $this->buttons = array();
        foreach ($this->actionButtons as $action)
	        $this->buttons[] = $this->convertToTbButtonConfig($action);
    }

    /**
     *### .renderButtons()
     *
     * @return bool renders all initialized buttons
     */
    public function renderButtons()
    {
        if ($this->buttons === array())
            return false;

        echo CHtml::openTag(
            'div',
            array('id' => $this->getId(), 'style' => 'position:relative', 'class' => $this->align)
        );

        foreach ($this->buttons as $actionButton)
            $this->renderButton($actionButton);

        if (!$this->selectableRows)
            echo '<div style="position:absolute;top:0;left:0;height:100%;width:100%;display:block;" class="bulk-actions-blocker"></div>';

        echo CHtml::closeTag('div');

        $this->registerClientScript();
	    return true;
    }

    /**
     *### .registerClientScript()
     *
     * Registers client script
     */
    public function registerClientScript()
    {
       
        $js = '';
        if(!$this->selectableRows)
        {
        $js .= <<<EOD
$(document).on("click", "#{$this->grid->id} input[type=checkbox]", function(){
	var grid = $("#{$this->grid->id}");
	if ($("input[name='{$this->columnName}']:checked", grid).length)
	{

		$(".bulk-actions-btn", grid).removeClass("disabled");
		$("div.bulk-actions-blocker",grid).hide();
	}
	else
	{
		$(".bulk-actions-btn", grid).addClass("disabled");
		$("div.bulk-actions-blocker",grid).show();
	}
});
EOD;
}
        foreach ($this->events as $buttonId => $handler) {
            $js .= "\n$(document).on('click','#{$buttonId}', function(){
            var grid = $(\"#{$this->grid->id}\");
            if (!$(\"input[name='{$this->columnName}']:checked\", grid).length)
            {
                alert('".$this->noCheckedMessage."');
                return false;
            }
            var checked = $('input[name=\"{$this->columnName}\"]:checked');\n
			var fn = $handler; if ($.isFunction(fn)){fn(checked);}\nreturn false;});\n";
        }
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), $js);
    }

    /**
     *### .renderButton()
     *
     * Creates a TbButton and renders it
     *
     * @param array $actionButton the configuration to create the TbButton
     */
    protected function renderButton($actionButton)
    {
        // create widget and display
        if (isset($actionButton['htmlOptions']['class']) && !$this->selectableRows)
            $actionButton['htmlOptions']['class'] .= ' disabled bulk-actions-btn';
        elseif (isset($actionButton['htmlOptions']['class']) && $this->selectableRows)
            $actionButton['htmlOptions']['class'] .= 'bulk-actions-btn';
        else
            $actionButton['htmlOptions']['class'] = 'disabled bulk-actions-btn';
            $action = null;

        if (isset($actionButton['click'])) {
            $action = CJavaScript::encode($actionButton['click']);
            unset($actionButton['click']);
        }

        $button = Yii::createComponent($actionButton);
        $button->init();
        echo '&nbsp;';
        $button->run();
        echo '&nbsp;';
        if ($action !== null) {
            $this->events[$button->id] = $action;
        }
    }

    /**
     *### .attachCheckBoxColumn()
     *
     * Adds a checkbox column to the grid. It is called when
     */
    protected function attachCheckBoxColumn()
    {
        $dataProvider = $this->grid->dataProvider;
        $columnName = null;

        if (!isset($this->checkBoxColumnConfig['name'])) {
            // supports two types of DataProviders
            if ($dataProvider instanceof CActiveDataProvider) {
                // we need to get the name of the key field 'by default'
                if (is_string($dataProvider->modelClass)) {
                    $modelClass = $dataProvider->modelClass;
                    $model = CActiveRecord::model($modelClass);
                } else {
                    $model = $dataProvider->modelClass;
                }

                $table = $model->tableSchema;
                if (is_string($table->primaryKey)) {
                    $columnName = $this->{$table->primaryKey};
                } else if (is_array($table->primaryKey)) {
                    $columnName = $table->primaryKey[0];
                } // just get the first one
            }
            if ($dataProvider instanceof CArrayDataProvider || $dataProvider instanceof CSqlDataProvider) {
                $columnName = $dataProvider->keyField;
            } // key Field
        }
        // create CCheckBoxColumn and attach to columns at its beginning
        $column = CMap::mergeArray(
            array(
                'class' => 'CCheckBoxColumn',
                'name' => $columnName,
                'selectableRows' => 2
            ),
            $this->checkBoxColumnConfig
        );


        array_unshift($this->grid->columns, $column);
        $this->columnName = $this->grid->id . '_c0\[\]'; //
    }

	/**
	 * @param $action
	 *
	 * @return array
	 * @throws CException
	 */
	private function convertToTbButtonConfig($action)
	{
		if (!isset($action['id'])) {
			throw new CException(Yii::t(
				'zii',
				'Each bulk action button should have its "id" attribute set to ensure its functionality among ajax updates'
			));
		}
		// button configuration is a regular TbButton
		$buttonConfig = array(
			'class' => 'bootstrap.widgets.TbButton',
			'id' => $action['id'], // we must ensure this
			'buttonType' => isset($action['buttonType']) ? $action['buttonType'] : TbButton::BUTTON_LINK,
			'type' => isset($action['type']) ? $action['type'] : '',
			'size' => isset($action['size']) ? $action['size'] : TbButton::SIZE_SMALL,
			'icon' => isset($action['icon']) ? $action['icon'] : null,
			'label' => isset($action['label']) ? $action['label'] : null,
			'url' => isset($action['url']) ? $action['url'] : null,
			'active' => isset($action['active']) ? $action['active'] : false,
			'items' => isset($action['items']) ? $action['items'] : array(),
			'ajaxOptions' => isset($action['ajaxOptions']) ? $action['ajaxOptions'] : array(),
			'htmlOptions' => isset($action['htmlOptions']) ? $action['htmlOptions'] : array(),
			'encodeLabel' => isset($action['encodeLabel']) ? $action['encodeLabel'] : true,
			'click' => isset($action['click']) ? $action['click'] : false
		);
		return $buttonConfig;
	}
}
