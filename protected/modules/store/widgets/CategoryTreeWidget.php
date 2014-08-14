<?php

Yii::import('store.models.*');

class CategoryTreeWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;

    /**
     * @var array of nodes. Each node must contain next attributes:
     *  id - If of node
     *  label - Name of none
     *  items - get children array
     */
    public $data = array();

    /**
     * @var array jstree options
     */
    public $options = array(
        'plugins' => array('checkbox'),
        'checkbox' => array(
            'three_state' => false,
            'keep_selected_style' => false
        )
    );

    /**
     * @var CClientScript
     */
    protected $cs;

    public $selectedCategories = array();

    public $view = 'store.views.widgets.CategoryTreeWidget';

    public function init()
    {
        $moduleAssets = Yii::app()->getModule('store')->getAssetsUrl();
        Yii::app()->clientScript->registerScriptFile($moduleAssets . '/js/jstree/jstree.min.js');
        Yii::app()->clientScript->registerCssFile($moduleAssets . '/js/jstree/themes/default/style.min.css');

        if (!is_array($this->selectedCategories)) {
            $this->selectedCategories = array();
        }
    }

    public function run()
    {
        $data = StoreCategory::model()->getMenuList(10);

        echo CHtml::openTag(
            'div',
            array(
                'id' => $this->id,
            )
        );
        echo CHtml::openTag('ul');
        $this->createHtmlTree($data);
        echo CHtml::closeTag('ul');
        echo CHtml::closeTag('div');

        $options = CJavaScript::encode($this->options);

        Yii::app()->clientScript->registerScript(
            'JsTreeScript',
            "
			$('#{$this->id}').jstree({$options});
		"
        );
    }

    /**
     * Create ul html tree from data array
     * @param string $data
     */
    private function createHtmlTree($data)
    {
        foreach ($data as $node) {
            echo CHtml::openTag(
                'li',
                array(
                    'id' => $this->id . 'Node_' . $node['id'],
                )
            );
            echo CHtml::link(
                CHtml::encode($node['label']),
                '#',
                array(
                    'data-category-id' => $node['id'],
                    'class' => (in_array($node['id'], $this->selectedCategories) ? 'jstree-clicked' : '')
                )
            );
            if (count($node['items'])) {
                echo CHtml::openTag('ul');
                $this->createHtmlTree($node['items']);
                echo CHtml::closeTag('ul');
            }
            echo CHtml::closeTag('li');
        }
    }
}
