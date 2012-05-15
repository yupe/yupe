<?php
class MenuWidget extends YWidget
{
    public $name;
    public $parent_id = 0;

    public $id;
    public $params = array();

    public function init()
    {
        parent::init();

        $this->parent_id = (int)$this->parent_id;
    }

    public function run()
    {
        echo CHtml::openTag('div', array('id' => $this->id));

        $this->widget('zii.widgets.CMenu', array_merge($this->params, array('items' => Menu::model()->getItems($this->name, $this->parent_id))));

        echo CHtml::closeTag('div');
    }

}
