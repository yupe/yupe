<?php
/**
* Виджет для вывода меню
* @param name - уникальный код меню
* @param layout - шаблон для вывода меню. Файл должен иметь расширение php и находиться в themes/<название темы>/views/widgets/MenuWidget.
* Если параметр не указан, то меню выводится старым способом.
* @param viewData - массив дополнительных параметров, которые можно передавать в шаблон виджета
*/

class MenuWidget extends YWidget
{
    public $name;
    public $parent_id = 0;
	
	public $layout;
	public $viewData=array();
	
    public $id;
    public $params = array();

    public function init()
    {
        parent::init();

        $this->parent_id = (int)$this->parent_id;
    }

    public function run()
    {
		$content=$this->widget('zii.widgets.CMenu', 
						array_merge(
							$this->params, 
							array('items' => Menu::model()->getItems($this->name, $this->parent_id))),
						true
					);
		if (isset($this->layout)) {
			$this->render($this->layout, array_merge(array('content'=>$content),$this->viewData));
		} else {
			echo CHtml::openTag('div', array('id' => $this->id));
			echo $content;
			echo CHtml::closeTag('div');
		}
    }

}
